CREATE TABLE IF NOT EXISTS  `Users`
(
    `id`         int auto_increment not null,
    `email`      varchar(100)       not null unique,
    `username`   varchar(25)        not null unique,
    `password`   varchar(60),
    `country`    varchar(50),
    `created`    timestamp default current_timestamp,
    `modified`   timestamp default current_timestamp on update current_timestamp,
    PRIMARY KEY (`id`)
)