/* ADMIN */
/* view products of meal  */
DECLARE @meal_id int = 47;

SELECT m.meal_id, card_id, "timestamp", table_id, p.product_id, amount, p.name, price, pfand
FROM meal m JOIN consists_of c ON (m.meal_id=c.meal_id) 
			JOIN product p ON (c.product_id=p.product_id)
WHERE m.meal_id=@meal_id