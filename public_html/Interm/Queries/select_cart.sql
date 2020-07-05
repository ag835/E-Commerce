SELECT * FROM Products, Carts
WHERE Products.id = Carts.productID AND Carts.userID = :userID