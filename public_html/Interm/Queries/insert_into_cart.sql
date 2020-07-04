INSERT INTO Carts (productID) VALUES (:productID)
UPDATE Carts
   SET quanity = quantity + 1
 WHERE productID = :productID
