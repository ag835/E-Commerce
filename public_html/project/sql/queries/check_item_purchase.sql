SELECT * FROM Orders
WHERE product_id = :product_id AND user_id = :user_id
LIMIT 1