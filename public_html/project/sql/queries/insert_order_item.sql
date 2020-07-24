INSERT INTO Orders (order_id, product_id, user_id, quantity, cost)
VALUES(:order_id, :item_id, :user_id, :quantity, :cost);
UPDATE Products
SET quantity = quantity - :quantity
WHERE id = :item_id
