SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE `bdp_captcha` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_key` text NOT NULL,
  `text` text NOT NULL,
  `ip` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `bdp_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` int(11) NOT NULL,
  `title` text NOT NULL,
  `text` text NOT NULL,
  `deleted_date` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

INSERT INTO `bdp_news` (`id`, `date`, `title`, `text`, `deleted_date`) VALUES
(1, 1370088000, 'First news', 'First news on this website :)', '');

CREATE TABLE `bdp_news_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nid` int(11) NOT NULL,
  `text` text NOT NULL,
  `date` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `author` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin2;

INSERT INTO `bdp_news_comments` (`id`, `nid`, `text`, `date`, `uid`, `author`) VALUES
(1, 1, 'First comment :D', 1370088300, 1, 'First User');

CREATE TABLE `bdp_offers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `count` int(11) NOT NULL,
  `child_age` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `archived_date` text NOT NULL,
  `taker_id` int(11) NOT NULL,
  `state` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

INSERT INTO `bdp_offers` (`id`, `uid`, `title`, `description`, `count`, `child_age`, `date`, `archived_date`, `taker_id`, `state`) VALUES
(1, 1, 'My books', 'Some text', 5, 8, 1370088360, '', 0, 0);

CREATE TABLE `bdp_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `file` text NOT NULL,
  `showInMenu` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `bdp_pages` (`id`, `name`, `file`, `showInMenu`) VALUES
(1, 'HOME', 'index', 1),
(4, 'Login', 'login', 1),
(5, 'Rejestracja', 'registration', 1),
(6, 'Takers', 'takers', 1),
(7, 'Donors', 'donors', 1);

CREATE TABLE `bdp_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userType` int(11) NOT NULL,
  `login` text NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL,
  `offers` int(11) NOT NULL,
  `name` text NOT NULL,
  `adress` text NOT NULL,
  `city` text NOT NULL,
  `phone` text NOT NULL,
  `zipCode` text NOT NULL,
  `region` int(11) NOT NULL,
  `country` text NOT NULL,
  `activation_code` text NOT NULL,
  `cordLat` text NOT NULL,
  `cordLng` text NOT NULL,
  `points` int(11) NOT NULL,
  `points_all` int(11) NOT NULL,
  `state` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `bdp_users` (`id`, `userType`, `login`, `password`, `email`, `offers`, `name`, `adress`, `city`, `phone`, `zipCode`, `region`, `country`, `activation_code`, `cordLat`, `cordLng`, `points`, `points_all`, `state`) VALUES
(1, 2, 'firstuser', '202cb962ac59075b964b07152d234b70', 'mail@abc.pl', 1, 'First User', 'Street', 'Siemianowice ĹlÄskie', '', '41-100', 12, 'Polska', 'actived', '50.314891', '19.0245204', 0, 0, 3);
