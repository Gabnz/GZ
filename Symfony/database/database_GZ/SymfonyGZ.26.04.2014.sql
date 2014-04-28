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
(1, 'cerveza', 5, 'normal', 996, 'Polar Light'),
(2, 'cerveza', 10, 'business', 492, 'Solera'),
(3, 'cerveza', 15, 'high', 300, 'Polar Xtreme'),
(4, 'vino', 10, 'normal', 98, 'San Andrés'),
(5, 'vino', 11, 'business', 226, 'Caminos de San Joaquín'),
(6, 'vino', 12, 'high', 250, 'Uvas del Cochinal'),
(7, 'alcohol', 25, 'normal', 96, 'Vokda Glacial'),
(8, 'alcohol', 35, 'business', 142, 'Santa Teresa'),
(9, 'alcohol', 75, 'high', 200, 'Droché 80 años - Edición Especial'),
(10, 'agua', 5, 'normal', 488, 'Minalba Pura de Manatial, eso dice la etiqueta'),
(11, 'refresco', 3, 'normal', 888, 'Pepsi-Cola'),
(12, 'llamada_internacional', 5, 'normal', 0, NULL),
(13, 'llamada_nacional', 1, 'normal', 0, NULL),
(14, 'cama_niño', 10, 'normal', 0, NULL),
(15, 'habitacion_individual', 40, 'normal', 0, NULL),
(16, 'habitacion_doble', 70, 'normal', 0, NULL),
(17, 'alojamiento', 1, 'normal', 0, NULL),
(18, 'alojamiento', 1.3, 'business', 0, NULL),
(19, 'alojamiento', 2, 'high', 0, NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

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

INSERT INTO `Room` (`id`, `tv`, `shower`, `jacuzzi`, `music`, `massage`, `roomtype`, `roomcategory`, `roomstatus`) VALUES
(2, 1, 1, 1, 1, 1, 'individual', 'standard', 'active'),
(5, 0, 1, 0, 0, 0, 'individual', 'normal', 'open'),
(8, 0, 1, 0, 0, 0, 'individual', 'normal', 'open'),
(11, 0, 1, 0, 0, 0, 'individual', 'normal', 'open'),
(12, 0, 1, 0, 0, 0, 'individual', 'normal', 'open'),
(13, 0, 1, 0, 0, 0, 'individual', 'normal', 'open'),
(14, 0, 1, 0, 0, 0, 'individual', 'normal', 'open'),
(15, 0, 1, 0, 0, 0, 'individual', 'normal', 'open'),
(16, 0, 1, 0, 0, 0, 'individual', 'normal', 'open'),
(17, 0, 1, 0, 0, 0, 'individual', 'normal', 'open'),
(18, 0, 1, 0, 0, 0, 'individual', 'normal', 'open'),
(19, 0, 1, 0, 0, 0, 'individual', 'normal', 'open'),
(20, 0, 1, 0, 0, 0, 'individual', 'normal', 'open'),
(21, 0, 1, 0, 0, 0, 'double', 'normal', 'open'),
(22, 0, 1, 0, 0, 0, 'double', 'normal', 'open'),
(23, 0, 1, 0, 0, 0, 'double', 'normal', 'open'),
(24, 0, 1, 0, 0, 0, 'double', 'normal', 'open'),
(25, 0, 1, 0, 0, 0, 'double', 'normal', 'open'),
(26, 0, 1, 0, 0, 0, 'double', 'normal', 'open'),
(27, 0, 1, 0, 0, 0, 'double', 'normal', 'open'),
(28, 0, 1, 0, 0, 0, 'double', 'normal', 'open'),
(29, 0, 1, 0, 0, 0, 'double', 'normal', 'open'),
(30, 0, 1, 0, 0, 0, 'double', 'normal', 'open'),
(31, 0, 1, 0, 0, 0, 'double', 'normal', 'open'),
(32, 0, 1, 0, 0, 0, 'double', 'normal', 'open'),
(33, 0, 1, 0, 0, 0, 'double', 'normal', 'open'),
(34, 0, 1, 0, 0, 0, 'double', 'normal', 'open'),
(35, 0, 1, 0, 0, 0, 'double', 'normal', 'open'),
(36, 0, 1, 0, 0, 0, 'double', 'normal', 'open'),
(37, 0, 1, 0, 0, 0, 'double', 'normal', 'open'),
(38, 0, 1, 0, 0, 0, 'double', 'normal', 'open'),
(39, 0, 1, 0, 0, 0, 'double', 'normal', 'open'),
(40, 0, 1, 0, 0, 0, 'double', 'normal', 'open'),
(41, 0, 1, 0, 0, 0, 'individual', 'business', 'open'),
(42, 0, 1, 0, 0, 0, 'individual', 'business', 'open'),
(43, 0, 1, 0, 0, 0, 'individual', 'business', 'open'),
(44, 0, 1, 0, 0, 0, 'individual', 'business', 'open'),
(45, 0, 1, 0, 0, 0, 'individual', 'business', 'open'),
(46, 0, 1, 0, 0, 0, 'individual', 'business', 'open'),
(47, 0, 1, 0, 0, 0, 'individual', 'business', 'open'),
(48, 0, 1, 0, 0, 0, 'individual', 'business', 'open'),
(49, 0, 1, 0, 0, 0, 'individual', 'business', 'open'),
(50, 0, 1, 0, 0, 0, 'individual', 'business', 'open'),
(51, 0, 1, 0, 0, 0, 'individual', 'business', 'open'),
(52, 0, 1, 0, 0, 0, 'individual', 'business', 'open'),
(53, 0, 1, 0, 0, 0, 'individual', 'business', 'open'),
(54, 0, 1, 0, 0, 0, 'individual', 'business', 'open'),
(55, 0, 1, 0, 0, 0, 'individual', 'business', 'open'),
(56, 0, 1, 0, 0, 0, 'individual', 'business', 'open'),
(57, 0, 1, 0, 0, 0, 'individual', 'business', 'open'),
(58, 0, 1, 0, 0, 0, 'individual', 'business', 'open'),
(59, 0, 1, 0, 0, 0, 'individual', 'business', 'open'),
(60, 0, 1, 0, 0, 0, 'individual', 'business', 'open'),
(61, 0, 1, 0, 0, 0, 'double', 'business', 'open'),
(62, 0, 1, 0, 0, 0, 'double', 'business', 'open'),
(63, 0, 1, 0, 0, 0, 'double', 'business', 'open'),
(64, 0, 1, 0, 0, 0, 'double', 'business', 'open'),
(65, 0, 1, 0, 0, 0, 'double', 'business', 'open'),
(66, 0, 1, 0, 0, 0, 'double', 'business', 'open'),
(67, 0, 1, 0, 0, 0, 'double', 'business', 'open'),
(68, 0, 1, 0, 0, 0, 'double', 'business', 'open'),
(69, 0, 1, 0, 0, 0, 'double', 'business', 'open'),
(70, 0, 1, 0, 0, 0, 'double', 'business', 'open'),
(71, 0, 1, 0, 0, 0, 'double', 'business', 'open'),
(72, 0, 1, 0, 0, 0, 'double', 'business', 'open'),
(73, 0, 1, 0, 0, 0, 'double', 'business', 'open'),
(74, 0, 1, 0, 0, 0, 'double', 'business', 'open'),
(75, 0, 1, 0, 0, 0, 'double', 'business', 'open'),
(76, 0, 1, 0, 0, 0, 'double', 'business', 'open'),
(77, 0, 1, 0, 0, 0, 'double', 'business', 'open'),
(78, 0, 1, 0, 0, 0, 'double', 'business', 'open'),
(79, 0, 1, 0, 0, 0, 'double', 'business', 'open'),
(80, 0, 1, 0, 0, 0, 'double', 'business', 'open'),
(81, 0, 1, 0, 0, 0, 'individual', 'high', 'open'),
(82, 0, 1, 0, 0, 0, 'individual', 'high', 'open'),
(83, 0, 1, 0, 0, 0, 'individual', 'high', 'open'),
(84, 0, 1, 0, 0, 0, 'individual', 'high', 'open'),
(85, 0, 1, 0, 0, 0, 'individual', 'high', 'open'),
(86, 0, 1, 0, 0, 0, 'individual', 'high', 'open'),
(87, 0, 1, 0, 0, 0, 'individual', 'high', 'open'),
(88, 0, 1, 0, 0, 0, 'individual', 'high', 'open'),
(89, 0, 1, 0, 0, 0, 'individual', 'high', 'open'),
(90, 0, 1, 0, 0, 0, 'individual', 'high', 'open'),
(91, 0, 1, 0, 0, 0, 'individual', 'high', 'open'),
(92, 0, 1, 0, 0, 0, 'individual', 'high', 'open'),
(93, 0, 1, 0, 0, 0, 'individual', 'high', 'open'),
(94, 0, 1, 0, 0, 0, 'individual', 'high', 'open'),
(95, 0, 1, 0, 0, 0, 'individual', 'high', 'open'),
(96, 0, 1, 0, 0, 0, 'individual', 'high', 'open'),
(97, 0, 1, 0, 0, 0, 'individual', 'high', 'open'),
(98, 0, 1, 0, 0, 0, 'individual', 'high', 'open'),
(99, 0, 1, 0, 0, 0, 'individual', 'high', 'open'),
(100, 0, 1, 0, 0, 0, 'individual', 'high', 'open'),
(101, 0, 1, 0, 0, 0, 'double', 'high', 'open'),
(102, 0, 1, 0, 0, 0, 'double', 'high', 'open'),
(103, 0, 1, 0, 0, 0, 'double', 'high', 'open'),
(104, 0, 1, 0, 0, 0, 'double', 'high', 'open'),
(105, 0, 1, 0, 0, 0, 'double', 'high', 'open'),
(106, 0, 1, 0, 0, 0, 'double', 'high', 'open'),
(107, 0, 1, 0, 0, 0, 'double', 'high', 'open'),
(108, 0, 1, 0, 0, 0, 'double', 'high', 'open'),
(109, 0, 1, 0, 0, 0, 'double', 'high', 'open'),
(110, 0, 1, 0, 0, 0, 'double', 'high', 'open'),
(111, 0, 1, 0, 0, 0, 'double', 'high', 'open'),
(112, 0, 1, 0, 0, 0, 'double', 'high', 'open'),
(113, 0, 1, 0, 0, 0, 'double', 'high', 'open'),
(114, 0, 1, 0, 0, 0, 'double', 'high', 'open'),
(115, 0, 1, 0, 0, 0, 'double', 'high', 'open'),
(116, 0, 1, 0, 0, 0, 'double', 'high', 'open'),
(117, 0, 1, 0, 0, 0, 'double', 'high', 'open'),
(118, 0, 1, 0, 0, 0, 'double', 'high', 'open'),
(119, 0, 1, 0, 0, 0, 'double', 'high', 'open'),
(120, 0, 1, 0, 0, 0, 'double', 'high', 'open'),
(121, 1, 1, 1, 1, 1, 'double', 'standard', 'active');

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
(7, '12345', 'prueba', 'prueba', 'prueba2@gmail.com', 'male', '12345678', '1992-11-14', '1234567891123456', 'current', 'venezuelan', 'V-12321312-9', 'standard');

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
