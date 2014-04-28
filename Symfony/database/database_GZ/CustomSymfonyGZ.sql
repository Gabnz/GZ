-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 26-04-2014 a las 12:30:39
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
  PRIMARY KEY (`id`),
  KEY `IDX_DA13B6DDA76ED395` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

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
(1, 'cerveza', 15, 'standard', 996, 'Polar Light'),
(2, 'cerveza', 20, 'business', 492, 'Solera'),
(3, 'cerveza', 35, 'high', 300, 'Polar Xtreme'),
(4, 'vino', 20, 'standard', 98, 'San Andrés'),
(5, 'vino', 31, 'business', 226, 'Caminos de San Joaquín'),
(6, 'vino', 42, 'high', 250, 'Uvas del Cochinal'),
(7, 'alcohol', 35, 'standard', 96, 'Vokda Glacial'),
(8, 'alcohol', 45, 'business', 142, 'Santa Teresa'),
(9, 'alcohol', 85, 'high', 200, 'Droché 80 años - Edición Especial'),
(10, 'agua', 10, 'standard', 488, 'Minalba Pura de Manatial, eso dice la etiqueta'),
(11, 'refresco', 20, 'standard', 888, 'Pepsi-Cola'),
(12, 'llamada_internacional', 10, 'standard', 0, NULL),
(13, 'llamada_nacional', 5, 'standard', 0, NULL),
(14, 'cama_niño', 20, 'standard', 0, NULL),
(15, 'individual', 100, 'standard', 0, NULL),
(16, 'double', 200, 'standard', 0, NULL),
(17, 'standard', 2, 'standard', 0, NULL),
(18, 'business', 2.5, 'business', 0, NULL),
(19, 'high', 4, 'high', 0, NULL);


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Disparadores `consumible`
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


--
-- Volcado de datos para la tabla `consumible`
--

INSERT INTO `Consumable` (`id`, `reserve_id`, `consumablestore_id`, `amount`) VALUES
(1, 1, 1, 4),
(2, 1, 4, 2),
(3, 1, 10, 4),
(4, 1, 11, 4),
(5, 1, 7, 4),
(6, 2, 1, 4),
(7, 2, 4, 2),
(8, 2, 10, 4),
(9, 2, 11, 4),
(10, 2, 7, 4),
(11, 3, 2, 4),
(12, 3, 5, 2),
(13, 3, 10, 4),
(14, 3, 11, 4),
(15, 3, 8, 4),
(16, 4, 2, 4),
(17, 4, 5, 2),
(18, 4, 10, 4),
(19, 4, 11, 4),
(20, 4, 8, 4),
(21, 5, 3, 4),
(22, 5, 6, 2),
(23, 5, 10, 4),
(24, 5, 11, 4),
(25, 5, 9, 4),
(26, 6, 3, 4),
(27, 6, 6, 2),
(28, 6, 10, 4),
(29, 6, 11, 4),
(30, 6, 9, 4);

--
-- (31, 7, 1, 4),
-- (32, 7, 4, 2),
-- (33, 7, 10, 4),
-- (34, 7, 11, 4),
-- (35, 7, 7, 4),
-- (36, 8, 1, 4),
-- (37, 8, 4, 2),
-- (38, 8, 10, 4),
-- (39, 8, 11, 4),
-- (40, 8, 7, 4),
-- (41, 9, 2, 4),
-- (42, 9, 5, 2),
-- (43, 9, 10, 4),
-- (44, 9, 11, 4),
-- (45, 9, 8, 4),
-- (46, 10, 2, 4),
-- (47, 10, 5, 2),
-- (48, 10, 10, 4),
-- (49, 10, 11, 4),
-- (50, 10, 8, 4),
-- (51, 11, 3, 4),
-- (52, 11, 6, 2),
-- (53, 11, 10, 4),
-- (54, 11, 11, 4),
-- (55, 11, 9, 4),
-- (56, 12, 3, 4),
-- (57, 12, 6, 2),
-- (58, 12, 10, 4),
-- (59, 12, 11, 4),
-- (60, 12, 9, 4);
-- 


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Volcado de datos para la tabla `llamadas_tlfs`
--

