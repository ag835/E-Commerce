SELECT * FROM Products
WHERE quantity > 0 AND is_active = 1 AND name LIKE CONCAT('%', :search, '%')
ORDER BY