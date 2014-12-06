-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 05, 2014 at 08:25 PM
-- Server version: 5.5.32
-- PHP Version: 5.3.27
-- test
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `nimbo_tex`
--
CREATE DATABASE IF NOT EXISTS `nimbo_tex` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `nimbo_tex`;

-- --------------------------------------------------------

--
-- Table structure for table `bets`
--

CREATE TABLE IF NOT EXISTS `bets` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author` varchar(255) NOT NULL,
  `sport` varchar(255) NOT NULL,
  `matchas` varchar(255) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `bet` varchar(255) NOT NULL,
  `koef` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `like_count` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `bets`
--

INSERT INTO `bets` (`id`, `date`, `author`, `sport`, `matchas`, `bet`, `koef`, `status`, `like_count`) VALUES
(1, '2014-12-04 23:02:06', 'Thomas', 'Tenisas', 'Andy Murray - Novak Djokovic', 'N. Djokovic (Games -8)', '2.0', 'GrÄ…Å¾inta', 0),
(2, '2014-12-05 00:02:55', 'Paulius', 'KrepÅ¡inis', 'Madrido Real - Barcelona', 'Barcelona +2.0', '2.50', 'PralaimÄ—ta', 0),
(21, '2014-12-05 09:35:21', 'Anglas', 'KrepÅ¡inis', 'Olympiacos - NeptÅ«nas', 'NeptÅ«nas (+10)', '1.50', 'LaimÄ—ta', 0),
(20, '2014-12-05 09:34:07', 'Paulius', 'Futbolas', 'Dortmund - Hoffenheim', 'Dortmund -1', '2.50', 'LaimÄ—ta', 0),
(22, '2014-12-05 13:20:55', 'Ä—Ä—', 'Futbolas', 'Ä¯Ä¯', 'Å¡Å¡', 'Å³Å³', 'PralaimÄ—ta', 0),
(23, '2014-12-05 13:37:11', 'Anglas', 'Futbolas', 'Banga - Å½algiris', 'Å½algiris', '1.34', 'Laukiama', 0),
(24, '2014-12-05 13:37:49', 'Thoma', 'Futbolas', 'Atlantas - Kruoja', 'Kruoja', '2.34', 'LaimÄ—ta', 10);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