INSERT INTO `PhoneCall` (`id`, `reserve_id`, `calldate`, `starttime`, `endtime`, `phonenumber`, `calltype`) VALUES
(1, 1, '2014-04-16', '12:22:01', '12:23:00', '9532132132168', 'international'),
(2, 2, '2014-04-17', '12:40:00', '12:50:00', '04265842524', 'national'),
(3, 3, '2014-04-18', '12:22:01', '12:23:00', '04264484827', 'national'),
(4, 4, '2014-04-19', '12:40:00', '13:40:00', '04145844721', 'national'),
(5, 5, '2014-04-20', '22:40:00', '22:50:00', '892312132131', 'international'),
(6, 6, '2014-04-16', '09:30:00', '09:50:22', '02418236631', 'national'),
(7, 1, '2014-04-17', '09:30:00', '09:50:22', '04145855539', 'national'),
(8, 2, '2014-04-20', '12:30:00', '12:40:34', '04120388544', 'international');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=122 ;

--
-- Volcado de datos para la tabla `Room`
--
INSERT INTO `Room` (`id`, `roomtype`, `roomcategory`, `tv`, `shower`, `jacuzzi`, `music`, `massage`, `roomstatus`) VALUES
(1, 'individual', 'standard', 0, 1, 0, 0, 0, 'free'),
(2, 'individual', 'standard', 0, 1, 0, 0, 0, 'free'),
(3, 'individual', 'standard', 0, 1, 0, 0, 0, 'free'),
(4, 'individual', 'standard', 0, 1, 0, 0, 0, 'free'),
(5, 'individual', 'standard', 0, 1, 0, 0, 0, 'free'),
(6, 'individual', 'standard', 0, 1, 0, 0, 0, 'free'),
(7, 'individual', 'standard', 0, 1, 0, 0, 0, 'free'),
(8, 'individual', 'standard', 0, 1, 0, 0, 0, 'occupied'),
(9, 'individual', 'standard', 0, 1, 0, 0, 0, 'free'),
(10, 'individual', 'standard', 0, 1, 0, 0, 0, 'free'),
(11, 'individual', 'standard', 0, 1, 0, 0, 0, 'free'),
(12, 'individual', 'standard', 0, 1, 0, 0, 0, 'free'),
(13, 'individual', 'standard', 0, 1, 0, 0, 0, 'free'),
(14, 'individual', 'standard', 0, 1, 0, 0, 0, 'free'),
(15, 'individual', 'standard', 0, 1, 0, 0, 0, 'free'),
(16, 'individual', 'standard', 0, 1, 0, 0, 0, 'free'),
(17, 'individual', 'standard', 0, 1, 0, 0, 0, 'free'),
(18, 'individual', 'standard', 0, 1, 0, 0, 0, 'free'),
(19, 'individual', 'standard', 0, 1, 0, 0, 0, 'free'),
(20, 'individual', 'standard', 0, 1, 0, 0, 0, 'free'),
(21, 'double', 'standard', 0, 1, 0, 0, 0, 'free'),
(22, 'double', 'standard', 0, 1, 0, 0, 0, 'free'),
(23, 'double', 'standard', 0, 1, 0, 0, 0, 'free'),
(24, 'double', 'standard', 0, 1, 0, 0, 0, 'free'),
(25, 'double', 'standard', 0, 1, 0, 0, 0, 'free'),
(26, 'double', 'standard', 0, 1, 0, 0, 0, 'free'),
(27, 'double', 'standard', 0, 1, 0, 0, 0, 'free'),
(28, 'double', 'standard', 0, 1, 0, 0, 0, 'occupied'),
(29, 'double', 'standard', 0, 1, 0, 0, 0, 'free'),
(30, 'double', 'standard', 0, 1, 0, 0, 0, 'free'),
(31, 'double', 'standard', 0, 1, 0, 0, 0, 'free'),
(32, 'double', 'standard', 0, 1, 0, 0, 0, 'free'),
(33, 'double', 'standard', 0, 1, 0, 0, 0, 'free'),
(34, 'double', 'standard', 0, 1, 0, 0, 0, 'free'),
(35, 'double', 'standard', 0, 1, 0, 0, 0, 'free'),
(36, 'double', 'standard', 0, 1, 0, 0, 0, 'free'),
(37, 'double', 'standard', 0, 1, 0, 0, 0, 'free'),
(38, 'double', 'standard', 0, 1, 0, 0, 0, 'free'),
(39, 'double', 'standard', 0, 1, 0, 0, 0, 'free'),
(40, 'double', 'standard', 0, 1, 0, 0, 0, 'free'),
(41, 'individual', 'business', 0, 1, 0, 0, 0, 'free'),
(42, 'individual', 'business', 0, 1, 0, 0, 0, 'free'),
(43, 'individual', 'business', 0, 1, 0, 0, 0, 'free'),
(44, 'individual', 'business', 0, 1, 0, 0, 0, 'free'),
(45, 'individual', 'business', 0, 1, 0, 0, 0, 'free'),
(46, 'individual', 'business', 0, 1, 0, 0, 0, 'free'),
(47, 'individual', 'business', 0, 1, 0, 0, 0, 'free'),
(48, 'individual', 'business', 0, 1, 0, 0, 0, 'occupied'),
(49, 'individual', 'business', 0, 1, 0, 0, 0, 'free'),
(50, 'individual', 'business', 0, 1, 0, 0, 0, 'free'),
(51, 'individual', 'business', 0, 1, 0, 0, 0, 'free'),
(52, 'individual', 'business', 0, 1, 0, 0, 0, 'free'),
(53, 'individual', 'business', 0, 1, 0, 0, 0, 'free'),
(54, 'individual', 'business', 0, 1, 0, 0, 0, 'free'),
(55, 'individual', 'business', 0, 1, 0, 0, 0, 'free'),
(56, 'individual', 'business', 0, 1, 0, 0, 0, 'free'),
(57, 'individual', 'business', 0, 1, 0, 0, 0, 'free'),
(58, 'individual', 'business', 0, 1, 0, 0, 0, 'free'),
(59, 'individual', 'business', 0, 1, 0, 0, 0, 'free'),
(60, 'individual', 'business', 0, 1, 0, 0, 0, 'free'),
(61, 'double', 'business', 0, 1, 0, 0, 0, 'free'),
(62, 'double', 'business', 0, 1, 0, 0, 0, 'free'),
(63, 'double', 'business', 0, 1, 0, 0, 0, 'free'),
(64, 'double', 'business', 0, 1, 0, 0, 0, 'free'),
(65, 'double', 'business', 0, 1, 0, 0, 0, 'free'),
(66, 'double', 'business', 0, 1, 0, 0, 0, 'free'),
(67, 'double', 'business', 0, 1, 0, 0, 0, 'free'),
(68, 'double', 'business', 0, 1, 0, 0, 0, 'occupied'),
(69, 'double', 'business', 0, 1, 0, 0, 0, 'free'),
(70, 'double', 'business', 0, 1, 0, 0, 0, 'free'),
(71, 'double', 'business', 0, 1, 0, 0, 0, 'free'),
(72, 'double', 'business', 0, 1, 0, 0, 0, 'free'),
(73, 'double', 'business', 0, 1, 0, 0, 0, 'free'),
(74, 'double', 'business', 0, 1, 0, 0, 0, 'free'),
(75, 'double', 'business', 0, 1, 0, 0, 0, 'free'),
(76, 'double', 'business', 0, 1, 0, 0, 0, 'free'),
(77, 'double', 'business', 0, 1, 0, 0, 0, 'free'),
(78, 'double', 'business', 0, 1, 0, 0, 0, 'free'),
(79, 'double', 'business', 0, 1, 0, 0, 0, 'free'),
(80, 'double', 'business', 0, 1, 0, 0, 0, 'free'),
(81, 'individual', 'high', 0, 1, 0, 0, 0, 'free'),
(82, 'individual', 'high', 0, 1, 0, 0, 0, 'free'),
(83, 'individual', 'high', 0, 1, 0, 0, 0, 'free'),
(84, 'individual', 'high', 0, 1, 0, 0, 0, 'free'),
(85, 'individual', 'high', 0, 1, 0, 0, 0, 'free'),
(86, 'individual', 'high', 0, 1, 0, 0, 0, 'free'),
(87, 'individual', 'high', 0, 1, 0, 0, 0, 'free'),
(88, 'individual', 'high', 0, 1, 0, 0, 0, 'occupied'),
(89, 'individual', 'high', 0, 1, 0, 0, 0, 'free'),
(90, 'individual', 'high', 0, 1, 0, 0, 0, 'free'),
(91, 'individual', 'high', 0, 1, 0, 0, 0, 'free'),
(92, 'individual', 'high', 0, 1, 0, 0, 0, 'free'),
(93, 'individual', 'high', 0, 1, 0, 0, 0, 'free'),
(94, 'individual', 'high', 0, 1, 0, 0, 0, 'free'),
(95, 'individual', 'high', 0, 1, 0, 0, 0, 'free'),
(96, 'individual', 'high', 0, 1, 0, 0, 0, 'free'),
(97, 'individual', 'high', 0, 1, 0, 0, 0, 'free'),
(98, 'individual', 'high', 0, 1, 0, 0, 0, 'free'),
(99, 'individual', 'high', 0, 1, 0, 0, 0, 'free'),
(100, 'individual', 'high', 0, 1, 0, 0, 0, 'free'),
(101, 'double', 'high', 0, 1, 0, 0, 0, 'free'),
(102, 'double', 'high', 0, 1, 0, 0, 0, 'free'),
(103, 'double', 'high', 0, 1, 0, 0, 0, 'free'),
(104, 'double', 'high', 0, 1, 0, 0, 0, 'free'),
(105, 'double', 'high', 0, 1, 0, 0, 0, 'free'),
(106, 'double', 'high', 0, 1, 0, 0, 0, 'free'),
(107, 'double', 'high', 0, 1, 0, 0, 0, 'free'),
(108, 'double', 'high', 0, 1, 0, 0, 0, 'occupied'),
(109, 'double', 'high', 0, 1, 0, 0, 0, 'free'),
(110, 'double', 'high', 0, 1, 0, 0, 0, 'free'),
(111, 'double', 'high', 0, 1, 0, 0, 0, 'free'),
(112, 'double', 'high', 0, 1, 0, 0, 0, 'free'),
(113, 'double', 'high', 0, 1, 0, 0, 0, 'free'),
(114, 'double', 'high', 0, 1, 0, 0, 0, 'free'),
(115, 'double', 'high', 0, 1, 0, 0, 0, 'free'),
(116, 'double', 'high', 0, 1, 0, 0, 0, 'free'),
(117, 'double', 'high', 0, 1, 0, 0, 0, 'free'),
(118, 'double', 'high', 0, 1, 0, 0, 0, 'free'),
(119, 'double', 'high', 0, 1, 0, 0, 0, 'free'),
(120, 'double', 'high', 0, 1, 0, 0, 0, 'free');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Volcado de datos para la tabla `reserva_ocupa`
--

