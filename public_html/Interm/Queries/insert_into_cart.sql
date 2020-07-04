INSERT INTO Carts (productID, userID) VALUES (:id, :userid)
UPDATE Carts SET quantity = quantity + 1 WHERE productID = :id //not sure if this will work bc columns..
//something like this, otherwise try products(id) or products.id or whatever it is
//also user is logged in so how would I get user id?
//check login.php and logout.php...