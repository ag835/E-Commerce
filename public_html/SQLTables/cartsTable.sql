CREATE TABLE Cart (
    ID int AUTO_INCREMENT,
    ProductID int,
    Quantity int,
    UserID int,
    created datetime DEFAULT current_timestamp,
    modified datetime DEFAULT current_timestamp on update current_timestamp,
    PRIMARY KEY(ID),
    FOREIGN KEY(ProductID) references Products.ID,
    FOREIGN KEY(UserID) references Users.id
)