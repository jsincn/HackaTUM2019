/* USER PAYMENT */
BEGIN TRANSACTION
 DECLARE @DataID int;
 DECLARE @total money;
 DECLARE @card_id numeric(18,0) = 04200586721;
 DECLARE @table_id int = 2;

	/* CREATE NEW meal-TRANSACTION*/
   INSERT INTO meal (card_id, table_id) VALUES (@card_id, @table_id);
   SELECT @DataID = @@IDENTITY;

   /* START OF INSERTING PRODUCTS */
   INSERT INTO consists_of (meal_id, product_id, amount) VALUES (@DataID, 1, 3);
   INSERT INTO consists_of (meal_id, product_id, amount) VALUES (@DataID, 3, 2);
   INSERT INTO consists_of (meal_id, product_id, amount) VALUES (@DataID, 2, 1);
   INSERT INTO consists_of (meal_id, product_id, amount) VALUES (@DataID, 4, 1);
   /* END OF INSERTING PRODUCTS */

   /* CALCULATE TOTAL */
   SELECT @total = (SELECT sum((coalesce(p.price+p.pfand, p.price, p.pfand)) * c.amount) 
					FROM consists_of c, product p
					WHERE c.meal_id=@DataID AND c.product_id=p.product_id);
   UPDATE meal SET total = @total WHERE meal_id = @DataID; 
   
   /* UPDATE card balance*/
   IF (select balance from student_card where card_id=@card_id)-@total>= 0
	   BEGIN
	   UPDATE student_card
	   SET balance = balance - @total
	   WHERE card_id=@card_id;
	   COMMIT
	   END
	ELSE
		
		ROLLBACK TRANSACTION;

SELECT * FROM meal

SELECT *
FROM student_card
WHERE card_id = @card_id;