INSERT INTO `Reserve` (`id`, `entrydate`, `exitdate`, `special`, `user_id`, `roomcategory`, `roomtype`, `restatus`, `room_id`, `childbed`) VALUES
(1, '2014-05-15', '2014-05-30', 0 , 8 , 'standard', 'individual' , 'occupied', 8, 0),
(2, '2014-05-15', '2014-05-30', 0 , 9 , 'standard', 'double' , 'occupied', 28, 1),

(3, '2014-05-15', '2014-05-30', 0 , 8 , 'bussiness', 'individual' , 'occupied', 48, 0),
(4, '2014-05-15', '2014-05-30', 0 , 9 , 'bussiness', 'double' , 'occupied', 68, 2),

(5, '2014-05-15', '2014-05-30', 0 , 8 , 'high', 'individual' , 'occupied', 88, 0),
(6, '2014-05-15', '2014-05-30', 0 , 9, 'high', 'double' , 'occupied', 108, 0),

(7, '2014-05-15', '2014-05-30', 0 , 10 , 'standard', 'individual' , 'canceled', NULL, 1),
(8, '2014-05-15', '2014-05-30', 0 , 10, 'standard', 'double' , 'canceled', NULL, 0),

(9, '2014-05-15', '2014-05-30', 0 , 10, 'bussiness', 'individual' , 'canceled', NULL, 2),
(10, '2014-05-15', '2014-05-30', 0 , 10, 'bussiness', 'double' , 'canceled', NULL, 0),

(11, '2014-05-15', '2014-05-30', 0 , 10, 'high', 'individual' , 'canceled', NULL, 0),
(12, '2014-05-15', '2014-05-30', 0 , 10, 'high', 'double' , 'canceled', NULL, 0),

(13, '2014-05-15', '2014-05-30', 0 , 11, 'standard', 'individual' , 'active', NULL, 0),
(14, '2014-05-15', '2014-05-30', 0 , 11, 'standard', 'double' , 'active', NULL, 0),

(15, '2014-05-15', '2014-05-30', 0 , 11, 'bussiness', 'individual' , 'active', NULL, 0),
(16, '2014-05-15', '2014-05-30', 0 , 11, 'bussiness', 'double' , 'active', NULL, 0),

(17, '2014-05-15', '2014-05-30', 0 , 11, 'high', 'individual' , 'active', NULL, 0),
(18, '2014-05-15', '2014-05-30', 0 , 11, 'high', 'double' , 'active', NULL, 0);



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
