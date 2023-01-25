SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Developer'),
(2, 'Manager'),
(3, 'QA');

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `roleId` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `firstname`, `lastname`, `roleId`, `created`, `updated`) VALUES
(1, 'John', 'Doe', 1, '2012-06-01 02:12:31', '2023-01-24 10:39:49'),
(2, 'Matthew', 'Popp', 1, '2016-01-04 05:20:30', '2023-01-24 22:20:40'),
(3, 'Joyce', 'Hinze', 2, '2017-05-02 02:20:30', '2023-01-24 22:20:44'),
(4, 'Joel', 'Ogle', 1, '2020-02-01 06:22:50', '2023-01-24 22:20:46'),
(5, 'Todd', 'Martell', 2, '2023-01-24 22:08:38', '2023-01-24 22:21:36'),
(6, 'Andrew', 'Best', 2, '2023-01-24 22:19:49', '2023-01-24 22:20:51'),
(7, 'Donna', 'Andrews', 1, '2023-01-24 22:19:49', '2023-01-24 22:20:55'),
(8, 'Joyce', 'Hinze', 2, '2023-01-24 22:20:10', '2023-01-24 22:20:57'),
(9, 'Alan', 'Wallin', 3, '2023-01-24 22:20:10', '2023-01-24 22:21:00'),
(10, 'Matthew', 'Popp', 2, '2023-01-24 22:20:33', '2023-01-24 22:21:06'),
(11, 'Adela', 'Marion', 1, '2023-01-24 22:20:33', '2023-01-24 22:21:10');
