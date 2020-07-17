UPDATE Products
    SET quanitity = quantity - Carts.quantity
    WHERE SELECT * FROM Products INNER JOIN Carts ON (Products.id = Carts.productID);