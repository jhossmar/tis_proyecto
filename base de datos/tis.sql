-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-04-2015 a las 15:12:21
-- Versión del servidor: 5.6.20
-- Versión de PHP: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `tis`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_fases_convocatoria`(IN gestion INT)
BEGIN
	SELECT * FROM fases_convocatoria f WHERE f.gestion = gestion;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_grupo_empresas`()
BEGIN
	SELECT* FROM grupo_empresa;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_id`(IN nomb CHAR(20), IN gest INT)
BEGIN
	SELECT id_usuario FROM usuario WHERE nombre_usuario = nomb AND gestion = gest;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_usuarios`()
BEGIN
	SELECT * FROM `usuario`;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `iniciar_sesion`(IN id INT)
BEGIN
	IF NOT EXISTS (SELECT id_proceso FROM sesion WHERE id_proceso = connection_id() )
	THEN INSERT INTO sesion(id_proceso,usuario) VALUES (connection_id(), id);
	ELSE UPDATE sesion SET usuario = id WHERE id_proceso = connection_id();
	END IF;
	-- INSERT INTO bitacora_sesion(usuario,fecha_hora) VALUES(id,CURRENT_TIMESTAMP);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `new_consultor`(IN nombre_usuario CHAR(20), IN clave CHAR(20), IN nombre CHAR(45), IN apellido CHAR(45), IN telefono CHAR(12), IN email CHAR(48), IN foto CHAR(128), IN habilitado TINYINT(1), IN tipo_usuario INT, IN curriculum CHAR(128))
BEGIN
	INSERT INTO `usuario` (`nombre_usuario`, `clave`, `nombre`, `apellido`, `telefono`, `email`, `foto`, `habilitado`, `tipo_usuario`, `gestion`) VALUES (nombre_usuario, clave, nombre, apellido, telefono, email, foto, habilitado, tipo_usuario, get_gestion_actual());
	INSERT INTO `consultor_tis` (`usuario`,`curriculum`) VALUES (LAST_INSERT_ID(), curriculum);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `new_grupo_empresa`(IN nombre_largo CHAR(64), IN nombre_corto CHAR(20), IN sociedad INT, IN consultor_tis INT)
BEGIN
	INSERT INTO `grupo_empresa` (`id_grupo_empresa`, `nombre_largo`, `nombre_corto`, `fecha_sobre_a`, `sobre_a`, `fecha_sobre_b`, `sobre_b`, `sociedad`, `consultor_tis`) VALUES (nombre_largo, nombre_corto, NULL, NULL, NULL, NULL, sociedad, consultor_tis);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `new_integrante`(IN nombre_usuario CHAR(20), IN clave CHAR(20), IN nombre CHAR(45), IN apellido CHAR(45), IN telefono CHAR(12), IN email CHAR(48), IN foto CHAR(128), IN habilitado TINYINT(1), IN tipo_usuario INT, IN codigo_sis CHAR(9), IN carrera INT, IN grupo_empresa INT)
BEGIN
	INSERT INTO `usuario` (`nombre_usuario`, `clave`, `nombre`, `apellido`, `telefono`, `email`, `foto`, `habilitado`, `tipo_usuario`, `gestion`) VALUES (nombre_usuario, clave, nombre, apellido, telefono, email, foto, habilitado, tipo_usuario, get_gestion_actual());
	INSERT INTO `integrante` (`usuario`,`codigo_sis`,`carrera`,`grupo_empresa`) VALUES (LAST_INSERT_ID(), codigo_sis, carrera, grupo_empresa);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_RAISE_ERROR`(IN P_ERROR VARCHAR(256))
BEGIN
    DECLARE V_ERROR VARCHAR(300);
    SET V_ERROR := CONCAT('[ERROR: ', P_ERROR, ']');
    INSERT INTO `TBL_DUMMY` VALUES (V_ERROR);
END$$

--
-- Funciones
--
CREATE DEFINER=`root`@`localhost` FUNCTION `get_consultor_empresa`(emp INT) RETURNS int(11)
BEGIN
	DECLARE con INT;
	SELECT consultor_tis INTO con FROM grupo_empresa WHERE id_grupo_empresa = emp;
	RETURN con;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `get_gestion_actual`() RETURNS int(11)
BEGIN
	DECLARE g INT(11);
	SELECT id_gestion INTO g FROM gestion_empresa_tis WHERE gestion_activa = 1 AND gestion != '0';
	RETURN g;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `get_jefe_grupo`(`grupo` int) RETURNS int(11)
BEGIN
	DECLARE jefe INT;
	SELECT usuario INTO jefe FROM integrante WHERE grupo_empresa = grupo AND usuario IN (SELECT id_usuario FROM usuario WHERE tipo_usuario = 4);
	RETURN jefe;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `get_pago_real`(entrega INT) RETURNS decimal(6,2)
BEGIN
	DECLARE d DECIMAL(6,2);
	SELECT pago_establecido * get_porcentaje_entrega(entrega) / 100 INTO d FROM entrega_producto where id_entrega_producto = entrega;
	RETURN d;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `get_porcentaje_actividad`(activ INT) RETURNS decimal(6,2)
BEGIN
	DECLARE d DECIMAL(6,2);
	SELECT sum(porcentaje_completado) / count(*) INTO d FROM tarea where actividad = activ;
	RETURN d;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `get_porcentaje_entrega`(entrega INT) RETURNS decimal(6,2)
BEGIN
	DECLARE d DECIMAL(6,2);
	SELECT sum(porcentaje_completado) / count(*) INTO d FROM actividad_grupo_empresa WHERE entrega_producto = entrega;
	RETURN d;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `id_jefe_consultor`(jefe INT) RETURNS int(11)
BEGIN
	DECLARE id INT;
	SELECT id_usuario INTO id FROM usuario WHERE tipo_usuario = 2;
	RETURN id;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `id_usuario`(conn INT) RETURNS int(11)
BEGIN
	DECLARE u INT;
	SELECT usuario INTO u FROM sesion WHERE id_proceso = conn;
	IF(u <=> NULL) THEN SET u = 1;
	END IF;
	RETURN u;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad_grupo_empresa`
--

