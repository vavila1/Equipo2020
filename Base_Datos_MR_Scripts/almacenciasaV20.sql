-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 10-06-2020 a las 23:39:05
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `almacenciasa`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `crearCuenta` (IN `new_puesto` INT(10), IN `new_almacen` INT(10), IN `new_correo` VARCHAR(100), IN `new_nombre` VARCHAR(100), IN `new_usuario` VARCHAR(50), IN `new_contra` VARCHAR(100), IN `new_rol` INT(10))  NO SQL
BEGIN
START TRANSACTION;

INSERT INTO empleado (Id_Puesto, Id_Almacen, Correo, Nombre) VALUES (new_puesto, new_almacen,new_correo, new_nombre);

INSERT INTO cuenta (Id_Empleado, Usuario, Password, Id_Estatusgeneral) VALUES ( (SELECT e.Id_Empleado FROM empleado as e ORDER BY e.Id_Empleado DESC LIMIT 1) ,new_usuario,new_contra, 1);

INSERT INTO cuenta_rol (Id_Cuenta, Id_Rol) VALUES ( (SELECT c.Id_Cuenta FROM cuenta as c ORDER BY c.Id_Cuenta DESC LIMIT 1) ,new_rol);

COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerHistorial` (IN `id` INT(10))  BEGIN 
	SELECT
    E.nombre AS E_nombre,
    H.fecha AS H_fecha
FROM
    estatus_producto AS E,
    producto AS P,
    e_p AS H
WHERE
    E.id = H.Id_Estado_producto AND P.id = H.Id_Producto AND H.Id_Producto = id 
ORDER BY
    H.fecha
DESC
LIMIT 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerProductos` (IN `almacen` INT(10), IN `marca` INT(10), IN `tipo` INT(10))  BEGIN 
	SELECT p.id AS p_id, p.nombre AS p_nombre, m.nombre AS m_nombre, t.nombre AS tp_nombre, p.cantidad AS p_cantidad, p.precio AS p_precio 
    FROM producto AS p, marca AS m, tipo_producto AS t, empleado, almacen 
    WHERE m.id = p.id_marca AND t.id = p.id_tipo AND almacen.id = empleado.Id_Almacen AND p.Id_Almacen = almacen.id AND p.Id_Estatus != 5 AND p.Id_Almacen = almacen AND m.id = marca AND t.id = tipo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `registrarEntradaConsumibles` (IN `id_producto` INT(10), IN `new_cantidad` INT(10))  NO SQL
BEGIN
START TRANSACTION;
Set @cantidad2 = (Select P.cantidad From producto as P where P.id=id_producto);
Update producto Set cantidad=(@cantidad2+new_cantidad), Id_Estatus = 6 Where id=(id_producto);
COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `registrarRetornoHerramientas` (IN `id_producto` INT(10), IN `id_empleado` INT(10))  NO SQL
BEGIN
START TRANSACTION;

INSERT INTO entregan (Id_Transaccion, Id_Producto, Id_Empleado) VALUES (3, id_producto ,id_empleado);
INSERT INTO e_p (Id_Producto, Id_Estado_producto) VALUES (id_producto,6);
UPDATE producto SET Id_Estatus = 6 wHERE id = id_producto;
UPDATE producto SET cantidad = 1 wHERE id = id_producto;
COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `registrarSalidaConsumibles` (IN `id_producto` INT(10), IN `id_proyecto` INT(10), IN `id_empleado` INT(10), IN `new_cantidad` INT(10), IN `id_estado` INT(10))  NO SQL
BEGIN
START TRANSACTION;

INSERT INTO producto_proyecto  (Id_Producto, Id_Proyecto, Cantidad_Asignada) VALUES (id_producto, id_proyecto,new_cantidad);
INSERT INTO entregan (Id_Transaccion, Id_Producto, Id_Empleado) VALUES (1, id_producto ,id_empleado);
INSERT INTO e_p (Id_Producto, Id_Estado_producto) VALUES (id_producto,id_estado);
UPDATE producto SET Id_Estatus = id_estado wHERE id = id_producto;
UPDATE producto SET cantidad = (cantidad - new_cantidad) wHERE id = id_producto;
COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `registrarSalidaHerramienta` (IN `id_producto` INT(10), IN `id_proyecto` INT(10), IN `id_empleado` INT(10), IN `new_cantidad` INT(10))  NO SQL
BEGIN
START TRANSACTION;

