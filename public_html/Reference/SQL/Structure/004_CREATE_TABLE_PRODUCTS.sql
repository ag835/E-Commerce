CREATE TABLE IF NOT EXISTS  `Products`
(
    `id`         int auto_increment not null,
    `name`      varchar(100)       not null unique,
    `category` varchar(20) default 'Game',
    `quantity` int default 0,
    `price` decimal(6,2) default 0.00,
    `description` TEXT,
    `Release_Date` date default (CURRENT_DATE),
    `created`    timestamp default current_timestamp,
    `modified`   timestamp default current_timestamp on update current_timestamp,
    PRIMARY KEY (`id`)
)