CREATE TABLE IF NOT EXISTS `actividad_grupo_empresa` (
`id_actividad` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `descripcion` varchar(128) NOT NULL,
  `porcentaje_completado` decimal(6,2) DEFAULT '0.00',
  `modificado` int(11) DEFAULT '0',
  `entrega_producto` int(11) NOT NULL,
  `id_responsable` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Disparadores `actividad_grupo_empresa`
--
DELIMITER //
CREATE TRIGGER `actividad_grupo_empresa_ADEL` AFTER DELETE ON `actividad_grupo_empresa`
 FOR EACH ROW BEGIN
	INSERT INTO bitacora_bd(usuario,tabla,fecha_hora,viejo) VALUES (id_usuario(connection_id()),'actividad_grupo_empresa',CURRENT_TIMESTAMP,CONCAT_WS(',',OLD.id_actividad,OLD.fecha_inicio,OLD.fecha_fin,OLD.descripcion,OLD.porcentaje_completado,OLD.modificado,OLD.entrega_producto));
END
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `actividad_grupo_empresa_AINS` AFTER INSERT ON `actividad_grupo_empresa`
 FOR EACH ROW BEGIN
	INSERT INTO bitacora_bd(usuario,tabla,fecha_hora,nuevo) VALUES (id_usuario(connection_id()),'actividad_grupo_empresa',CURRENT_TIMESTAMP,CONCAT_WS(',',NEW.id_actividad,NEW.fecha_inicio,NEW.fecha_fin,NEW.descripcion,NEW.porcentaje_completado,NEW.modificado,NEW.entrega_producto));
END
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `actividad_grupo_empresa_AUPD` AFTER UPDATE ON `actividad_grupo_empresa`
 FOR EACH ROW BEGIN
	INSERT INTO bitacora_bd(usuario,tabla,fecha_hora,viejo,nuevo) VALUES (id_usuario(connection_id()),'actividad_grupo_empresa',CURRENT_TIMESTAMP,CONCAT_WS(',',OLD.id_actividad,OLD.fecha_inicio,OLD.fecha_fin,OLD.descripcion,OLD.porcentaje_completado,OLD.modificado,OLD.entrega_producto),CONCAT_WS(',',NEW.id_actividad,NEW.fecha_inicio,NEW.fecha_fin,NEW.descripcion,NEW.porcentaje_completado,NEW.modificado,NEW.entrega_producto));
END
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `actividad_grupo_empresa_BUPD` BEFORE UPDATE ON `actividad_grupo_empresa`
 FOR EACH ROW BEGIN
	DECLARE old_date CONDITION FOR SQLSTATE '99991';
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	  BEGIN
		CALL `SP_RAISE_ERROR` ('La fecha de inicio de la actividad ya ha vencido.');
	  END;
	IF(OLD.fecha_inicio <= CURDATE() AND (OLD.descripcion != NEW.descripcion OR OLD.fecha_inicio != NEW.fecha_inicio OR OLD.fecha_fin != NEW.fecha_fin)) THEN
		CALL ghost_procedure();
	END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anuncio`
--

CREATE TABLE IF NOT EXISTS `anuncio` (
`id_anuncio` int(11) NOT NULL,
  `titulo` varchar(64) NOT NULL,
  `contenido` text,
  `adjunto` varchar(128) DEFAULT NULL,
  `usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `avance_semanal`
--

CREATE TABLE IF NOT EXISTS `avance_semanal` (
`id_avance_semanal` int(11) NOT NULL,
  `fecha_revision` date NOT NULL,
  `desc_avance` varchar(128) NOT NULL,
  `enlace_entregable` varchar(128) DEFAULT NULL,
  `observacion` varchar(128) DEFAULT NULL,
  `presentado` int(1) NOT NULL,
  `grupo_empresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Disparadores `avance_semanal`
--
DELIMITER //
CREATE TRIGGER `avance_semanal_BINS` BEFORE INSERT ON `avance_semanal`
 FOR EACH ROW BEGIN
	INSERT INTO notificacion(fecha,tipo_notificacion,usuario,usuario_destino) VALUES (CURRENT_TIMESTAMP,6,NEW.grupo_empresa,get_consultor_empresa(NEW.grupo_empresa));
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `backup_log`
--

CREATE TABLE IF NOT EXISTS `backup_log` (
`id_backup` int(11) NOT NULL,
  `nombre_backup` varchar(32) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `observacion` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora_bd`
--

CREATE TABLE IF NOT EXISTS `bitacora_bd` (
`id_bitacora` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `tabla` varchar(64) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `viejo` text,
  `nuevo` text
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=425 ;

--
-- Volcado de datos para la tabla `bitacora_bd`
--

INSERT INTO `bitacora_bd` (`id_bitacora`, `usuario`, `tabla`, `fecha_hora`, `viejo`, `nuevo`) VALUES
(253, 1, 'usuario', '2014-06-23 09:07:57', NULL, '0,admin,admin,Boris Marcelo,Calancha Navia,4436755,boris@yahoo.com,,1,1,1'),
(411, 1, 'usuario', '2015-04-27 09:48:06', NULL, '0,brianperez,rbpo92007,Brian,Perez,4292136,b@hotmail.com,1,2,1'),
(412, 1, 'usuario', '2015-04-27 09:49:36', 'brianperez,rbpo92007,Brian,Perez,4292136,b@hotmail.com,1,2,1', NULL),
(413, 1, 'usuario', '2015-04-27 09:53:27', NULL, '0,brianperez,rbpo92007,Brian,Perez,4292136,b@gmail.com,0,2,1'),
(414, 1, 'consultor_tis', '2015-04-27 09:53:27', NULL, '8'),
(415, 1, 'usuario', '2015-04-27 10:17:05', 'brianperez,rbpo92007,Brian,Perez,4292136,b@gmail.com,0,2,1', 'brianperez,rbpo92007,Brian,Perez,4292136,b@gmail.com,1,3,1'),
(416, 1, 'usuario', '2015-04-27 10:20:25', NULL, '0,rodrigoperez,rbpo92007,Rodrigo,Perez,4292136,bp@gmail.com,0,2,1'),
(417, 1, 'consultor_tis', '2015-04-27 10:20:25', NULL, '9'),
(418, 1, 'usuario', '2015-04-27 10:21:12', 'rodrigoperez,rbpo92007,Rodrigo,Perez,4292136,bp@gmail.com,0,2,1', 'rodrigoperez,rbpo92007,Rodrigo,Perez,4292136,bp@gmail.com,1,3,1'),
(419, 1, 'usuario', '2015-04-27 10:54:46', 'brianperez,rbpo92007,Brian,Perez,4292136,b@gmail.com,1,2,1', 'brianperez,rbpo92007,Brian,Perez,4292136,b@gmail.com,0,2,1'),
(420, 1, 'usuario', '2015-04-28 15:24:13', NULL, '0,asdasdasd,asdasdasd92,brian,perez,80000000,bere@hotmail.com,0,4,3'),
(421, 1, 'grupo_empresa', '2015-04-28 15:24:13', NULL, 'tallerdeingenieria,tis2015,2,9'),
(422, 1, 'integrante', '2015-04-28 15:24:14', NULL, '10,201101035,1,1'),
(423, 1, 'usuario', '2015-04-28 15:25:08', 'asdasdasd,asdasdasd92,brian,perez,80000000,bere@hotmail.com,0,4,3', 'asdasdasd,asdasdasd92,brian,perez,80000000,bere@hotmail.com,1,4,3'),
(424, 1, 'usuario', '2015-04-28 16:58:01', 'asdasdasd,asdasdasd92,brian,perez,80000000,bere@hotmail.com,1,4,3', 'asdasdasd,asdasdasd92,brian,perez,80000000,bere@hotmail.com,0,4,3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora_sesion`
--

CREATE TABLE IF NOT EXISTS `bitacora_sesion` (
`id_bitacora_sesion` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `operacion` tinyint(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=87 ;

--
-- Volcado de datos para la tabla `bitacora_sesion`
--

INSERT INTO `bitacora_sesion` (`id_bitacora_sesion`, `usuario`, `fecha_hora`, `operacion`) VALUES
(52, 1, '2015-04-27 09:50:19', 0),
(53, 1, '2015-04-27 09:50:45', 1),
(54, 1, '2015-04-27 09:54:19', 0),
(55, 1, '2015-04-27 10:08:43', 1),
(56, 1, '2015-04-27 10:10:13', 0),
(57, 1, '2015-04-27 10:16:36', 1),
(58, 1, '2015-04-27 10:16:57', 0),
(59, 1, '2015-04-27 10:17:10', 1),
(60, 8, '2015-04-27 10:17:22', 0),
(61, 8, '2015-04-27 10:19:15', 1),
(62, 1, '2015-04-27 10:20:57', 0),
(63, 1, '2015-04-27 10:55:00', 1),
(64, 9, '2015-04-27 10:56:22', 0),
(65, 9, '2015-04-27 11:03:36', 1),
(66, 9, '2015-04-27 11:03:46', 0),
(67, 9, '2015-04-27 11:05:23', 1),
(68, 9, '2015-04-27 11:05:55', 0),
(69, 9, '2015-04-27 11:20:50', 1),
(70, 9, '2015-04-27 11:22:06', 0),
(71, 9, '2015-04-28 15:04:42', 0),
(72, 9, '2015-04-28 15:05:07', 1),
(73, 1, '2015-04-28 15:05:12', 0),
(74, 1, '2015-04-28 15:07:25', 1),
(75, 9, '2015-04-28 15:07:37', 0),
(76, 9, '2015-04-28 15:14:19', 1),
(77, 1, '2015-04-28 15:14:45', 0),
(78, 1, '2015-04-28 15:17:24', 1),
(79, 9, '2015-04-28 15:17:33', 0),
(80, 9, '2015-04-28 15:20:20', 1),
(81, 1, '2015-04-28 15:24:20', 0),
(82, 1, '2015-04-28 15:30:45', 1),
(83, 1, '2015-04-28 15:34:12', 0),
(84, 1, '2015-04-28 16:23:59', 1),
(85, 1, '2015-04-28 16:24:49', 0),
(86, 1, '2015-04-29 09:10:51', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrera`
--

CREATE TABLE IF NOT EXISTS `carrera` (
`id_carrera` int(11) NOT NULL,
  `nombre_carrera` varchar(45) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `carrera`
--

INSERT INTO `carrera` (`id_carrera`, `nombre_carrera`) VALUES
(1, 'Licenciatura en Informática'),
(2, 'Ingeniería de Sistemas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultor_tis`
--

CREATE TABLE IF NOT EXISTS `consultor_tis` (
  `usuario` int(11) NOT NULL,
  `curriculum` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `consultor_tis`
--

INSERT INTO `consultor_tis` (`usuario`, `curriculum`) VALUES
(8, NULL),
(9, NULL);

--
-- Disparadores `consultor_tis`
--
DELIMITER //
CREATE TRIGGER `consultor_tis_ADEL` AFTER DELETE ON `consultor_tis`
 FOR EACH ROW BEGIN
	INSERT INTO bitacora_bd(usuario,fecha_hora,tabla,viejo) VALUES (id_usuario(connection_id()),CURRENT_TIMESTAMP,'consultor_tis', CONCAT_WS(',', OLD.usuario, OLD.curriculum));
END
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `consultor_tis_AINS` AFTER INSERT ON `consultor_tis`
 FOR EACH ROW BEGIN
	INSERT INTO bitacora_bd(usuario,fecha_hora,tabla,nuevo) VALUES (id_usuario(connection_id()),CURRENT_TIMESTAMP,'consultor_tis', CONCAT_WS(',' , NEW.usuario, NEW.curriculum));
END
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `consultor_tis_AUPD` AFTER UPDATE ON `consultor_tis`
 FOR EACH ROW BEGIN
	INSERT INTO bitacora_bd(usuario,fecha_hora,tabla,viejo,nuevo) VALUES (id_usuario(connection_id()),CURRENT_TIMESTAMP,'consultor_tis', CONCAT_WS(',', OLD.usuario, OLD.curriculum), CONCAT_WS(',' , NEW.usuario, NEW.curriculum));
END
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `consultor_tis_BINS` BEFORE INSERT ON `consultor_tis`
 FOR EACH ROW BEGIN
	INSERT INTO notificacion (fecha,tipo_notificacion,usuario,usuario_destino) VALUES (CURRENT_TIMESTAMP,1,NEW.usuario,1);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento_consultor`
--

CREATE TABLE IF NOT EXISTS `documento_consultor` (
`id_documento_consultor` int(11) NOT NULL,
  `nombre_documento` varchar(64) NOT NULL,
  `descripsion_documento` varchar(128) DEFAULT NULL,
  `ruta_documento` varchar(128) DEFAULT NULL,
  `fecha_documento` datetime NOT NULL,
  `documento_jefe` tinyint(1) NOT NULL,
  `consultor_tis` int(11) NOT NULL,
  `gestion` int(11) NOT NULL,
  `habilitado` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Disparadores `documento_consultor`
--
DELIMITER //
CREATE TRIGGER `documento_consultor_AINS` AFTER INSERT ON `documento_consultor`
 FOR EACH ROW BEGIN
	INSERT INTO notificacion(fecha,tipo_notificacion,usuario,usuario_destino) VALUES (CURRENT_TIMESTAMP,4,NEW.consultor_tis,1);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrega_producto`
--

CREATE TABLE IF NOT EXISTS `entrega_producto` (
`id_entrega_producto` int(11) NOT NULL,
  `descripcion` varchar(128) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `fecha_real_entrega` date DEFAULT NULL,
  `pago_establecido` decimal(6,2) DEFAULT '0.00',
  `pago_recibido` decimal(6,2) DEFAULT '0.00',
  `observacion` text,
  `enlace_producto` text,
  `grupo_empresa` int(11) NOT NULL,
  `id_responsable` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Disparadores `entrega_producto`
--
DELIMITER //
CREATE TRIGGER `entrega_producto_ADEL` AFTER DELETE ON `entrega_producto`
 FOR EACH ROW BEGIN
	INSERT INTO bitacora_bd(usuario,tabla,fecha_hora,viejo) VALUES (id_usuario(connection_id()),'entrega_producto',CURRENT_TIMESTAMP,CONCAT_WS(',',OLD.id_entrega_producto,OLD.descripcion,OLD.fecha_inicio,OLD.fecha_fin,OLD.fecha_real_entrega,OLD.pago_establecido,OLD.pago_recibido,OLD.observacion,OLD.enlace_producto,OLD.grupo_empresa));
END
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `entrega_producto_AINS` AFTER INSERT ON `entrega_producto`
 FOR EACH ROW BEGIN
	INSERT INTO bitacora_bd(usuario,tabla,fecha_hora,nuevo) VALUES (id_usuario(connection_id()),'entrega_producto',CURRENT_TIMESTAMP,CONCAT_WS(',',NEW.id_entrega_producto,NEW.descripcion,NEW.fecha_inicio,NEW.fecha_fin,NEW.fecha_real_entrega,NEW.pago_establecido,NEW.pago_recibido,NEW.observacion,NEW.enlace_producto,NEW.grupo_empresa));
END
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `entrega_producto_AUPD` AFTER UPDATE ON `entrega_producto`
 FOR EACH ROW BEGIN
	INSERT INTO bitacora_bd(usuario,tabla,fecha_hora,viejo,nuevo) VALUES (id_usuario(connection_id()),'entrega_producto',CURRENT_TIMESTAMP,CONCAT_WS(',',OLD.id_entrega_producto,OLD.descripcion,OLD.fecha_inicio,OLD.fecha_fin,OLD.fecha_real_entrega,OLD.pago_establecido,OLD.pago_recibido,OLD.observacion,OLD.enlace_producto,OLD.grupo_empresa),CONCAT_WS(',',NEW.id_entrega_producto,NEW.descripcion,NEW.fecha_inicio,NEW.fecha_fin,NEW.fecha_real_entrega,NEW.pago_establecido,NEW.pago_recibido,NEW.observacion,NEW.enlace_producto,NEW.grupo_empresa));
END
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `entrega_producto_BUPD` BEFORE UPDATE ON `entrega_producto`
 FOR EACH ROW BEGIN
	DECLARE old_date CONDITION FOR SQLSTATE '99991';
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	  BEGIN
		CALL SP_RAISE_ERROR ('La actividad puede editarse. Verifique lo siguiente:
-La fecha de inicio de la entrega no es hoy ni ha pasado ya.
-La duración máxima de la entrega deber ser de dos semanas.');
	  END;
	IF(OLD.fecha_inicio <= CURDATE() AND (OLD.descripcion != NEW.descripcion OR OLD.fecha_inicio != NEW.fecha_inicio OR OLD.fecha_fin != NEW.fecha_fin)) THEN
		CALL ghost_procedure();
	END IF;
	IF(OLD.enlace_producto != NEW.enlace_producto)
	THEN INSERT INTO notificacion(fecha,tipo_notificacion,usuario,usuario_destino) VALUES (CURRENT_TIMESTAMP,11,id_usuario(connection_id()),get_consultor_empresa(NEW.grupo_empresa));
	END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fase_convocatoria`
--

CREATE TABLE IF NOT EXISTS `fase_convocatoria` (
`id_fase_convocatoria` int(11) NOT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `descripcion` varchar(128) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '0',
  `tipo_fase_convocatoria` int(11) NOT NULL,
  `gestion` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Volcado de datos para la tabla `fase_convocatoria`
--

INSERT INTO `fase_convocatoria` (`id_fase_convocatoria`, `fecha_inicio`, `fecha_fin`, `descripcion`, `activo`, `tipo_fase_convocatoria`, `gestion`) VALUES
(13, NULL, NULL, NULL, 0, 1, 1),
(14, NULL, NULL, NULL, 0, 2, 1),
(15, NULL, NULL, NULL, 0, 3, 1),
(16, NULL, NULL, NULL, 0, 4, 1),
(17, NULL, NULL, NULL, 0, 5, 1),
(18, NULL, NULL, NULL, 0, 6, 1),
(19, NULL, NULL, NULL, 0, 7, 1),
(27, '2015-04-28', '2015-05-21', NULL, 1, 1, 3),
(28, '2015-04-28', '2015-05-21', NULL, 1, 2, 3),
(29, '2015-04-28', '2015-05-21', NULL, 1, 3, 3),
(30, '2015-04-28', '2015-05-21', NULL, 1, 4, 3),
(31, '2015-04-28', '2015-07-31', NULL, 1, 5, 3),
(32, '2015-04-28', '2015-07-01', NULL, 1, 6, 3),
(33, '2015-04-28', '2015-05-21', NULL, 1, 7, 3);

--
-- Disparadores `fase_convocatoria`
--
DELIMITER //
CREATE TRIGGER `fase_convocatoria_BUPD` BEFORE UPDATE ON `fase_convocatoria`
 FOR EACH ROW BEGIN
	DECLARE tipo INT;
	IF(OLD.activo != NEW.activo)
	THEN IF(NEW.activo = 1)
			THEN SET tipo = 9;
			ELSE SET tipo = 10;
		END IF;
		INSERT INTO notificacion(fecha,tipo_notificacion,usuario,usuario_destino) VALUES (CURRENT_TIMESTAMP,tipo,id_usuario(connection_id()),1);
	END IF;
	IF(OLD.fecha_inicio != NEW.fecha_inicio OR OLD.fecha_fin != NEW.fecha_fin)
	THEN SET tipo = 14;
		INSERT INTO notificacion(fecha,tipo_notificacion,usuario,usuario_destino) VALUES (CURRENT_TIMESTAMP,tipo,id_usuario(connection_id()),1);
	END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestion_empresa_tis`
--

CREATE TABLE IF NOT EXISTS `gestion_empresa_tis` (
`id_gestion` int(11) NOT NULL,
  `gestion` varchar(20) NOT NULL,
  `descripcion_gestion` varchar(64) DEFAULT NULL,
  `fecha_ini_gestion` date NOT NULL,
  `fecha_fin_gestion` date DEFAULT NULL,
  `gestion_activa` tinyint(1) NOT NULL,
  `Fecha1` date NOT NULL,
  `Fecha2` date NOT NULL,
  `Fecha3` date NOT NULL,
  `Fecha4` date NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `gestion_empresa_tis`
--

INSERT INTO `gestion_empresa_tis` (`id_gestion`, `gestion`, `descripcion_gestion`, `fecha_ini_gestion`, `fecha_fin_gestion`, `gestion_activa`, `Fecha1`, `Fecha2`, `Fecha3`, `Fecha4`) VALUES
(1, 'Permanente', 'Gestion Permanente para Administrador Y Consultor TIS', '2014-01-01', NULL, 0, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(3, '1-2015', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2015-04-27', '2015-07-31', 1, '0000-00-00', '2015-04-07', '0000-00-00', '0000-00-00');

--
-- Disparadores `gestion_empresa_tis`
--
DELIMITER //
CREATE TRIGGER `fases` AFTER INSERT ON `gestion_empresa_tis`
 FOR EACH ROW BEGIN
	INSERT INTO fase_convocatoria(activo,tipo_fase_convocatoria,gestion) VALUES(0,1,NEW.id_gestion);
	INSERT INTO fase_convocatoria(activo,tipo_fase_convocatoria,gestion) VALUES(0,2,NEW.id_gestion);
	INSERT INTO fase_convocatoria(activo,tipo_fase_convocatoria,gestion) VALUES(0,3,NEW.id_gestion);
	INSERT INTO fase_convocatoria(activo,tipo_fase_convocatoria,gestion) VALUES(0,4,NEW.id_gestion);
	INSERT INTO fase_convocatoria(activo,tipo_fase_convocatoria,gestion) VALUES(0,5,NEW.id_gestion);
	INSERT INTO fase_convocatoria(activo,tipo_fase_convocatoria,gestion) VALUES(0,6,NEW.id_gestion);
	INSERT INTO fase_convocatoria(activo,tipo_fase_convocatoria,gestion) VALUES(0,7,NEW.id_gestion);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo_empresa`
--

CREATE TABLE IF NOT EXISTS `grupo_empresa` (
`id_grupo_empresa` int(11) NOT NULL,
  `nombre_largo` varchar(64) NOT NULL,
  `nombre_corto` varchar(20) NOT NULL,
  `fecha_sobre_a` date DEFAULT NULL,
  `sobre_a` varchar(128) DEFAULT NULL,
  `fecha_sobre_b` date DEFAULT NULL,
  `sobre_b` varchar(128) DEFAULT NULL,
  `sociedad` int(11) DEFAULT NULL,
  `consultor_tis` int(11) NOT NULL,
  `observacion` varchar(64) DEFAULT NULL,
  `habilitado` int(1) DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `grupo_empresa`
--

INSERT INTO `grupo_empresa` (`id_grupo_empresa`, `nombre_largo`, `nombre_corto`, `fecha_sobre_a`, `sobre_a`, `fecha_sobre_b`, `sobre_b`, `sociedad`, `consultor_tis`, `observacion`, `habilitado`) VALUES
(1, 'tallerdeingenieria', 'tis2015', NULL, NULL, NULL, NULL, 2, 9, NULL, 0);

--
-- Disparadores `grupo_empresa`
--
DELIMITER //
CREATE TRIGGER `grupo_empresa_ADEL` AFTER DELETE ON `grupo_empresa`
 FOR EACH ROW BEGIN
	INSERT INTO bitacora_bd(usuario,fecha_hora,tabla,viejo) VALUES (id_usuario(connection_id()),CURRENT_TIMESTAMP,'grupo_empresa', CONCAT_WS(',', OLD.nombre_largo, OLD.nombre_corto, OLD.fecha_sobre_a, OLD.sobre_a, OLD.fecha_sobre_b, OLD.sobre_b, OLD.sociedad, OLD.consultor_tis));
END
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `grupo_empresa_AINS` AFTER INSERT ON `grupo_empresa`
 FOR EACH ROW BEGIN
	INSERT INTO bitacora_bd(usuario,fecha_hora,tabla,nuevo) VALUES (id_usuario(connection_id()),CURRENT_TIMESTAMP,'grupo_empresa', CONCAT_WS(',' ,NEW.nombre_largo, NEW.nombre_corto, NEW.fecha_sobre_a, NEW.sobre_a, NEW.fecha_sobre_b, NEW.sobre_b, NEW.sociedad, NEW.consultor_tis));
END
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `grupo_empresa_AUPD` AFTER UPDATE ON `grupo_empresa`
 FOR EACH ROW BEGIN
	INSERT INTO bitacora_bd(usuario,fecha_hora,tabla,viejo,nuevo) VALUES (id_usuario(connection_id()),CURRENT_TIMESTAMP,'grupo_empresa', CONCAT_WS(',', OLD.nombre_largo, OLD.nombre_corto, OLD.fecha_sobre_a, OLD.sobre_a, OLD.fecha_sobre_b, OLD.sobre_b, OLD.sociedad, OLD.consultor_tis, OLD.observacion, OLD.habilitado), CONCAT_WS(',' ,NEW.nombre_largo, NEW.nombre_corto, NEW.fecha_sobre_a, NEW.sobre_a, NEW.fecha_sobre_b, NEW.sobre_b, NEW.sociedad, NEW.consultor_tis, NEW.observacion, NEW.habilitado));
END
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `grupo_empresa_BUPD` BEFORE UPDATE ON `grupo_empresa`
 FOR EACH ROW BEGIN
IF((OLD.sobre_a <=> NULL AND !(OLD.sobre_a <=> NEW.sobre_a)) OR(OLD.sobre_b <=> NULL AND !(OLD.sobre_b <=> NEW.sobre_b)))
         THEN INSERT INTO notificacion(fecha,tipo_notificacion,usuario,usuario_destino) VALUES (CURRENT_TIMESTAMP,16,get_jefe_grupo(OLD.id_grupo_empresa),get_consultor_empresa(OLD.id_grupo_empresa));
ELSE IF((!(OLD.sobre_a <=> NULL) AND (NEW.sobre_a <=> NULL)) OR(!(OLD.sobre_b <=> NULL) AND (NEW.sobre_b <=> NULL)))
         THEN INSERT INTO notificacion(fecha,tipo_notificacion,usuario,usuario_destino) VALUES (CURRENT_TIMESTAMP,12,get_consultor_empresa(OLD.id_grupo_empresa),get_jefe_grupo(OLD.id_grupo_empresa));
         ELSE IF(OLD.habilitado = '0' AND NEW.habilitado = '1')
                  THEN INSERT INTO notificacion(fecha,tipo_notificacion,usuario,usuario_destino) VALUES (CURRENT_TIMESTAMP,15,get_consultor_empresa(OLD.id_grupo_empresa),get_jefe_grupo(OLD.id_grupo_empresa));
                  END IF;
         END IF;
END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `integrante`
--

CREATE TABLE IF NOT EXISTS `integrante` (
  `usuario` int(11) NOT NULL,
  `codigo_sis` varchar(9) NOT NULL,
  `carrera` int(11) NOT NULL,
  `grupo_empresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `integrante`
--

INSERT INTO `integrante` (`usuario`, `codigo_sis`, `carrera`, `grupo_empresa`) VALUES
(10, '201101035', 1, 1);

--
-- Disparadores `integrante`
--
DELIMITER //
CREATE TRIGGER `integrante_ADEL` AFTER DELETE ON `integrante`
 FOR EACH ROW BEGIN
	INSERT INTO bitacora_bd(usuario,fecha_hora,tabla,viejo) VALUES (id_usuario(connection_id()),CURRENT_TIMESTAMP,'integrante', CONCAT_WS(',', OLD.usuario, OLD.codigo_sis, OLD.carrera, OLD.grupo_empresa));
END
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `integrante_AINS` AFTER INSERT ON `integrante`
 FOR EACH ROW BEGIN
	INSERT INTO bitacora_bd(usuario,fecha_hora,tabla,nuevo) VALUES (id_usuario(connection_id()),CURRENT_TIMESTAMP,'integrante', CONCAT_WS(',' , NEW.usuario, NEW.codigo_sis, NEW.carrera, NEW.grupo_empresa));
END
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `integrante_AUPD` AFTER UPDATE ON `integrante`
 FOR EACH ROW BEGIN
	INSERT INTO bitacora_bd(usuario,fecha_hora,tabla,viejo,nuevo) VALUES (id_usuario(connection_id()),CURRENT_TIMESTAMP,'integrante', CONCAT_WS(',', OLD.usuario, OLD.codigo_sis, OLD.carrera, OLD.grupo_empresa), CONCAT_WS(',' , NEW.usuario, NEW.codigo_sis, NEW.carrera, NEW.grupo_empresa));
END
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `integrante_BINS` BEFORE INSERT ON `integrante`
 FOR EACH ROW BEGIN
	INSERT INTO notificacion (fecha, tipo_notificacion, usuario, usuario_destino) VALUES (CURRENT_TIMESTAMP,2,NEW.usuario,get_consultor_empresa(NEW.grupo_empresa));
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensaje`
--

CREATE TABLE IF NOT EXISTS `mensaje` (
`id_mensaje` int(11) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `contenido` text NOT NULL,
  `leido` tinyint(1) NOT NULL,
  `de_usuario` int(11) NOT NULL,
  `asunto` varchar(32) NOT NULL,
  `visible` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodologia`
--

CREATE TABLE IF NOT EXISTS `metodologia` (
`id_metodologia` int(11) unsigned NOT NULL,
  `nombre_metodologia` varchar(50) NOT NULL,
  `descripcion_metodologia` varchar(300) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `metodologia`
--

INSERT INTO `metodologia` (`id_metodologia`, `nombre_metodologia`, `descripcion_metodologia`) VALUES
(1, 'scrum', 'metodologia scrum'),
(2, 'eXtreme Programming', 'metodologia xp');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodologia_grupo_empresa`
--

CREATE TABLE IF NOT EXISTS `metodologia_grupo_empresa` (
  `id_grupo_empresa` int(11) NOT NULL,
  `id_metodologia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `metodologia_grupo_empresa`
--

INSERT INTO `metodologia_grupo_empresa` (`id_grupo_empresa`, `id_metodologia`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacion`
--

CREATE TABLE IF NOT EXISTS `notificacion` (
`id_notificacion` int(11) NOT NULL,
  `leido` tinyint(1) NOT NULL DEFAULT '0',
  `fecha` datetime NOT NULL,
  `tipo_notificacion` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `usuario_destino` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

--
-- Volcado de datos para la tabla `notificacion`
--

INSERT INTO `notificacion` (`id_notificacion`, `leido`, `fecha`, `tipo_notificacion`, `usuario`, `usuario_destino`) VALUES
(30, 0, '2015-04-27 09:53:27', 1, 8, 1),
(31, 0, '2015-04-27 10:17:05', 7, 1, 8),
(32, 0, '2015-04-27 10:20:25', 1, 9, 1),
(33, 0, '2015-04-27 10:21:12', 7, 1, 9),
(34, 0, '2015-04-27 10:54:46', 8, 1, 8),
(35, 0, '2015-04-28 15:18:14', 9, 9, 1),
(36, 0, '2015-04-28 15:18:29', 9, 9, 1),
(37, 0, '2015-04-28 15:18:39', 9, 9, 1),
(38, 0, '2015-04-28 15:18:51', 9, 9, 1),
(39, 0, '2015-04-28 15:19:03', 9, 9, 1),
(40, 0, '2015-04-28 15:19:38', 9, 9, 1),
(41, 0, '2015-04-28 15:20:03', 9, 9, 1),
(42, 0, '2015-04-28 15:24:14', 2, 10, 9),
(43, 0, '2015-04-28 15:25:08', 7, 1, 10),
(44, 0, '2015-04-28 16:58:01', 8, 1, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE IF NOT EXISTS `rol` (
`id_rol` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(128) NOT NULL,
  `rol_unico` varchar(2) NOT NULL DEFAULT 'no',
  `id_metodologia` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `nombre`, `descripcion`, `rol_unico`, `id_metodologia`) VALUES
(1, 'Representante Legal', 'El Representante Legal contacta con la Empresa TIS para todo efecto legal.', 'si', 0),
(2, 'Product Owner', 'En Scrum, el Product Owner estudia los requerimientos del cliente y los comunica al Equipo.', 'si', 1),
(3, 'Scrum Master', 'En Scrum, el Scrum Master dirige el proceso de desarrollo.', 'si', 1),
(4, 'Desarrollador', 'El Desarrollador es "el pan y la mantequilla" de todo proceso de desarrollo de software.', 'no', 0),
(5, 'Tester', 'El Tester se encarga de probar la funcionalidad de los producto de los desarrolladores.', 'no', 0),
(6, 'Encargado Base de Datos', 'El Encargado de la Base de Datos está continuamente trabajando con la reingeniería de la base de datos.', 'no', 0),
(7, 'Documentador', 'El Documentador redacta los documentos necesarios para controlar, verificar y avalar el proceso.', 'no', 0),
(8, 'Tracker', 'Proporciona retroalimentacion al equipo en el proceso xp', 'si', 2),
(9, 'Big boss', 'Es el vinculo entre clientes y programadores', 'si', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_integrante`
--

CREATE TABLE IF NOT EXISTS `rol_integrante` (
  `integrante` int(11) NOT NULL,
  `rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rol_integrante`
--

INSERT INTO `rol_integrante` (`integrante`, `rol`) VALUES
(10, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sesion`
--

CREATE TABLE IF NOT EXISTS `sesion` (
  `id_proceso` int(11) NOT NULL,
  `usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sesion`
--

INSERT INTO `sesion` (`id_proceso`, `usuario`) VALUES
(14, 1),
(126, 1),
(132, 1),
(320, 1),
(322, 1),
(327, 1),
(329, 1),
(354, 1),
(366, 1),
(368, 1),
(391, 1),
(397, 1),
(408, 1),
(410, 1),
(483, 1),
(485, 1),
(516, 1),
(519, 1),
(523, 1),
(529, 1),
(531, 1),
(546, 1),
(568, 1),
(586, 1),
(587, 1),
(589, 1),
(590, 1),
(592, 1),
(605, 1),
(617, 1),
(626, 1),
(629, 1),
(642, 1),
(654, 1),
(656, 1),
(658, 1),
(661, 1),
(664, 1),
(667, 1),
(701, 1),
(715, 1),
(728, 1),
(741, 1),
(754, 1),
(769, 1),
(782, 1),
(51, 9),
(83, 9),
(86, 9),
(94, 9),
(97, 9),
(99, 9),
(100, 9),
(101, 9),
(102, 9),
(103, 9),
(104, 9),
(105, 9),
(106, 9),
(107, 9),
(108, 9),
(109, 9),
(110, 9),
(111, 9),
(112, 9),
(113, 9),
(114, 9),
(115, 9),
(116, 9),
(117, 9),
(118, 9),
(119, 9),
(120, 9),
(121, 9),
(801, 9),
(803, 9),
(874, 9),
(912, 9),
(959, 9),
(962, 9),
(1213, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sociedad`
--

CREATE TABLE IF NOT EXISTS `sociedad` (
`id_sociedad` int(11) NOT NULL,
  `descripcion` varchar(64) NOT NULL,
  `abreviatura` varchar(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `sociedad`
--

INSERT INTO `sociedad` (`id_sociedad`, `descripcion`, `abreviatura`) VALUES
(1, 'Sociedad Anónima', 'S.A.'),
(2, 'Sociedad de Responsabilidad Limitada', 'S.R.L.'),
(3, 'Empresa Individual de Responsabilidad Limitada', 'E.I.R.L.'),
(4, 'Sociedad en Comandita', 'S.Co.'),
(5, 'Sociedad Colectiva', 'S.C.'),
(6, 'Sociedad de Hecho', 'S.H.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarea`
--

CREATE TABLE IF NOT EXISTS `tarea` (
`id_tarea` int(11) NOT NULL,
  `descripcion` varchar(128) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `resultado_esperado` varchar(128) NOT NULL,
  `resultado_obtenido` varchar(128) DEFAULT NULL,
  `porcentaje_completado` int(11) NOT NULL DEFAULT '0',
  `color_tarea` varchar(20) DEFAULT NULL,
  `color_texto` varchar(20) DEFAULT NULL,
  `modificado` int(11) DEFAULT '0',
  `actividad` int(11) NOT NULL,
  `responsable` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Disparadores `tarea`
--
DELIMITER //
CREATE TRIGGER `tarea_ADEL` AFTER DELETE ON `tarea`
 FOR EACH ROW BEGIN
	INSERT INTO bitacora_bd(usuario,tabla,fecha_hora,viejo) VALUES (id_usuario(connection_id()),'tarea',CURRENT_TIMESTAMP,CONCAT_WS(',',OLD.id_tarea,OLD.descripcion,OLD.fecha_inicio,OLD.fecha_fin,OLD.resultado_esperado,OLD.resultado_obtenido,OLD.porcentaje_completado,OLD.color_tarea,OLD.color_texto,OLD.modificado));
END
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `tarea_AINS` AFTER INSERT ON `tarea`
 FOR EACH ROW BEGIN
	INSERT INTO bitacora_bd(usuario,tabla,fecha_hora,nuevo) VALUES (id_usuario(connection_id()),'tarea',CURRENT_TIMESTAMP,CONCAT_WS(',',NEW.id_tarea,NEW.descripcion,NEW.fecha_inicio,NEW.fecha_fin,NEW.resultado_esperado,NEW.resultado_obtenido,NEW.porcentaje_completado,NEW.color_tarea,NEW.color_texto,NEW.modificado));
END
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `tarea_AUPD` AFTER UPDATE ON `tarea`
 FOR EACH ROW BEGIN
	INSERT INTO bitacora_bd(usuario,tabla,fecha_hora,viejo,nuevo) VALUES (id_usuario(connection_id()),'tarea',CURRENT_TIMESTAMP,CONCAT_WS(',',OLD.id_tarea,OLD.descripcion,OLD.fecha_inicio,OLD.fecha_fin,OLD.resultado_esperado,OLD.resultado_obtenido,OLD.porcentaje_completado,OLD.color_tarea,OLD.color_texto,OLD.modificado),CONCAT_WS(',',NEW.id_tarea,NEW.descripcion,NEW.fecha_inicio,NEW.fecha_fin,NEW.resultado_esperado,NEW.resultado_obtenido,NEW.porcentaje_completado,NEW.color_tarea,NEW.color_texto,NEW.modificado));
END
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `tarea_BUPD` BEFORE UPDATE ON `tarea`
 FOR EACH ROW BEGIN
	DECLARE old_date CONDITION FOR SQLSTATE '99991';
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	  BEGIN
		CALL SP_RAISE_ERROR ('La fecha de inicio de la tarea ya ha vencido.');
	  END;
	IF(OLD.fecha_inicio <= CURDATE() AND (OLD.descripcion != NEW.descripcion OR OLD.fecha_inicio != NEW.fecha_inicio OR OLD.fecha_fin != NEW.fecha_fin)) THEN
		CALL ghost_procedure();
	END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_dummy`
--

CREATE TABLE IF NOT EXISTS `tbl_dummy` (
  `error` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Disparadores `tbl_dummy`
--
DELIMITER //
CREATE TRIGGER `TRIG_BI_DUMMY` BEFORE INSERT ON `tbl_dummy`
 FOR EACH ROW BEGIN
    SET NEW = NEW.`error`;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_fase_convocatoria`
--

CREATE TABLE IF NOT EXISTS `tipo_fase_convocatoria` (
`id_tipo_fase_convocatoria` int(11) NOT NULL,
  `descripcion` varchar(64) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `tipo_fase_convocatoria`
--

INSERT INTO `tipo_fase_convocatoria` (`id_tipo_fase_convocatoria`, `descripcion`) VALUES
(1, 'Lanzamiento de la Convocatoria Pública'),
(2, 'Registro de Grupo Empresas'),
(3, 'Envio de Documentos'),
(4, 'Firma de Contratos'),
(5, 'Proceso de Desarollo'),
(6, 'Entrega de Producto Final'),
(7, 'Cierre de la Convocatoria');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_notificacion`
--

CREATE TABLE IF NOT EXISTS `tipo_notificacion` (
`id_tipo_notificacion` int(11) NOT NULL,
  `descripcion` varchar(60) NOT NULL,
  `enlace` varchar(128) DEFAULT NULL,
  `contenido` varchar(40) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Volcado de datos para la tabla `tipo_notificacion`
--

INSERT INTO `tipo_notificacion` (`id_tipo_notificacion`, `descripcion`, `enlace`, `contenido`) VALUES
(1, 'Consultor(es) TIS esperando validación', '', ''),
(2, 'Integrante(s) esperando validación', '', ''),
(3, 'Comentario(s) nuevo(s)', '', ''),
(4, 'Documento(s) nuevo(s)', '', ''),
(5, 'Plazo(s) cumplido(s)', '', ''),
(6, 'Nuevo avance semanal', '', ''),
(7, 'Usuario habilitado', '', ''),
(8, 'Usuario deshabilitado', '', ''),
(9, 'Fase habilitada', '', ''),
(10, 'Fase deshabilitada', '', ''),
(11, 'Enlace producto actualizado', '', ''),
(12, 'Consultor TIS rechazo sobres A-B', '', ''),
(13, 'Documento recibido', '', ''),
(14, 'Fase modificada', '', ''),
(15, 'Consultor TIS acepta sobres A-B', '', ''),
(16, 'Grupo Empresa envio sobres A-B', '', ''),
(17, 'Tiene observacion(es) en la entrega de un subsistema', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE IF NOT EXISTS `tipo_usuario` (
`id_tipo_usuario` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id_tipo_usuario`, `descripcion`) VALUES
(1, 'Administrador'),
(2, 'Jefe Consultor TIS'),
(3, 'Consultor TIS'),
(4, 'Jefe de Grupo Empresa'),
(5, 'Integrante');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
`id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(20) NOT NULL,
  `clave` varchar(20) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `telefono` varchar(12) DEFAULT NULL,
  `email` varchar(48) NOT NULL,
  `foto` varchar(128) DEFAULT NULL,
  `habilitado` tinyint(1) NOT NULL,
  `tipo_usuario` int(11) NOT NULL,
  `gestion` int(11) NOT NULL,
  `asistencia` int(2) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre_usuario`, `clave`, `nombre`, `apellido`, `telefono`, `email`, `foto`, `habilitado`, `tipo_usuario`, `gestion`, `asistencia`) VALUES
(1, 'admin', 'admin', 'Boris Marcelo', 'Calancha Navia', '4436755', 'boris@yahoo.com', '', 1, 1, 1, 0),
(8, 'brianperez', 'rbpo92007', 'Brian', 'Perez', '4292136', 'b@gmail.com', NULL, 0, 2, 1, 0),
(9, 'rodrigoperez', 'rbpo92007', 'Rodrigo', 'Perez', '4292136', 'bp@gmail.com', NULL, 1, 2, 1, 0),
(10, 'asdasdasd', 'asdasdasd92', 'brian', 'perez', '80000000', 'bere@hotmail.com', NULL, 0, 4, 3, 0);

--
-- Disparadores `usuario`
--
DELIMITER //
CREATE TRIGGER `usuario_ADEL` AFTER DELETE ON `usuario`
 FOR EACH ROW BEGIN
	INSERT INTO bitacora_bd(usuario,fecha_hora,tabla,viejo) VALUES (id_usuario(connection_id()),CURRENT_TIMESTAMP,'usuario', CONCAT_WS(',', OLD.nombre_usuario, OLD.clave, OLD.nombre, OLD.apellido, OLD.telefono, OLD.email, OLD.foto, OLD.habilitado, OLD.tipo_usuario, OLD.gestion));
END
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `usuario_AINS` AFTER INSERT ON `usuario`
 FOR EACH ROW BEGIN
	INSERT INTO bitacora_bd(usuario,fecha_hora,tabla,nuevo) VALUES (id_usuario(connection_id()),CURRENT_TIMESTAMP,'usuario',CONCAT_WS(',', LAST_INSERT_ID(), NEW.nombre_usuario, NEW.clave, NEW.nombre, NEW.apellido, NEW.telefono, NEW.email, NEW.foto, NEW.habilitado, NEW.tipo_usuario, NEW.gestion));
END
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `usuario_AUPD` AFTER UPDATE ON `usuario`
 FOR EACH ROW BEGIN
	IF(OLD.habilitado != NEW.habilitado) THEN
	INSERT INTO bitacora_bd(usuario,fecha_hora,tabla,viejo,nuevo) VALUES (id_usuario(connection_id()),CURRENT_TIMESTAMP,'usuario', CONCAT_WS(',', OLD.nombre_usuario, OLD.clave, OLD.nombre, OLD.apellido, OLD.telefono, OLD.email, OLD.foto, OLD.habilitado, OLD.tipo_usuario, OLD.gestion), CONCAT_WS(',' ,NEW.nombre_usuario, NEW.clave, NEW.nombre, NEW.apellido, NEW.telefono, NEW.email, NEW.foto, NEW.habilitado, NEW.tipo_usuario, NEW.gestion));
	END IF;
END
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `usuario_BUPD` BEFORE UPDATE ON `usuario`
 FOR EACH ROW BEGIN
	DECLARE tipo INT;
	IF(OLD.habilitado != NEW.habilitado)
	THEN IF(NEW.habilitado = 1)
			THEN SET tipo = 7;
			ELSE SET tipo = 8;
		END IF;
		INSERT INTO notificacion(fecha,tipo_notificacion,usuario,usuario_destino) VALUES (CURRENT_TIMESTAMP,tipo,id_usuario(connection_id()),NEW.id_usuario);
	END IF;
END
//
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividad_grupo_empresa`
--
ALTER TABLE `actividad_grupo_empresa`
 ADD PRIMARY KEY (`id_actividad`), ADD KEY `fk_actividad_grupo_empresa_entrega_producto1_idx` (`entrega_producto`), ADD KEY `id_responsable` (`id_responsable`), ADD KEY `id_responsable_2` (`id_responsable`);

--
-- Indices de la tabla `anuncio`
--
ALTER TABLE `anuncio`
 ADD PRIMARY KEY (`id_anuncio`), ADD KEY `fk_anuncio_usuario1_idx` (`usuario`);

--
-- Indices de la tabla `avance_semanal`
--
ALTER TABLE `avance_semanal`
 ADD PRIMARY KEY (`id_avance_semanal`), ADD KEY `fk_avance_semanal_grupo_empresa1_idx` (`grupo_empresa`);

--
-- Indices de la tabla `backup_log`
--
ALTER TABLE `backup_log`
 ADD PRIMARY KEY (`id_backup`);

--
-- Indices de la tabla `bitacora_bd`
--
ALTER TABLE `bitacora_bd`
 ADD PRIMARY KEY (`id_bitacora`), ADD KEY `fk_bitacora_usuario1_idx` (`usuario`);

--
-- Indices de la tabla `bitacora_sesion`
--
ALTER TABLE `bitacora_sesion`
 ADD PRIMARY KEY (`id_bitacora_sesion`), ADD KEY `fk_bitacora_sesion_usuario1_idx` (`usuario`);

--
-- Indices de la tabla `carrera`
--
ALTER TABLE `carrera`
 ADD PRIMARY KEY (`id_carrera`);

--
-- Indices de la tabla `consultor_tis`
--
ALTER TABLE `consultor_tis`
 ADD PRIMARY KEY (`usuario`);

--
-- Indices de la tabla `documento_consultor`
--
ALTER TABLE `documento_consultor`
 ADD PRIMARY KEY (`id_documento_consultor`), ADD KEY `fk_documento_consultor_consultor_tis1_idx` (`consultor_tis`), ADD KEY `fk_documento_consultor_gestion_empresa_tis1_idx` (`gestion`);

--
-- Indices de la tabla `entrega_producto`
--
ALTER TABLE `entrega_producto`
 ADD PRIMARY KEY (`id_entrega_producto`), ADD KEY `fk_entrega_producto_grupo_empresa1_idx` (`grupo_empresa`), ADD KEY `id_responsable` (`id_responsable`);

--
-- Indices de la tabla `fase_convocatoria`
--
ALTER TABLE `fase_convocatoria`
 ADD PRIMARY KEY (`id_fase_convocatoria`), ADD KEY `fk_actividad_tipo_actividad1_idx` (`tipo_fase_convocatoria`), ADD KEY `fk_fase_convocatoria_gestion_empresa_tis1_idx` (`gestion`);

--
-- Indices de la tabla `gestion_empresa_tis`
--
ALTER TABLE `gestion_empresa_tis`
 ADD PRIMARY KEY (`id_gestion`);

--
-- Indices de la tabla `grupo_empresa`
--
ALTER TABLE `grupo_empresa`
 ADD PRIMARY KEY (`id_grupo_empresa`), ADD KEY `fk_grupo_empresa_sociedad` (`sociedad`), ADD KEY `fk_grupo_empresa_consultor_tis1_idx` (`consultor_tis`);

--
-- Indices de la tabla `integrante`
--
ALTER TABLE `integrante`
 ADD PRIMARY KEY (`usuario`), ADD KEY `fk_integrante_carrera1_idx` (`carrera`), ADD KEY `fk_integrante_grupo_empresa1_idx` (`grupo_empresa`);

--
-- Indices de la tabla `mensaje`
--
ALTER TABLE `mensaje`
 ADD PRIMARY KEY (`id_mensaje`), ADD KEY `fk_mensaje_usuario1_idx` (`de_usuario`);

--
-- Indices de la tabla `metodologia`
--
ALTER TABLE `metodologia`
 ADD PRIMARY KEY (`id_metodologia`), ADD UNIQUE KEY `id_metodologia` (`id_metodologia`);

--
-- Indices de la tabla `metodologia_grupo_empresa`
--
ALTER TABLE `metodologia_grupo_empresa`
 ADD UNIQUE KEY `id_grupo_empresa` (`id_metodologia`), ADD KEY `id_metodologia` (`id_metodologia`);

--
-- Indices de la tabla `notificacion`
--
ALTER TABLE `notificacion`
 ADD PRIMARY KEY (`id_notificacion`), ADD KEY `fk_notificacion_tipo_notificacion1_idx` (`tipo_notificacion`), ADD KEY `fk_notificacion_usuario1_idx` (`usuario`), ADD KEY `fk_notificacion_usuario2_idx` (`usuario_destino`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
 ADD PRIMARY KEY (`id_rol`), ADD KEY `id_metodologia` (`id_metodologia`);

--
-- Indices de la tabla `rol_integrante`
--
ALTER TABLE `rol_integrante`
 ADD KEY `fk_rol_integrante_rol1_idx` (`rol`), ADD KEY `fk_rol_integrante_integrante1_idx` (`integrante`);

--
-- Indices de la tabla `sesion`
--
ALTER TABLE `sesion`
 ADD PRIMARY KEY (`id_proceso`), ADD KEY `fk_sesion_usuario1_idx` (`usuario`);

--
-- Indices de la tabla `sociedad`
--
ALTER TABLE `sociedad`
 ADD PRIMARY KEY (`id_sociedad`);

--
-- Indices de la tabla `tarea`
--
ALTER TABLE `tarea`
 ADD PRIMARY KEY (`id_tarea`), ADD KEY `fk_tarea_actividad_grupo_empresa1_idx` (`actividad`), ADD KEY `fk_tarea_integrante1_idx` (`responsable`);

--
-- Indices de la tabla `tipo_fase_convocatoria`
--
ALTER TABLE `tipo_fase_convocatoria`
 ADD PRIMARY KEY (`id_tipo_fase_convocatoria`);

--
-- Indices de la tabla `tipo_notificacion`
--
ALTER TABLE `tipo_notificacion`
 ADD PRIMARY KEY (`id_tipo_notificacion`);

--
-- Indices de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
 ADD PRIMARY KEY (`id_tipo_usuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
 ADD PRIMARY KEY (`id_usuario`), ADD KEY `fk_usuario_tipo_usuario1_idx` (`tipo_usuario`), ADD KEY `fk_usuario_gestion_empresa_tis1_idx` (`gestion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividad_grupo_empresa`
--
ALTER TABLE `actividad_grupo_empresa`
MODIFY `id_actividad` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `anuncio`
--
ALTER TABLE `anuncio`
MODIFY `id_anuncio` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `avance_semanal`
--
ALTER TABLE `avance_semanal`
MODIFY `id_avance_semanal` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `backup_log`
--
ALTER TABLE `backup_log`
MODIFY `id_backup` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `bitacora_bd`
--
ALTER TABLE `bitacora_bd`
MODIFY `id_bitacora` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=425;
--
-- AUTO_INCREMENT de la tabla `bitacora_sesion`
--
ALTER TABLE `bitacora_sesion`
MODIFY `id_bitacora_sesion` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=87;
--
-- AUTO_INCREMENT de la tabla `carrera`
--
ALTER TABLE `carrera`
MODIFY `id_carrera` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `documento_consultor`
--
ALTER TABLE `documento_consultor`
MODIFY `id_documento_consultor` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `entrega_producto`
--
ALTER TABLE `entrega_producto`
MODIFY `id_entrega_producto` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `fase_convocatoria`
--
ALTER TABLE `fase_convocatoria`
MODIFY `id_fase_convocatoria` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT de la tabla `gestion_empresa_tis`
--
ALTER TABLE `gestion_empresa_tis`
MODIFY `id_gestion` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `grupo_empresa`
--
ALTER TABLE `grupo_empresa`
MODIFY `id_grupo_empresa` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `mensaje`
--
ALTER TABLE `mensaje`
MODIFY `id_mensaje` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `metodologia`
--
ALTER TABLE `metodologia`
MODIFY `id_metodologia` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `notificacion`
--
ALTER TABLE `notificacion`
MODIFY `id_notificacion` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `sociedad`
--
ALTER TABLE `sociedad`
MODIFY `id_sociedad` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `tarea`
--
ALTER TABLE `tarea`
MODIFY `id_tarea` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tipo_fase_convocatoria`
--
ALTER TABLE `tipo_fase_convocatoria`
MODIFY `id_tipo_fase_convocatoria` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `tipo_notificacion`
--
ALTER TABLE `tipo_notificacion`
MODIFY `id_tipo_notificacion` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
MODIFY `id_tipo_usuario` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividad_grupo_empresa`
--
ALTER TABLE `actividad_grupo_empresa`
ADD CONSTRAINT `fk_actividad_grupo_empresa_entrega_producto1` FOREIGN KEY (`entrega_producto`) REFERENCES `entrega_producto` (`id_entrega_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `anuncio`
--
ALTER TABLE `anuncio`
ADD CONSTRAINT `fk_anuncio_usuario1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `avance_semanal`
--
ALTER TABLE `avance_semanal`
ADD CONSTRAINT `fk_avance_semanal_grupo_empresa1` FOREIGN KEY (`grupo_empresa`) REFERENCES `grupo_empresa` (`id_grupo_empresa`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `bitacora_bd`
--
ALTER TABLE `bitacora_bd`
ADD CONSTRAINT `fk_bitacora_usuario1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `bitacora_sesion`
--
ALTER TABLE `bitacora_sesion`
ADD CONSTRAINT `fk_bitacora_sesion_usuario1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `consultor_tis`
--
ALTER TABLE `consultor_tis`
ADD CONSTRAINT `fk_consultor_tis_usuario1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `documento_consultor`
--
ALTER TABLE `documento_consultor`
ADD CONSTRAINT `fk_documento_consultor_consultor_tis1` FOREIGN KEY (`consultor_tis`) REFERENCES `consultor_tis` (`usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_documento_consultor_gestion_empresa_tis1` FOREIGN KEY (`gestion`) REFERENCES `gestion_empresa_tis` (`id_gestion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `entrega_producto`
--
ALTER TABLE `entrega_producto`
ADD CONSTRAINT `entrega_producto_ibfk_1` FOREIGN KEY (`id_responsable`) REFERENCES `usuario` (`id_usuario`),
ADD CONSTRAINT `fk_entrega_producto_grupo_empresa1` FOREIGN KEY (`grupo_empresa`) REFERENCES `grupo_empresa` (`id_grupo_empresa`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fase_convocatoria`
--
ALTER TABLE `fase_convocatoria`
ADD CONSTRAINT `fk_actividad_tipo_actividad1` FOREIGN KEY (`tipo_fase_convocatoria`) REFERENCES `tipo_fase_convocatoria` (`id_tipo_fase_convocatoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_fase_convocatoria_gestion_empresa_tis1` FOREIGN KEY (`gestion`) REFERENCES `gestion_empresa_tis` (`id_gestion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `grupo_empresa`
--
ALTER TABLE `grupo_empresa`
ADD CONSTRAINT `fk_grupo_empresa_consultor_tis1` FOREIGN KEY (`consultor_tis`) REFERENCES `consultor_tis` (`usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_grupo_empresa_sociedad` FOREIGN KEY (`sociedad`) REFERENCES `sociedad` (`id_sociedad`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `integrante`
--
ALTER TABLE `integrante`
ADD CONSTRAINT `fk_integrante_carrera1` FOREIGN KEY (`carrera`) REFERENCES `carrera` (`id_carrera`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_integrante_grupo_empresa1` FOREIGN KEY (`grupo_empresa`) REFERENCES `grupo_empresa` (`id_grupo_empresa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_integrante_usuario1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `mensaje`
--
ALTER TABLE `mensaje`
ADD CONSTRAINT `fk_mensaje_usuario1` FOREIGN KEY (`de_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `notificacion`
--
ALTER TABLE `notificacion`
ADD CONSTRAINT `fk_notificacion_tipo_notificacion1` FOREIGN KEY (`tipo_notificacion`) REFERENCES `tipo_notificacion` (`id_tipo_notificacion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_notificacion_usuario1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_notificacion_usuario2` FOREIGN KEY (`usuario_destino`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `rol_integrante`
--
ALTER TABLE `rol_integrante`
ADD CONSTRAINT `fk_rol_integrante_integrante1` FOREIGN KEY (`integrante`) REFERENCES `integrante` (`usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_rol_integrante_rol1` FOREIGN KEY (`rol`) REFERENCES `rol` (`id_rol`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sesion`
--
ALTER TABLE `sesion`
ADD CONSTRAINT `fk_sesion_usuario1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tarea`
--
ALTER TABLE `tarea`
ADD CONSTRAINT `fk_tarea_actividad_grupo_empresa1` FOREIGN KEY (`actividad`) REFERENCES `actividad_grupo_empresa` (`id_actividad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_tarea_integrante1` FOREIGN KEY (`responsable`) REFERENCES `integrante` (`usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
ADD CONSTRAINT `fk_usuario_gestion_empresa_tis1` FOREIGN KEY (`gestion`) REFERENCES `gestion_empresa_tis` (`id_gestion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_usuario_tipo_usuario1` FOREIGN KEY (`tipo_usuario`) REFERENCES `tipo_usuario` (`id_tipo_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
