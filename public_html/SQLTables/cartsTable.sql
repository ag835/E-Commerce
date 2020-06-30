CREATE TABLE Carts (
    id int AUTO_INCREMENT,
    productID int,
    quantity int,
    userID int,
    created datetime DEFAULT current_timestamp,
    modified datetime DEFAULT current_timestamp on update current_timestamp,
    PRIMARY KEY(id),
    FOREIGN KEY(productID) references Products(id),
    FOREIGN KEY(userID) references Users(id)
)