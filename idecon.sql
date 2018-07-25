-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-11-2017 a las 01:13:42
-- Versión del servidor: 10.1.21-MariaDB
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `idecon`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad`
--

CREATE TABLE `actividad` (
  `idActividad` int(11) NOT NULL,
  `idEvento` int(11) NOT NULL,
  `modalidad` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `tipo` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `responsable` varchar(100) NOT NULL,
  `costo` int(11) NOT NULL,
  `premio` int(11) NOT NULL COMMENT '0: no tiene premios, 1: tiene premio',
  `lugar` int(11) NOT NULL COMMENT '0: varios lugares, 1: mismo lugar'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `actividad`
--

INSERT INTO `actividad` (`idActividad`, `idEvento`, `modalidad`, `nombre`, `tipo`, `created_at`, `updated_at`, `deleted_at`, `responsable`, `costo`, `premio`, `lugar`) VALUES
(10, 1, 1, 'dfgdfg', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 'fdgdfg', 44334, 0, 0),
(11, 1, 0, 'ghjgh', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 'ghjhj', 56756, 0, 1),
(12, 1, 1, 'fgdfg', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 'dfgdfg', 56456, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agrupaciones`
--

CREATE TABLE `agrupaciones` (
  `idAgrupacion` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `representante` varchar(100) NOT NULL,
  `nit` varchar(50) NOT NULL,
  `direccion` text NOT NULL,
  `ciudad` int(11) NOT NULL,
  `departamento` int(11) NOT NULL,
  `region` int(11) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `telefono2` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `genero` int(11) NOT NULL,
  `clasificacion` int(11) NOT NULL,
  `tipo` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `agrupaciones`
--

INSERT INTO `agrupaciones` (`idAgrupacion`, `nombre`, `representante`, `nit`, `direccion`, `ciudad`, `departamento`, `region`, `telefono`, `telefono2`, `correo`, `genero`, `clasificacion`, `tipo`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'ldkfjsdlk', '', '9458309', 'kfljsd sdlkfjkl', 1, 11, 1, '4509438', '49238', 'correo@c.c', 1, 0, 0, '2017-11-14 21:23:02', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudad`
--

CREATE TABLE `ciudad` (
  `idCiudad` int(11) NOT NULL,
  `idDepartamento` int(11) NOT NULL,
  `nombre` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ciudad`
--

INSERT INTO `ciudad` (`idCiudad`, `idDepartamento`, `nombre`) VALUES
(1, 11, 'Valledupar'),
(2, 11, 'La Paz'),
(3, 11, 'Aguachica'),
(4, 11, 'Chimichagua'),
(5, 11, 'El Paso'),
(6, 11, 'San Alberto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clasificacion`
--

CREATE TABLE `clasificacion` (
  `idClasificacion` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `clasificacion`
--

INSERT INTO `clasificacion` (`idClasificacion`, `nombre`) VALUES
(1, 'clasico'),
(2, 'nueva ola');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuidad`
--

CREATE TABLE `cuidad` (
  `idCiudad` int(11) NOT NULL,
  `idDepartamento` int(11) NOT NULL,
  `nombre` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cuidad`
--

INSERT INTO `cuidad` (`idCiudad`, `idDepartamento`, `nombre`) VALUES
(1, 11, 'Valledupar'),
(2, 11, 'La Paz'),
(3, 11, 'Aguachica'),
(4, 11, 'Chimichagua'),
(5, 11, 'El Paso'),
(6, 11, 'San Alberto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `idDepartamento` int(11) NOT NULL,
  `nombre` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`idDepartamento`, `nombre`) VALUES
(1, 'Amazonas'),
(2, 'Antioquia'),
(3, 'Arauca'),
(4, 'Atlantico'),
(5, 'Bolivar'),
(6, 'Boyaca'),
(7, 'Caldas'),
(8, 'Caqueta'),
(9, 'Casanare'),
(10, 'Cauca'),
(11, 'Cesar'),
(12, 'Choco'),
(13, 'Cordoba'),
(14, 'Cundinamarca'),
(15, 'Guainia'),
(16, 'Guaviare'),
(17, 'Huila'),
(18, 'La Guajira'),
(19, 'Magdalena'),
(20, 'Meta'),
(21, 'Nariño'),
(22, 'Norte de Santander'),
(23, 'Putumayo'),
(24, 'Quindio'),
(25, 'Risaralda'),
(26, 'San Andrés y Providencia'),
(27, 'Santander'),
(28, 'Sucre'),
(29, 'Tolima'),
(30, 'Valle del Cauca'),
(31, 'Vaupes'),
(32, 'Vichada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direccionactividad`
--

CREATE TABLE `direccionactividad` (
  `idDireccion` int(11) NOT NULL,
  `idActividad` int(11) NOT NULL,
  `direccion` text NOT NULL,
  `fechaInicio` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fechaFin` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lat` varchar(50) NOT NULL,
  `lng` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `direccionactividad`
--

INSERT INTO `direccionactividad` (`idDireccion`, `idActividad`, `direccion`, `fechaInicio`, `fechaFin`, `lat`, `lng`) VALUES
(11, 10, 'fghgfhgfh', '2017-11-14 23:01:00', '2017-11-15 13:00:00', '10.471522876846073', '-73.24357509613037'),
(12, 10, 'fghfh', '2017-11-16 23:00:00', '2017-11-18 00:00:00', '10.47380170112126', '-73.24398279190063'),
(13, 11, 'gfhfhfgh', '2017-11-17 22:59:00', '2017-11-18 13:00:00', '10.474012702521476', '-73.2453453540802'),
(14, 12, 'gyfhf', '2017-11-01 23:00:00', '2017-11-05 11:00:00', '10.475046607306014', '-73.252694606781');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `idEmpresa` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `nit` varchar(50) NOT NULL,
  `sector` varchar(50) NOT NULL,
  `gerente` varchar(50) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `telefono1` varchar(50) NOT NULL,
  `telefono2` varchar(50) DEFAULT NULL,
  `correo` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`idEmpresa`, `nombre`, `nit`, `sector`, `gerente`, `direccion`, `telefono1`, `telefono2`, `correo`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'nombre', '3290482', 'sector', 'gerente', 'carrera 19 # 17 sicarare', '4903903', '834293', 'correo@c.c', '2017-10-28 11:21:34', '2017-10-27 13:00:32', NULL),
(2, 'empresa', '945049', 'SECTOR', 'gerente', 'carrera 21 #24c3-74 sicarare', '3049290', NULL, 'correo@c.c', '2017-10-28 11:22:00', '2017-10-27 13:11:01', NULL),
(3, 'drtrtet', '4556456', 'fghdfhfh', 'gfhgfh', '', '567567567', '6756756', 'u@c.c', '2017-11-15 09:10:45', '2017-11-15 09:10:45', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento`
--

CREATE TABLE `evento` (
  `idEvento` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `imagen` varchar(100) NOT NULL DEFAULT 'img/evento/no.png',
  `idUsuario` int(11) NOT NULL,
  `idDepartamento` int(11) NOT NULL,
  `idRegion` int(11) NOT NULL,
  `idCiudad` int(11) NOT NULL,
  `nit` varchar(100) NOT NULL,
  `codigoPostal` varchar(50) NOT NULL,
  `Direccion` text NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `telefono2` varchar(50) DEFAULT NULL,
  `correo` varchar(50) NOT NULL,
  `correo2` varchar(50) DEFAULT NULL,
  `fundado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `version` varchar(50) NOT NULL,
  `fechaInicio` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fechaFin` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dias` int(11) NOT NULL,
  `poblacion` int(11) NOT NULL,
  `website` varchar(100) DEFAULT NULL,
  `facebook` varchar(100) DEFAULT NULL,
  `instagram` varchar(100) DEFAULT NULL,
  `twitter` varchar(100) DEFAULT NULL,
  `snapchat` varchar(50) DEFAULT NULL,
  `otro` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `evento`
--

INSERT INTO `evento` (`idEvento`, `descripcion`, `imagen`, `idUsuario`, `idDepartamento`, `idRegion`, `idCiudad`, `nit`, `codigoPostal`, `Direccion`, `telefono`, `telefono2`, `correo`, `correo2`, `fundado`, `version`, `fechaInicio`, `fechaFin`, `dias`, `poblacion`, `website`, `facebook`, `instagram`, `twitter`, `snapchat`, `otro`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Festival Vallenato', 'img/evento/no.png', 1, 11, 4, 1, '345445', '344545334', 'dfdfggf', '5455654', NULL, 'i@p.p', 'e@p.p', '2017-11-10 03:21:38', '51', '2017-11-01 05:00:00', '2017-11-03 05:00:00', 2, 25, NULL, NULL, NULL, NULL, NULL, NULL, '2017-10-27 13:51:18', '2017-10-27 13:51:18', NULL),
(2, 'Festival de la quinta', 'img/evento/quinta.png', 1, 11, 4, 1, '345445', '344545334', 'dfdfggf', '5455654', NULL, 'i@p.p', 'e@p.p', '2017-10-28 11:15:03', '51', '2017-10-27 10:00:00', '2017-10-29 10:00:00', 2, 25, NULL, NULL, NULL, NULL, NULL, NULL, '2017-10-27 13:51:56', '2017-10-27 13:51:56', NULL),
(3, 'Concierto Silvestre Dangong', 'img/evento/no.png', 1, 11, 3, 1, '54645', '456456', 'gfgfgfgfgfgfgfgfgfgfgfgf', '565656565656565656567', '56565656567', 'ghgf', NULL, '2017-11-22 06:53:47', '58', '2017-10-20 10:00:00', '2017-10-23 10:00:00', 45, 453645, NULL, NULL, NULL, NULL, NULL, NULL, '2017-10-27 13:53:43', '2017-11-22 11:53:47', '2017-11-22 11:53:47'),
(4, 'un dia', 'img/evento/no.png', 1, 11, 1, 1, '655656', '65475675', ' 65tyjgfhj', '6575476', '567567', 'gfjf', 'hfffff', '2017-11-22 06:50:50', '5665', '2017-10-15 05:00:00', '2017-10-15 05:00:00', 7, 56457, NULL, 'gfhgfh', 'dfghdfghd', 'dfghdghdfg', 'dfghdghgfh', 'dghfghdfh', '2017-10-31 13:04:43', '2017-11-22 11:50:50', '2017-11-22 11:50:50'),
(5, 'ejemplo', 'img/evento/5.jpg', 1, 11, 2, 1, '1111111', '200001', ' carrera x', '3022976993', '3028855', 'ejemplo@c.c', 'ejemplo2@c.c', '2017-11-22 06:51:59', '2', '2017-11-23 05:00:00', '2017-11-23 05:00:00', 1, 300000, '', '', '', '', '', '', '2017-11-22 11:20:48', '2017-11-22 11:51:59', '2017-11-22 11:51:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventoactividad`
--

CREATE TABLE `eventoactividad` (
  `idEventoActividad` int(11) NOT NULL,
  `idActividad` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `duracion` varchar(100) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `idAgrupacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `eventoactividad`
--

INSERT INTO `eventoactividad` (`idEventoActividad`, `idActividad`, `nombre`, `duracion`, `cantidad`, `idAgrupacion`) VALUES
(7, 8, 'fgdfg', 'dfgdfg', 0, 0),
(8, 10, 'vfhgfghgf', 'hgfhgfh', 56, 0),
(9, 10, 'hhhhhhhh', 'ghgh', 65, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genero`
--

CREATE TABLE `genero` (
  `idGenero` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `genero`
--

INSERT INTO `genero` (`idGenero`, `nombre`) VALUES
(1, 'vallenato'),
(2, 'pop');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habilidad`
--

CREATE TABLE `habilidad` (
  `idHabilidad` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hotel`
--

CREATE TABLE `hotel` (
  `idHotel` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `categoria` int(11) NOT NULL,
  `rtn` int(11) NOT NULL,
  `direccion` text NOT NULL,
  `ciudad` int(11) NOT NULL DEFAULT '0',
  `telefono` varchar(50) NOT NULL,
  `telefono2` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `pagina` varchar(40) NOT NULL,
  `gerente` varchar(80) NOT NULL,
  `habitaciones` int(11) NOT NULL,
  `capacidadMax` int(11) NOT NULL,
  `parqueadero` int(11) NOT NULL,
  `aire` int(11) NOT NULL,
  `tv` int(11) NOT NULL,
  `jardin` int(11) NOT NULL,
  `artesania` int(11) NOT NULL,
  `wifi` int(11) NOT NULL,
  `lavanderia` int(11) NOT NULL,
  `piscina` int(11) NOT NULL,
  `bar` int(11) NOT NULL,
  `roomservice` int(11) NOT NULL,
  `restaurante` int(11) NOT NULL,
  `gimnasio` int(11) NOT NULL,
  `areasociales` int(11) NOT NULL,
  `llamadaGratis` int(11) NOT NULL,
  `vipareasocial` int(11) NOT NULL,
  `salonEventos` int(11) NOT NULL,
  `tripadvisor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `hotel`
--

INSERT INTO `hotel` (`idHotel`, `nombre`, `categoria`, `rtn`, `direccion`, `ciudad`, `telefono`, `telefono2`, `correo`, `pagina`, `gerente`, `habitaciones`, `capacidadMax`, `parqueadero`, `aire`, `tv`, `jardin`, `artesania`, `wifi`, `lavanderia`, `piscina`, `bar`, `roomservice`, `restaurante`, `gimnasio`, `areasociales`, `llamadaGratis`, `vipareasocial`, `salonEventos`, `tripadvisor`) VALUES
(104, 'La malena', 1, 17775, 'Cra. 6 No. 16-71', 1, '3205263188', '0', 'Mayafra1@Hotmail.Com', 'Www.Lamalena.Com', 'Laura Tinaco Coronel ', 20, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0),
(105, 'Hotel Sicarare', 1, 3665, 'Carrera 9 No. 16-04', 1, '5849283', '3205308010', 'Tcalvo@Solarhoteles.Com', 'Www.Solarhoteles.Com', 'Tulia Sofia Calvo Martinez', 50, 150, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1, 0, 1, 1, 1),
(106, 'Cesar Numero 1', 1, 6924, 'Calle 18 Numero 9- 39', 1, '5743059', '0', 'Hotelcesarnumero1@Hotmail.Com', 'no', 'Nereida Paez Sanchez', 14, 42, 0, 1, 1, 1, 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(107, 'Acdac', 1, 19683, 'Carrera 8 Numero 19-04', 1, '5840202', '3002895555', 'Hotelacdac09@Hotmail.Com', 'Www.Hotelacdac.Com', 'Luis Cesar Rueda', 24, 56, 1, 1, 1, 0, 0, 1, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0),
(108, 'Hotel El Triunfo Vallenato', 1, 34458, 'Calle 19 No.9-31', 1, '5744459', '3186333064', 'no', 'no', 'Jose Hernando Rueda Ayala', 20, 30, 0, 1, 1, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0),
(109, 'Hotel Vajamar', 1, 109, 'Carrera 7 No 16A 30', 1, '5732010', '3184279418', 'Reservas@Hotelvajamar.Com', 'Www.Hotelvajamar.Com', 'Javier Quintero Julio', 60, 120, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1),
(110, 'Hotel Benecia De La Novena', 1, 20898, 'Carrera 9 19-26', 1, '5806495', '3157519120', 'Clinicadelrepuesto@Hotmail.Com', 'no', 'Jose Enrique Fuente', 10, 25, 0, 1, 1, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(111, 'Hotel Arawak', 1, 4588, 'Carrera 7 No 16B 50 ', 1, '584646', '3003294926', 'Reservar@Arawakupar.Com', 'Www.@Arawakupar.Com', 'Nora Jaime', 63, 170, 1, 1, 1, 0, 0, 1, 1, 0, 1, 1, 1, 0, 1, 0, 1, 1, 1),
(112, 'Hotel Avenida', 1, 31968, 'Calle 44 No.28-201', 1, '5826786', '3135802925', 'Motel.Avenida@Gmail.Com  ', 'no', 'Jose Sebastian Maestre', 25, 40, 1, 1, 1, 0, 0, 1, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0),
(113, 'Hotel Ceibote', 1, 11913, 'Carrera 18 D No. 20-100', 1, '5701010', '3158834178', 'Hotelceibote@Yahoo.Com', 'no', 'Sarelys Sierra Gutierrez', 19, 28, 1, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0),
(114, 'Hotel Milenium', 1, 21383, 'Carrera 8 # 19-32', 1, '5806540', '3116731603', 'Hotelmilenium@Hotmail.Es', 'no', 'Martha Nelis Durango ', 25, 60, 0, 1, 1, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(115, 'Hotel Cesar No 2', 1, 6923, 'Calle 18 11 58 ', 1, '5744415', '3192609586', 'Hotelcesar2@Hotmail.Com', 'Www.Hotelcesar2.Com', 'Magalis Paez', 21, 40, 1, 1, 1, 0, 0, 1, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0),
(116, 'Hotel Urak', 1, 12345, 'Carrera 18 D # 27-56 Primero De Mayo', 1, '5716231', '3164147492', 'Reservas@Hotelurak.Com', 'Www.Hotelurak.Com', 'Alfonso Del Castillo', 18, 40, 1, 1, 1, 0, 0, 1, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0),
(117, 'Hotel El Palmar', 1, 14739, 'Cra 11 N 18-38', 1, '5809090', '3176565651', 'Elpalmarhotel@Gmail.Com', 'no', 'Francisco Meza', 36, 88, 1, 1, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0),
(118, 'Hotel Dubai Plaza', 1, 0, 'Carrera 21# 40-52', 1, '5828179', '3164665872', 'Hoteldubaiplaza14@Hotmail.Com', 'no', 'Elida Ochoa', 26, 60, 1, 1, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 1),
(119, 'Hotel Catleya', 1, 14743, 'Carrera 7A # 19B 60', 1, '5847257', '3216980188', 'Hotelcatleyademusicayleyenda@Gmail.Com', 'no', 'Hernan Ariza', 13, 30, 0, 1, 1, 0, 0, 1, 1, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0),
(120, 'Hotel Valledupar Plaza', 1, 29665, 'Calle 19 # 40-56 Barrio La Granja ', 1, '5714287', '3107371668', 'Reservacion@Hotelvalleduparplaza.Com', 'Www.Hotelvalleduparplaza.Com', 'Idalmis Rodriguez ', 15, 35, 1, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0),
(121, 'Hotel Sofia Plaza', 1, 26159, 'Calle 17# 7-54', 1, '5807545', '3205663971', 'Hotelsofiaplaza@Hotmail.Com', 'Www.Hotelsofiaplaza.Com', 'Carlos Andres Alvarez Pacheco', 31, 90, 0, 1, 1, 0, 0, 1, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0),
(122, 'Hotel Panorama', 1, 4448, 'Carrera 11 No 18 34 Gaitan', 1, '5606396', '3116810286', 'Hotelpanoramavalledupar@Hotmail.Com', 'no', 'Alejandro Aharon Valera', 34, 68, 1, 1, 1, 1, 1, 1, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0),
(123, 'Hotel 999', 1, 6161, 'Calle 17 No 9 101 Centro', 1, '5749057', '3013846995', 'Hotel999Valledupar@HotmailCom', 'no', 'Hector Arzuaga', 26, 42, 1, 1, 1, 0, 0, 1, 1, 0, 1, 1, 0, 0, 1, 0, 0, 0, 0),
(124, 'Hotel Eupari', 1, 17306, 'Carrera 6-13B-31', 1, '5746800', '3205651504', 'Hoteleupari@Hotmail.Com', 'no', 'Bettys Leon Machado', 24, 50, 1, 1, 1, 0, 0, 1, 1, 0, 1, 1, 1, 0, 0, 0, 0, 1, 1),
(125, 'Hotel Leyenda Vallenata', 1, 18595, 'Calle 19B 11-50', 1, '5843262', '3187473960', 'Hoteleyendavallenata@Hotmail.Com', 'no', 'Brian Gomez', 14, 70, 1, 1, 1, 0, 0, 1, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0),
(126, 'Hotel Boutique Casa Rosalia ', 1, 30025, 'Calle 16# 10-10', 1, '5744129', '3205662556', 'Servicioalclientecasarosalia@Hotmail.Com', 'Www.Lacasarosalia.Com', 'Josefina Castro Daza', 7, 20, 1, 1, 1, 0, 0, 1, 1, 1, 1, 0, 1, 0, 1, 0, 0, 0, 0),
(127, 'Sonesta Hotel Valledupar', 1, 18640, 'Diagonal 10 N 6N-15', 1, '5748686', '3135109655', 'Adreina.Saurith@Ghlhoteles.Com', 'Www.Sonestavalledupar.Com', 'Maria Fernanda Villabona', 108, 250, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1),
(128, 'Hotel Casa Blanca', 1, 0, 'Carrera 18D No 33 12', 1, '5727740', '5727740', 'Ccasahotel@Hotmail.Com', 'Www.Hotelcassa.Com', 'Francisco Ollos', 30, 80, 0, 1, 1, 0, 0, 1, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0),
(129, 'Hotel Sirena Plaza', 1, 0, 'Carrera  18D # 39-54', 1, '5826798', '3184810050', 'Sirena_Plaza39@Hotmail.Com', 'no', 'Orlando Licarazo', 14, 50, 1, 1, 1, 0, 0, 1, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0),
(130, 'Hotel Las Torres Gemelas    ', 1, 30109, 'Carrera 11 No.18 - 43', 1, '5851625', '0', 'Hoteltorresgemelas@Hotmail.Com', 'no', 'Paulo Andres Peralta Rivera', 30, 60, 1, 1, 1, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(131, 'Hotel Noe ', 1, 3002, 'Calle 17 # 9-94', 1, '5840769', '3107300426', 'Luisleal@Hotmail.Com   ', 'no', 'Jhon Jairo Leal', 10, 30, 0, 1, 1, 0, 0, 1, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0),
(132, 'Hotel Londres', 1, 34956, 'Calle 17 No 7A 77', 1, '5842508', '3043504793', 'Jhosua1088@Hotmail.Com', 'no', 'Josue Guerrero', 20, 40, 0, 1, 1, 0, 0, 1, 1, 0, 0, 1, 1, 0, 1, 0, 0, 1, 1),
(133, 'Hotel Apartamentos El Oasis', 1, 14204, 'Carrera 18D # 41-08', 1, '5717326', '3007145640', 'Libiagomezortiz@Hotmail.Com      ', 'no', 'Jose Pallares ', 24, 50, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(134, 'Hotel Mana Plaza', 1, 17348, 'Calle 19E No.13-13', 1, '5807794', '3186297968', 'Manaplazahotel@Gmail.Com', 'no', 'Arelis Rios Fonseca', 20, 46, 1, 1, 0, 0, 0, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0),
(135, 'Mizare Hostal', 2, 21561, 'Calle 9 No. 8-42', 1, '5884476', '3167572611', 'Mizarehostal@Hotmail.Com', 'no', 'Jorge Rendon', 4, 15, 1, 1, 1, 0, 0, 1, 1, 0, 1, 0, 1, 0, 1, 0, 1, 0, 0),
(136, 'Hotel El Mio ', 1, 33992, 'Carrera 9 No.18-63 Centro ', 1, '5849445', '3148452235', 'Hotelelmio@Hotmail.Com', 'Www.Hotelelmio.Com', 'Jose Molina ', 29, 50, 1, 1, 1, 0, 0, 1, 1, 0, 0, 0, 0, 0, 1, 0, 0, 1, 1),
(137, 'Hotel Rey De Reyes ', 1, 0, 'Diagonal 21 No. 28-67 ', 1, '5727181', '3135544055', 'Reydereyes_Hotel@Hotmail.Com', 'no', 'Samuel Zapata ', 21, 56, 1, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0),
(138, 'Tativan Hotel', 3, 4250, 'Calle 16 A 9 - 50', 1, '5707474', '3008904403', 'Informacion@Tativanhotel.Com', 'Www.Tativanhotel.Com', 'Dora Jazmin Perez', 70, 142, 1, 1, 1, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1),
(139, 'Apartamento Las Vegas', 2, 17269, 'Carrera 18D 42 04', 1, '5717586', '3156888327', 'Didierquintana18@Hotmail.Com', 'no', 'Didier Quintana Hernandez', 24, 42, 1, 1, 0, 0, 0, 1, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0),
(140, 'Hostal Loperena', 1, 23600, 'Calle 16A No.9-63', 1, '5805703', '0', 'Hostalloperena@Gmail.Com', 'no', 'Luisa Osorio Gomez', 13, 43, 0, 1, 1, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(141, 'Hotel La Sexta ', 1, 12049, 'Carrera Sexta No. 17A 35', 1, '5845640', '0', 'no', 'no', 'Maria Alejandra Ceballos ', 21, 50, 0, 1, 0, 0, 0, 1, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0),
(142, 'Hotel Maranata ', 1, 30522, 'Carrera 11# 19-56 Barrio Gaitan ', 1, '5728443', '3187755202', 'Info@Hotelmaranata.Com', 'Www.Hotelmaranata.Com', 'Maranata Hotel ', 26, 95, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 0, 0, 1, 0, 0, 0, 0),
(143, 'Hotel Exito Valledupar', 1, 43365, 'Calle 17 No. 7A - 19', 1, '5842585', '3003623011', 'Hotel-Exito@Hotmail.Com', 'no', 'Alina Maria Lopez Rangel', 25, 80, 1, 1, 1, 0, 0, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0),
(144, 'Residencias Antioquia', 4, 0, 'Carrera 7  No. 19A- 35', 1, '5805681', '3135988593', 'no', 'no', 'Lizcano Beatriz        ', 8, 15, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(145, 'Hotel El Bosque', 1, 36884, 'El Bosque Hotel Casacampo Via La Pedregosa Lotificacion Darien', 1, '5857238', '3108225642', 'Elbosquehotelcasacampo@Outlook.Com', 'Www.Elbosquehotelcasacampo.Com', 'Magalys Patricia Daza Montenegro', 32, 140, 1, 1, 1, 0, 0, 1, 1, 1, 1, 1, 1, 0, 1, 0, 1, 1, 1),
(146, 'Hospedaje Las 24 Horas  ', 4, 16315, 'Carrera 18F #43-65', 1, '5821348', '3004308660', 'Hospedaje24H@Gmail.Com', 'no', ' Carlos  Arturo Caviedes Quiroz', 25, 50, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(147, 'Hotel Hampton By Hilton Valledupar', 1, 38161, 'Calle 30 No 6A 133', 1, '5898555', '3016194253', 'Pbarcelo@Metro-Op.Com', 'Www.Hampton.Com', 'Pedro Barcelo', 102, 300, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 0, 1, 1, 1),
(148, 'Hospedaje Restaurante Variedades Yiya  ', 4, 75968, 'Carrera 18 E # 39-26', 1, '5725060', '3205024410', 'no', 'no', 'Ligia Lucia Cuadro Sanchez ', 10, 30, 0, 1, 1, 0, 1, 1, 1, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0),
(149, 'Residencias Hospedaje Duran ', 4, 65943, 'Carrera 18D Avenida Simon Bolivar 42A - 28', 1, '5827198', '3145097899', 'Jorgeduran05@Hotmail.Com', 'no', 'Jorge Alberto Duran Castro', 12, 36, 1, 1, 0, 0, 0, 1, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0),
(150, 'La Casa De Taty ', 5, 116082, 'Carrera 6 #13C -30 ', 1, '5749070', '3156522977', 'Lmrosenow@Hotmail.Com', 'Www.Lacasadetaty.Com', 'Luz Marina Rosenow Arregoces', 12, 18, 0, 1, 1, 0, 1, 1, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0),
(151, 'Hotel Union  ', 1, 14572, 'Calle 19B # 11-15 Barrio La Granja  ', 1, '5714420', '3126874171', 'Ferreteriaunion_@Hotmail.Com', 'no', 'Celia Maria Duarte ', 14, 30, 1, 1, 1, 0, 0, 1, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0),
(152, 'Hostal Buenos Aires ', 1, 34882, 'Carrera 7 No 14 -60', 1, '5749804', '3003241366', 'Hostal.Buenosaires@Hotmail.Com', 'no', 'Edith Mendoza', 7, 25, 0, 1, 1, 0, 0, 1, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0),
(153, 'Hotel Mizare 3', 1, 43398, 'Cr  6   13 39   ', 1, '5888476', '3167572611', 'Mizarehostal@Hotmail.Com', 'no', 'Jorge Rendon Ospino', 21, 56, 1, 1, 1, 1, 0, 1, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0),
(154, 'Hotel Mizare Ii', 1, 34274, 'Carrera 5 9A 42 Barrio Novalito', 1, '5888476', '3167572611', 'Mizarehostal@Hotmail.Com', 'no', 'Jorge Rendon ', 21, 56, 1, 1, 1, 1, 0, 1, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0),
(155, 'Hostal La Casona Vieja', 1, 23159, 'Carrera 19 No.5 -245 ', 1, '5898234', '3205279596', 'Hostallacasonavieja@Hotmail.Com', 'no', 'Pedro Julio Maestre Vasques', 14, 41, 1, 1, 1, 0, 0, 1, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0),
(156, 'Hotel Casa Linda ', 1, 12882, 'Calle 19# 9-58', 1, '5806984', '3002053122', 'Luckert22@Hotmail.Com', 'no', 'Sofia Beltran', 10, 20, 0, 1, 1, 0, 0, 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0),
(157, 'Hostal Lola', 1, 23932, 'Carrera 5 No. 11-25', 1, '5843042', '3008161639', 'Lolabarrios5@Hotmail.Com', 'Http://Festivalenvalledupar.Blogsop.Com/', 'Dolores Barrios Ortega', 4, 12, 1, 1, 1, 0, 0, 1, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0),
(158, 'Hotel Rancho Regis', 1, 22820, 'Kilometro 2 Via A La Pedregoza', 1, '5733954', '3145389754', 'Reservar@Ranchoregis.Com', 'Www.Ramchoregis.Com', 'Nicola Ortis', 11, 52, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1, 1),
(159, 'Hostal El Cacique', 2, 40023, 'Calle 19 No.9-40', 1, '5702832', '3016932807', 'Hostalelcacique.Valledupar@Gmail.Com', 'no', 'Omar Bolaños Suarez', 21, 60, 0, 1, 1, 0, 0, 1, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0),
(160, 'Aqua Hostal', 2, 32498, 'Carrera 7 No 13A - 42', 1, '5700439', '3012139142', 'Aquahostalvalledupar@Gmail.Com', 'Www.Aquahostalvalledupar.Com', 'Juan Osorio', 8, 32, 0, 1, 1, 0, 0, 1, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0),
(161, 'Residencias Y Bar Venezuela', 4, 0, 'Calle 18A No. 6-26', 1, '0', '3006306299', 'Juanpablo11@Hotmail.Com', 'no', 'Juan Uribe', 12, 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(162, 'Hotel Boutique Calle Grande', 6, 26579, 'Carrera 7 No.15-85', 1, '5705757', '0', 'Contacto@Hotelboutiquecallegrande.Com', 'Www.Hotelboutiquecallegrande.Com', 'Tatiana Calderon', 28, 58, 1, 1, 1, 0, 0, 1, 1, 0, 1, 1, 1, 0, 1, 0, 0, 0, 0),
(163, 'Hotel Plaza Colonial', 1, 22734, 'Calle 15 N 4-50', 1, '5749041', '3043757799', 'Hotelplazacolonial1@Gmail.Com', 'Www.Hotelplazacolonialvalledupar.Com', 'Hernando Jose Palacios', 20, 60, 0, 1, 0, 0, 0, 1, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0),
(164, 'Hotel Gales', 1, 40024, 'Calle 44  No.18F- 40', 1, '5747434', '3136710176', 'Galeshotel@Gmail.Com', 'Www.Hotelgales.Com', 'Blanca Caviedes', 40, 80, 1, 1, 1, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(165, 'Hotel Caribe Platinium   ', 1, 40212, 'Carrera 15 No 18 29  Barrio Gaitan', 1, '5885257', '3225480736', 'Hotelcaribeplatinium@Oulok.Com', 'no', 'Edwin Jose Suarez Sierra', 5, 15, 1, 1, 1, 0, 0, 1, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0),
(166, 'Hotel Julimar', 1, 16040, 'Carrera 11 No. 19D-32', 1, '5808757', '0', 'Hoteljulimart@Hotmail.Com', 'no', 'Lina Paola Cordoba', 18, 40, 0, 1, 1, 0, 0, 1, 1, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0),
(167, 'Hotel Puerta Del Cielo ', 1, 44040, 'Calle 19D #6A 20', 1, '5716337', '3002785938', 'Hotelpuertadelcielo5@Gmail.Com', 'no', 'Gloria Ahumada ', 12, 40, 1, 1, 1, 1, 1, 1, 1, 0, 1, 0, 1, 0, 1, 0, 0, 0, 0),
(168, 'Hotel Loperena Plaza', 1, 30027, 'Calle 16B  No.9-66', 1, '5804652', '3186565356', 'Hotelloperenaplazavalledupar@Hotmail.Com', 'no', 'Juan Carlos Bermudez', 16, 35, 1, 1, 1, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(169, 'Hotel Casa Rosalia', 1, 30025, 'Calle 16 No 10 10', 1, '5744129', '3205662556', 'Sercioalclientecasarosalia Hotmail.Com', 'Www.Lacasarosali.Com', 'Josefina Castro Daza', 7, 20, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 0, 0, 0, 0),
(170, 'Hotel Risaralda ', 1, 12545, 'Calle 18 # 9-58', 1, '5898293', '3145897447', 'Hotel.Risaraldavalledupar@Hotmail.Com', 'no', 'Milena Gonzalez', 27, 70, 0, 1, 1, 0, 0, 1, 1, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0),
(171, 'Residencias Monpox', 4, 0, 'Carrea 18 D 39 30 Barrio San Martin', 1, '0', '3012889491', 'no', 'no', 'Ana Mariela Arrieta', 12, 30, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0),
(172, 'Hotel Buenavista B.V', 1, 18713, 'Carrera 11 # 19- 113', 1, '5898072', '3135454377', 'Buenavista_ Hotel @Hotmail.Com', 'no', 'Ananias  Penuela', 33, 66, 0, 1, 1, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(173, 'Residencias Nuevo Brisilia ', 4, 0, 'Carrera 18 E 43 75 Valle Meza', 1, '5828585', '31143376184', 'no', 'no', 'Elma Lopez', 10, 20, 1, 1, 1, 0, 0, 1, 1, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0),
(174, 'Hotel Arce Plaza', 1, 35125, 'Cra. 18D # 22 B 14', 1, '5746148', '315 514 3841', 'Hotelarceplazavalledupar@Hotmail.Com', 'Hotelarceplazavalledupar@Hotmail.Com', 'Solis Socarras De Arce', 20, 54, 1, 1, 1, 0, 1, 1, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0),
(175, 'Hotel Miriam ', 1, 0, 'Carrera 16# 23-34', 1, '5602064', '3156167109', 'no', 'no', 'Otoniel  Rueda Guarin', 16, 35, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(176, 'Hotel Camacho ', 1, 43316, 'Calle 19 #9- 72', 1, '5821415', '3045690600', 'no', 'no', 'Zuley Camacho', 20, 40, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(177, 'Complejo Ecoturistico Villa Violeta', 7, 0, 'San Jose De Oriente A 800 Metros Del Mismo Pueblo', 1, '0', '3002108222', 'Alidya27@Hotmail.Com', 'no', 'Alidis Fuentes', 13, 30, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0),
(178, 'Hotel El Don Pueblo Bello', 1, 0, 'Carrera 21 N 5 11 Las Delicias', 1, '0', '3148727618', 'Recepcionhoteleldon@Pb.Com', 'Www.Hoteleldonpb.Com', 'Carlos Arlan', 16, 50, 1, 0, 0, 1, 1, 1, 1, 0, 0, 0, 1, 0, 1, 0, 0, 1, 1),
(179, 'Hospedaje Shajen', 4, 0, 'Calle 9 No 9096 Barrio La Pista Pueblo Pello Cesar', 1, '0', '3158951471', 'Wilfridotheeran@HotmailCom', 'no', 'Donaldo Theeran Dimas', 5, 25, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 1),
(180, 'Finca Hostal La Danta', 8, 0, 'Finca Hostal La Danta Manaure Cesar', 1, '0', '3135982933', 'Fincahostalladna@Gmail.Com', 'no', 'Rodrigo Gomes Velez', 6, 40, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1, 0, 0, 0, 0, 0, 0),
(181, 'Pompatao Apartamentos Y Suites     ', 3, 39683, ' Carrera 11 # 8-51', 1, '5838318', '3006896002', 'Pompatao6@Gmail.Com', 'Www.Pompatao.Com.Co', 'Didian Arsuza ', 6, 24, 1, 1, 1, 0, 0, 1, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0),
(182, 'Hotel Santa Isabel Arenas', 1, 2147483647, 'Cra 18C #21-91', 1, '5602158', '3107382791', 'Caisarag@Hotmail.Com', 'no', 'Carolina Arenas', 7, 21, 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(183, 'Hotel El Santuario', 1, 15967, 'Carrera 13 Con 5A', 1, '5659879', '3126679896', 'Hotelelsantuario@Hotmail.Com', 'no', 'Erwis Puentes', 37, 90, 1, 1, 1, 0, 0, 1, 1, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(184, 'Residencia Y Hospedaje Intimades', 4, 0, 'Calle 19D # 14-66 Barrio La Granja', 1, '5705951', '3215930605', 'Marlucyesteban@Hotmail.Com ', 'no', 'Nasline Resarte Quintana ', 21, 42, 1, 1, 1, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(185, 'Residencia La Mia ', 4, 0, 'Calle 43 18D 77', 1, '0', '3116890208', 'no', 'no', 'Rodrigo Bayona', 21, 42, 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(186, 'Hostal Plaza Valledupar', 1, 0, 'Calle 16 # 6-74', 1, '0', '3188032572', 'Ropepe23@Hotmail.Com', 'no', 'Miladys Narvaes', 8, 20, 1, 1, 1, 1, 1, 1, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0),
(187, 'Residencia Los Nuevos Bucaros Jp ', 4, 0, 'Calle 44 27-132', 1, '5829809', '3215382110', 'no', 'no', 'Nuris Contreras Romero', 26, 50, 1, 1, 0, 0, 0, 1, 1, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0),
(188, 'Posada Don Josè', 9, 15067, ' Carrera 18 N 5-62', 1, '5654457', '3114032814', 'Medonquemoroma@Hotmail.Com', 'no', 'Marialle Cardozo Cabrera', 20, 40, 1, 1, 1, 0, 0, 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0),
(189, 'Hotel Royal', 1, 0, 'Carrera 17 # 7-26 Barrio El Centro', 1, '0', '3112379390', 'Jacomepallares@Hotmail.Com', 'no', 'Deyanira Jacome Pallares', 8, 17, 0, 1, 1, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(190, 'Hotel El Carmen ', 1, 43364, 'Carrera 18D # 41-26 Avenida Simon Bolivar ', 1, '5717580', '3145210285', 'Emersonrestrepo22@Hotmail.Com', 'no', 'Emerson Restrepo ', 16, 20, 0, 1, 1, 0, 0, 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0),
(191, 'Hostal Aguablanca ', 1, 0, 'Carrera 14# 8-10', 1, '5707597', '3103805822', 'Enohemia2@Hotmail.Com', 'no', 'Enohemia Ochoa', 8, 14, 1, 1, 1, 0, 0, 1, 1, 0, 1, 0, 1, 0, 1, 0, 0, 0, 0),
(192, 'Centro Turistico Y Ecologico Villa Adelaida', 10, 39515, '200 Mts Del Puente Sobre El Rio Manaure', 1, '5707410', '3008311095', 'Villadelaidaturismo@Gmail.Com', 'no', 'Richar Gomez Iriarte', 7, 50, 1, 0, 1, 1, 1, 0, 1, 1, 1, 0, 1, 0, 1, 0, 1, 1, 1),
(193, 'Aparta Hotel Caldas ', 3, 18469, 'Calle 7# 13-69', 1, '5651212', '3156606665', 'Apartahotelcaldas@Gmail.Com', 'no', 'Jorge Ivan Guarin ', 27, 75, 1, 1, 1, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(194, 'Hostal Balop', 2, 37201, 'Calle 13C # 14-70 Piso 2 ', 1, '5805327', '3205345276', 'Hostalbalopvalledupar@Hotmail.Com', 'no', 'Fabiana Jevaquer', 8, 21, 0, 1, 1, 0, 0, 1, 1, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0),
(195, 'Hotel El Santuario', 1, 15967, 'Carrera 13 N°5A  - 53', 1, '5659879', '3126679896', 'Hotelelsantuario@Hotmail.Com', 'no', 'Erwis Fuentes Harris', 38, 150, 1, 1, 1, 0, 0, 1, 1, 1, 1, 0, 0, 0, 1, 0, 1, 0, 0),
(196, 'Hostal Smpt', 1, 43333, 'Calle 13B N 19E 53 2 Piso', 1, '0', '3136864327', 'Tesalmer12@Gmail.Com', 'no', 'Linda Salcedo  Mercado', 4, 8, 1, 1, 1, 0, 0, 1, 1, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0),
(197, 'Hotel D´Leon Inn', 1, 10346, 'Carrera 30 No.5 - 21 ', 1, '5652510', '3106427985', 'Deleonaguachica@Gmail.Com', 'Www.Hoteldeleonaguachica.Com', 'Don Mario Leon', 72, 50, 1, 1, 1, 0, 0, 1, 1, 1, 1, 1, 1, 0, 1, 0, 1, 1, 1),
(198, 'Hotel Luzmery ', 1, 34405, 'Calle 5 # 33- 44 Barrio Alto Prado ', 1, '5651178', '3158435294', 'Perezcardena123@Gmail.Com', 'no', 'Esperanza Ruedas', 22, 84, 1, 1, 1, 0, 0, 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0),
(199, 'Restaurante Hospedaje El Gordo Saul', 9, 0, 'Calle 5 # 8-03', 1, '0', '3116877252', 'no', 'no', 'Saul Cadena Pedrozo', 10, 20, 1, 1, 1, 0, 0, 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0),
(200, 'Hotel Marsella ', 1, 0, 'Carrera 7 No. 25C-89', 1, '5883090', '3013202329', 'Jose-Studio@Hotmail.Com', 'no', 'Kelly Tatiana Foronda', 16, 50, 0, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 0, 0, 0, 0, 0, 0),
(201, 'Orquidea Real Hotel', 1, 15074, 'Cr 18D 41 16 Brr Vallemeza', 1, '5825353', '3122849504', 'Orquidearealhotel11@Hotmail.Com', 'no', 'Ana Rosa Gutierrez', 30, 120, 1, 1, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(202, 'Provincia Hostal Valledupar', 2, 18954, 'Calle 16A #5-25 Atras De La Plaza Alfonso Lopez Digonal Al Callejon De La Estrella', 1, '5800558', '3002419210', 'Info@Provinciavalledupar.Com', 'Www.Provinciavalledupar.Com', 'Cristina Zapata Naranjo', 8, 30, 0, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0),
(203, 'Casa De Los Santos Reyes Hotel Boutique  Valledupar Colombia.', 6, 42908, 'Calle 13C # 4A-90\nCentro Histórico - A Dos Cuadras De La Plaza Alfonso Lopez', 1, '5801782', '3135308269', 'Hotelboutiquevalledupar@Gmail.Com', 'Www.Hotelboutiquevalledupar.Com', 'Cristina Zapata Naranjo', 6, 12, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 0, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `infopoblacion`
--

CREATE TABLE `infopoblacion` (
  `idinfo` int(11) NOT NULL,
  `idEvento` int(11) NOT NULL,
  `_0a18H` int(11) NOT NULL,
  `_0a18M` int(11) DEFAULT '0',
  `_19a64H` int(11) DEFAULT '0',
  `_19a64M` int(11) DEFAULT '0',
  `mayor64H` int(11) DEFAULT '0',
  `mayor64M` int(11) DEFAULT '0',
  `indigenaH` int(11) DEFAULT '0',
  `indigenaM` int(11) DEFAULT '0',
  `afroColombianaH` int(11) DEFAULT '0',
  `afroColombianaM` int(11) DEFAULT '0',
  `raizalH` int(11) DEFAULT '0',
  `raizalM` int(11) DEFAULT '0',
  `puebloRomH` int(11) DEFAULT '0',
  `puebloRomM` int(11) DEFAULT '0',
  `mestizaH` int(11) DEFAULT '0',
  `mestizaM` int(11) DEFAULT '0',
  `palenqueraH` int(11) DEFAULT '0',
  `palenqueraM` int(11) DEFAULT '0',
  `desplazadosH` int(11) DEFAULT '0',
  `desplazadosM` int(11) DEFAULT '0',
  `discapacitadosH` int(11) DEFAULT '0',
  `discapacitadosM` int(11) DEFAULT '0',
  `victimasH` int(11) DEFAULT '0',
  `victimasM` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `infopoblacion`
--

INSERT INTO `infopoblacion` (`idinfo`, `idEvento`, `_0a18H`, `_0a18M`, `_19a64H`, `_19a64M`, `mayor64H`, `mayor64M`, `indigenaH`, `indigenaM`, `afroColombianaH`, `afroColombianaM`, `raizalH`, `raizalM`, `puebloRomH`, `puebloRomM`, `mestizaH`, `mestizaM`, `palenqueraH`, `palenqueraM`, `desplazadosH`, `desplazadosM`, `discapacitadosH`, `discapacitadosM`, `victimasH`, `victimasM`) VALUES
(1, 1, 3423, 324234, 23423, 32424, 32424, 2342, 34234, 4324, NULL, NULL, 3243, 432, NULL, NULL, NULL, NULL, 23424, 234, NULL, NULL, 423, 23423, NULL, NULL),
(2, 2, 20, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `junta`
--

CREATE TABLE `junta` (
  `idJunta` int(11) NOT NULL,
  `idEvento` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `fechaNac` date NOT NULL,
  `edad` int(11) NOT NULL,
  `sexo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `junta`
--

INSERT INTO `junta` (`idJunta`, `idEvento`, `nombre`, `apellido`, `fechaNac`, `edad`, `sexo`) VALUES
(1, 1, 'Fabian', 'Dangond', '2017-11-14', 36, 0),
(2, 1, 'Saniurys', 'Villazana', '2017-09-20', 24, 1),
(8, 2, 'prueba', 'apellido', '2017-11-11', 28, 0),
(9, 1, 'Ingrid', 'Prado', '1994-08-19', 24, 1),
(10, 1, 'hgfh', 'hggfhgf', '2017-11-17', 25, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `palco`
--

CREATE TABLE `palco` (
  `idPalco` int(11) NOT NULL,
  `idActividad` int(11) NOT NULL,
  `detalle` varchar(100) NOT NULL,
  `capacidad` int(11) NOT NULL,
  `costo` double(11,2) NOT NULL,
  `cantidadReal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `palco`
--

INSERT INTO `palco` (`idPalco`, `idActividad`, `detalle`, `capacidad`, `costo`, `cantidadReal`) VALUES
(11, 10, 'ghgf', 655656, 655665.00, 0),
(12, 10, 'gfhgfh', 567, 65765.00, 0),
(13, 11, 'gfhgfh', 6557, 546455.00, 0),
(14, 12, 'dfgdf', 546, 454.00, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `participante`
--

CREATE TABLE `participante` (
  `idParticipante` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `cedula` varchar(50) NOT NULL,
  `edad` int(11) NOT NULL,
  `sexo` int(11) NOT NULL,
  `habilidad` int(11) NOT NULL,
  `profesion` varchar(100) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `telefono2` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `participante`
--

INSERT INTO `participante` (`idParticipante`, `nombre`, `apellido`, `cedula`, `edad`, `sexo`, `habilidad`, `profesion`, `telefono`, `telefono2`, `correo`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Luis', 'Perez', '3467899965', 29, 0, 0, 'cantante', '5676576', '45356465', 'luisperez@c.c', '2017-11-15 00:27:03', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `premio`
--

CREATE TABLE `premio` (
  `idPremio` int(11) NOT NULL,
  `idActividad` int(11) NOT NULL,
  `detalle` varchar(100) NOT NULL,
  `costo` double(11,2) NOT NULL,
  `idParticipante` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `region`
--

CREATE TABLE `region` (
  `idRegion` int(11) NOT NULL,
  `nombre` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `region`
--

INSERT INTO `region` (`idRegion`, `nombre`) VALUES
(1, 'Amazonia'),
(2, 'Andina'),
(3, 'Caribe'),
(4, 'Insular'),
(5, 'Orinoquía'),
(6, 'Pacífico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo`
--

CREATE TABLE `tipo` (
  `idTipo` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo`
--

INSERT INTO `tipo` (`idTipo`, `nombre`) VALUES
(1, 'Show Musical'),
(2, 'Teatro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `cedula` varchar(50) NOT NULL,
  `tipo` int(11) NOT NULL COMMENT '0:admin 1:planificador 2:operario',
  `correo` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `nombre`, `apellido`, `cedula`, `tipo`, `correo`, `password`, `created_at`, `updated_at`, `deleted_at`, `remember_token`) VALUES
(1, 'Ingrid', 'Prado', '22650574', 0, 'i@c.c', '$2y$10$qVH1X6UL9aRAs95eASV4XeKJrSNdPIfv19DiB0OB66YmzZ0ePXaYa', '2017-10-17 03:14:08', '0000-00-00 00:00:00', NULL, 'l4Qg340IcoPAJDfAa5b1PnRpPGQu7TfYLm5peVjQcgdar1isLbfEGBk4DpfQ');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividad`
--
ALTER TABLE `actividad`
  ADD PRIMARY KEY (`idActividad`);

--
-- Indices de la tabla `agrupaciones`
--
ALTER TABLE `agrupaciones`
  ADD PRIMARY KEY (`idAgrupacion`);

--
-- Indices de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  ADD PRIMARY KEY (`idCiudad`);

--
-- Indices de la tabla `clasificacion`
--
ALTER TABLE `clasificacion`
  ADD PRIMARY KEY (`idClasificacion`);

--
-- Indices de la tabla `cuidad`
--
ALTER TABLE `cuidad`
  ADD PRIMARY KEY (`idCiudad`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`idDepartamento`);

--
-- Indices de la tabla `direccionactividad`
--
ALTER TABLE `direccionactividad`
  ADD PRIMARY KEY (`idDireccion`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`idEmpresa`);

--
-- Indices de la tabla `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`idEvento`);

--
-- Indices de la tabla `eventoactividad`
--
ALTER TABLE `eventoactividad`
  ADD PRIMARY KEY (`idEventoActividad`);

--
-- Indices de la tabla `genero`
--
ALTER TABLE `genero`
  ADD PRIMARY KEY (`idGenero`);

--
-- Indices de la tabla `habilidad`
--
ALTER TABLE `habilidad`
  ADD PRIMARY KEY (`idHabilidad`);

--
-- Indices de la tabla `hotel`
--
ALTER TABLE `hotel`
  ADD PRIMARY KEY (`idHotel`);

--
-- Indices de la tabla `infopoblacion`
--
ALTER TABLE `infopoblacion`
  ADD PRIMARY KEY (`idinfo`);

--
-- Indices de la tabla `junta`
--
ALTER TABLE `junta`
  ADD PRIMARY KEY (`idJunta`);

--
-- Indices de la tabla `palco`
--
ALTER TABLE `palco`
  ADD PRIMARY KEY (`idPalco`);

--
-- Indices de la tabla `participante`
--
ALTER TABLE `participante`
  ADD PRIMARY KEY (`idParticipante`);

--
-- Indices de la tabla `premio`
--
ALTER TABLE `premio`
  ADD PRIMARY KEY (`idPremio`);

--
-- Indices de la tabla `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`idRegion`);

--
-- Indices de la tabla `tipo`
--
ALTER TABLE `tipo`
  ADD PRIMARY KEY (`idTipo`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividad`
--
ALTER TABLE `actividad`
  MODIFY `idActividad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `agrupaciones`
--
ALTER TABLE `agrupaciones`
  MODIFY `idAgrupacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  MODIFY `idCiudad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `clasificacion`
--
ALTER TABLE `clasificacion`
  MODIFY `idClasificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `cuidad`
--
ALTER TABLE `cuidad`
  MODIFY `idCiudad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `idDepartamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT de la tabla `direccionactividad`
--
ALTER TABLE `direccionactividad`
  MODIFY `idDireccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `idEmpresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `evento`
--
ALTER TABLE `evento`
  MODIFY `idEvento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `eventoactividad`
--
ALTER TABLE `eventoactividad`
  MODIFY `idEventoActividad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `genero`
--
ALTER TABLE `genero`
  MODIFY `idGenero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `habilidad`
--
ALTER TABLE `habilidad`
  MODIFY `idHabilidad` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `hotel`
--
ALTER TABLE `hotel`
  MODIFY `idHotel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=204;
--
-- AUTO_INCREMENT de la tabla `infopoblacion`
--
ALTER TABLE `infopoblacion`
  MODIFY `idinfo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `junta`
--
ALTER TABLE `junta`
  MODIFY `idJunta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `palco`
--
ALTER TABLE `palco`
  MODIFY `idPalco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `participante`
--
ALTER TABLE `participante`
  MODIFY `idParticipante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `premio`
--
ALTER TABLE `premio`
  MODIFY `idPremio` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `region`
--
ALTER TABLE `region`
  MODIFY `idRegion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `tipo`
--
ALTER TABLE `tipo`
  MODIFY `idTipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
