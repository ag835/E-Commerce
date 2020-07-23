SELECT * FROM Orders
    JOIN Products on Orders.product_id = Products.id
WHERE user_id = :user_id