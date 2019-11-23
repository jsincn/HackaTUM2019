/* ADMIN */
/* view previous transactions at TABLE on current day */
DECLARE @table_id int = 2;

SELECT *
FROM meal m
WHERE table_id=@table_id AND 
		year("timestamp") = year(CURRENT_TIMESTAMP)
		and month("timestamp") = month(CURRENT_TIMESTAMP)
		and day("timestamp") = day(CURRENT_TIMESTAMP)


ORDER BY "timestamp" DESC;