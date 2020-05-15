-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-05-2020 a las 21:56:54
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
LIMIT 3;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacen`
--

CREATE TABLE `almacen` (
  `id` int(10) NOT NULL,
  `id_estado` int(10) DEFAULT NULL,
  `nombre` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `almacen`
--

INSERT INTO `almacen` (`id`, `id_estado`, `nombre`) VALUES
(1, 1, 'Almacen queretaro'),
(2, 7, 'Almacen Monterrey'),
(3, 5, 'Almacen Sinaloa'),
(4, 4, 'alamcen jalisco');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta`
--

CREATE TABLE `cuenta` (
  `Id_Cuenta` int(10) NOT NULL,
  `Id_Empleado` int(10) DEFAULT NULL,
  `Usuario` varchar(20) DEFAULT NULL,
  `Contraseña` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cuenta`
--

INSERT INTO `cuenta` (`Id_Cuenta`, `Id_Empleado`, `Usuario`, `Contraseña`) VALUES
(2, 2, 'Admin', 'Admin'),
(3, 3, 'Admin2', 'Admin2');

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
(3, 1);

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
(3, 1, 3, 'sinaloa@.com', 'Marco sinaloa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entregan`
--

CREATE TABLE `entregan` (
  `Id_Transaccion` int(10) NOT NULL,
  `Id_Producto` int(10) NOT NULL,
  `Id_Empleado` int(10) NOT NULL,
  `Fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `entregan`
--

INSERT INTO `entregan` (`Id_Transaccion`, `Id_Producto`, `Id_Empleado`, `Fecha`) VALUES
(1, 1, 2, '2020-05-12 19:06:20');

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
(6, 'Disponible');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `e_p`
--

CREATE TABLE `e_p` (
  `Id_Producto` int(10) NOT NULL,
  `Id_Estado_producto` int(10) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `e_p`
--

INSERT INTO `e_p` (`Id_Producto`, `Id_Estado_producto`, `fecha`) VALUES
(1, 1, '2020-05-12 19:05:44'),
(1, 3, '2020-05-12 19:06:00'),
(3, 2, '2020-05-12 19:26:30'),
(5, 3, '2020-05-14 17:56:15'),
(7, 6, '2020-05-14 18:08:31'),
(8, 6, '2020-05-14 19:57:05'),
(9, 6, '2020-05-14 20:06:12'),
(10, 6, '2020-05-14 20:09:00');

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
(6, 'Nike');

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
(7, 'Registar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` int(10) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
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

INSERT INTO `producto` (`id`, `nombre`, `cantidad`, `precio`, `id_marca`, `id_tipo`, `Id_Almacen`, `Id_Estatus`) VALUES
(11, 'Martillo', 1, 1222, 1, 1, 1, 6);

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
(1, 1, 1, 1, '2020-05-12 19:06:36');

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
(0, 1, 'Proyecto 1', '2020-05-12 18:52:31', NULL),
(1, 5, 'Oxxo', '2020-05-12 19:09:58', NULL),
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
(1, 'Administrador');

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
(1, 6);

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
(3, 'Perecedero');

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
(2, 'llegada');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `almacen`
--
ALTER TABLE `almacen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_estado` (`id_estado`);

--
-- Indices de la tabla `cuenta`
--
ALTER TABLE `cuenta`
  ADD PRIMARY KEY (`Id_Cuenta`),
  ADD KEY `Id_Empleado` (`Id_Empleado`);

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
  ADD PRIMARY KEY (`Id_Transaccion`,`Id_Producto`,`Id_Empleado`),
  ADD KEY `Id_Producto` (`Id_Producto`),
  ADD KEY `Id_Empleado` (`Id_Empleado`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
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
  ADD PRIMARY KEY (`Id_Producto`,`Id_Estado_producto`),
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
  MODIFY `Id_Cuenta` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `Id_Empleado` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `estatusproyecto`
--
ALTER TABLE `estatusproyecto`
  MODIFY `Id_EstatusProyecto` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `estatus_producto`
--
ALTER TABLE `estatus_producto`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `privilegio`
--
ALTER TABLE `privilegio`
  MODIFY `Id_Privilegio` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `producto_proyecto`
--
ALTER TABLE `producto_proyecto`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `puesto`
--
ALTER TABLE `puesto`
  MODIFY `Id_Puesto` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `Id_Rol` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tipo_producto`
--
ALTER TABLE `tipo_producto`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `transaccion`
--
ALTER TABLE `transaccion`
  MODIFY `Id_Transaccion` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `almacen`
--
ALTER TABLE `almacen`
  ADD CONSTRAINT `almacen_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id`);

--
-- Filtros para la tabla `cuenta`
--
ALTER TABLE `cuenta`
  ADD CONSTRAINT `cuenta_ibfk_1` FOREIGN KEY (`Id_Empleado`) REFERENCES `empleado` (`Id_Empleado`);

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
  ADD CONSTRAINT `e_p_ibfk_1` FOREIGN KEY (`Id_Producto`) REFERENCES `producto` (`id`),
  ADD CONSTRAINT `e_p_ibfk_2` FOREIGN KEY (`Id_Estado_producto`) REFERENCES `estatus_producto` (`id`);

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
