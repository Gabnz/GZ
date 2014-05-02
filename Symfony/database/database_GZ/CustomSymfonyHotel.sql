-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 01-05-2014 a las 03:26:46
-- Versión del servidor: 5.5.36-MariaDB-log
-- Versión de PHP: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `SymfonyGZ`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Bill`
--

CREATE TABLE IF NOT EXISTS `Bill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `issuedate` date NOT NULL,
  `billstatus` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `category` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_cost` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type_cost` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `housing_days` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `housing_cost` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `items_cost` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_cost` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type_bill` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fail_cost` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DA13B6DDA76ED395` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=55 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `BillItems`
--

CREATE TABLE IF NOT EXISTS `BillItems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `amount` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C145C5B1A8C12F5` (`bill_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=425 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Consumable`
--

CREATE TABLE IF NOT EXISTS `Consumable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reserve_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `consumablestore_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B28F3455913AEBF` (`reserve_id`),
  KEY `IDX_B28F34545104AA6` (`consumablestore_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=31 ;

--
-- Volcado de datos para la tabla `Consumable`
--

INSERT INTO `Consumable` (`id`, `reserve_id`, `amount`, `consumablestore_id`) VALUES
(1, 1, 4, 1),
(2, 1, 2, 4),
(3, 1, 4, 10),
(4, 1, 4, 11),
(5, 1, 4, 7),
(6, 2, 4, 1),
(7, 2, 2, 4),
(8, 2, 4, 10),
(9, 2, 4, 11),
(10, 2, 4, 7),
(11, 3, 4, 2),
(12, 3, 2, 5),
(13, 3, 4, 10),
(14, 3, 4, 11),
(15, 3, 4, 8),
(16, 4, 4, 2),
(17, 4, 2, 5),
(18, 4, 4, 10),
(19, 4, 4, 11),
(20, 4, 4, 8),
(21, 5, 4, 3),
(22, 5, 2, 6),
(23, 5, 4, 10),
(24, 5, 4, 11),
(25, 5, 4, 9),
(26, 6, 4, 3),
(27, 6, 2, 6),
(28, 6, 4, 10),
(29, 6, 4, 11),
(30, 6, 4, 9);

--
-- Disparadores `Consumable`
--
DROP TRIGGER IF EXISTS `restar_consumible_almacen`;
DELIMITER //
CREATE TRIGGER `restar_consumible_almacen` AFTER INSERT ON `Consumable`
 FOR EACH ROW BEGIN
    UPDATE ConsumableStore SET amount = amount - NEW.amount
    WHERE ConsumableStore.id = NEW.consumablestore_id;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ConsumableStore`
--

CREATE TABLE IF NOT EXISTS `ConsumableStore` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `roomcategory` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `brand` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

--
-- Volcado de datos para la tabla `ConsumableStore`
--

INSERT INTO `ConsumableStore` (`id`, `name`, `price`, `roomcategory`, `amount`, `brand`) VALUES
(1, 'cerveza', 15, 'standard', 988, 'Polar Light'),
(2, 'cerveza', 20, 'business', 484, 'Solera'),
(3, 'cerveza', 35, 'high', 292, 'Polar Xtreme'),
(4, 'vino', 20, 'standard', 94, 'San Andrés'),
(5, 'vino', 31, 'business', 222, 'Caminos de San Joaquín'),
(6, 'vino', 42, 'high', 246, 'Uvas del Cochinal'),
(7, 'alcohol', 35, 'standard', 88, 'Vokda Glacial'),
(8, 'alcohol', 45, 'business', 134, 'Santa Teresa'),
(9, 'alcohol', 85, 'high', 192, 'Droché 80 años - Edición Especial'),
(10, 'agua', 10, 'standard', 464, 'Minalba Pura de Manatial'),
(11, 'refresco', 20, 'standard', 864, 'Pepsi-Cola'),
(12, 'llamada_internacional', 10, 'standard', 0, NULL),
(13, 'llamada_nacional', 5, 'standard', 0, NULL),
(14, 'cama_niño', 50, 'standard', 100, NULL),
(15, 'individual', 100, 'standard', 0, NULL),
(16, 'double', 200, 'standard', 0, NULL),
(17, 'standard', 2, 'standard', 0, NULL),
(18, 'business', 2.5, 'business', 0, NULL),
(19, 'high', 4, 'high', 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Contact`
--

CREATE TABLE IF NOT EXISTS `Contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(700) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `PhoneCall`
--

CREATE TABLE IF NOT EXISTS `PhoneCall` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reserve_id` int(11) NOT NULL,
  `calldate` date NOT NULL,
  `starttime` time NOT NULL,
  `endtime` time NOT NULL,
  `phonenumber` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `calltype` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C47F1BD15913AEBF` (`reserve_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `PhoneCall`
--

INSERT INTO `PhoneCall` (`id`, `reserve_id`, `calldate`, `starttime`, `endtime`, `phonenumber`, `calltype`) VALUES
(1, 1, '2014-04-16', '12:22:01', '12:23:00', '9532132132168', 'international'),
(2, 2, '2014-04-17', '12:40:00', '12:50:00', '04265842524', 'national'),
(3, 3, '2014-04-18', '12:22:01', '12:23:00', '04264484827', 'national'),
(4, 4, '2014-04-19', '12:40:00', '13:40:00', '04145844721', 'national'),
(5, 5, '2014-04-20', '22:40:00', '22:50:00', '892312132131', 'international'),
(6, 6, '2014-04-16', '09:30:00', '09:50:22', '02418236631', 'national'),
(7, 1, '2014-04-17', '09:30:00', '09:50:22', '04145855539', 'national'),
(8, 3, '2014-04-20', '12:30:00', '12:40:34', '04120388544', 'international');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Reserve`
--

CREATE TABLE IF NOT EXISTS `Reserve` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entrydate` date NOT NULL,
  `exitdate` date NOT NULL,
  `special` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `roomcategory` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `roomtype` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `restatus` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `room_id` int(11) DEFAULT NULL,
  `childbed` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_D05DD3BE54177093` (`room_id`),
  KEY `IDX_D05DD3BEA76ED395` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

--
-- Volcado de datos para la tabla `Reserve`
--

INSERT INTO `Reserve` (`id`, `entrydate`, `exitdate`, `special`, `user_id`, `roomcategory`, `roomtype`, `restatus`, `room_id`, `childbed`) VALUES
(1, '2014-04-15', '2014-05-20', 0, 8, 'standard', 'individual', 'occupied', 8, 1),
(2, '2014-04-15', '2014-05-20', 0, 9, 'standard', 'double', 'occupied', 28, 0),
(3, '2014-04-15', '2014-05-20', 0, 8, 'business', 'individual', 'occupied', 48, 0),
(4, '2014-04-15', '2014-05-20', 0, 9, 'business', 'double', 'occupied', 68, 1),
(5, '2014-04-15', '2014-05-20', 0, 8, 'high', 'individual', 'occupied', 88, 0),
(6, '2014-04-15', '2014-05-20', 0, 9, 'high', 'double', 'occupied', 108, 0),
(7, '2014-04-15', '2014-05-20', 0, 10, 'standard', 'individual', 'occupied', 9, 0),
(8, '2014-04-15', '2014-05-20', 0, 10, 'standard', 'double', 'occupied', 29, 0),
(9, '2014-04-15', '2014-05-20', 0, 10, 'business', 'individual', 'occupied', 49, 1),
(10, '2014-04-15', '2014-05-20', 0, 10, 'business', 'double', 'occupied', 69, 0),
(11, '2014-04-15', '2014-05-20', 0, 10, 'high', 'individual', 'occupied', 89, 1),
(12, '2014-04-15', '2014-05-20', 0, 10, 'high', 'double', 'occupied', 109, 1),
(13, '2014-05-01', '2014-05-20', 0, 11, 'standard', 'individual', 'active', NULL, 1),
(14, '2014-05-02', '2014-05-20', 0, 11, 'standard', 'double', 'active', NULL, 0),
(15, '2014-05-03', '2014-05-20', 0, 11, 'business', 'individual', 'active', NULL, 0),
(16, '2014-05-04', '2014-05-20', 0, 11, 'business', 'double', 'active', NULL, 1),
(17, '2014-05-01', '2014-05-20', 0, 11, 'high', 'individual', 'active', NULL, 1),
(18, '2014-05-07', '2014-05-20', 0, 11, 'high', 'double', 'active', NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Room`
--

CREATE TABLE IF NOT EXISTS `Room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tv` tinyint(1) NOT NULL,
  `shower` tinyint(1) NOT NULL,
  `jacuzzi` tinyint(1) NOT NULL,
  `music` tinyint(1) NOT NULL,
  `massage` tinyint(1) NOT NULL,
  `roomtype` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `roomcategory` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `roomstatus` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=121 ;

--
-- Volcado de datos para la tabla `Room`
--

INSERT INTO `Room` (`id`, `tv`, `shower`, `jacuzzi`, `music`, `massage`, `roomtype`, `roomcategory`, `roomstatus`) VALUES
(1, 0, 1, 0, 0, 0, 'individual', 'standard', 'free'),
(2, 0, 1, 0, 0, 0, 'individual', 'standard', 'free'),
(3, 0, 1, 0, 0, 0, 'individual', 'standard', 'free'),
(4, 0, 1, 0, 0, 0, 'individual', 'standard', 'free'),
(5, 0, 1, 0, 0, 0, 'individual', 'standard', 'free'),
(6, 0, 1, 0, 0, 0, 'individual', 'standard', 'free'),
(7, 0, 1, 0, 0, 0, 'individual', 'standard', 'free'),
(8, 0, 1, 0, 0, 0, 'individual', 'standard', 'occupied'),
(9, 0, 1, 0, 0, 0, 'individual', 'standard', 'occupied'),
(10, 0, 1, 0, 0, 0, 'individual', 'standard', 'free'),
(11, 0, 1, 0, 0, 0, 'individual', 'standard', 'free'),
(12, 0, 1, 0, 0, 0, 'individual', 'standard', 'free'),
(13, 0, 1, 0, 0, 0, 'individual', 'standard', 'free'),
(14, 0, 1, 0, 0, 0, 'individual', 'standard', 'free'),
(15, 0, 1, 0, 0, 0, 'individual', 'standard', 'free'),
(16, 0, 1, 0, 0, 0, 'individual', 'standard', 'free'),
(17, 0, 1, 0, 0, 0, 'individual', 'standard', 'free'),
(18, 0, 1, 0, 0, 0, 'individual', 'standard', 'free'),
(19, 0, 1, 0, 0, 0, 'individual', 'standard', 'free'),
(20, 0, 1, 0, 0, 0, 'individual', 'standard', 'free'),
(21, 0, 1, 0, 0, 0, 'double', 'standard', 'free'),
(22, 0, 1, 0, 0, 0, 'double', 'standard', 'free'),
(23, 0, 1, 0, 0, 0, 'double', 'standard', 'free'),
(24, 0, 1, 0, 0, 0, 'double', 'standard', 'free'),
(25, 0, 1, 0, 0, 0, 'double', 'standard', 'free'),
(26, 0, 1, 0, 0, 0, 'double', 'standard', 'free'),
(27, 0, 1, 0, 0, 0, 'double', 'standard', 'free'),
(28, 0, 1, 0, 0, 0, 'double', 'standard', 'occupied'),
(29, 0, 1, 0, 0, 0, 'double', 'standard', 'occupied'),
(30, 0, 1, 0, 0, 0, 'double', 'standard', 'free'),
(31, 0, 1, 0, 0, 0, 'double', 'standard', 'free'),
(32, 0, 1, 0, 0, 0, 'double', 'standard', 'free'),
(33, 0, 1, 0, 0, 0, 'double', 'standard', 'free'),
(34, 0, 1, 0, 0, 0, 'double', 'standard', 'free'),
(35, 0, 1, 0, 0, 0, 'double', 'standard', 'free'),
(36, 0, 1, 0, 0, 0, 'double', 'standard', 'free'),
(37, 0, 1, 0, 0, 0, 'double', 'standard', 'free'),
(38, 0, 1, 0, 0, 0, 'double', 'standard', 'free'),
(39, 0, 1, 0, 0, 0, 'double', 'standard', 'free'),
(40, 0, 1, 0, 0, 0, 'double', 'standard', 'free'),
(41, 0, 1, 0, 0, 0, 'individual', 'business', 'free'),
(42, 0, 1, 0, 0, 0, 'individual', 'business', 'free'),
(43, 0, 1, 0, 0, 0, 'individual', 'business', 'free'),
(44, 0, 1, 0, 0, 0, 'individual', 'business', 'free'),
(45, 0, 1, 0, 0, 0, 'individual', 'business', 'free'),
(46, 0, 1, 0, 0, 0, 'individual', 'business', 'free'),
(47, 0, 1, 0, 0, 0, 'individual', 'business', 'free'),
(48, 0, 1, 0, 0, 0, 'individual', 'business', 'occupied'),
(49, 0, 1, 0, 0, 0, 'individual', 'business', 'occupied'),
(50, 0, 1, 0, 0, 0, 'individual', 'business', 'free'),
(51, 0, 1, 0, 0, 0, 'individual', 'business', 'free'),
(52, 0, 1, 0, 0, 0, 'individual', 'business', 'free'),
(53, 0, 1, 0, 0, 0, 'individual', 'business', 'free'),
(54, 0, 1, 0, 0, 0, 'individual', 'business', 'free'),
(55, 0, 1, 0, 0, 0, 'individual', 'business', 'free'),
(56, 0, 1, 0, 0, 0, 'individual', 'business', 'free'),
(57, 0, 1, 0, 0, 0, 'individual', 'business', 'free'),
(58, 0, 1, 0, 0, 0, 'individual', 'business', 'free'),
(59, 0, 1, 0, 0, 0, 'individual', 'business', 'free'),
(60, 0, 1, 0, 0, 0, 'individual', 'business', 'free'),
(61, 0, 1, 0, 0, 0, 'double', 'business', 'free'),
(62, 0, 1, 0, 0, 0, 'double', 'business', 'free'),
(63, 0, 1, 0, 0, 0, 'double', 'business', 'free'),
(64, 0, 1, 0, 0, 0, 'double', 'business', 'free'),
(65, 0, 1, 0, 0, 0, 'double', 'business', 'free'),
(66, 0, 1, 0, 0, 0, 'double', 'business', 'free'),
(67, 0, 1, 0, 0, 0, 'double', 'business', 'free'),
(68, 0, 1, 0, 0, 0, 'double', 'business', 'occupied'),
(69, 0, 1, 0, 0, 0, 'double', 'business', 'occupied'),
(70, 0, 1, 0, 0, 0, 'double', 'business', 'free'),
(71, 0, 1, 0, 0, 0, 'double', 'business', 'free'),
(72, 0, 1, 0, 0, 0, 'double', 'business', 'free'),
(73, 0, 1, 0, 0, 0, 'double', 'business', 'free'),
(74, 0, 1, 0, 0, 0, 'double', 'business', 'free'),
(75, 0, 1, 0, 0, 0, 'double', 'business', 'free'),
(76, 0, 1, 0, 0, 0, 'double', 'business', 'free'),
(77, 0, 1, 0, 0, 0, 'double', 'business', 'free'),
(78, 0, 1, 0, 0, 0, 'double', 'business', 'free'),
(79, 0, 1, 0, 0, 0, 'double', 'business', 'free'),
(80, 0, 1, 0, 0, 0, 'double', 'business', 'free'),
(81, 0, 1, 0, 0, 0, 'individual', 'high', 'free'),
(82, 0, 1, 0, 0, 0, 'individual', 'high', 'free'),
(83, 0, 1, 0, 0, 0, 'individual', 'high', 'free'),
(84, 0, 1, 0, 0, 0, 'individual', 'high', 'free'),
(85, 0, 1, 0, 0, 0, 'individual', 'high', 'free'),
(86, 0, 1, 0, 0, 0, 'individual', 'high', 'free'),
(87, 0, 1, 0, 0, 0, 'individual', 'high', 'free'),
(88, 0, 1, 0, 0, 0, 'individual', 'high', 'occupied'),
(89, 0, 1, 0, 0, 0, 'individual', 'high', 'occupied'),
(90, 0, 1, 0, 0, 0, 'individual', 'high', 'free'),
(91, 0, 1, 0, 0, 0, 'individual', 'high', 'free'),
(92, 0, 1, 0, 0, 0, 'individual', 'high', 'free'),
(93, 0, 1, 0, 0, 0, 'individual', 'high', 'free'),
(94, 0, 1, 0, 0, 0, 'individual', 'high', 'free'),
(95, 0, 1, 0, 0, 0, 'individual', 'high', 'free'),
(96, 0, 1, 0, 0, 0, 'individual', 'high', 'free'),
(97, 0, 1, 0, 0, 0, 'individual', 'high', 'free'),
(98, 0, 1, 0, 0, 0, 'individual', 'high', 'free'),
(99, 0, 1, 0, 0, 0, 'individual', 'high', 'free'),
(100, 0, 1, 0, 0, 0, 'individual', 'high', 'free'),
(101, 0, 1, 0, 0, 0, 'double', 'high', 'free'),
(102, 0, 1, 0, 0, 0, 'double', 'high', 'free'),
(103, 0, 1, 0, 0, 0, 'double', 'high', 'free'),
(104, 0, 1, 0, 0, 0, 'double', 'high', 'free'),
(105, 0, 1, 0, 0, 0, 'double', 'high', 'free'),
(106, 0, 1, 0, 0, 0, 'double', 'high', 'free'),
(107, 0, 1, 0, 0, 0, 'double', 'high', 'free'),
(108, 0, 1, 0, 0, 0, 'double', 'high', 'occupied'),
(109, 0, 1, 0, 0, 0, 'double', 'high', 'occupied'),
(110, 0, 1, 0, 0, 0, 'double', 'high', 'free'),
(111, 0, 1, 0, 0, 0, 'double', 'high', 'free'),
(112, 0, 1, 0, 0, 0, 'double', 'high', 'free'),
(113, 0, 1, 0, 0, 0, 'double', 'high', 'free'),
(114, 0, 1, 0, 0, 0, 'double', 'high', 'free'),
(115, 0, 1, 0, 0, 0, 'double', 'high', 'free'),
(116, 0, 1, 0, 0, 0, 'double', 'high', 'free'),
(117, 0, 1, 0, 0, 0, 'double', 'high', 'free'),
(118, 0, 1, 0, 0, 0, 'double', 'high', 'free'),
(119, 0, 1, 0, 0, 0, 'double', 'high', 'free'),
(120, 0, 1, 0, 0, 0, 'double', 'high', 'free');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `User`
--

CREATE TABLE IF NOT EXISTS `User` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pass` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `idcard` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `birthdate` date NOT NULL,
  `creditcard` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `account` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `nationality` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `rif` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Volcado de datos para la tabla `User`
--

INSERT INTO `User` (`id`, `pass`, `firstname`, `lastname`, `email`, `gender`, `idcard`, `birthdate`, `creditcard`, `account`, `nationality`, `rif`, `role`) VALUES
(1, '123', 'nombre', 'apellido', 'prueba@gmail.com', 'male', '22222', '2008-01-01', '1234567890123456', 'current', 'venezuelan', 'V-123456789-9', 'standard'),
(2, '123', 'roynny', 'zambrano', 'roynny@gmail.com', 'male', '12219443', '1988-10-07', '1234567890123456', 'saving', 'venezuelan', 'V-22310143-9', 'standard'),
(3, '123', 'baltazar', 'apellido', 'baltazar@gmail.com', 'male', '222232', '2008-01-01', '1234567890123456', 'current', 'venezuelan', 'V-123456789-9', 'standard'),
(4, '123', 'royadmin', 'zambrano', 'royadmin@gmail.com', 'male', '210443', '1997-11-09', '1234567890123456', 'saving', 'venezuelan', 'V-42210243-9', 'admin'),
(5, '123', 'penoso', 'apellido', 'penoso@gmail.com', 'male', '224432', '2008-01-01', '1234567890123456', 'current', 'venezuelan', 'V-123456789-9', 'standard'),
(6, '123', 'vayaina', 'apellido', 'vayaina@gmail.com', 'male', '0000332', '2008-01-01', '1234567890123456', 'current', 'venezuelan', 'V-123456789-9', 'standard'),
(7, '12345', 'prueba', 'prueba', 'prueba2@gmail.com', 'male', '12345678', '1992-11-14', '1234567891123456', 'current', 'venezuelan', 'V-12321312-9', 'standard'),
(8, '123', 'reservador1', 'apellido', 'reservador1@gmail.com', 'male', '5000332', '2008-01-01', '1234567890123457', 'current', 'venezuelan', 'V-123456789-10', 'standard'),
(9, '123', 'reservador2', 'prueba', 'reservador2@gmail.com', 'male', '42345678', '1992-11-14', '1234567891123458', 'current', 'venezuelan', 'V-12321312-11', 'standard'),
(10, '123', 'reservador3', 'apellido', 'reservador3@gmail.com', 'male', '3000332', '2008-01-01', '1234567890123459', 'current', 'venezuelan', 'V-123456789-12', 'standard'),
(11, '123', 'reservador4', 'prueba', 'reservador4@gmail.com', 'male', '22345678', '1992-11-14', '1234567891123410', 'current', 'venezuelan', 'V-12321312-13', 'standard');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Bill`
--
ALTER TABLE `Bill`
  ADD CONSTRAINT `FK_DA13B6DDA76ED395` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`);

--
-- Filtros para la tabla `BillItems`
--
ALTER TABLE `BillItems`
  ADD CONSTRAINT `FK_C145C5B1A8C12F5` FOREIGN KEY (`bill_id`) REFERENCES `Bill` (`id`);

--
-- Filtros para la tabla `Consumable`
--
ALTER TABLE `Consumable`
  ADD CONSTRAINT `FK_B28F34545104AA6` FOREIGN KEY (`consumablestore_id`) REFERENCES `ConsumableStore` (`id`),
  ADD CONSTRAINT `FK_B28F3455913AEBF` FOREIGN KEY (`reserve_id`) REFERENCES `Reserve` (`id`);

--
-- Filtros para la tabla `PhoneCall`
--
ALTER TABLE `PhoneCall`
  ADD CONSTRAINT `FK_C47F1BD15913AEBF` FOREIGN KEY (`reserve_id`) REFERENCES `Reserve` (`id`);

--
-- Filtros para la tabla `Reserve`
--
ALTER TABLE `Reserve`
  ADD CONSTRAINT `FK_D05DD3BE54177093` FOREIGN KEY (`room_id`) REFERENCES `Room` (`id`),
  ADD CONSTRAINT `FK_D05DD3BEA76ED395` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
