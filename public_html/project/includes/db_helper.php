<?php

class DBH{
    private static function getDB(){
        global $common;
        if(isset($common)){
            return $common->getDB();
        }
        throw new Exception("Failed to find reference to common");
    }

    /** Wraps all responses in this wrapper as a contract for whoever calls this helper
     * @param $data
     * @param int $status
     * @param string $message
     * @return array
     */
    private static function response($data, $status = 200, $message = ""){
        return array("status"=>$status, "message"=>$message, "data"=>$data);
    }

    /*** Basic repetitive STMT check, throws exception
     * @param $stmt
     * @throws Exception
     */
    private static function verify_sql($stmt){
        if(!isset($stmt)){
            throw new Exception("stmt object is undefined");
        }
        $e = $stmt->errorInfo();
        if($e[0] != '00000'){
            $error = var_export($e, true);
            error_log($error);
            throw new Exception("SQL Error: $error");
        }
    }
    public static function login($email, $pass){
        try {
            $query = file_get_contents(__DIR__ . "/../sql/queries/login.sql");
            $stmt = DBH::getDB()->prepare($query);
            $stmt->execute([":email" => $email]);
            DBH::verify_sql($stmt);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                if (password_verify($pass, $user["password"])) {
                    unset($user["password"]);//TODO remove password before we return results
                    //TODO get roles
                    $query = file_get_contents(__DIR__ . "/../sql/queries/get_roles.sql");
                    $stmt = DBH::getDB()->prepare($query);
                    $stmt->execute([":user_id"=>$user["id"]]);
                    DBH::verify_sql($stmt);
                    $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    error_log(var_export($roles, true));
                    $user["roles"] = $roles;
                    return DBH::response($user);
                } else {
                    return DBH::response(NULL, 403, "Invalid email or password");
                }
            } else {
                return DBH::response(NULL, 403, "Invalid email or password");
            }
        }
        catch(Exception $e){
            error_log($e->getMessage());
            return DBH::response(NULL, 400, "DB Error: " . $e->getMessage());
        }
    }
    public static function register($email, $username, $pass, $country){
        try {
            $query = file_get_contents(__DIR__ . "/../sql/queries/register.sql");
            $stmt = DBH::getDB()->prepare($query);
            $pass = password_hash($pass, PASSWORD_BCRYPT);
            $result = $stmt->execute([":email" => $email, ":username" => $username, ":password" => $pass, ":country" => $country]);
            DBH::verify_sql($stmt);
            if($result){
                return DBH::response(NULL,200, "Registration successful");
            }
            else{
                return DBH::response(NULL, 400, "Registration unsuccessful");
            }
        }
        catch(Exception $e){
            error_log($e->getMessage());
            return DBH::response(NULL, 400, "DB Error: " . $e->getMessage());
        }
    }

    /*** Fetch System user ID, this is used for Points Transactions
     * @return array
     */
    public static function get_system_user_id(){
        try {
            $query = file_get_contents(__DIR__ . "/../sql/queries/login.sql");
            $stmt = DBH::getDB()->prepare($query);
            $stmt->execute([":email"=>"localhost"]);
            DBH::verify_sql($stmt);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if($result){
                return DBH::response($result,200, "success");
            }
            else{
                return DBH::response(NULL, 400, "error");
            }
        }
        catch(Exception $e){
            error_log($e->getMessage());
            return DBH::response(NULL, 400, "DB Error: " . $e->getMessage());
        }
    }

    public static function get_aggregated_stats($user_id){
        try {
            $query = file_get_contents(__DIR__ . "/../sql/queries/get_aggregated_stats.sql");
            $stmt = DBH::getDB()->prepare($query);
            $result = $stmt->execute([":uid" => $user_id]);
            DBH::verify_sql($stmt);
            if($result){
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return DBH::response($result,200, "success");
            }
            else{
                return DBH::response(NULL, 400, "error");
            }
        }
        catch(Exception $e){
            error_log($e->getMessage());
            return DBH::response(NULL, 400, "DB Error: " . $e->getMessage());
        }
    }
    public static function update_user_stats($user_id, $level, $xp, $points, $wins, $losses){
        try {
            $query = file_get_contents(__DIR__ . "/../sql/queries/update_user_stats.sql");
            $stmt = DBH::getDB()->prepare($query);
            $result = $stmt->execute([
                ":uid" => $user_id,
                ":level"=>$level,
                ":xp"=>$xp,
                ":points"=>$points,
                ":wins"=>$wins,
                ":losses"=>$losses
            ]);
            DBH::verify_sql($stmt);
            if($result){
                return DBH::response(NULL,200, "success");
            }
            else{
                return DBH::response(NULL, 400, "error");
            }
        }
        catch(Exception $e){
            error_log($e->getMessage());
            return DBH::response(NULL, 400, "DB Error: " . $e->getMessage());
        }
    }

    public static function get_shop_items(){
        try {
            $query = file_get_contents(__DIR__ . "/../sql/queries/get_shop_items.sql");
            $stmt = DBH::getDB()->prepare($query);
            $result = $stmt->execute();
            DBH::verify_sql($stmt);
            if($result){
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                return DBH::response($result,200, "success");
            }
            else{
                return DBH::response(NULL, 400, "error");
            }
        }
        catch(Exception $e){
            error_log($e->getMessage());
            return DBH::response(NULL, 400, "DB Error: " . $e->getMessage());
        }
    }

    public static function save_order($data){
        try {
            $query = file_get_contents(__DIR__ . "/../sql/queries/get_max_order_id.sql"); #max bc we're processing the newest order which will have the greatest value?
            $stmt = DBH::getDB()->prepare($query);
            $result = $stmt->execute();
            DBH::verify_sql($stmt);
            if($result){
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $max = (int)$result["max"];
                $max += 1;
                $query =  file_get_contents(__DIR__ . "/../sql/queries/insert_order_item.sql");
                $stmt = DBH::getDB()->prepare($query);
                $user_id = Common::get_user_id();
                foreach($data as $item){
                    $result = $stmt->execute([
                        ":order_id"=>$max,
                        ":item_id"=>$item["id"],
                        ":user_id"=>$user_id,
                        ":quantity"=>$item["quantity"],
                        ":cost"=>$item["price"] #switched cost and price bc I did so in my tables
                    ]);
                }
                return DBH::response($result,200, "success");
            }
            else{
                return DBH::response(NULL, 400, "error");
            }
        }
        catch(Exception $e){
            error_log($e->getMessage());
            return DBH::response(NULL, 400, "DB Error: " . $e->getMessage());
        }
    }

    public static function save_product($product){
        try {
            $query = file_get_contents(__DIR__ . "/../sql/queries/insert_products.sql");
            $stmt = DBH::getDB()->prepare($query);
            $result = $stmt->execute([
                ":name"=>Common::get($product, "name", null),
                ":category"=>Common::get($product, "category", null),
                ":quantity"=>Common::get($product, "quantity", 1),
                ":price"=>Common::get($product, "price", 1),
                ":description"=>Common::get($product, "description", null),
                ":active"=>Common::get($product, "active", false)?1:0//convert to tinyint
                #":uid"=>Common::get_user_id() don't know if this is useful to me
            ]);
            DBH::verify_sql($stmt);
            if($result){
                return DBH::response(NULL,200, "success");
            }
            else{
                return DBH::response(NULL, 400, "error");
            }
        }
        catch(Exception $e){
            error_log($e->getMessage());
            return DBH::response(NULL, 400, "DB Error: " . $e->getMessage());
        }
    }

}