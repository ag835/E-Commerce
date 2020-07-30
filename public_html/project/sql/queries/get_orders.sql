SELECT * FROM Orders
    JOIN Products on Orders.product_id = Products.id
    JOIN Users on Orders.user_id = Users.id
