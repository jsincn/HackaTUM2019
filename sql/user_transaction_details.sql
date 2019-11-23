/* USER */
/* transaction totals, date and table */
SELECT meal_id, c.card_id, "timestamp", table_id, total
FROM meal m, student_card c
WHERE m.card_id = c.card_id
	AND c.card_id = 4200586721

