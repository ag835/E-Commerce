INSERT INTO Carts (productID) VALUES (:productID);
UPDATE Carts
   SET quantity = quantity + 1
 WHERE productID = :productID
