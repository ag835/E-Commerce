SELECT o.id, o.order_id, Products.name, o.quantity, o.cost, o.created
FROM Orders o
         JOIN Products ON o.product_id = Products.id
WHERE user_id = :user_id