INSERT INTO producto_proyecto  (Id_Producto, Id_Proyecto, Cantidad_Asignada) VALUES (id_producto, id_proyecto,new_cantidad);
INSERT INTO entregan (Id_Transaccion, Id_Producto, Id_Empleado) VALUES (1, id_producto ,id_empleado);
INSERT INTO e_p (Id_Producto, Id_Estado_producto) VALUES (id_producto,3);
UPDATE producto SET Id_Estatus = 3 wHERE id = id_producto;
UPDATE producto SET cantidad = (cantidad - new_cantidad) wHERE id = id_producto;
COMMIT;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacen`
--

CREATE TABLE `almacen` (
  `id` int(10) NOT NULL,
  `id_estado` int(10) DEFAULT NULL,
  `nombre` varchar(20) DEFAULT NULL,
  `id_estatus` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `almacen`
--

INSERT INTO `almacen` (`id`, `id_estado`, `nombre`, `id_estatus`) VALUES
(1, 1, 'Almacen queretaro', 6),
(2, 7, 'Almacen Monterrey', 6),
(3, 5, 'Almacen Sinaloa', 6),
(4, 4, 'alamcen jalisco', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta`
--

CREATE TABLE `cuenta` (
  `Id_Cuenta` int(10) NOT NULL,
  `Id_Empleado` int(10) DEFAULT NULL,
  `Usuario` varchar(20) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `Id_Estatusgeneral` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cuenta`
--

INSERT INTO `cuenta` (`Id_Cuenta`, `Id_Empleado`, `Usuario`, `Password`, `Id_Estatusgeneral`) VALUES
(2, 2, 'Admin', '24934871b4dd5d625da5ec9346416245e6e3789dd6d7e48bb870db3e', 1),
(3, 3, 'Admin2', '5df12634ec7067e2ee7c1f96ba094021801a8b36eff8a84ad655ebf0', 1),
(16, 16, 'nombre', '602bdc204140db016bee5374895e5568ce422fabe17e064061d80097', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta_rol`
--

CREATE TABLE `cuenta_rol` (
  `Id_Cuenta` int(10) NOT NULL,
  `Id_Rol` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cuenta_rol`
--

INSERT INTO `cuenta_rol` (`Id_Cuenta`, `Id_Rol`) VALUES
(2, 1),
(3, 1),
(16, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `Id_Empleado` int(10) NOT NULL,
  `Id_Puesto` int(10) DEFAULT NULL,
  `Id_Almacen` int(10) DEFAULT NULL,
  `Correo` varchar(50) DEFAULT NULL,
  `Nombre` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`Id_Empleado`, `Id_Puesto`, `Id_Almacen`, `Correo`, `Nombre`) VALUES
(2, 1, 1, 'corre@correo.com', 'Marco'),
(3, 1, 3, 'sinaloa@.com', 'Marco sinaloa'),
(16, 1, 2, 'nombre@hotmail.com', 'Nombre');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entregan`
--

CREATE TABLE `entregan` (
  `id` int(10) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `Id_Transaccion` int(10) DEFAULT NULL,
  `Id_Producto` int(10) DEFAULT NULL,
  `Id_Empleado` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `entregan`
--

INSERT INTO `entregan` (`id`, `fecha`, `Id_Transaccion`, `Id_Producto`, `Id_Empleado`) VALUES
(17, '2020-05-27 16:06:28', 1, 27, 2),
(18, '2020-05-27 16:40:08', 1, 25, 2),
(19, '2020-05-27 16:40:09', 1, 27, 2),
(20, '2020-05-27 16:59:29', 2, 25, 2),
(21, '2020-05-27 16:59:45', 2, 27, 2),
(22, '2020-05-27 17:01:33', 1, 27, 2),
(23, '2020-05-27 17:01:46', 2, 27, 2),
(24, '2020-05-27 17:01:52', 1, 27, 2),
(25, '2020-05-27 17:01:58', 2, 27, 2),
(26, '2020-05-27 17:13:39', 1, 25, 2),
(27, '2020-05-27 17:13:50', 2, 25, 2),
(28, '2020-05-27 17:32:32', 1, 26, 2),
(29, '2020-05-27 17:34:02', 1, 26, 2),
(30, '2020-05-27 17:34:14', 1, 26, 2),
(31, '2020-05-27 17:47:34', 1, 30, 3),
(32, '2020-05-27 17:47:37', 1, 31, 3),
(33, '2020-05-27 17:50:05', 1, 32, 2),
(34, '2020-05-27 17:50:29', 1, 32, 2),
(35, '2020-05-27 17:54:50', 1, 25, 2),
(36, '2020-05-27 17:54:55', 2, 25, 2),
(37, '2020-05-29 17:17:03', 1, 25, 2),
(38, '2020-05-29 17:19:08', 2, 25, 2),
(39, '2020-05-29 17:19:14', 1, 27, 2),
(40, '2020-05-29 17:19:28', 2, 27, 2),
(41, '2020-06-01 18:55:50', 1, 29, 2),
(42, '2020-06-01 18:56:14', 3, 29, 2),
(43, '2020-06-10 19:24:44', 1, 32, 2),
(44, '2020-06-10 19:39:12', 1, 32, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `id` int(10) NOT NULL,
  `nombre` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`id`, `nombre`) VALUES
(1, 'Queretaro'),
(2, 'Quintana Roo'),
(3, 'Zacatecas'),
(4, 'Estado de Mexico'),
(5, 'CDMX'),
(6, 'Sinaloa'),
(7, 'Monterrey');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estatusgeneral`
--

CREATE TABLE `estatusgeneral` (
  `id` int(10) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estatusgeneral`
--

INSERT INTO `estatusgeneral` (`id`, `nombre`) VALUES
(1, 'Disponible'),
(2, 'Eliminado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estatusproyecto`
--

CREATE TABLE `estatusproyecto` (
  `Id_EstatusProyecto` int(10) NOT NULL,
  `Nombre` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estatusproyecto`
--

INSERT INTO `estatusproyecto` (`Id_EstatusProyecto`, `Nombre`) VALUES
(1, 'Terminado'),
(2, 'Pendiente'),
(3, 'En proceso'),
(4, 'Iniciado'),
(5, 'Eliminado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estatus_producto`
--

CREATE TABLE `estatus_producto` (
  `id` int(10) NOT NULL,
  `nombre` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estatus_producto`
--

INSERT INTO `estatus_producto` (`id`, `nombre`) VALUES
(1, 'Calibración'),
(2, 'Agotado'),
(3, 'En prestamo'),
(4, 'Descompuesto'),
(5, 'Eliminado'),
(6, 'Disponible'),
(7, 'Caducado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `e_p`
--

CREATE TABLE `e_p` (
  `id` int(10) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `Id_Producto` int(10) DEFAULT NULL,
  `Id_Estado_producto` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `e_p`
--

INSERT INTO `e_p` (`id`, `fecha`, `Id_Producto`, `Id_Estado_producto`) VALUES
(38, '2020-05-27 16:40:08', 25, 3),
(39, '2020-05-27 16:40:09', 27, 3),
(40, '2020-05-27 16:59:29', 25, 6),
(41, '2020-05-27 16:59:45', 27, 6),
(42, '2020-05-27 17:01:33', 27, 3),
(43, '2020-05-27 17:01:46', 27, 6),
(44, '2020-05-27 17:01:52', 27, 3),
(45, '2020-05-27 17:01:58', 27, 6),
(46, '2020-05-27 17:13:39', 25, 3),
(47, '2020-05-27 17:13:50', 25, 6),
(48, '2020-05-27 17:19:46', 29, 6),
(49, '2020-05-27 17:19:52', 29, 1),
(50, '2020-05-27 17:19:56', 29, 6),
(52, '2020-05-27 17:34:02', 26, 6),
(53, '2020-05-27 17:34:14', 26, 2),
(54, '2020-05-27 17:46:18', 30, 6),
(55, '2020-05-27 17:46:29', 31, 6),
(56, '2020-05-27 17:47:34', 30, 3),
(57, '2020-05-27 17:47:37', 31, 6),
(58, '2020-05-27 17:49:47', 32, 6),
(59, '2020-05-27 17:50:05', 32, 6),
(60, '2020-05-27 17:50:29', 32, 2),
(61, '2020-05-27 17:54:50', 25, 3),
(62, '2020-05-27 17:54:55', 25, 6),
(63, '2020-05-29 17:17:03', 25, 3),
(64, '2020-05-29 17:19:08', 25, 6),
(65, '2020-05-29 17:19:14', 27, 3),
(66, '2020-05-29 17:19:28', 27, 6),
(67, '2020-06-01 18:54:47', 32, 6),
(68, '2020-06-01 18:55:50', 29, 3),
(69, '2020-06-01 18:56:14', 29, 6),
(70, '2020-06-01 18:56:30', 32, 6),
(71, '2020-06-07 16:15:37', 25, 1),
(72, '2020-06-07 16:15:40', 25, 6),
(73, '2020-06-09 17:08:48', 28, 1),
(74, '2020-06-09 17:08:57', 28, 6),
(75, '2020-06-09 17:35:22', 33, 2),
(76, '2020-06-09 17:37:44', 34, 6),
(77, '2020-06-09 17:37:51', 33, 5),
(78, '2020-06-09 17:38:06', 34, 1),
(79, '2020-06-09 17:38:13', 34, 6),
(80, '2020-06-09 17:44:51', 34, 6),
(81, '2020-06-09 17:45:42', 26, 5),
(82, '2020-06-10 19:24:44', 32, 6),
(83, '2020-06-10 19:27:26', 32, 6),
(84, '2020-06-10 19:37:46', 32, 6),
(85, '2020-06-10 19:39:12', 32, 6),
(86, '2020-06-10 20:27:28', 32, 6),
(87, '2020-06-10 21:32:35', 32, 6),
(88, '2020-06-10 21:36:53', 32, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE `marca` (
  `id` int(10) NOT NULL,
  `nombre` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `marca`
--

INSERT INTO `marca` (`id`, `nombre`) VALUES
(1, 'Trupper'),
(2, 'Vitromex'),
(3, 'DeWalt'),
(4, 'Bosch'),
(5, 'totis'),
(6, 'Nike'),
(7, 'GRANDSTREAM');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `privilegio`
--

CREATE TABLE `privilegio` (
  `Id_Privilegio` int(10) NOT NULL,
  `Nombre` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `privilegio`
--

INSERT INTO `privilegio` (`Id_Privilegio`, `Nombre`) VALUES
(1, 'Ver'),
(2, 'Editar'),
(3, 'Eliminar'),
(4, 'Registrar'),
(5, 'Consultar'),
(6, 'Registrar'),
(7, 'Registar'),
(8, 'VerInicio'),
(9, 'VerReporte'),
(10, 'ConsultarReporte'),
(11, 'DescargarReporte'),
(12, 'VerProyecto'),
(13, 'ConsultarProyecto'),
(14, 'AgregarProyecto'),
(15, 'SalidaProyecto'),
(16, 'EntradaProyecto'),
(17, 'EditarProyecto'),
(18, 'EliminarProyecto'),
(19, 'VerInventario'),
(20, 'ConsultarInventario'),
(21, 'AgregarInventario'),
(22, 'CalibrarProducto'),
(23, 'RecibirProducto'),
(24, 'EditarProducto'),
(25, 'ImprimirCB'),
(26, 'EliminarProducto'),
(27, 'VerAlmacen'),
(28, 'ConsultarAlmacen'),
(29, 'AgregarAlmacen'),
(30, 'EditarAlmacen'),
(31, 'EliminarAlmacen'),
(32, 'VerMarcas'),
(33, 'ConsultarMarcas'),
(34, 'AgregarMarcas'),
(35, 'EditarMarcas'),
(36, 'EliminarMarcas'),
(37, 'VerTP'),
(38, 'ConsultarTP'),
(39, 'AgregarTP'),
(40, 'EditarTP'),
(41, 'EliminarTP'),
(42, 'VerEP'),
(43, 'ConsultarEP'),
(44, 'AgregarEP'),
(45, 'EditarEP'),
(46, 'EliminarEP'),
(47, 'VerUsuario'),
(48, 'ConsultarUsuario'),
(49, 'AgregarUsuario'),
(50, 'EditarUsuario'),
(51, 'EliminarUsuario'),
(52, 'ContraseñaUsuario'),
(53, 'TerminarProyecto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` int(10) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `modelo` varchar(100) NOT NULL,
  `cantidad` int(10) DEFAULT NULL,
  `precio` int(10) DEFAULT NULL,
  `id_marca` int(10) DEFAULT NULL,
  `id_tipo` int(10) DEFAULT NULL,
  `Id_Almacen` int(10) DEFAULT NULL,
  `Id_Estatus` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `nombre`, `modelo`, `cantidad`, `precio`, `id_marca`, `id_tipo`, `Id_Almacen`, `Id_Estatus`) VALUES
(22, 'Frutsi', '', 500, 8, 3, 2, 1, 5),
(23, 'Pala T-2000 Cuadrada', '', 1, 254, 1, 1, 1, 5),
(24, 'Mojojo', '', 1, 1230, 2, 1, 1, 5),
(25, 'Pala T-2000 Cuadrada', '', 1, 150, 1, 1, 1, 6),
(26, 'Frutsi', '', 1, 6, 4, 2, 1, 5),
(27, 'FrutsiED', '', 1, 150, 3, 1, 1, 6),
(28, 'Cemento Refractario Humedo Cubeta', '', 5, 12, 1, 1, 1, 6),
(29, 'Prueba', '', 1, 1500, 3, 1, 1, 6),
(30, 'Martillo Sinaloa', '', 0, 100, 1, 1, 3, 3),
(31, 'Cemento Cruz Azul', '', 448, 123, 4, 2, 3, 6),
(32, 'Consumible', '', 12, 12222, 3, 2, 1, 6),
(33, 'Small Business HD IP Phone', 'GXP1620/1625', 0, 1650, 7, 6, 1, 5),
(34, 'Small Business HD IP Phone', 'GXP1620/1625', 1, 100, 7, 6, 1, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_proyecto`
--

CREATE TABLE `producto_proyecto` (
  `id` int(10) NOT NULL,
  `Id_Producto` int(10) DEFAULT NULL,
  `Id_Proyecto` int(10) DEFAULT NULL,
  `Cantidad_Asignada` int(10) DEFAULT NULL,
  `Fecha_Asignacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `producto_proyecto`
--

INSERT INTO `producto_proyecto` (`id`, `Id_Producto`, `Id_Proyecto`, `Cantidad_Asignada`, `Fecha_Asignacion`) VALUES
(36, 25, 0, 1, '2020-05-27 16:40:08'),
(37, 27, 0, 1, '2020-05-27 16:40:09'),
(38, 27, 0, 0, '2020-05-27 17:01:33'),
(39, 27, 0, 1, '2020-05-27 17:01:52'),
(40, 25, 0, 1, '2020-05-27 17:13:39'),
(41, 26, 0, 20, '2020-05-27 17:32:32'),
(42, 26, 0, 2, '2020-05-27 17:34:02'),
(43, 26, 0, 3, '2020-05-27 17:34:14'),
(44, 30, 0, 1, '2020-05-27 17:47:34'),
(45, 31, 0, 52, '2020-05-27 17:47:37'),
(46, 32, 0, 50, '2020-05-27 17:50:05'),
(47, 32, 0, 450, '2020-05-27 17:50:29'),
(48, 25, 0, 1, '2020-05-27 17:54:50'),
(49, 25, 0, 1, '2020-05-29 17:17:03'),
(50, 27, 123123, 1, '2020-05-29 17:19:14'),
(51, 29, 0, 1, '2020-06-01 18:55:50'),
(52, 32, 12345, 2, '2020-06-10 19:24:44'),
(53, 32, 12345, 1, '2020-06-10 19:39:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyecto`
--

CREATE TABLE `proyecto` (
  `Id_Proyecto` int(10) NOT NULL,
  `Id_EstatusProyecto` int(10) DEFAULT NULL,
  `Nombre` varchar(10) DEFAULT NULL,
  `Fecha_Inicio` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Fecha_Fin` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `proyecto`
--

INSERT INTO `proyecto` (`Id_Proyecto`, `Id_EstatusProyecto`, `Nombre`, `Fecha_Inicio`, `Fecha_Fin`) VALUES
(0, 1, 'Qualitas', '2020-06-09 17:06:37', '2020-06-09 12:06:37'),
(1, 5, 'Oxxo', '2020-05-12 19:09:58', NULL),
(999, 5, 'borrado', '2020-06-07 16:28:32', NULL),
(12345, 4, 'dadfdsaads', '2020-06-10 18:55:12', NULL),
(123123, 2, 'Prueba', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puesto`
--

CREATE TABLE `puesto` (
  `Id_Puesto` int(10) NOT NULL,
  `Nombre` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `puesto`
--

INSERT INTO `puesto` (`Id_Puesto`, `Nombre`) VALUES
(1, 'Admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `Id_Rol` int(10) NOT NULL,
  `Nombre` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`Id_Rol`, `Nombre`) VALUES
(1, 'Administrador'),
(4, 'Gerente'),
(5, 'Coordinacion'),
(6, 'Almacenista'),
(7, 'Supervisor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_privilegio`
--

CREATE TABLE `rol_privilegio` (
  `Id_Rol` int(10) NOT NULL,
  `Id_Privilegio` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `rol_privilegio`
--

INSERT INTO `rol_privilegio` (`Id_Rol`, `Id_Privilegio`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(1, 24),
(1, 25),
(1, 26),
(1, 27),
(1, 28),
(1, 29),
(1, 30),
(1, 31),
(1, 32),
(1, 33),
(1, 34),
(1, 35),
(1, 36),
(1, 37),
(1, 38),
(1, 39),
(1, 40),
(1, 41),
(1, 42),
(1, 43),
(1, 44),
(1, 45),
(1, 46),
(1, 47),
(1, 48),
(1, 49),
(1, 50),
(1, 51),
(1, 52),
(1, 53),
(4, 8),
(4, 9),
(4, 10),
(4, 11),
(4, 12),
(4, 13),
(4, 14),
(4, 17),
(4, 18),
(4, 19),
(4, 20),
(4, 21),
(4, 22),
(4, 23),
(4, 24),
(4, 25),
(4, 26),
(4, 27),
(4, 28),
(4, 29),
(4, 30),
(4, 32),
(4, 33),
(4, 34),
(4, 35),
(5, 8),
(5, 9),
(5, 10),
(5, 11),
(5, 12),
(5, 13),
(5, 14),
(5, 17),
(5, 19),
(5, 20),
(5, 21),
(5, 22),
(5, 23),
(5, 24),
(5, 25),
(5, 26),
(6, 8),
(6, 12),
(6, 13),
(6, 15),
(6, 16),
(6, 19),
(6, 20),
(6, 21),
(6, 22),
(6, 23),
(6, 24),
(6, 32),
(6, 33),
(6, 34);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_producto`
--

CREATE TABLE `tipo_producto` (
  `id` int(10) NOT NULL,
  `nombre` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_producto`
--

INSERT INTO `tipo_producto` (`id`, `nombre`) VALUES
(1, 'Herramienta'),
(2, 'Consumible'),
(4, 'Vehiculo'),
(6, 'Periferico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transaccion`
--

CREATE TABLE `transaccion` (
  `Id_Transaccion` int(10) NOT NULL,
  `Nombre` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `transaccion`
--

INSERT INTO `transaccion` (`Id_Transaccion`, `Nombre`) VALUES
(1, 'Salida'),
(2, 'llegada'),
(3, 'Retorno');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `almacen`
--
ALTER TABLE `almacen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_estado` (`id_estado`),
  ADD KEY `estatus_id` (`id_estatus`);

--
-- Indices de la tabla `cuenta`
--
ALTER TABLE `cuenta`
  ADD PRIMARY KEY (`Id_Cuenta`),
  ADD KEY `Id_Empleado` (`Id_Empleado`),
  ADD KEY `Id_Estatusgeneral` (`Id_Estatusgeneral`);

--
-- Indices de la tabla `cuenta_rol`
--
ALTER TABLE `cuenta_rol`
  ADD PRIMARY KEY (`Id_Cuenta`,`Id_Rol`),
  ADD KEY `Id_Rol` (`Id_Rol`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`Id_Empleado`),
  ADD KEY `Id_Puesto` (`Id_Puesto`),
  ADD KEY `Id_Almacen` (`Id_Almacen`);

--
-- Indices de la tabla `entregan`
--
ALTER TABLE `entregan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Id_Transaccion` (`Id_Transaccion`),
  ADD KEY `Id_Producto` (`Id_Producto`),
  ADD KEY `Id_Empleado` (`Id_Empleado`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estatusgeneral`
--
ALTER TABLE `estatusgeneral`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estatusproyecto`
--
ALTER TABLE `estatusproyecto`
  ADD PRIMARY KEY (`Id_EstatusProyecto`);

--
-- Indices de la tabla `estatus_producto`
--
ALTER TABLE `estatus_producto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `e_p`
--
ALTER TABLE `e_p`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Id_Producto` (`Id_Producto`),
  ADD KEY `Id_Estado_producto` (`Id_Estado_producto`);

--
-- Indices de la tabla `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `privilegio`
--
ALTER TABLE `privilegio`
  ADD PRIMARY KEY (`Id_Privilegio`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_marca` (`id_marca`),
  ADD KEY `Id_Almacen` (`Id_Almacen`),
  ADD KEY `id_tipo` (`id_tipo`),
  ADD KEY `Id_Estatus` (`Id_Estatus`);

--
-- Indices de la tabla `producto_proyecto`
--
ALTER TABLE `producto_proyecto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Id_Proyecto` (`Id_Proyecto`),
  ADD KEY `Id_Producto` (`Id_Producto`);

--
-- Indices de la tabla `proyecto`
--
ALTER TABLE `proyecto`
  ADD PRIMARY KEY (`Id_Proyecto`),
  ADD KEY `Id_EstatusProyecto` (`Id_EstatusProyecto`);

--
-- Indices de la tabla `puesto`
--
ALTER TABLE `puesto`
  ADD PRIMARY KEY (`Id_Puesto`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`Id_Rol`);

--
-- Indices de la tabla `rol_privilegio`
--
ALTER TABLE `rol_privilegio`
  ADD PRIMARY KEY (`Id_Rol`,`Id_Privilegio`),
  ADD KEY `Id_Privilegio` (`Id_Privilegio`);

--
-- Indices de la tabla `tipo_producto`
--
ALTER TABLE `tipo_producto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `transaccion`
--
ALTER TABLE `transaccion`
  ADD PRIMARY KEY (`Id_Transaccion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `almacen`
--
ALTER TABLE `almacen`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cuenta`
--
ALTER TABLE `cuenta`
  MODIFY `Id_Cuenta` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `Id_Empleado` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `entregan`
--
ALTER TABLE `entregan`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `estatusgeneral`
--
ALTER TABLE `estatusgeneral`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estatusproyecto`
--
ALTER TABLE `estatusproyecto`
  MODIFY `Id_EstatusProyecto` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `estatus_producto`
--
ALTER TABLE `estatus_producto`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `e_p`
--
ALTER TABLE `e_p`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `privilegio`
--
ALTER TABLE `privilegio`
  MODIFY `Id_Privilegio` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `producto_proyecto`
--
ALTER TABLE `producto_proyecto`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `puesto`
--
ALTER TABLE `puesto`
  MODIFY `Id_Puesto` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `Id_Rol` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tipo_producto`
--
ALTER TABLE `tipo_producto`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `transaccion`
--
ALTER TABLE `transaccion`
  MODIFY `Id_Transaccion` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `almacen`
--
ALTER TABLE `almacen`
  ADD CONSTRAINT `almacen_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id`),
  ADD CONSTRAINT `estatus_id` FOREIGN KEY (`id_estatus`) REFERENCES `estatus_producto` (`id`);

--
-- Filtros para la tabla `cuenta`
--
ALTER TABLE `cuenta`
  ADD CONSTRAINT `cuenta_ibfk_1` FOREIGN KEY (`Id_Empleado`) REFERENCES `empleado` (`Id_Empleado`),
  ADD CONSTRAINT `cuenta_ibfk_2` FOREIGN KEY (`Id_Estatusgeneral`) REFERENCES `estatusgeneral` (`id`);

--
-- Filtros para la tabla `cuenta_rol`
--
ALTER TABLE `cuenta_rol`
  ADD CONSTRAINT `cuenta_rol_ibfk_1` FOREIGN KEY (`Id_Rol`) REFERENCES `rol` (`Id_Rol`),
  ADD CONSTRAINT `cuenta_rol_ibfk_2` FOREIGN KEY (`Id_Cuenta`) REFERENCES `cuenta` (`Id_Cuenta`);

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `empleado_ibfk_1` FOREIGN KEY (`Id_Puesto`) REFERENCES `puesto` (`Id_Puesto`),
  ADD CONSTRAINT `empleado_ibfk_2` FOREIGN KEY (`Id_Almacen`) REFERENCES `almacen` (`id`);

--
-- Filtros para la tabla `entregan`
--
ALTER TABLE `entregan`
  ADD CONSTRAINT `entregan_ibfk_1` FOREIGN KEY (`Id_Transaccion`) REFERENCES `transaccion` (`Id_Transaccion`),
  ADD CONSTRAINT `entregan_ibfk_2` FOREIGN KEY (`Id_Producto`) REFERENCES `producto` (`id`),
  ADD CONSTRAINT `entregan_ibfk_3` FOREIGN KEY (`Id_Empleado`) REFERENCES `empleado` (`Id_Empleado`);

--
-- Filtros para la tabla `e_p`
--
ALTER TABLE `e_p`
  ADD CONSTRAINT `e_p_ibfk_1` FOREIGN KEY (`Id_Producto`) REFERENCES `producto` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `e_p_ibfk_2` FOREIGN KEY (`Id_Estado_producto`) REFERENCES `estatus_producto` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`id_marca`) REFERENCES `marca` (`id`),
  ADD CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`Id_Almacen`) REFERENCES `almacen` (`id`),
  ADD CONSTRAINT `producto_ibfk_3` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_producto` (`id`),
  ADD CONSTRAINT `producto_ibfk_4` FOREIGN KEY (`Id_Estatus`) REFERENCES `estatus_producto` (`id`);

--
-- Filtros para la tabla `producto_proyecto`
--
ALTER TABLE `producto_proyecto`
  ADD CONSTRAINT `producto_proyecto_ibfk_1` FOREIGN KEY (`Id_Proyecto`) REFERENCES `proyecto` (`Id_Proyecto`),
  ADD CONSTRAINT `producto_proyecto_ibfk_2` FOREIGN KEY (`Id_Producto`) REFERENCES `producto` (`id`);

--
-- Filtros para la tabla `proyecto`
--
ALTER TABLE `proyecto`
  ADD CONSTRAINT `proyecto_ibfk_1` FOREIGN KEY (`Id_EstatusProyecto`) REFERENCES `estatusproyecto` (`Id_EstatusProyecto`);

--
-- Filtros para la tabla `rol_privilegio`
--
ALTER TABLE `rol_privilegio`
  ADD CONSTRAINT `rol_privilegio_ibfk_1` FOREIGN KEY (`Id_Rol`) REFERENCES `rol` (`Id_Rol`),
  ADD CONSTRAINT `rol_privilegio_ibfk_2` FOREIGN KEY (`Id_Privilegio`) REFERENCES `privilegio` (`Id_Privilegio`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
