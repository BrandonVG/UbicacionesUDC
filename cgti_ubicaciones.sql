/*
MySQL Data Transfer
Source Host: 148.213.1.123
Source Database: cgti_ubicaciones
Target Host: 148.213.1.123
Target Database: cgti_ubicaciones
Date: 15/03/2022 11:37:38 a. m.
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for actividades
-- ----------------------------
CREATE TABLE `actividades` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(70) NOT NULL,
  `estatus` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0: Inactivo  - 1: Activo',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for actividadesUbicacion
-- ----------------------------
CREATE TABLE `actividadesUbicacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idUbicacion` int(11) NOT NULL,
  `idActividad` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dirigido
-- ----------------------------
CREATE TABLE `dirigido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) NOT NULL,
  `estatus` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for dirigidoUbicacion
-- ----------------------------
CREATE TABLE `dirigidoUbicacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idUbicacion` int(11) NOT NULL,
  `idDirigido` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for equipamiento
-- ----------------------------
CREATE TABLE `equipamiento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(70) NOT NULL,
  `estatus` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Activo = 1; Inactivo = 0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for equipamientoUbicacion
-- ----------------------------
CREATE TABLE `equipamientoUbicacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idUbicacion` int(11) NOT NULL,
  `idEquipamiento` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for historico
-- ----------------------------
CREATE TABLE `historico` (
  `id` int(11) NOT NULL,
  `etiqueta` varchar(50) NOT NULL,
  `cupo` int(11) NOT NULL,
  `titulo` varchar(70) NOT NULL,
  `latitud` double NOT NULL,
  `longitud` double NOT NULL,
  `descripcion` varchar(2000) NOT NULL,
  `resumen` varchar(200) NOT NULL,
  `detalles` varchar(200) NOT NULL,
  `clasificadores` varchar(500) NOT NULL,
  `idSitio` int(11) NOT NULL,
  `dirigido` varchar(75) NOT NULL,
  `portada` varchar(50) NOT NULL,
  `idTipo` int(11) NOT NULL,
  `estatus` tinyint(4) NOT NULL DEFAULT '0',
  `aceptado` int(4) NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '0',
  `idPadre` int(11) NOT NULL DEFAULT '-1',
  `idHijo` int(11) NOT NULL,
  `fechaEdicion` timestamp NULL DEFAULT NULL,
  `fechaAprobacion` timestamp NULL DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `agrupador` varchar(20) NOT NULL,
  UNIQUE KEY `fecha` (`fecha`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for log
-- ----------------------------
CREATE TABLE `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(11) NOT NULL,
  `correo` varchar(70) NOT NULL,
  `idObjeto` int(11) NOT NULL,
  `tipoObjeto` varchar(50) NOT NULL,
  `accion` varchar(75) NOT NULL,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tiposUbicaciones
-- ----------------------------
CREATE TABLE `tiposUbicaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(70) NOT NULL,
  `estatus` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0: Inactivo  - 1: Activo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ubicaciones
-- ----------------------------
CREATE TABLE `ubicaciones` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `etiqueta` varchar(50) NOT NULL,
  `cupo` int(11) NOT NULL,
  `titulo` varchar(70) NOT NULL,
  `latitud` double NOT NULL,
  `longitud` double NOT NULL,
  `resumen` varchar(1000) NOT NULL,
  `descripcion` longtext NOT NULL,
  `detalles` varchar(1000) NOT NULL,
  `clasificadores` varchar(500) NOT NULL,
  `portada` varchar(50) NOT NULL,
  `idTipo` int(11) NOT NULL,
  `idSitio` int(11) NOT NULL,
  `estatus` tinyint(4) NOT NULL DEFAULT '0' COMMENT '-1: Eliminada - 0: guardada, 1: Enviada',
  `aceptado` tinyint(4) NOT NULL DEFAULT '-1' COMMENT '-1: Indefinido - 0: False - 1: Verdadero',
  `visible` tinyint(1) NOT NULL DEFAULT '0',
  `idPadre` int(11) NOT NULL DEFAULT '-1' COMMENT 'id de la ubicación que ya fue validada',
  `idHijo` int(11) NOT NULL DEFAULT '-1',
  `fechaEdicion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fechaAprobacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idDelegacion` tinyint(4) NOT NULL,
  `agrupador` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- View structure for v_dependencia_usuarios
-- ----------------------------
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `v_dependencia_usuarios` AS select `sitio_usuario`.`url` AS `url`,`sitio_usuario`.`titulo` AS `titulo`,`sitio_usuario`.`activo` AS `activo`,`sitio_usuario`.`correo` AS `correo`,`sitio_usuario`.`id_sitio` AS `id_sitio`,`sitio_usuario`.`id` AS `id`,`sitio_usuario`.`rol` AS `rol`,`sitio_usuario`.`tipo` AS `tipo`,`sitio_usuario`.`reconocido` AS `reconocido`,`sitio_usuario`.`subdominio` AS `subdominio`,`sitio_usuario`.`permiso` AS `permiso`,`sitio_usuario`.`s_delegacion` AS `s_delegacion` from `bd_micrositios`.`sitio_usuario` where ((`sitio_usuario`.`tipo` > 10) and (`sitio_usuario`.`permiso` > 0));

-- ----------------------------
-- View structure for v_dependencias
-- ----------------------------
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `v_dependencias` AS select `planteles_dependencias`.`id` AS `id_sitio`,`planteles_dependencias`.`url` AS `url`,`planteles_dependencias`.`titulo` AS `titulo`,`planteles_dependencias`.`id_modulo` AS `id_modulo`,`planteles_dependencias`.`activo` AS `activo`,`planteles_dependencias`.`fecha_creacion` AS `fecha_creacion`,`planteles_dependencias`.`menu_adicional` AS `menu_adicional`,`planteles_dependencias`.`mostrar_estilo` AS `mostrar_estilo`,`planteles_dependencias`.`tipo` AS `tipo`,`planteles_dependencias`.`validacion` AS `validacion`,`planteles_dependencias`.`reconocido` AS `reconocido`,`planteles_dependencias`.`s_delegacion` AS `s_delegacion`,`planteles_dependencias`.`s_nivel` AS `s_nivel`,`planteles_dependencias`.`s_clave` AS `s_clave`,`planteles_dependencias`.`s_pronad` AS `s_pronad`,`planteles_dependencias`.`r_id` AS `r_id` from `bd_micrositios`.`planteles_dependencias`;

-- ----------------------------
-- Records 
-- ----------------------------
INSERT INTO `actividades` VALUES ('1', 'Conferencias', '1');
INSERT INTO `actividades` VALUES ('2', 'Presentaciones', '1');
INSERT INTO `actividades` VALUES ('3', 'Talleres', '1');
INSERT INTO `actividades` VALUES ('4', 'Cursos', '1');
INSERT INTO `actividadesUbicacion` VALUES ('1', '1', '1');
INSERT INTO `actividadesUbicacion` VALUES ('2', '1', '3');
INSERT INTO `actividadesUbicacion` VALUES ('3', '1', '2');
INSERT INTO `actividadesUbicacion` VALUES ('10', '9', '1');
INSERT INTO `dirigido` VALUES ('1', 'Estudiantes', '1');
INSERT INTO `dirigido` VALUES ('2', 'Público en general', '1');
INSERT INTO `dirigido` VALUES ('3', 'Docentes', '1');
INSERT INTO `dirigido` VALUES ('4', 'Trabajadores', '1');
INSERT INTO `dirigidoUbicacion` VALUES ('1', '1', '1');
INSERT INTO `dirigidoUbicacion` VALUES ('2', '1', '3');
INSERT INTO `dirigidoUbicacion` VALUES ('3', '1', '4');
INSERT INTO `dirigidoUbicacion` VALUES ('10', '9', '1');
INSERT INTO `equipamiento` VALUES ('1', 'Computadora', '1');
INSERT INTO `equipamiento` VALUES ('2', 'Proyector', '1');
INSERT INTO `equipamiento` VALUES ('3', 'Pantalla', '1');
INSERT INTO `equipamiento` VALUES ('4', 'Estrado', '1');
INSERT INTO `equipamientoUbicacion` VALUES ('1', '1', '1');
INSERT INTO `equipamientoUbicacion` VALUES ('2', '1', '3');
INSERT INTO `equipamientoUbicacion` VALUES ('3', '1', '2');
INSERT INTO `equipamientoUbicacion` VALUES ('10', '9', '1');
INSERT INTO `equipamientoUbicacion` VALUES ('11', '9', '3');
INSERT INTO `log` VALUES ('1', '22', 'saul@ucol.mx', '1', 'Ubicación', 'Crear ubicación', '2018-10-01 17:26:24', '148.213.20.111');
INSERT INTO `log` VALUES ('2', '22', 'saul@ucol.mx', '1', 'Catálogo a ubicación: equipamientoUbicacion', 'Agregar al catálogo', '2018-10-01 17:26:24', '148.213.20.111');
INSERT INTO `log` VALUES ('3', '22', 'saul@ucol.mx', '1', 'Catálogo a ubicación: actividadesUbicacion', 'Agregar al catálogo', '2018-10-01 17:26:24', '148.213.20.111');
INSERT INTO `log` VALUES ('4', '22', 'saul@ucol.mx', '1', 'Catálogo a ubicación: dirigidoUbicacion', 'Agregar al catálogo', '2018-10-01 17:26:24', '148.213.20.111');
INSERT INTO `log` VALUES ('5', '22', 'saul@ucol.mx', '1', 'Imagen de ubicación', 'Guardar imagen', '2018-10-01 17:26:24', '148.213.20.111');
INSERT INTO `log` VALUES ('6', '22', 'saul@ucol.mx', '1', 'Ubicación', 'Actualizar estatus ubicación: 1', '2018-10-01 17:26:28', '148.213.20.111');
INSERT INTO `log` VALUES ('7', '22', 'saul@ucol.mx', '1', 'Ubicación', 'Actualizar aceptado ubicación: 1', '2018-10-01 17:26:31', '148.213.20.111');
INSERT INTO `log` VALUES ('8', '22', 'vcatita@ucol.mx', '2', 'Ubicación', 'Crear ubicación', '2018-12-10 09:48:45', '148.213.20.112');
INSERT INTO `log` VALUES ('9', '22', 'vcatita@ucol.mx', '3', 'Ubicación', 'Crear ubicación', '2018-12-10 09:49:42', '148.213.20.112');
INSERT INTO `log` VALUES ('10', '22', 'vcatita@ucol.mx', '4', 'Ubicación', 'Crear ubicación', '2018-12-10 09:55:51', '148.213.20.112');
INSERT INTO `log` VALUES ('11', '22', 'vcatita@ucol.mx', '4', 'Catálogo a ubicación: equipamientoUbicacion', 'Agregar al catálogo', '2018-12-10 09:55:51', '148.213.20.112');
INSERT INTO `log` VALUES ('12', '22', 'vcatita@ucol.mx', '4', 'Catálogo a ubicación: actividadesUbicacion', 'Agregar al catálogo', '2018-12-10 09:55:51', '148.213.20.112');
INSERT INTO `log` VALUES ('13', '22', 'vcatita@ucol.mx', '4', 'Catálogo a ubicación: dirigidoUbicacion', 'Agregar al catálogo', '2018-12-10 09:55:51', '148.213.20.112');
INSERT INTO `log` VALUES ('14', '22', 'vcatita@ucol.mx', '4', 'Imagen de ubicación', 'Guardar imagen', '2018-12-10 09:55:51', '148.213.20.112');
INSERT INTO `log` VALUES ('15', '22', 'vcatita@ucol.mx', '4', 'Ubicación', 'Actualizar ubicación', '2018-12-10 09:56:20', '148.213.20.112');
INSERT INTO `log` VALUES ('16', '22', 'vcatita@ucol.mx', '4', 'Catálogo de ubicación: equipamientoUbicacion', 'Eliminar todo del catálogo por idUbicacion', '2018-12-10 09:56:20', '148.213.20.112');
INSERT INTO `log` VALUES ('17', '22', 'vcatita@ucol.mx', '4', 'Catálogo de ubicación: actividadesUbicacion', 'Eliminar todo del catálogo por idUbicacion', '2018-12-10 09:56:20', '148.213.20.112');
INSERT INTO `log` VALUES ('18', '22', 'vcatita@ucol.mx', '4', 'Catálogo a ubicación: equipamientoUbicacion', 'Agregar al catálogo', '2018-12-10 09:56:20', '148.213.20.112');
INSERT INTO `log` VALUES ('19', '22', 'vcatita@ucol.mx', '4', 'Catálogo de ubicación: dirigidoUbicacion', 'Eliminar todo del catálogo por idUbicacion', '2018-12-10 09:56:20', '148.213.20.112');
INSERT INTO `log` VALUES ('20', '22', 'vcatita@ucol.mx', '4', 'Catálogo a ubicación: actividadesUbicacion', 'Agregar al catálogo', '2018-12-10 09:56:20', '148.213.20.112');
INSERT INTO `log` VALUES ('21', '22', 'vcatita@ucol.mx', '4', 'Catálogo a ubicación: dirigidoUbicacion', 'Agregar al catálogo', '2018-12-10 09:56:20', '148.213.20.112');
INSERT INTO `log` VALUES ('22', '22', 'vcatita@ucol.mx', '5', 'Ubicación', 'Crear ubicación', '2018-12-10 09:58:06', '148.213.20.112');
INSERT INTO `log` VALUES ('23', '22', 'vcatita@ucol.mx', '5', 'Catálogo a ubicación: equipamientoUbicacion', 'Agregar al catálogo', '2018-12-10 09:58:06', '148.213.20.112');
INSERT INTO `log` VALUES ('24', '22', 'vcatita@ucol.mx', '5', 'Catálogo a ubicación: actividadesUbicacion', 'Agregar al catálogo', '2018-12-10 09:58:06', '148.213.20.112');
INSERT INTO `log` VALUES ('25', '22', 'vcatita@ucol.mx', '5', 'Imagen de ubicación', 'Guardar imagen', '2018-12-10 09:58:06', '148.213.20.112');
INSERT INTO `log` VALUES ('26', '22', 'vcatita@ucol.mx', '5', 'Catálogo a ubicación: dirigidoUbicacion', 'Agregar al catálogo', '2018-12-10 09:58:06', '148.213.20.112');
INSERT INTO `log` VALUES ('27', '22', 'vcatita@ucol.mx', '6', 'Ubicación', 'Crear ubicación', '2018-12-10 09:59:33', '148.213.20.112');
INSERT INTO `log` VALUES ('28', '22', 'vcatita@ucol.mx', '6', 'Catálogo a ubicación: equipamientoUbicacion', 'Agregar al catálogo', '2018-12-10 09:59:33', '148.213.20.112');
INSERT INTO `log` VALUES ('29', '22', 'vcatita@ucol.mx', '6', 'Catálogo a ubicación: dirigidoUbicacion', 'Agregar al catálogo', '2018-12-10 09:59:33', '148.213.20.112');
INSERT INTO `log` VALUES ('30', '22', 'vcatita@ucol.mx', '6', 'Imagen de ubicación', 'Guardar imagen', '2018-12-10 09:59:33', '148.213.20.112');
INSERT INTO `log` VALUES ('31', '22', 'vcatita@ucol.mx', '6', 'Catálogo a ubicación: actividadesUbicacion', 'Agregar al catálogo', '2018-12-10 09:59:33', '148.213.20.112');
INSERT INTO `log` VALUES ('32', '22', 'vcatita@ucol.mx', '7', 'Ubicación', 'Crear ubicación', '2018-12-10 10:00:18', '148.213.20.112');
INSERT INTO `log` VALUES ('33', '22', 'vcatita@ucol.mx', '7', 'Catálogo a ubicación: equipamientoUbicacion', 'Agregar al catálogo', '2018-12-10 10:00:18', '148.213.20.112');
INSERT INTO `log` VALUES ('34', '22', 'vcatita@ucol.mx', '7', 'Catálogo a ubicación: dirigidoUbicacion', 'Agregar al catálogo', '2018-12-10 10:00:18', '148.213.20.112');
INSERT INTO `log` VALUES ('35', '22', 'vcatita@ucol.mx', '7', 'Catálogo a ubicación: actividadesUbicacion', 'Agregar al catálogo', '2018-12-10 10:00:18', '148.213.20.112');
INSERT INTO `log` VALUES ('36', '22', 'vcatita@ucol.mx', '7', 'Imagen de ubicación', 'Guardar imagen', '2018-12-10 10:00:18', '148.213.20.112');
INSERT INTO `log` VALUES ('37', '22', 'vcatita@ucol.mx', '8', 'Ubicación', 'Crear ubicación', '2018-12-10 10:01:49', '148.213.20.112');
INSERT INTO `log` VALUES ('38', '22', 'vcatita@ucol.mx', '8', 'Catálogo a ubicación: equipamientoUbicacion', 'Agregar al catálogo', '2018-12-10 10:01:49', '148.213.20.112');
INSERT INTO `log` VALUES ('39', '22', 'vcatita@ucol.mx', '8', 'Catálogo a ubicación: dirigidoUbicacion', 'Agregar al catálogo', '2018-12-10 10:01:49', '148.213.20.112');
INSERT INTO `log` VALUES ('40', '22', 'vcatita@ucol.mx', '8', 'Catálogo a ubicación: actividadesUbicacion', 'Agregar al catálogo', '2018-12-10 10:01:49', '148.213.20.112');
INSERT INTO `log` VALUES ('41', '22', 'vcatita@ucol.mx', '8', 'Imagen de ubicación', 'Guardar imagen', '2018-12-10 10:01:49', '148.213.20.112');
INSERT INTO `log` VALUES ('42', '22', 'vcatita@ucol.mx', '7', 'Ubicación', 'Actualizar estatus ubicación: 1', '2018-12-10 11:12:53', '148.213.20.112');
INSERT INTO `log` VALUES ('43', '22', 'vcatita@ucol.mx', '9', 'Ubicación', 'Crear ubicación', '2018-12-10 14:17:59', '148.213.20.112');
INSERT INTO `log` VALUES ('44', '22', 'vcatita@ucol.mx', '9', 'Catálogo a ubicación: equipamientoUbicacion', 'Agregar al catálogo', '2018-12-10 14:17:59', '148.213.20.112');
INSERT INTO `log` VALUES ('45', '22', 'vcatita@ucol.mx', '9', 'Catálogo a ubicación: actividadesUbicacion', 'Agregar al catálogo', '2018-12-10 14:17:59', '148.213.20.112');
INSERT INTO `log` VALUES ('46', '22', 'vcatita@ucol.mx', '9', 'Catálogo a ubicación: dirigidoUbicacion', 'Agregar al catálogo', '2018-12-10 14:17:59', '148.213.20.112');
INSERT INTO `log` VALUES ('47', '22', 'vcatita@ucol.mx', '9', 'Imagen de ubicación', 'Guardar imagen', '2018-12-10 14:17:59', '148.213.20.112');
INSERT INTO `tiposUbicaciones` VALUES ('1', 'Sala', '1');
INSERT INTO `tiposUbicaciones` VALUES ('2', 'Auditorio', '1');
INSERT INTO `tiposUbicaciones` VALUES ('3', 'Aula', '1');
INSERT INTO `tiposUbicaciones` VALUES ('4', 'Teatro', '1');
INSERT INTO `ubicaciones` VALUES ('1', 'sala-exhibicion', '20', 'Sala de Exhibición', '19.24870948614517', '-103.69853308812151', '<p>La sala de exhibici&amp;oacute;n es un espacio que tiene las herramientas de trabajo necesarias para llevar a cabo diversas actividades.</p>\n', '<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"width:500px;\">\n	<tbody>\n		<tr>\n			<td><img alt=\"\" src=\"/content/ubicaciones/22/image/sistemas8.jpg\" style=\"width: 1500px; height: 844px;\" /></td>\n		</tr>\n		<tr>\n			<td><img alt=\"\" src=\"/content/ubicaciones/22/image/sistemas11.jpg\" style=\"width: 1500px; height: 844px;\" /></td>\n		</tr>\n		<tr>\n			<td><img alt=\"\" src=\"/content/ubicaciones/22/image/sistemas9.jpg\" style=\"width: 1500px; height: 844px;\" /></td>\n		</tr>\n	</tbody>\n</table>\n\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vitae sagittis magna. Quisque elit erat, faucibus in condimentum sed, tempus nec orci. Etiam non pharetra tortor. In sodales tempor arcu et semper. Pellentesque semper orci sed congue sodales. Sed rutrum magna eget quam efficitur facilisis. Nulla porttitor mattis dapibus. Aenean vulputate feugiat purus. Donec mauris augue, consectetur sit amet lacus sed, ullamcorper suscipit tellus.&lt;/p&gt;\\n\\n&lt;p&gt;Donec iaculis nisi iaculis vulputate laoreet. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. In hac habitasse platea dictumst. Vestibulum nunc erat, semper sit amet hendrerit a, bibendum eu purus. Etiam at lacinia dui. Proin sit amet leo ultricies, tincidunt quam eget, vestibulum orci. Donec molestie nisl tortor, sed bibendum purus interdum porttitor. Vestibulum sed lectus non elit tristique iaculis. Donec sollicitudin dignissim massa. Phasellus quis augue vel tellus viverra tempor placerat ac felis. Nullam non sodales massa. Praesent id quam ut elit aliquam tempus. Etiam vel purus a velit malesuada viverra. Pellentesque vel enim rhoncus, sagittis erat laoreet, mattis leo.&lt;/p&gt;\\n\\n&lt;p&gt;Mauris euismod mauris in purus tempor interdum. Fusce elementum, urna vitae vulputate commodo, lectus tellus bibendum ante, eu eleifend neque nibh vel mi. Nunc mattis dui pellentesque nisi laoreet, id auctor lorem rhoncus. Praesent magna elit, tempus vel rhoncus lacinia, aliquet id neque. Etiam non nisi sed sapien aliquet malesuada fringilla id elit. Curabitur vel diam nisl. Etiam imperdiet lorem dui, a convallis tellus vehicula tincidunt. Aliquam condimentum orci at nunc semper, in tristique dolor tempus. Cras sed odio vitae ex convallis pretium sit amet ut odio. Integer molestie posuere mauris in facilisis. Pellentesque lobortis ornare sodales.&lt;/p&gt;\\n\\n&lt;p&gt;Cras ultrices dapibus tortor vitae facilisis. Mauris venenatis dapibus dapibus. Duis ullamcorper metus blandit commodo ornare. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vestibulum quam id malesuada ornare. Fusce ornare ex a tellus pharetra, ac pretium justo lacinia. In elementum varius nisl eget aliquet. Curabitur cursus erat a convallis laoreet.&amp;nbsp;&lt;/p&gt;\\n\\n&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vitae sagittis magna. Quisque elit erat, faucibus in condimentum sed, tempus nec orci. Etiam non pharetra tortor. In sodales tempor arcu et semper. Pellentesque semper orci sed congue sodales. Sed rutrum magna eget quam efficitur facilisis. Nulla porttitor mattis dapibus. Aenean vulputate feugiat purus. Donec mauris augue, consectetur sit amet lacus sed, ullamcorper suscipit tellus.</p>\n', '<p>Horario de pr&eacute;stamo:</p>\n\n<p>De lunes a viernes de 7:00 a 19:00 horas.</p>\n\n<p>Tr&aacute;mites:</p>\n\n<p>Comunicarse al tel&eacute;fono (312) 316-10-8</p>\n', 'sala juntas presentaciones', '2018-10-01T22:26:25.845Z134304.jpg', '1', '22', '0', '1', '1', '-1', '-1', '2018-10-01 03:26:31', '2018-10-01 03:26:31', '3', '');


CREATE TABLE `planteles_dependencias`(
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    url VARCHAR(70),
    titulo VARCHAR(70),
    id_modulo VARCHAR(70),
    activo BOOLEAN,
    fecha_creacion DATETIME,
    menu_adicional VARCHAR(70),
    mostrar_estilo VARCHAR(70),
    tipo VARCHAR(70),
    validacion VARCHAR(70),
    reconocido VARCHAR(70),
    s_delegacion VARCHAR(70),
    s_nivel VARCHAR(70),
    s_clave VARCHAR(70),
    s_pronad VARCHAR(70),
    r_id VARCHAr(70)
);