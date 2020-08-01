SELECT o.id, o.order_id, Users.username, Products.name, Products.category, o.quantity, o.cost, o.created
FROM Orders o
         JOIN Products ON o.product_id = Products.id
         JOIN Users on o.user_id = Users.id
WHERE Products.category = :category ORDER BY created