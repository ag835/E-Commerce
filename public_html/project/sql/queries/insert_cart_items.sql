INSERT INTO Carts (product_id, quantity, user_id) VALUES (:product_id, :quantity, :user_id)
ON DUPLICATE KEY UPDATE quantity = :quantity