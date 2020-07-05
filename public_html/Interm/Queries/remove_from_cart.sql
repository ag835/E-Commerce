UPDATE Carts
   SET quantity = quantity - 1
 WHERE productID = :productID AND userID = :userID