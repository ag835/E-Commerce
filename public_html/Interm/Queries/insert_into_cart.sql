INSERT IGNORE INTO Carts (productID, userID) VALUES (:productID, :userID);
UPDATE Carts
   SET quantity = quantity + 1
 WHERE productID = :productID AND userID = :userID
