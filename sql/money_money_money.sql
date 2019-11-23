/* SUPER-ADMIN */
/* LOAD CARD*/
DECLARE @amount MONEY = 100.00;
DECLARE @card_id numeric(18,0) = 04200586721;

UPDATE student_card
SET balance = balance + @amount
WHERE card_id = @card_id;

SELECT *
FROM student_card
WHERE card_id = @card_id;