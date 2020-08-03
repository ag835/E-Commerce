SELECT * FROM Products
WHERE id IN (SELECT product_id FROM Carts)
  AND quantity > 1