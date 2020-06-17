ALTER TABLE Users
ADD accountName varchar(25) NOT NULL UNIQUE,
ADD Country varchar(50) NOT NULL,

DROP COLUMN first_name,
DROP COLUMN last_name
