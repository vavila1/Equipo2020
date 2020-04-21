-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2020 at 05:57 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `almacenciasa`
--

-- --------------------------------------------------------

--
-- Table structure for table `almacen`
--

CREATE TABLE `almacen` (
  `id` int(10) NOT NULL,
  `id_estado` int(10) DEFAULT NULL,
  `nombre` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `almacen`
--

INSERT INTO `almacen` (`id`, `id_estado`, `nombre`) VALUES
(2, 8, 'Almacen BC'),
(3, 7, 'Almacen Chiapas'),
(4, 20, 'Almacen Chichuahua'),
(5, 12, 'Almacen  coahuila'),
(6, 19, 'Almacen  Guanajuato'),
(7, 11, 'Almacen Guerrero'),
(8, 15, 'Almacen Hidalgo'),
(9, 3, 'Almacen Jalisco'),
(10, 5, 'Almacen Michoacan'),
(11, 13, 'Almacen Morelos'),
(12, 18, 'Almacen  Nayarit'),
(13, 9, 'Almacen NL'),
(14, 2, 'Almacen  QRO'),
(15, 16, 'Almacen  QROO'),
(16, 6, 'Almacen  SNL'),
(17, 17, 'Almacen  Tabasco'),
(18, 1, 'Almacen Tamaulipas'),
(19, 4, 'Almacen Yucatan');

-- --------------------------------------------------------

--
-- Table structure for table `cuenta`
--

CREATE TABLE `cuenta` (
  `Id_Cuenta` int(10) NOT NULL,
  `Id_Empleado` int(10) DEFAULT NULL,
  `Usuario` varchar(20) DEFAULT NULL,
  `Contraseña` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cuenta`
--

INSERT INTO `cuenta` (`Id_Cuenta`, `Id_Empleado`, `Usuario`, `Contraseña`) VALUES
(1, 1, 'MarcoAdmin', '123456'),
(3, 3, 'Username2', 'avion1234'),
(4, 4, 'Username3', 'casa1234'),
(7, 4, 'Admin', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `cuenta_rol`
--

CREATE TABLE `cuenta_rol` (
  `Id_Cuenta` int(10) NOT NULL,
  `Id_Rol` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cuenta_rol`
--

INSERT INTO `cuenta_rol` (`Id_Cuenta`, `Id_Rol`) VALUES
(1, 6),
(3, 7),
(4, 10),
(7, 6);

-- --------------------------------------------------------

--
-- Table structure for table `empleado`
--

CREATE TABLE `empleado` (
  `Id_Empleado` int(10) NOT NULL,
  `Id_Puesto` int(10) DEFAULT NULL,
  `Correo` varchar(50) DEFAULT NULL,
  `Nombre` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `empleado`
--

INSERT INTO `empleado` (`Id_Empleado`, `Id_Puesto`, `Correo`, `Nombre`) VALUES
(1, 1, 'tkumar.kvishal@designingenium.com', 'Marco '),
(2, 2, 'fmohamad-sh32@betaboks.org', 'Juan'),
(3, 2, 'hdempapa508@flexninori.ga', 'Andrés'),
(4, 2, 'zeronax6@lordfkas.tk', 'Eduardo'),
(5, 3, 'rlethiap@hghhumangrowthhormones.com', 'Javier'),
(6, 4, 'gmessaoud39ss@betaboks.org', 'Jaime');

-- --------------------------------------------------------

--
-- Table structure for table `entregan`
--

CREATE TABLE `entregan` (
  `Id_Transaccion` int(10) NOT NULL,
  `Id_Producto` int(10) NOT NULL,
  `Id_Almacen` int(10) NOT NULL,
  `Id_Empleado` int(10) NOT NULL,
  `Fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `entregan`
--

INSERT INTO `entregan` (`Id_Transaccion`, `Id_Producto`, `Id_Almacen`, `Id_Empleado`, `Fecha`) VALUES
(2, 4, 14, 1, '2020-04-15 14:53:57'),
(2, 6, 14, 2, '2020-04-15 14:53:57');

-- --------------------------------------------------------

--
-- Table structure for table `estado`
--

CREATE TABLE `estado` (
  `id` int(10) NOT NULL,
  `nombre` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `estado`
--

INSERT INTO `estado` (`id`, `nombre`) VALUES
(1, 'Tamaulipas'),
(2, 'Queretaro'),
(3, 'Jalsco'),
(4, 'Yucatan'),
(5, 'Michoacan'),
(6, 'Sinaloa'),
(7, 'Chiapas'),
(8, 'Baja California'),
(9, 'Nuevo León'),
(10, 'Sonora'),
(11, 'Guerrero'),
(12, 'Coahuila'),
(13, 'Morelos'),
(14, 'Zacatecas'),
(15, 'Hidalgo'),
(16, 'Quinata Roo'),
(17, 'Tabasco'),
(18, 'Nayarit'),
(19, 'Guanajuato'),
(20, 'Chihuahua');

-- --------------------------------------------------------

--
-- Table structure for table `estatusproyecto`
--

CREATE TABLE `estatusproyecto` (
  `Id_EstatusProyecto` int(10) NOT NULL,
  `Nombre` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `estatusproyecto`
--

INSERT INTO `estatusproyecto` (`Id_EstatusProyecto`, `Nombre`) VALUES
(1, 'Terminado'),
(2, 'Pendiente'),
(3, 'Suspendido'),
(4, 'En proceso');

-- --------------------------------------------------------

--
-- Table structure for table `estatus_producto`
--

CREATE TABLE `estatus_producto` (
  `id` int(10) NOT NULL,
  `nombre` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `estatus_producto`
--

INSERT INTO `estatus_producto` (`id`, `nombre`) VALUES
(1, 'Agotado'),
(2, 'Disponible'),
(3, 'Prestado'),
(4, 'En reparacion'),
(5, 'Descompuesto');

-- --------------------------------------------------------

--
-- Table structure for table `marca`
--

CREATE TABLE `marca` (
  `id` int(10) NOT NULL,
  `nombre` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `marca`
--

INSERT INTO `marca` (`id`, `nombre`) VALUES
(1, 'Trupper'),
(2, 'Vitromex'),
(3, 'DeWalt'),
(4, 'Makita'),
(5, 'Bosch'),
(6, 'Milwaukee'),
(7, 'Einhell'),
(8, 'Tacklife'),
(9, 'Stanley'),
(10, 'Bellota'),
(11, 'Coca Cola'),
(12, 'Pepsi'),
(13, 'Bubulubu'),
(14, 'Pixar'),
(15, 'Totis');

-- --------------------------------------------------------

--
-- Table structure for table `privilegio`
--

CREATE TABLE `privilegio` (
  `Id_Privilegio` int(10) NOT NULL,
  `Nombre` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `privilegio`
--

INSERT INTO `privilegio` (`Id_Privilegio`, `Nombre`) VALUES
(1, 'Ver'),
(2, 'Editar'),
(3, 'Eliminar'),
(4, 'Registar'),
(5, 'Consultar');

-- --------------------------------------------------------

--
-- Table structure for table `producto`
--

CREATE TABLE `producto` (
  `id` int(10) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `cantidad` int(10) DEFAULT NULL,
  `precio` int(10) DEFAULT NULL,
  `id_marca` int(10) DEFAULT NULL,
  `id_estatus` int(10) DEFAULT NULL,
  `id_tipo` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `producto`
--

INSERT INTO `producto` (`id`, `nombre`, `cantidad`, `precio`, `id_marca`, `id_estatus`, `id_tipo`) VALUES
(4, 'Panel de Vidrio 10 metros cuadrados', 10, 1000, 2, 2, 1),
(6, 'Panel vidrio 11 metros cuadrados', 4, 750, 2, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `producto_proyecto`
--

CREATE TABLE `producto_proyecto` (
  `id` int(10) NOT NULL,
  `Id_Producto` int(10) DEFAULT NULL,
  `Id_Proyecto` int(10) DEFAULT NULL,
  `Cantidad_Asignada` int(10) DEFAULT NULL,
  `Fecha_Asignacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `producto_proyecto`
--

INSERT INTO `producto_proyecto` (`id`, `Id_Producto`, `Id_Proyecto`, `Cantidad_Asignada`, `Fecha_Asignacion`) VALUES
(2, 4, 1, 2, '2020-04-17 18:38:59');

-- --------------------------------------------------------

--
-- Table structure for table `proyecto`
--

CREATE TABLE `proyecto` (
  `Id_Proyecto` int(10) NOT NULL,
  `Id_EstatusProyecto` int(10) DEFAULT NULL,
  `Nombre` varchar(10) DEFAULT NULL,
  `Fecha_Inicio` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Fecha_Fin` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `proyecto`
--

INSERT INTO `proyecto` (`Id_Proyecto`, `Id_EstatusProyecto`, `Nombre`, `Fecha_Inicio`, `Fecha_Fin`) VALUES
(1, 4, 'Oxxo venta', '2020-04-15 14:51:24', '0000-00-00 00:00:00'),
(2, 1, 'Carretara ', '2020-04-15 14:51:24', '0000-00-00 00:00:00'),
(25, 1, 'Proyecto 1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `puesto`
--

CREATE TABLE `puesto` (
  `Id_Puesto` int(10) NOT NULL,
  `Nombre` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `puesto`
--

INSERT INTO `puesto` (`Id_Puesto`, `Nombre`) VALUES
(1, 'Administrador'),
(2, 'Almacenista'),
(3, 'Obrero'),
(4, 'Supervisor de obra');

-- --------------------------------------------------------

--
-- Table structure for table `rol`
--

CREATE TABLE `rol` (
  `Id_Rol` int(10) NOT NULL,
  `Nombre` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rol`
--

INSERT INTO `rol` (`Id_Rol`, `Nombre`) VALUES
(6, 'Administrador'),
(7, 'Almacenista'),
(8, 'Obrero'),
(9, 'Supervisor de obra'),
(10, 'Servicio al cliente');

-- --------------------------------------------------------

--
-- Table structure for table `rol_privilegio`
--

CREATE TABLE `rol_privilegio` (
  `Id_Rol` int(10) NOT NULL,
  `Id_Privilegio` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rol_privilegio`
--

INSERT INTO `rol_privilegio` (`Id_Rol`, `Id_Privilegio`) VALUES
(6, 1),
(6, 2),
(6, 3),
(6, 4),
(6, 5),
(7, 1),
(7, 2),
(10, 1),
(10, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tipo_producto`
--

CREATE TABLE `tipo_producto` (
  `id` int(10) NOT NULL,
  `nombre` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tipo_producto`
--

INSERT INTO `tipo_producto` (`id`, `nombre`) VALUES
(1, 'Consumible'),
(2, 'Herramienta'),
(3, 'Perecedero');

-- --------------------------------------------------------

--
-- Table structure for table `transaccion`
--

CREATE TABLE `transaccion` (
  `Id_Transaccion` int(10) NOT NULL,
  `Nombre` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaccion`
--

INSERT INTO `transaccion` (`Id_Transaccion`, `Nombre`) VALUES
(1, 'Llegada'),
(2, 'Salida');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `almacen`
--
ALTER TABLE `almacen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_estado` (`id_estado`);

--
-- Indexes for table `cuenta`
--
ALTER TABLE `cuenta`
  ADD PRIMARY KEY (`Id_Cuenta`),
  ADD KEY `Id_Empleado` (`Id_Empleado`);

--
-- Indexes for table `cuenta_rol`
--
ALTER TABLE `cuenta_rol`
  ADD PRIMARY KEY (`Id_Cuenta`,`Id_Rol`),
  ADD KEY `Id_Rol` (`Id_Rol`);

--
-- Indexes for table `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`Id_Empleado`),
  ADD KEY `Id_Puesto` (`Id_Puesto`);

--
-- Indexes for table `entregan`
--
ALTER TABLE `entregan`
  ADD PRIMARY KEY (`Id_Transaccion`,`Id_Producto`,`Id_Almacen`,`Id_Empleado`),
  ADD KEY `Id_Producto` (`Id_Producto`),
  ADD KEY `Id_Almacen` (`Id_Almacen`),
  ADD KEY `Id_Empleado` (`Id_Empleado`);

--
-- Indexes for table `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `estatusproyecto`
--
ALTER TABLE `estatusproyecto`
  ADD PRIMARY KEY (`Id_EstatusProyecto`);

--
-- Indexes for table `estatus_producto`
--
ALTER TABLE `estatus_producto`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `privilegio`
--
ALTER TABLE `privilegio`
  ADD PRIMARY KEY (`Id_Privilegio`);

--
-- Indexes for table `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_marca` (`id_marca`),
  ADD KEY `id_estatus` (`id_estatus`),
  ADD KEY `id_tipo` (`id_tipo`);

--
-- Indexes for table `producto_proyecto`
--
ALTER TABLE `producto_proyecto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Id_Proyecto` (`Id_Proyecto`),
  ADD KEY `Id_Producto` (`Id_Producto`);

--
-- Indexes for table `proyecto`
--
ALTER TABLE `proyecto`
  ADD PRIMARY KEY (`Id_Proyecto`),
  ADD KEY `Id_EstatusProyecto` (`Id_EstatusProyecto`);

--
-- Indexes for table `puesto`
--
ALTER TABLE `puesto`
  ADD PRIMARY KEY (`Id_Puesto`);

--
-- Indexes for table `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`Id_Rol`);

--
-- Indexes for table `rol_privilegio`
--
ALTER TABLE `rol_privilegio`
  ADD PRIMARY KEY (`Id_Rol`,`Id_Privilegio`),
  ADD KEY `Id_Privilegio` (`Id_Privilegio`);

--
-- Indexes for table `tipo_producto`
--
ALTER TABLE `tipo_producto`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaccion`
--
ALTER TABLE `transaccion`
  ADD PRIMARY KEY (`Id_Transaccion`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `almacen`
--
ALTER TABLE `almacen`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `cuenta`
--
ALTER TABLE `cuenta`
  MODIFY `Id_Cuenta` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `empleado`
--
ALTER TABLE `empleado`
  MODIFY `Id_Empleado` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `estado`
--
ALTER TABLE `estado`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `estatusproyecto`
--
ALTER TABLE `estatusproyecto`
  MODIFY `Id_EstatusProyecto` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `estatus_producto`
--
ALTER TABLE `estatus_producto`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `marca`
--
ALTER TABLE `marca`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `privilegio`
--
ALTER TABLE `privilegio`
  MODIFY `Id_Privilegio` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `producto_proyecto`
--
ALTER TABLE `producto_proyecto`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `puesto`
--
ALTER TABLE `puesto`
  MODIFY `Id_Puesto` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rol`
--
ALTER TABLE `rol`
  MODIFY `Id_Rol` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tipo_producto`
--
ALTER TABLE `tipo_producto`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transaccion`
--
ALTER TABLE `transaccion`
  MODIFY `Id_Transaccion` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `almacen`
--
ALTER TABLE `almacen`
  ADD CONSTRAINT `almacen_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id`);

--
-- Constraints for table `cuenta`
--
ALTER TABLE `cuenta`
  ADD CONSTRAINT `cuenta_ibfk_1` FOREIGN KEY (`Id_Empleado`) REFERENCES `empleado` (`Id_Empleado`);

--
-- Constraints for table `cuenta_rol`
--
ALTER TABLE `cuenta_rol`
  ADD CONSTRAINT `cuenta_rol_ibfk_1` FOREIGN KEY (`Id_Rol`) REFERENCES `rol` (`Id_Rol`),
  ADD CONSTRAINT `cuenta_rol_ibfk_2` FOREIGN KEY (`Id_Cuenta`) REFERENCES `cuenta` (`Id_Cuenta`);

--
-- Constraints for table `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `empleado_ibfk_1` FOREIGN KEY (`Id_Puesto`) REFERENCES `puesto` (`Id_Puesto`);

--
-- Constraints for table `entregan`
--
ALTER TABLE `entregan`
  ADD CONSTRAINT `entregan_ibfk_1` FOREIGN KEY (`Id_Transaccion`) REFERENCES `transaccion` (`Id_Transaccion`),
  ADD CONSTRAINT `entregan_ibfk_2` FOREIGN KEY (`Id_Producto`) REFERENCES `producto` (`id`),
  ADD CONSTRAINT `entregan_ibfk_3` FOREIGN KEY (`Id_Almacen`) REFERENCES `almacen` (`id`),
  ADD CONSTRAINT `entregan_ibfk_4` FOREIGN KEY (`Id_Empleado`) REFERENCES `empleado` (`Id_Empleado`);

--
-- Constraints for table `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`id_marca`) REFERENCES `marca` (`id`),
  ADD CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`id_estatus`) REFERENCES `estatus_producto` (`id`),
  ADD CONSTRAINT `producto_ibfk_3` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_producto` (`id`);

--
-- Constraints for table `producto_proyecto`
--
ALTER TABLE `producto_proyecto`
  ADD CONSTRAINT `producto_proyecto_ibfk_1` FOREIGN KEY (`Id_Proyecto`) REFERENCES `proyecto` (`Id_Proyecto`),
  ADD CONSTRAINT `producto_proyecto_ibfk_2` FOREIGN KEY (`Id_Producto`) REFERENCES `producto` (`id`);

--
-- Constraints for table `proyecto`
--
ALTER TABLE `proyecto`
  ADD CONSTRAINT `proyecto_ibfk_1` FOREIGN KEY (`Id_EstatusProyecto`) REFERENCES `estatusproyecto` (`Id_EstatusProyecto`);

--
-- Constraints for table `rol_privilegio`
--
ALTER TABLE `rol_privilegio`
  ADD CONSTRAINT `rol_privilegio_ibfk_1` FOREIGN KEY (`Id_Rol`) REFERENCES `rol` (`Id_Rol`),
  ADD CONSTRAINT `rol_privilegio_ibfk_2` FOREIGN KEY (`Id_Privilegio`) REFERENCES `privilegio` (`Id_Privilegio`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
