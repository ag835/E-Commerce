CREATE TABLE Products (
    ProductID int NOT NULL AUTO_INCREMENT,
    Title varchar(100) NOT NULL UNIQUE,
    Category varchar(20) DEFAULT 'Game',
    Price decimal(6,2) NOT NULL,
    Quantity int,
    Release_Date date DEFAULT CURRENT_DATE,
    PRIMARY KEY (ProductID),
    INDEX (Category)
);