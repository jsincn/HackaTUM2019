/* ADMIN */
/* CREATE NEW PRODUCT */
DECLARE @name VARCHAR(255) = 'TEST';
DECLARE @type VARCHAR(255) = 'vegan';
DECLARE @price MONEY = 10.00;
DECLARE @pfand MONEY = NULL;

INSERT INTO product (name, type, price, pfand) VALUES(@name, @type, @price, @pfand)

