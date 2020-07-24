UPDATE Products
SET quantity = quantity - :quantity
WHERE item_id = :item_id AND user_id = :user_id
