/**
  Create users table
 */
CREATE TABLE IF NOT EXISTS `users`
(
    `id`        int(11)      NOT NULL AUTO_INCREMENT,
    `firstname` varchar(256) NOT NULL,
    `lastname`  varchar(50),
    `roleId`    int(11)      NOT NULL,
    `created`   datetime     NOT NULL,
    `updated`   datetime     NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

/**
  Create roles table
 */
CREATE TABLE IF NOT EXISTS `roles`
(
    `id`   int(11)      NOT NULL AUTO_INCREMENT,
    `name` varchar(256) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

/**
  Input demo data
 */
INSERT INTO `users` (`id`, `firstname`, `lastname`, `roleId`, `created`, `updated`)
VALUES (1, 'John', 'Doe', 1, '2012-06-01 02:12:30', null),
       (2, 'David', 'Costa', 2, '2013-03-03 01:20:10', null),
       (3, 'Todd', 'Martell', 3, '2014-09-20 03:10:25', null),
       (4, 'Adela', 'Marion', 2, '2015-04-11 04:11:12', null),
       (5, 'Matthew', 'Popp', 1, '2016-01-04 05:20:30', null),
       (6, 'Alan', 'Wallin', 1, '2017-01-10 06:40:10', null),
       (7, 'Joyce', 'Hinze', 2, '2017-05-02 02:20:30', null),
       (8, 'Donna', 'Andrews', 2, '2018-01-04 05:15:35', null),
       (9, 'Andrew', 'Best', 3, '2019-01-02 02:20:30', null),
       (10, 'Joel', 'Ogle', 3, '2020-02-01 06:22:50', null);

INSERT INTO `roles` (`id`, `name`)
VALUES (1, 'Developer'),
       (2, 'Manager'),
       (3, 'QA');


