SELECT * FROM Products
WHERE name LIKE CONCAT('%', :product, '%')
ORDER BY price;