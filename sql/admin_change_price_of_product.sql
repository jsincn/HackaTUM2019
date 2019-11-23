/* ADMIN */
/* change price of product */
DECLARE @product_id int = 1;
DECLARE @price MONEY = 3.50;

UPDATE product
SET price = @price
WHERE product_id=@product_id;

SELECT * FROM product