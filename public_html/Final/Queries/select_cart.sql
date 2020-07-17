SELECT * FROM Products INNER JOIN Carts ON (Products.id = Carts.productID)
/*
SELECT Carts.id, Products.name, Products.quantity, Products.price
FROM Products, Carts
WHERE Products.id = Carts.productID AND Carts.userID = :userID
 */