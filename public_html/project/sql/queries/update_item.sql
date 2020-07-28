UPDATE Products
SET name = :name, category = :category, quantity = :quantity, price = :price, description = :description,
    is_active = :active
WHERE id = :id