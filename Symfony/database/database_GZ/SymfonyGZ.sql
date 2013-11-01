-- phpMyAdmin SQL Dump
-- version 4.0.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 22-10-2013 a las 10:33:27
-- Versión del servidor: 5.5.30-MariaDB-log
-- Versión de PHP: 5.4.15

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

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
(12, 'llamada_internacional', 5, 'normal', NULL, NULL),
(13, 'llamada_nacional', 1, 'normal', NULL, NULL),
(14, 'cama_niño', 10, 'normal', NULL, NULL),
(15, 'habitacion_individual', 40, 'normal', NULL, NULL),
(16, 'habitacion_doble', 70, 'normal', NULL, NULL),
(17, 'alojamiento', 1, 'normal', NULL, NULL),
(18, 'alojamiento', 1.3, 'business', NULL, NULL),
(19, 'alojamiento', 2, 'high', NULL, NULL);



--
-- Estructura de tabla para la tabla `Contact`
--

CREATE TABLE IF NOT EXISTS `Contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `message` longtext COLLATE utf8_unicode_ci NOT NULL,
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
  `childbeds` int(11) NOT NULL,
  `entrydate` date NOT NULL,
  `exitdate` date NOT NULL,
  `special` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `roomcategory` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `roomtype` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `roomstatus` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `room_id` int(11) DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Volcado de datos para la tabla `romm`
--

INSERT INTO `Room` (`id`, `roomtype`, `roomcategory`, `tv`, `shower`, `jacuzzi`, `music`, `massage`, `roomstatus`) VALUES
(1, 'individual', 'normal', 0, 1, 0, 0, 0, 'open'),
(2, 'individual', 'normal', 0, 1, 0, 0, 0, 'open'),
(3, 'individual', 'normal', 0, 1, 0, 0, 0, 'open'),
(4, 'individual', 'normal', 0, 1, 0, 0, 0, 'open'),
(5, 'individual', 'normal', 0, 1, 0, 0, 0, 'open'),
(6, 'individual', 'normal', 0, 1, 0, 0, 0, 'open'),
(7, 'individual', 'normal', 0, 1, 0, 0, 0, 'open'),
(8, 'individual', 'normal', 0, 1, 0, 0, 0, 'open'),
(9, 'individual', 'normal', 0, 1, 0, 0, 0, 'open'),
(10, 'individual', 'normal', 0, 1, 0, 0, 0, 'open'),
(11, 'individual', 'normal', 0, 1, 0, 0, 0, 'open'),
(12, 'individual', 'normal', 0, 1, 0, 0, 0, 'open'),
(13, 'individual', 'normal', 0, 1, 0, 0, 0, 'open'),
(14, 'individual', 'normal', 0, 1, 0, 0, 0, 'open'),
(15, 'individual', 'normal', 0, 1, 0, 0, 0, 'open'),
(16, 'individual', 'normal', 0, 1, 0, 0, 0, 'open'),
(17, 'individual', 'normal', 0, 1, 0, 0, 0, 'open'),
(18, 'individual', 'normal', 0, 1, 0, 0, 0, 'open'),
(19, 'individual', 'normal', 0, 1, 0, 0, 0, 'open'),
(20, 'individual', 'normal', 0, 1, 0, 0, 0, 'open'),
(21, 'double', 'normal', 0, 1, 0, 0, 0, 'open'),
(22, 'double', 'normal', 0, 1, 0, 0, 0, 'open'),
(23, 'double', 'normal', 0, 1, 0, 0, 0, 'open'),
(24, 'double', 'normal', 0, 1, 0, 0, 0, 'open'),
(25, 'double', 'normal', 0, 1, 0, 0, 0, 'open'),
(26, 'double', 'normal', 0, 1, 0, 0, 0, 'open'),
(27, 'double', 'normal', 0, 1, 0, 0, 0, 'open'),
(28, 'double', 'normal', 0, 1, 0, 0, 0, 'open'),
(29, 'double', 'normal', 0, 1, 0, 0, 0, 'open'),
(30, 'double', 'normal', 0, 1, 0, 0, 0, 'open'),
(31, 'double', 'normal', 0, 1, 0, 0, 0, 'open'),
(32, 'double', 'normal', 0, 1, 0, 0, 0, 'open'),
(33, 'double', 'normal', 0, 1, 0, 0, 0, 'open'),
(34, 'double', 'normal', 0, 1, 0, 0, 0, 'open'),
(35, 'double', 'normal', 0, 1, 0, 0, 0, 'open'),
(36, 'double', 'normal', 0, 1, 0, 0, 0, 'open'),
(37, 'double', 'normal', 0, 1, 0, 0, 0, 'open'),
(38, 'double', 'normal', 0, 1, 0, 0, 0, 'open'),
(39, 'double', 'normal', 0, 1, 0, 0, 0, 'open'),
(40, 'double', 'normal', 0, 1, 0, 0, 0, 'open'),
(41, 'individual', 'business', 0, 1, 0, 0, 0, 'open'),
(42, 'individual', 'business', 0, 1, 0, 0, 0, 'open'),
(43, 'individual', 'business', 0, 1, 0, 0, 0, 'open'),
(44, 'individual', 'business', 0, 1, 0, 0, 0, 'open'),
(45, 'individual', 'business', 0, 1, 0, 0, 0, 'open'),
(46, 'individual', 'business', 0, 1, 0, 0, 0, 'open'),
(47, 'individual', 'business', 0, 1, 0, 0, 0, 'open'),
(48, 'individual', 'business', 0, 1, 0, 0, 0, 'open'),
(49, 'individual', 'business', 0, 1, 0, 0, 0, 'open'),
(50, 'individual', 'business', 0, 1, 0, 0, 0, 'open'),
(51, 'individual', 'business', 0, 1, 0, 0, 0, 'open'),
(52, 'individual', 'business', 0, 1, 0, 0, 0, 'open'),
(53, 'individual', 'business', 0, 1, 0, 0, 0, 'open'),
(54, 'individual', 'business', 0, 1, 0, 0, 0, 'open'),
(55, 'individual', 'business', 0, 1, 0, 0, 0, 'open'),
(56, 'individual', 'business', 0, 1, 0, 0, 0, 'open'),
(57, 'individual', 'business', 0, 1, 0, 0, 0, 'open'),
(58, 'individual', 'business', 0, 1, 0, 0, 0, 'open'),
(59, 'individual', 'business', 0, 1, 0, 0, 0, 'open'),
(60, 'individual', 'business', 0, 1, 0, 0, 0, 'open'),
(61, 'double', 'business', 0, 1, 0, 0, 0, 'open'),
(62, 'double', 'business', 0, 1, 0, 0, 0, 'open'),
(63, 'double', 'business', 0, 1, 0, 0, 0, 'open'),
(64, 'double', 'business', 0, 1, 0, 0, 0, 'open'),
(65, 'double', 'business', 0, 1, 0, 0, 0, 'open'),
(66, 'double', 'business', 0, 1, 0, 0, 0, 'open'),
(67, 'double', 'business', 0, 1, 0, 0, 0, 'open'),
(68, 'double', 'business', 0, 1, 0, 0, 0, 'open'),
(69, 'double', 'business', 0, 1, 0, 0, 0, 'open'),
(70, 'double', 'business', 0, 1, 0, 0, 0, 'open'),
(71, 'double', 'business', 0, 1, 0, 0, 0, 'open'),
(72, 'double', 'business', 0, 1, 0, 0, 0, 'open'),
(73, 'double', 'business', 0, 1, 0, 0, 0, 'open'),
(74, 'double', 'business', 0, 1, 0, 0, 0, 'open'),
(75, 'double', 'business', 0, 1, 0, 0, 0, 'open'),
(76, 'double', 'business', 0, 1, 0, 0, 0, 'open'),
(77, 'double', 'business', 0, 1, 0, 0, 0, 'open'),
(78, 'double', 'business', 0, 1, 0, 0, 0, 'open'),
(79, 'double', 'business', 0, 1, 0, 0, 0, 'open'),
(80, 'double', 'business', 0, 1, 0, 0, 0, 'open'),
(81, 'individual', 'high', 0, 1, 0, 0, 0, 'open'),
(82, 'individual', 'high', 0, 1, 0, 0, 0, 'open'),
(83, 'individual', 'high', 0, 1, 0, 0, 0, 'open'),
(84, 'individual', 'high', 0, 1, 0, 0, 0, 'open'),
(85, 'individual', 'high', 0, 1, 0, 0, 0, 'open'),
(86, 'individual', 'high', 0, 1, 0, 0, 0, 'open'),
(87, 'individual', 'high', 0, 1, 0, 0, 0, 'open'),
(88, 'individual', 'high', 0, 1, 0, 0, 0, 'open'),
(89, 'individual', 'high', 0, 1, 0, 0, 0, 'open'),
(90, 'individual', 'high', 0, 1, 0, 0, 0, 'open'),
(91, 'individual', 'high', 0, 1, 0, 0, 0, 'open'),
(92, 'individual', 'high', 0, 1, 0, 0, 0, 'open'),
(93, 'individual', 'high', 0, 1, 0, 0, 0, 'open'),
(94, 'individual', 'high', 0, 1, 0, 0, 0, 'open'),
(95, 'individual', 'high', 0, 1, 0, 0, 0, 'open'),
(96, 'individual', 'high', 0, 1, 0, 0, 0, 'open'),
(97, 'individual', 'high', 0, 1, 0, 0, 0, 'open'),
(98, 'individual', 'high', 0, 1, 0, 0, 0, 'open'),
(99, 'individual', 'high', 0, 1, 0, 0, 0, 'open'),
(100, 'individual', 'high', 0, 1, 0, 0, 0, 'open'),
(101, 'double', 'high', 0, 1, 0, 0, 0, 'open'),
(102, 'double', 'high', 0, 1, 0, 0, 0, 'open'),
(103, 'double', 'high', 0, 1, 0, 0, 0, 'open'),
(104, 'double', 'high', 0, 1, 0, 0, 0, 'open'),
(105, 'double', 'high', 0, 1, 0, 0, 0, 'open'),
(106, 'double', 'high', 0, 1, 0, 0, 0, 'open'),
(107, 'double', 'high', 0, 1, 0, 0, 0, 'open'),
(108, 'double', 'high', 0, 1, 0, 0, 0, 'open'),
(109, 'double', 'high', 0, 1, 0, 0, 0, 'open'),
(110, 'double', 'high', 0, 1, 0, 0, 0, 'open'),
(111, 'double', 'high', 0, 1, 0, 0, 0, 'open'),
(112, 'double', 'high', 0, 1, 0, 0, 0, 'open'),
(113, 'double', 'high', 0, 1, 0, 0, 0, 'open'),
(114, 'double', 'high', 0, 1, 0, 0, 0, 'open'),
(115, 'double', 'high', 0, 1, 0, 0, 0, 'open'),
(116, 'double', 'high', 0, 1, 0, 0, 0, 'open'),
(117, 'double', 'high', 0, 1, 0, 0, 0, 'open'),
(118, 'double', 'high', 0, 1, 0, 0, 0, 'open'),
(119, 'double', 'high', 0, 1, 0, 0, 0, 'open'),
(120, 'double', 'high', 0, 1, 0, 0, 0, 'open');


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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `User`
--

INSERT INTO `User` (`id`, `pass`, `firstname`, `lastname`, `email`, `gender`, `idcard`, `birthdate`, `creditcard`, `account`, `nationality`, `rif`, `role`) VALUES
(1, '123', 'nombre', 'apellido', 'prueba@gmail.com', 'male', '22222', '2008-01-01', '1234567890123456', 'current', 'venezuelan', 'V-123456789-9', 'standard'),
(2, '123', 'roynny', 'zambrano', 'roynny@gmail.com', 'male', '12219443', '1988-10-7', '1234567890123456', 'saving', 'venezuelan', 'V-22310143-9', 'standard'),
(3, '123', 'baltazar', 'apellido', 'baltazar@gmail.com', 'male', '222232', '2008-01-01', '1234567890123456', 'current', 'venezuelan', 'V-123456789-9', 'standard'),
(4, '123', 'royadmin', 'zambrano', 'royadmin@gmail.com', 'male', '210443', '1997-11-09', '1234567890123456', 'saving', 'venezuelan', 'V-42210243-9', 'admin'),
(5, '123', 'penoso', 'apellido', 'penoso@gmail.com', 'male', '224432', '2008-01-01', '1234567890123456', 'current', 'venezuelan', 'V-123456789-9', 'standard'),
(6, '123', 'vayaina', 'apellido', 'vayaina@gmail.com', 'male', '0000332', '2008-01-01', '1234567890123456', 'current', 'venezuelan', 'V-123456789-9', 'standard');

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
