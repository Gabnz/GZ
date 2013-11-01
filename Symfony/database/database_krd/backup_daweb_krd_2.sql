-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 08-08-2013 a las 03:16:45
-- Versión del servidor: 5.5.31
-- Versión de PHP: 5.3.10-1ubuntu3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `daweb_krd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('98706ccb923f4bcdb1643ea9fd8a0797', '127.0.0.1', 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', 1375947969, 'a:4:{s:9:"user_data";s:0:"";s:9:"logged_in";b:1;s:8:"username";s:8:"invitado";s:3:"rol";s:8:"invitado";}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consumible`
--

CREATE TABLE IF NOT EXISTS `consumible` (
  `id_consumible` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único autoincrementable.',
  `id_reserva_ocupa` int(11) NOT NULL COMMENT 'Clave foránea en la tabla\nid_reserva_ocupa.',
  `ids_consumible_almacen` int(11) NOT NULL COMMENT 'Clave foránea en id_consumible almancen.',
  `cantidad` int(11) NOT NULL COMMENT 'cantidad adquirida de un producto.',
  PRIMARY KEY (`id_consumible`,`id_reserva_ocupa`),
  KEY `fk_consumible_almacen_consumible` (`ids_consumible_almacen`) USING BTREE,
  KEY `fk_consumible_reserva_ocupa` (`id_reserva_ocupa`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Se guardán los productos asociados al minibar en función de ' AUTO_INCREMENT=16 ;

--
-- Volcado de datos para la tabla `consumible`
--

INSERT INTO `consumible` (`id_consumible`, `id_reserva_ocupa`, `ids_consumible_almacen`, `cantidad`) VALUES
(1, 1, 2, 4),
(2, 1, 5, 2),
(3, 1, 10, 4),
(4, 1, 11, 4),
(5, 1, 8, 4),
(6, 51, 1, 4),
(7, 51, 4, 2),
(8, 51, 10, 4),
(9, 51, 11, 4),
(10, 51, 7, 4),
(11, 27, 2, 4),
(12, 27, 5, 2),
(13, 27, 10, 4),
(14, 27, 11, 4),
(15, 27, 8, 4);

--
-- Disparadores `consumible`
--
DROP TRIGGER IF EXISTS `restar_consumible_almacen`;
DELIMITER //
CREATE TRIGGER `restar_consumible_almacen` AFTER INSERT ON `consumible`
 FOR EACH ROW BEGIN
    UPDATE consumible_almacen SET cantidad = cantidad - NEW.cantidad
    WHERE consumible_almacen.id_consumible_almacen = NEW.ids_consumible_almacen;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consumible_almacen`
--

CREATE TABLE IF NOT EXISTS `consumible_almacen` (
  `id_consumible_almacen` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único \nautoincrementable.',
  `nombre` varchar(50) NOT NULL COMMENT 'Descripción del elemento\n\nDominio{llamada_internacional. llamada_nacional, cerveza,\nvino, alcohol, agua, refresco}',
  `precio` float NOT NULL COMMENT 'Valor monetario del item\no servicio.',
  `categoria` enum('N','B','A') NOT NULL COMMENT 'Dominio {N, B, A}\n\nNormal: N\nBusiness: B\nAlta: A\n\nSegún la categoria\ncambia el precio\n',
  `cantidad` int(11) DEFAULT NULL COMMENT 'Cantidad de items existentes\nen inventario.',
  `marca` varchar(200) DEFAULT NULL COMMENT 'Marca del item. Aplica sólo\ncuando es un item, no para\nlos servicios. ',
  PRIMARY KEY (`id_consumible_almacen`),
  KEY `NOMBRE` (`nombre`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Aquí se guardarán los precios y descripciones actuales de ca' AUTO_INCREMENT=20 ;

--
-- Volcado de datos para la tabla `consumible_almacen`
--

INSERT INTO `consumible_almacen` (`id_consumible_almacen`, `nombre`, `precio`, `categoria`, `cantidad`, `marca`) VALUES
(1, 'cerveza', 5, 'N', 996, 'Polar Light'),
(2, 'cerveza', 10, 'B', 492, 'Solera'),
(3, 'cerveza', 15, 'A', 300, 'Polar Xtreme'),
(4, 'vino', 10, 'N', 98, 'San Andrés'),
(5, 'vino', 11, 'B', 226, 'Caminos de San Joaquín'),
(6, 'vino', 12, 'A', 250, 'Uvas del Cochinal'),
(7, 'alcohol', 25, 'N', 96, 'Vokda Glacial'),
(8, 'alcohol', 35, 'B', 142, 'Santa Teresa'),
(9, 'alcohol', 75, 'A', 200, 'Droché 80 años - Edición Especial'),
(10, 'agua', 5, 'N', 488, 'Minalba Pura de Manatial, eso dice la etiqueta'),
(11, 'refresco', 3, 'N', 888, 'Pepsi-Cola'),
(12, 'llamada_internacional', 5, 'N', NULL, NULL),
(13, 'llamada_nacional', 1, 'N', NULL, NULL),
(14, 'cama_niño', 10, 'N', NULL, NULL),
(15, 'habitacion_individual', 40, 'N', NULL, NULL),
(16, 'habitacion_doble', 70, 'N', NULL, NULL),
(17, 'alojamiento', 1, 'N', NULL, NULL),
(18, 'alojamiento', 1.3, 'B', NULL, NULL),
(19, 'alojamiento', 2, 'A', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE IF NOT EXISTS `factura` (
  `id_factura` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único\nautoincrementable de\nla tabla factura.',
  `id_usuario` varchar(100) DEFAULT NULL COMMENT 'id del usuario. Clave\nforánea en la tabla\nusuario.',
  `fecha_emision` date NOT NULL COMMENT 'Fecha de emisión de\nla factura.\n\nFormato: YY:MM:DD',
  `estatus_factura` enum('actual','vieja') NOT NULL DEFAULT 'actual' COMMENT 'Dominio{actual, vieja}',
  PRIMARY KEY (`id_factura`),
  KEY `fk_factura_usuario` (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Facturas de cada usuario.' AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`id_factura`, `id_usuario`, `fecha_emision`, `estatus_factura`) VALUES
(1, 'sandrab86', '2013-08-08', 'actual'),
(2, 'baltazar666', '2013-08-08', 'actual'),
(3, 'paola', '2013-08-08', 'actual'),
(4, 'pepe', '2013-08-08', 'actual');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitacion`
--

CREATE TABLE IF NOT EXISTS `habitacion` (
  `id_habitacion` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único autoincrementable\n',
  `tipo` int(11) NOT NULL DEFAULT '1' COMMENT 'Está dado por el número\nde camas estándares:\n\nDominio:{1,2}\n1: Individual\n2: Doble',
  `categoria` enum('N','B','A') NOT NULL DEFAULT 'N' COMMENT 'Dominio {N, B, A}\nNormal: N\nBusiness: B\nAlta: A\n\nSegún la categoria\ncambia el precio\n',
  `serv_tv` tinyint(1) DEFAULT '0' COMMENT 'Booleano que identifica\nsi posee o no el servicio de\ntelevisión',
  `serv_ducha` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Booleano que identifica\nsi posee o no el servicio de\nducha. Por defecto todas\nlas habitaciones lo posee',
  `serv_yacusi` tinyint(1) DEFAULT '0' COMMENT 'Booleano que identifica\nsi posee o no el servicio de\nyacusi',
  `serv_musica` tinyint(1) DEFAULT '0' COMMENT 'Booleano que identifica\nsi posee o no el servicio de\nmúsica',
  `serv_masaje` tinyint(1) DEFAULT '0' COMMENT 'Booleano que identifica\nsi posee o no el servicio de\nmasaje',
  `estatus_habitacion` enum('ocupada','libre') NOT NULL DEFAULT 'libre' COMMENT 'Para saber qué estatus tiene\nla habitación y así\npoder asociarla posteriormente\na una reserva.',
  PRIMARY KEY (`id_habitacion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Habitaciones que se encuentran en el hotel.' AUTO_INCREMENT=121 ;

--
-- Volcado de datos para la tabla `habitacion`
--

INSERT INTO `habitacion` (`id_habitacion`, `tipo`, `categoria`, `serv_tv`, `serv_ducha`, `serv_yacusi`, `serv_musica`, `serv_masaje`, `estatus_habitacion`) VALUES
(1, 1, 'N', 0, 1, 0, 0, 0, 'libre'),
(2, 1, 'N', 0, 1, 0, 0, 0, 'libre'),
(3, 1, 'N', 0, 1, 0, 0, 0, 'libre'),
(4, 1, 'N', 0, 1, 0, 0, 0, 'libre'),
(5, 1, 'N', 0, 1, 0, 0, 0, 'libre'),
(6, 1, 'N', 0, 1, 0, 0, 0, 'libre'),
(7, 1, 'N', 0, 1, 0, 0, 0, 'libre'),
(8, 1, 'N', 0, 1, 0, 0, 0, 'libre'),
(9, 1, 'N', 0, 1, 0, 0, 0, 'libre'),
(10, 1, 'N', 0, 1, 0, 0, 0, 'libre'),
(11, 1, 'N', 0, 1, 0, 0, 0, 'libre'),
(12, 1, 'N', 0, 1, 0, 0, 0, 'libre'),
(13, 1, 'N', 0, 1, 0, 0, 0, 'libre'),
(14, 1, 'N', 0, 1, 0, 0, 0, 'libre'),
(15, 1, 'N', 0, 1, 0, 0, 0, 'libre'),
(16, 1, 'N', 0, 1, 0, 0, 0, 'libre'),
(17, 1, 'N', 0, 1, 0, 0, 0, 'libre'),
(18, 1, 'N', 0, 1, 0, 0, 0, 'libre'),
(19, 1, 'N', 0, 1, 0, 0, 0, 'libre'),
(20, 1, 'N', 0, 1, 0, 0, 0, 'libre'),
(21, 2, 'N', 0, 1, 0, 0, 0, 'ocupada'),
(22, 2, 'N', 0, 1, 0, 0, 0, 'libre'),
(23, 2, 'N', 0, 1, 0, 0, 0, 'libre'),
(24, 2, 'N', 0, 1, 0, 0, 0, 'libre'),
(25, 2, 'N', 0, 1, 0, 0, 0, 'libre'),
(26, 2, 'N', 0, 1, 0, 0, 0, 'libre'),
(27, 2, 'N', 0, 1, 0, 0, 0, 'libre'),
(28, 2, 'N', 0, 1, 0, 0, 0, 'libre'),
(29, 2, 'N', 0, 1, 0, 0, 0, 'libre'),
(30, 2, 'N', 0, 1, 0, 0, 0, 'libre'),
(31, 2, 'N', 0, 1, 0, 0, 0, 'libre'),
(32, 2, 'N', 0, 1, 0, 0, 0, 'libre'),
(33, 2, 'N', 0, 1, 0, 0, 0, 'libre'),
(34, 2, 'N', 0, 1, 0, 0, 0, 'libre'),
(35, 2, 'N', 0, 1, 0, 0, 0, 'libre'),
(36, 2, 'N', 0, 1, 0, 0, 0, 'libre'),
(37, 2, 'N', 0, 1, 0, 0, 0, 'libre'),
(38, 2, 'N', 0, 1, 0, 0, 0, 'libre'),
(39, 2, 'N', 0, 1, 0, 0, 0, 'libre'),
(40, 2, 'N', 0, 1, 0, 0, 0, 'libre'),
(41, 1, 'B', 0, 1, 0, 0, 0, 'libre'),
(42, 1, 'B', 0, 1, 0, 0, 0, 'libre'),
(43, 1, 'B', 0, 1, 0, 0, 0, 'libre'),
(44, 1, 'B', 0, 1, 0, 0, 0, 'libre'),
(45, 1, 'B', 0, 1, 0, 0, 0, 'libre'),
(46, 1, 'B', 0, 1, 0, 0, 0, 'libre'),
(47, 1, 'B', 0, 1, 0, 0, 0, 'libre'),
(48, 1, 'B', 0, 1, 0, 0, 0, 'libre'),
(49, 1, 'B', 0, 1, 0, 0, 0, 'libre'),
(50, 1, 'B', 0, 1, 0, 0, 0, 'libre'),
(51, 1, 'B', 0, 1, 0, 0, 0, 'libre'),
(52, 1, 'B', 0, 1, 0, 0, 0, 'libre'),
(53, 1, 'B', 0, 1, 0, 0, 0, 'libre'),
(54, 1, 'B', 0, 1, 0, 0, 0, 'libre'),
(55, 1, 'B', 0, 1, 0, 0, 0, 'libre'),
(56, 1, 'B', 0, 1, 0, 0, 0, 'libre'),
(57, 1, 'B', 0, 1, 0, 0, 0, 'libre'),
(58, 1, 'B', 0, 1, 0, 0, 0, 'libre'),
(59, 1, 'B', 0, 1, 0, 0, 0, 'libre'),
(60, 1, 'B', 0, 1, 0, 0, 0, 'libre'),
(61, 2, 'B', 0, 1, 0, 0, 0, 'libre'),
(62, 2, 'B', 0, 1, 0, 0, 0, 'libre'),
(63, 2, 'B', 0, 1, 0, 0, 0, 'libre'),
(64, 2, 'B', 0, 1, 0, 0, 0, 'libre'),
(65, 2, 'B', 0, 1, 0, 0, 0, 'libre'),
(66, 2, 'B', 0, 1, 0, 0, 0, 'libre'),
(67, 2, 'B', 0, 1, 0, 0, 0, 'libre'),
(68, 2, 'B', 0, 1, 0, 0, 0, 'libre'),
(69, 2, 'B', 0, 1, 0, 0, 0, 'libre'),
(70, 2, 'B', 0, 1, 0, 0, 0, 'libre'),
(71, 2, 'B', 0, 1, 0, 0, 0, 'libre'),
(72, 2, 'B', 0, 1, 0, 0, 0, 'libre'),
(73, 2, 'B', 0, 1, 0, 0, 0, 'libre'),
(74, 2, 'B', 0, 1, 0, 0, 0, 'libre'),
(75, 2, 'B', 0, 1, 0, 0, 0, 'libre'),
(76, 2, 'B', 0, 1, 0, 0, 0, 'libre'),
(77, 2, 'B', 0, 1, 0, 0, 0, 'libre'),
(78, 2, 'B', 0, 1, 0, 0, 0, 'libre'),
(79, 2, 'B', 0, 1, 0, 0, 0, 'libre'),
(80, 2, 'B', 0, 1, 0, 0, 0, 'libre'),
(81, 1, 'A', 0, 1, 0, 0, 0, 'libre'),
(82, 1, 'A', 0, 1, 0, 0, 0, 'libre'),
(83, 1, 'A', 0, 1, 0, 0, 0, 'libre'),
(84, 1, 'A', 0, 1, 0, 0, 0, 'libre'),
(85, 1, 'A', 0, 1, 0, 0, 0, 'libre'),
(86, 1, 'A', 0, 1, 0, 0, 0, 'libre'),
(87, 1, 'A', 0, 1, 0, 0, 0, 'libre'),
(88, 1, 'A', 0, 1, 0, 0, 0, 'libre'),
(89, 1, 'A', 0, 1, 0, 0, 0, 'libre'),
(90, 1, 'A', 0, 1, 0, 0, 0, 'libre'),
(91, 1, 'A', 0, 1, 0, 0, 0, 'libre'),
(92, 1, 'A', 0, 1, 0, 0, 0, 'libre'),
(93, 1, 'A', 0, 1, 0, 0, 0, 'libre'),
(94, 1, 'A', 0, 1, 0, 0, 0, 'libre'),
(95, 1, 'A', 0, 1, 0, 0, 0, 'libre'),
(96, 1, 'A', 0, 1, 0, 0, 0, 'libre'),
(97, 1, 'A', 0, 1, 0, 0, 0, 'libre'),
(98, 1, 'A', 0, 1, 0, 0, 0, 'libre'),
(99, 1, 'A', 0, 1, 0, 0, 0, 'libre'),
(100, 1, 'A', 0, 1, 0, 0, 0, 'libre'),
(101, 2, 'A', 0, 1, 0, 0, 0, 'libre'),
(102, 2, 'A', 0, 1, 0, 0, 0, 'libre'),
(103, 2, 'A', 0, 1, 0, 0, 0, 'libre'),
(104, 2, 'A', 0, 1, 0, 0, 0, 'libre'),
(105, 2, 'A', 0, 1, 0, 0, 0, 'libre'),
(106, 2, 'A', 0, 1, 0, 0, 0, 'libre'),
(107, 2, 'A', 0, 1, 0, 0, 0, 'libre'),
(108, 2, 'A', 0, 1, 0, 0, 0, 'libre'),
(109, 2, 'A', 0, 1, 0, 0, 0, 'libre'),
(110, 2, 'A', 0, 1, 0, 0, 0, 'libre'),
(111, 2, 'A', 0, 1, 0, 0, 0, 'libre'),
(112, 2, 'A', 0, 1, 0, 0, 0, 'libre'),
(113, 2, 'A', 0, 1, 0, 0, 0, 'libre'),
(114, 2, 'A', 0, 1, 0, 0, 0, 'libre'),
(115, 2, 'A', 0, 1, 0, 0, 0, 'libre'),
(116, 2, 'A', 0, 1, 0, 0, 0, 'libre'),
(117, 2, 'A', 0, 1, 0, 0, 0, 'libre'),
(118, 2, 'A', 0, 1, 0, 0, 0, 'libre'),
(119, 2, 'A', 0, 1, 0, 0, 0, 'libre'),
(120, 2, 'A', 0, 1, 0, 0, 0, 'libre');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `items_factura`
--

CREATE TABLE IF NOT EXISTS `items_factura` (
  `id_items_factura` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de la\ntabla de items de factura.',
  `id_factura` int(11) NOT NULL COMMENT 'id de factura. Permite identificar a qué factura\npertenece un determinado\nitem.\n\nClave foránea en factura.',
  `nombre` varchar(50) DEFAULT NULL COMMENT 'Nombre del item agregado',
  `precio` float NOT NULL COMMENT 'Precio del item. Si es más\nde un item se guarda\nel total y se rellena ',
  `cantidad` int(11) DEFAULT NULL COMMENT 'Cantidad de productos.\nNo aplica para los servicios.',
  `num_habitacion` int(11) NOT NULL COMMENT 'Número de la habitación\nal cual se encuentra\nasociado el item\nfacturado.',
  PRIMARY KEY (`id_items_factura`,`id_factura`),
  KEY `fk_factura_items_factura` (`id_factura`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Items asociados a la factura.' AUTO_INCREMENT=16 ;

--
-- Volcado de datos para la tabla `items_factura`
--

INSERT INTO `items_factura` (`id_items_factura`, `id_factura`, `nombre`, `precio`, `cantidad`, `num_habitacion`) VALUES
(1, 2, 'Alojamiento', 1365, 15, 41),
(2, 2, 'Cerveza - Solera', 40, 4, 41),
(3, 2, 'Vino - Caminos de San Joaquín', 22, 2, 41),
(4, 2, 'Alcohol - Santa Teresa', 140, 4, 41),
(5, 2, 'Agua - Minalba Pura de Manatial, eso dice la etiqu', 20, 4, 41),
(6, 2, 'Refresco - Pepsi-Cola', 12, 4, 41),
(7, 2, 'llam. int.', 5, 1, 41),
(8, 2, 'llam. nac.', 10, 1, 41),
(9, 3, 'Alojamiento', 455, 5, 61),
(10, 3, 'Cerveza - Solera', 40, 4, 61),
(11, 3, 'Vino - Caminos de San Joaquín', 22, 2, 61),
(12, 3, 'Alcohol - Santa Teresa', 140, 4, 61),
(13, 3, 'Agua - Minalba Pura de Manatial, eso dice la etiqu', 20, 4, 61),
(14, 3, 'Refresco - Pepsi-Cola', 12, 4, 61),
(15, 4, 'Penalización - 10%', 8, 2, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `llamadas_tlfs`
--

CREATE TABLE IF NOT EXISTS `llamadas_tlfs` (
  `id_llamadas_tlf` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador \núnico de la tabla de\nllamada. El cual es un\nentero auto-incrementable',
  `fecha` date NOT NULL COMMENT 'Fecha de realización\nde la llamada.',
  `hora_ini` time NOT NULL COMMENT 'Hora de inicio de la\nllamada hecha',
  `hora_fin` time NOT NULL COMMENT 'Hora de culminación\nde la llamada realizada',
  `numero` varchar(30) NOT NULL COMMENT 'Número al cual se\nrealizó la llamada',
  `id_reserva_ocupa` int(11) NOT NULL COMMENT 'Domino{N,I}\n\nN: Nacional\nI: Internacional',
  `tipo` enum('N','I') NOT NULL COMMENT 'Dominio{N,I}\nN: llamada Nacional\nI: llamada Internacional\n',
  PRIMARY KEY (`id_llamadas_tlf`),
  KEY `fk_llamadas_tlfs_reserva_ocupa` (`id_reserva_ocupa`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Para contabilizar las llamadas telefónicas asociadas a una r' AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `llamadas_tlfs`
--

INSERT INTO `llamadas_tlfs` (`id_llamadas_tlf`, `fecha`, `hora_ini`, `hora_fin`, `numero`, `id_reserva_ocupa`, `tipo`) VALUES
(1, '2013-08-16', '12:22:01', '12:23:00', '9532132132168', 1, 'I'),
(2, '2013-08-17', '12:40:00', '12:50:00', '04265842524', 1, 'N'),
(3, '2013-08-18', '12:22:01', '12:23:00', '04264484827', 17, 'N'),
(4, '2013-08-19', '12:40:00', '13:40:00', '04145844721', 17, 'N'),
(5, '2013-08-20', '22:40:00', '22:50:00', '892312132131', 17, 'I'),
(6, '2013-08-16', '09:30:00', '09:50:22', '02418236631', 23, 'N'),
(7, '2013-08-17', '09:30:00', '09:50:22', '04145855539', 23, 'N'),
(8, '2013-08-20', '12:30:00', '12:40:34', '04120388544', 34, 'I');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes_contactar`
--

CREATE TABLE IF NOT EXISTS `mensajes_contactar` (
  `id_mensajes_contactar` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL COMMENT 'Nombre de la persona',
  `apellido` varchar(100) NOT NULL COMMENT 'apellido de la persona',
  `sitio_web` varchar(200) DEFAULT NULL COMMENT 'sitio web si lo pose.',
  `mensaje` varchar(1000) NOT NULL COMMENT 'cuerpo del mensaje',
  PRIMARY KEY (`id_mensajes_contactar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Donde se guardan los mensajes de la sección de contactar.' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva_ocupa`
--

CREATE TABLE IF NOT EXISTS `reserva_ocupa` (
  `id_reserva_ocupa` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador único de\nla tabla autoincrementable.',
  `id_habitacion_usr_hab` int(11) DEFAULT NULL COMMENT 'Clave foránea en habitación',
  `id_usuario` varchar(100) NOT NULL COMMENT 'Clave foránea en la\ntabla usuario',
  `num_camas_infantiles` int(11) NOT NULL DEFAULT '0' COMMENT 'Cantidad de camas\ninfantiles asociadas a\nla habitación.',
  `fecha_ini` date NOT NULL COMMENT 'fecha de inicio de la\nreserva',
  `fecha_fin` date NOT NULL COMMENT 'Fecha final de la reserva.',
  `categoria_habitacion` enum('N','B','A') NOT NULL DEFAULT 'N' COMMENT 'Dominio {N, B, A}\nNormal: N\nBusiness: B\nAlta: A\n\nSegún la categoria\ncambia el precio\n',
  `tipo_habitacion` int(11) NOT NULL DEFAULT '1' COMMENT 'Está dado por el número\nde camas estándares:\n\nDominio:{1,2}\n1: Individual\n2: Doble',
  `estatus_reserva` enum('activa','ocupada','cerrada','cancelada') NOT NULL DEFAULT 'activa' COMMENT 'Dominio{activa,ocupada,\n,cerrada,cancelada}\n\nactiva: Son las reservas\nque aun no han sido\nocupadas\n\nocupada: habitación\nasignada\n\ncerrada: culminó la\nestadía y facturo.\n\ncancelada: las reservas\nque han sido canceladas.',
  `caso_especial` tinyint(1) DEFAULT '0' COMMENT 'Atributo utilizado para \nel caso de que a un \nusuario se le asigne\nuna habitación "doble"\ncuando ha solicitado una \n"individual". Este hecho \nocurre por falta de\nhabitaciones del tipo\nindividual.',
  PRIMARY KEY (`id_reserva_ocupa`),
  KEY `fk_reserva_ocupa_habitacion` (`id_habitacion_usr_hab`),
  KEY `fk_reserva_ocupa_usuario` (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Permite identificar las reservas asociadas a un usuario.' AUTO_INCREMENT=59 ;

--
-- Volcado de datos para la tabla `reserva_ocupa`
--

INSERT INTO `reserva_ocupa` (`id_reserva_ocupa`, `id_habitacion_usr_hab`, `id_usuario`, `num_camas_infantiles`, `fecha_ini`, `fecha_fin`, `categoria_habitacion`, `tipo_habitacion`, `estatus_reserva`, `caso_especial`) VALUES
(1, 41, 'baltazar666', 0, '2013-08-15', '2013-08-30', 'B', 2, 'cerrada', 0),
(2, NULL, 'baltazar666', 0, '2013-08-15', '2013-08-30', 'B', 2, 'cancelada', 0),
(3, NULL, 'baltazar666', 0, '2013-08-15', '2013-08-30', 'B', 2, 'activa', 0),
(4, NULL, 'baltazar666', 0, '2013-08-15', '2013-08-30', 'B', 2, 'activa', 0),
(5, NULL, 'baltazar666', 0, '2013-08-15', '2013-08-30', 'B', 2, 'activa', 0),
(6, NULL, 'baltazar666', 0, '2013-08-15', '2013-08-30', 'B', 2, 'cancelada', 0),
(7, NULL, 'baltazar666', 0, '2013-08-20', '2013-08-30', 'B', 2, 'activa', 0),
(8, NULL, 'baltazar666', 0, '2013-08-20', '2013-08-30', 'B', 2, 'activa', 0),
(9, NULL, 'baltazar666', 0, '2013-08-20', '2013-08-30', 'B', 2, 'activa', 0),
(10, NULL, 'baltazar666', 0, '2013-08-20', '2013-08-30', 'B', 2, 'activa', 0),
(11, NULL, 'baltazar666', 0, '2013-08-20', '2013-08-30', 'B', 2, 'activa', 0),
(12, NULL, 'baltazar666', 0, '2013-08-20', '2013-08-30', 'B', 2, 'activa', 0),
(13, NULL, 'baltazar666', 0, '2013-08-20', '2013-08-30', 'N', 1, 'activa', 0),
(14, NULL, 'baltazar666', 0, '2013-08-20', '2013-08-30', 'N', 1, 'activa', 0),
(15, NULL, 'baltazar666', 0, '2013-08-20', '2013-08-30', 'N', 1, 'activa', 0),
(16, NULL, 'sandrab86', 0, '2013-08-15', '2013-08-20', 'B', 2, 'cancelada', 0),
(17, NULL, 'sandrab86', 0, '2013-08-15', '2013-08-20', 'B', 2, 'cancelada', 0),
(18, NULL, 'sandrab86', 0, '2013-08-15', '2013-08-20', 'B', 2, 'activa', 0),
(19, NULL, 'sandrab86', 0, '2013-08-15', '2013-08-20', 'A', 1, 'activa', 0),
(20, NULL, 'sandrab86', 0, '2013-08-15', '2013-08-20', 'A', 2, 'activa', 0),
(21, NULL, 'rr_gutierrez', 0, '2013-08-16', '2013-08-18', 'B', 2, 'activa', 0),
(22, NULL, 'rr_gutierrez', 0, '2013-08-16', '2013-08-18', 'N', 2, 'activa', 0),
(23, NULL, 'rr_gutierrez', 0, '2013-08-16', '2013-08-18', 'N', 2, 'activa', 0),
(24, NULL, 'rr_gutierrez', 0, '2013-08-16', '2013-08-18', 'B', 1, 'activa', 0),
(25, NULL, 'rr_gutierrez', 0, '2013-08-16', '2013-08-18', 'B', 1, 'activa', 0),
(26, NULL, 'rr_gutierrez', 0, '2013-08-16', '2013-08-18', 'B', 1, 'activa', 0),
(27, 61, 'paola', 0, '2013-08-15', '2013-08-20', 'B', 2, 'cerrada', 0),
(28, NULL, 'paola', 0, '2013-08-15', '2013-08-20', 'B', 2, 'activa', 0),
(29, NULL, 'paola', 0, '2013-08-15', '2013-08-20', 'B', 2, 'activa', 0),
(30, NULL, 'paola', 0, '2013-08-15', '2013-08-20', 'B', 2, 'activa', 0),
(31, NULL, 'paola', 0, '2013-08-15', '2013-08-20', 'N', 1, 'activa', 0),
(32, NULL, 'paola', 0, '2013-08-15', '2013-08-20', 'A', 1, 'activa', 0),
(33, NULL, 'paola', 0, '2013-08-15', '2013-08-20', 'A', 1, 'activa', 0),
(34, NULL, 'paola', 0, '2013-08-15', '2013-08-21', 'A', 1, 'activa', 0),
(51, 21, 'pepe', 2, '2013-08-14', '2013-08-16', 'N', 2, 'ocupada', 0),
(53, NULL, 'pepe', 1, '2013-08-08', '2013-08-16', 'N', 1, 'cancelada', 0),
(54, NULL, 'pepe', 1, '2013-08-08', '2013-08-16', 'B', 1, 'cancelada', 0),
(55, NULL, 'baltazar666', 2, '2013-08-14', '2013-08-16', 'B', 2, 'activa', 0),
(56, NULL, 'baltazar666', 2, '2013-08-14', '2013-08-16', 'B', 2, 'activa', 0),
(57, NULL, 'baltazar666', 0, '2013-08-14', '2013-08-16', 'B', 2, 'activa', 0),
(58, NULL, 'pepe', 1, '2013-08-10', '2013-08-12', 'N', 1, 'cancelada', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` varchar(100) NOT NULL COMMENT 'Nombre del usuario,\nes una cadena única \nalfanumérica.',
  `clave` varchar(100) NOT NULL COMMENT 'Clave asociada al usuario',
  `nombre` varchar(50) NOT NULL COMMENT 'Nombre del usuario',
  `apellido` varchar(50) NOT NULL COMMENT 'Apellido del usuario',
  `correo` varchar(100) NOT NULL COMMENT 'Correo asociado al usuario',
  `sexo` enum('F','M') NOT NULL COMMENT 'Sexo asociado al usuario.\n\nDominio {F,M}',
  `cedula` varchar(30) NOT NULL COMMENT 'Cédula de Identidad del\nusuario.',
  `fecha_nac` date NOT NULL COMMENT 'Fecha de nacimiento',
  `num_tarjeta` varchar(16) DEFAULT NULL COMMENT 'Número de tarjeta de \ncrédito o débito.',
  `tipo_cuenta` enum('ahorro','corriente') DEFAULT NULL COMMENT 'Tipo de cuenta\n\nDominio{ahorro,corriente}',
  `nacionalidad` enum('V','E') NOT NULL COMMENT 'Domino{V,E}\nV: venezolano\nE: extranjero',
  `rif` varchar(45) NOT NULL COMMENT 'RIF: Registro de Información\nFiscal del usuario.',
  `rol` enum('estandar','admin') NOT NULL DEFAULT 'estandar' COMMENT 'Dominio {admin,estándar}',
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='La información de la persona será manejada exclusivamente a ';

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `clave`, `nombre`, `apellido`, `correo`, `sexo`, `cedula`, `fecha_nac`, `num_tarjeta`, `tipo_cuenta`, `nacionalidad`, `rif`, `rol`) VALUES
('armando_p', '123456', 'Armanda', 'Manzilla', 'aafff@gmail.com', 'M', '324343432', '2013-08-20', '1231321321312312', 'corriente', 'E', 'V-343434-4234', 'estandar'),
('baltazar666', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Baltazar', 'Bueno', 'baltazar@gmail.com', 'M', '1000000', '1666-06-06', '422559658215569', 'corriente', 'E', 'E-1000000-9', 'estandar'),
('crismary', '123456', 'Crismary', 'Gamez', 'cirsma@hotmail.com', 'F', '20555889', '2012-09-18', '2343434345455545', 'ahorro', 'V', 'V2552020', 'estandar'),
('dasdasdsa', '123', 'sdas', 'dsad', 'sddas@asds.csd', 'F', '42333', '2013-08-01', '4234324534543544', 'ahorro', 'V', '342423', 'estandar'),
('ewqeqwe', 'qw', 'qweqweqweqwe', 'eqweqwe', 'ewqeqwew@fsf.asd', 'F', '2432434', '2013-08-07', '4132434343241433', 'ahorro', 'E', '341233423', 'estandar'),
('fmdfmk', 'dfdf', 'dfdf', 'ddf', 'fsfd@dfd.com', 'F', '4234334', '2013-08-26', '4324354354545454', 'ahorro', 'V', '342343432', 'estandar'),
('fsfs', 'sd', 'sdfdf', 'dfsdf', 'fsdfs@gdgdfg.cdsfd', 'F', '423', '2013-08-06', '3434324235435543', 'ahorro', 'V', 'fsdf', 'estandar'),
('kel', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'kelw', 'gmz', 'kdd@gmail.com', 'M', '20542093', '2013-08-01', '6516165161616182', 'ahorro', 'V', 'V-20542093-9', 'estandar'),
('ktrina', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Ktrina', 'Smith', 'ktrina@gmail.com', 'F', '20888999', '2013-07-24', NULL, NULL, 'V', 'V-20888999-6', 'admin'),
('paola', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Paola', 'Parra', 'paolapp@gmail.com', 'F', '20888666', '1990-05-22', '525222358345989', 'ahorro', 'V', 'V-20888666-5', 'estandar'),
('pedro_perez', '123456', 'Pedro', 'Perez', 'pedro_perz@gmail.com', 'M', '22000111', '2002-12-10', '1258921215212156', 'ahorro', 'V', 'V-22000111-2', 'estandar'),
('pedro_perez2', '123456', 'Pedro', 'Perez', 'pedro_perz@gmail.com', 'M', '22000111', '2002-12-10', '1258921215212156', 'ahorro', 'V', 'V-22000111-2', 'estandar'),
('pedro_perez3', '123456', 'Pedro', 'Perez', 'pedro_perz@gmail.com', 'M', '22000111', '2002-12-10', '1258921215212156', 'ahorro', 'V', 'V-22000111-2', 'estandar'),
('pepe', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'ke', 'gm', 'k@dsf.com', 'M', '220031122', '1992-02-02', '5652651651321316', 'ahorro', 'V', 'V23262134', 'estandar'),
('rerwrer', 'wewe', 'rwerewr', 'rwere', 'rwerwer@sdf.csf', 'F', '423431434', '2013-08-07', '4234223434534255', 'ahorro', 'V', '33f432', 'estandar'),
('rewr', 'dfdf', 'fsdfs', 'fsdfd', 'sdffds@fdsfd.cafas', 'F', '3443214', '2013-08-20', '2165123134513213', 'ahorro', 'V', 'r3rfedsf', 'estandar'),
('rewre', '123', 'rwe', 're', 'rewrwe@uff.com', 'F', '4324324334', '2013-08-02', '4354354543543544', 'ahorro', 'V', '42342343', 'estandar'),
('rr', 'rr', 'rr', 'rr', 'rrr@hot.com', 'F', '544354', '2013-08-14', '5454545454545452', 'corriente', 'V', '54545', 'estandar'),
('rr_gutierrez', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Ramon', 'Gutierrez', 'rgutierrez@gmail.com', 'M', '7500800', '1970-05-16', '525482358345589', 'ahorro', 'V', 'V-7500800-3', 'estandar'),
('rwere', 'rwere', 'ewrwer', 'rwer', 'rewrwer@fsdf.com', 'F', '32423324', '2013-08-27', '4324354354545454', 'ahorro', 'V', 'fsr3424', 'estandar'),
('sandrab86', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Sandra', 'Baron', 'sandrab86@hotmail.com', 'F', '21255897', '1993-06-18', '425412358389489', 'corriente', 'V', 'V-21255897-6', 'estandar'),
('sd', 'sss', 'sss', 'ss', 'dasds@hotmc.om', 'F', '5165165', '2013-08-01', '4324343434234346', 'ahorro', 'V', 'ss5151', 'estandar'),
('ssooo', 'si', 'SKSAKD', 'sdjlfdk', 'ssdfsd@dsf.csc', 'F', '3453545', '2013-08-08', '2589658978596222', 'ahorro', 'V', '545345', 'estandar'),
('usuarioprueba', '123456', 'Usuario', 'Prueba', 'dasd@dasd.fdssdf', 'F', '343243', '2013-08-16', '1222255555555555', 'ahorro', 'E', 'E-232223231-1', 'estandar'),
('zfdfsdf', 'fff', 'edsff', 'sdfs', 'sdffs@fsf.com', 'F', '423434', '2013-08-13', '5345435453534535', 'ahorro', 'E', '4324234', 'estandar');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `consumible`
--
ALTER TABLE `consumible`
  ADD CONSTRAINT `fk_consumible_almacen_consumible` FOREIGN KEY (`ids_consumible_almacen`) REFERENCES `consumible_almacen` (`id_consumible_almacen`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_consumible_reserva_ocupa` FOREIGN KEY (`id_reserva_ocupa`) REFERENCES `reserva_ocupa` (`id_reserva_ocupa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `fk_factura_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `items_factura`
--
ALTER TABLE `items_factura`
  ADD CONSTRAINT `fk_factura_items_factura` FOREIGN KEY (`id_factura`) REFERENCES `factura` (`id_factura`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `llamadas_tlfs`
--
ALTER TABLE `llamadas_tlfs`
  ADD CONSTRAINT `fk_llamadas_tlfs_reserva_ocupa` FOREIGN KEY (`id_reserva_ocupa`) REFERENCES `reserva_ocupa` (`id_reserva_ocupa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `reserva_ocupa`
--
ALTER TABLE `reserva_ocupa`
  ADD CONSTRAINT `fk_reserva_ocupa_habitacion` FOREIGN KEY (`id_habitacion_usr_hab`) REFERENCES `habitacion` (`id_habitacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reserva_ocupa_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
