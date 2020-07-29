CREATE TABLE IF NOT EXISTS  `Reviews`
(
    `id`         int auto_increment not null,
    `product_id` int,
    `user_id` int,
    `rating` int,
    `title` varchar(100) not null,
    `description` TEXT,
    `created`    timestamp default current_timestamp,
    `modified`   timestamp default current_timestamp on update current_timestamp,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`product_id`) REFERENCES Products(`id`),
    FOREIGN KEY (`user_id`) REFERENCES Users(`id`),
    CONSTRAINT UC_Review UNIQUE (product_id, user_id)
)