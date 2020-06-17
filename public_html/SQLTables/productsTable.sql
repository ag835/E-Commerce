CREATE TABLE Products (
    ID int AUTO_INCREMENT,
    Title varchar(100) NOT NULL UNIQUE,
    Category varchar(20) DEFAULT 'Game',
    Quantity int,
    Price decimal(6,2) DEFAULT 0.00,
    Description TEXT,
    Release_Date date DEFAULT (CURRENT_DATE),
    Modified datetime default current_timestamp on update current_timestamp,
    Created datetime default current_timestamp,
    PRIMARY KEY(ID)
)