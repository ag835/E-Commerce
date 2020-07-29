SELECT * FROM Orders
WHERE user_id = :user_id AND product_id = :product_id
LIMIT 1