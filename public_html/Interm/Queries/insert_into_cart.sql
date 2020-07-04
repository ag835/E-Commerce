INSERT INTO Carts (productID, userID) VALUES (:productID, :userID);
--create unique key for productID and userID? or try IGNORE, or something like that
UPDATE Carts
   SET quantity = quantity + 1
 WHERE productID = :productID
