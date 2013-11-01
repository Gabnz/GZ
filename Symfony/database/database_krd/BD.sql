SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `daweb_krd` DEFAULT CHARACTER SET utf8 ;
USE `daweb_krd` ;

-- -----------------------------------------------------
-- Table `daweb_krd`.`rol`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `daweb_krd`.`rol` (
  `id_rol` INT NOT NULL AUTO_INCREMENT ,
  `descripcion` VARCHAR(200) NULL ,
  PRIMARY KEY (`id_rol`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'Determinan qué modulos del sistema tendrá acceso un determin' /* comment truncated */;


-- -----------------------------------------------------
-- Table `daweb_krd`.`usuario`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `daweb_krd`.`usuario` (
  `id_usuario` VARCHAR(100) NOT NULL COMMENT 'Nombre del usuario,\nes una cadena única \nalfanumérica.' ,
  `clave` VARCHAR(100) NOT NULL ,
  `nombre` VARCHAR(50) NOT NULL ,
  `apellido` VARCHAR(50) NOT NULL ,
  `correo` VARCHAR(100) NOT NULL ,
  `sexo` CHAR NOT NULL COMMENT 'Dominio {F,M}' ,
  `cedula` VARCHAR(30) NOT NULL ,
  `fecha_nac` DATE NOT NULL COMMENT 'fecha de nacimiento' ,
  `num_tarjeta` VARCHAR(45) NOT NULL ,
  `tipo_cuenta` VARCHAR(10) NOT NULL ,
  `nacionalidad` CHAR NOT NULL ,
  `rif` VARCHAR(45) NOT NULL ,
  `id_rol` INT NULL ,
  PRIMARY KEY (`id_usuario`) ,
  INDEX `fk_usuario_rol` (`id_rol` ASC) ,
  CONSTRAINT `fk_usuario_rol`
    FOREIGN KEY (`id_rol` )
    REFERENCES `daweb_krd`.`rol` (`id_rol` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'La información de la persona será manejada exclusivamente a ' /* comment truncated */;


-- -----------------------------------------------------
-- Table `daweb_krd`.`factura`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `daweb_krd`.`factura` (
  `id_factura` INT NOT NULL AUTO_INCREMENT COMMENT 'fk en factura' ,
  `id_usuario` VARCHAR(100) NULL ,
  `fecha_emision` DATE NOT NULL ,
  PRIMARY KEY (`id_factura`) ,
  INDEX `fk_factura_usuario` (`id_usuario` ASC) ,
  CONSTRAINT `fk_factura_usuario`
    FOREIGN KEY (`id_usuario` )
    REFERENCES `daweb_krd`.`usuario` (`id_usuario` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'Factura(s) asociadas a un usuario';


-- -----------------------------------------------------
-- Table `daweb_krd`.`habitacion`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `daweb_krd`.`habitacion` (
  `id_habitacion` INT NOT NULL AUTO_INCREMENT ,
  `tipo` INT NOT NULL COMMENT 'Está dado por el número\nde camas estándares:\n\nDominio:{1,2}\n1: Individual\n2: Doble' ,
  `categoria` CHAR NOT NULL COMMENT 'Dominio {N, B, A}\nNormal: N\nBusiness: B\nAlta: A\n\nSegún la categoria\ncambia el precio\n' ,
  `estatus` VARCHAR(15) NOT NULL DEFAULT 'disponible' COMMENT 'Dominio \n{reservada, \ndisponible. ocupada}' ,
  `caso_especial` TINYINT(1) NULL COMMENT 'Atributo utilizado para \nel caso de que a un \nusuario se le asigne\nuna habitación \"doble\"\ncuando ha solicitado una \n\"individual\". Este hecho \nocurre por falta de\nhabitaciones del tipo\nindividual.' ,
  `serv_tv` TINYINT(1) NULL ,
  `serv_ducha` TINYINT(1) NOT NULL DEFAULT true ,
  `serv_yacusi` TINYINT(1) NULL ,
  `serv_musica` TINYINT(1) NULL ,
  `serv_masaje` TINYINT(1) NULL ,
  PRIMARY KEY (`id_habitacion`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'Información de la habitación';


-- -----------------------------------------------------
-- Table `daweb_krd`.`reserva_ocupa`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `daweb_krd`.`reserva_ocupa` (
  `id_reserva_ocupa` INT NOT NULL AUTO_INCREMENT ,
  `id_habitacion_usr_hab` INT NOT NULL ,
  `id_usuario` VARCHAR(100) NOT NULL ,
  `num_camas_infantiles` INT NOT NULL DEFAULT 0 ,
  `fecha_ini` DATE NOT NULL ,
  `fecha_fin` DATE NOT NULL ,
  PRIMARY KEY (`id_reserva_ocupa`) ,
  INDEX `fk_reserva_ocupa_habitacion` (`id_habitacion_usr_hab` ASC) ,
  INDEX `fk_reserva_ocupa_usuario` (`id_usuario` ASC) ,
  CONSTRAINT `fk_reserva_ocupa_habitacion`
    FOREIGN KEY (`id_habitacion_usr_hab` )
    REFERENCES `daweb_krd`.`habitacion` (`id_habitacion` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_reserva_ocupa_usuario`
    FOREIGN KEY (`id_usuario` )
    REFERENCES `daweb_krd`.`usuario` (`id_usuario` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'inf de reserva y ocupacion de hab'
PACK_KEYS = DEFAULT;


-- -----------------------------------------------------
-- Table `daweb_krd`.`llamadas_tlfs`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `daweb_krd`.`llamadas_tlfs` (
  `id_llamadas_tlf` INT NOT NULL AUTO_INCREMENT COMMENT 'Identificador \núnico de la tabla de\nllamada. El cual es un\nentero auto-incrementable' ,
  `fecha` DATE NOT NULL COMMENT 'Fecha de realización\nde la llamada.' ,
  `hora_ini` TIME NOT NULL COMMENT 'Hora de inicio de la\nllamada hecha' ,
  `hora_fin` TIME NOT NULL COMMENT 'Hora de culminación\nde la llamada realizada' ,
  `numero` VARCHAR(30) CHARACTER SET 'utf8' NOT NULL COMMENT 'Número al cual se\nrealizó la llamada' ,
  `id_reserva_ocupa` INT NOT NULL COMMENT 'Domino{N,I}\n\nN: Nacional\nI: Internacional' ,
  PRIMARY KEY (`id_llamadas_tlf`) ,
  INDEX `fk_llamadas_tlfs_reserva_ocupa` (`id_reserva_ocupa` ASC) ,
  CONSTRAINT `fk_llamadas_tlfs_reserva_ocupa`
    FOREIGN KEY (`id_reserva_ocupa` )
    REFERENCES `daweb_krd`.`reserva_ocupa` (`id_reserva_ocupa` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'Para contabilizar las llamadas telefónicas de hab';


-- -----------------------------------------------------
-- Table `daweb_krd`.`consumible_almacen`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `daweb_krd`.`consumible_almacen` (
  `id_consumible_almacen` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(50) NOT NULL COMMENT 'descripción del elemento\n\nDominio{llamda, cerveza,\nvino, alcohol, agua, refresco}' ,
  `precio` INT NOT NULL COMMENT 'valor monetario' ,
  `categoria` CHAR NOT NULL ,
  PRIMARY KEY (`id_consumible_almacen`) ,
  INDEX `NOMBRE` (`nombre` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'Aquí se guardarán los precios y descripciones actuales de ca' /* comment truncated */;


-- -----------------------------------------------------
-- Table `daweb_krd`.`consumible`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `daweb_krd`.`consumible` (
  `id_consumible` INT NOT NULL AUTO_INCREMENT ,
  `id_reserva_ocupa` INT NOT NULL ,
  `ids_consumible_almacen` INT NOT NULL ,
  PRIMARY KEY (`id_consumible`, `id_reserva_ocupa`) ,
  INDEX `fk_consumible_almacen_consumible` USING BTREE (`ids_consumible_almacen` ASC) ,
  INDEX `fk_consumible_reserva_ocupa` (`id_reserva_ocupa` ASC) ,
  CONSTRAINT `fk_consumible_almacen_consumible`
    FOREIGN KEY (`ids_consumible_almacen` )
    REFERENCES `daweb_krd`.`consumible_almacen` (`id_consumible_almacen` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_consumible_reserva_ocupa`
    FOREIGN KEY (`id_reserva_ocupa` )
    REFERENCES `daweb_krd`.`reserva_ocupa` (`id_reserva_ocupa` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'Cada item consumido de la hab';


-- -----------------------------------------------------
-- Table `daweb_krd`.`items_factura`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `daweb_krd`.`items_factura` (
  `id_items_factura` INT NOT NULL AUTO_INCREMENT ,
  `id_factura` INT NOT NULL ,
  `nombre` VARCHAR(50) NULL ,
  `precio` INT NOT NULL ,
  `iva` INT NULL ,
  PRIMARY KEY (`id_items_factura`, `id_factura`) ,
  INDEX `fk_factura_items_factura` (`id_factura` ASC) ,
  CONSTRAINT `fk_factura_items_factura`
    FOREIGN KEY (`id_factura` )
    REFERENCES `daweb_krd`.`factura` (`id_factura` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'Items de cada factura';


-- -----------------------------------------------------
-- Table `daweb_krd`.`modulo_sistema`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `daweb_krd`.`modulo_sistema` (
  `id_nombre_modulo_sistema` VARCHAR(100) NOT NULL ,
  `descripcion` VARCHAR(200) NOT NULL ,
  `id_rol` INT NOT NULL ,
  PRIMARY KEY (`id_nombre_modulo_sistema`, `descripcion`) ,
  INDEX `fk_modulo_sistema_rol` (`id_rol` ASC) ,
  CONSTRAINT `fk_modulo_sistema_rol`
    FOREIGN KEY (`id_rol` )
    REFERENCES `daweb_krd`.`rol` (`id_rol` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'Para la inserción de los módulos del sistema previamente deb' /* comment truncated */;

USE `daweb_krd`;

DELIMITER $$
USE `daweb_krd`$$


CREATE TRIGGER actualizar_estatus_habitacion_reservada AFTER INSERT ON reserva_ocupa
FOR EACH ROW BEGIN
    UPDATE habitacion SET estatus = 'reservada'
    WHERE habitacion.id_habitacion = NEW.id_habitacion_usr_hab;
END;

$$

USE `daweb_krd`$$


CREATE TRIGGER actualizar_estatus_habitacion_disponible AFTER DELETE ON reserva_ocupa
FOR EACH ROW BEGIN
    UPDATE habitacion SET estatus = 'disponible'
    WHERE habitacion.id_habitacion = OLD.id_habitacion_usr_hab;
END;


$$


DELIMITER ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
