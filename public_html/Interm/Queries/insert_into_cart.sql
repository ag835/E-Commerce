INSERT INTO Carts (productID, userID) VALUES (:productID, Users(id));
--SELECT * FROM (SELECT productID)
--WHERE NOT EXISTS (SELECT productID FROM Carts WHERE productID = productID) LIMIT 1;
UPDATE Carts
   SET quantity = quantity + 1
 WHERE productID = :productID
