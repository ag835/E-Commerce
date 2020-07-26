SELECT * FROM Products
WHERE id IN (SELECT * FROM Carts WHERE product_id = :product_id) AND quantity > 0