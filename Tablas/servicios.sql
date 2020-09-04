-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-09-2020 a las 17:41:32
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `task`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id` int(5) NOT NULL,
  `Nombre` varchar(200) DEFAULT NULL,
  `OpRef` int(5) DEFAULT NULL,
  `idCliente1` int(5) DEFAULT NULL,
  `OpServicio` int(5) DEFAULT NULL,
  `idCliente2` int(5) DEFAULT NULL,
  `Trabajo` varchar(255) DEFAULT NULL,
  `Lugar` varchar(255) DEFAULT NULL,
  `FechaIni` date DEFAULT NULL,
  `FechaFin` date DEFAULT NULL,
  `Estado` varchar(30) DEFAULT NULL,
  `OBS` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id`, `Nombre`, `OpRef`, `idCliente1`, `OpServicio`, `idCliente2`, `Trabajo`, `Lugar`, `FechaIni`, `FechaFin`, `Estado`, `OBS`) VALUES
(2, 'abc', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'pru2', 5555, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'pru3', 5526, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'pru4', 5556, 16, 5557, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'pru5', 5601, 6, 5602, 17, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'pru6', 5605, 321, 5606, 128, 'Tra 1', NULL, NULL, NULL, NULL, NULL),
(8, 'Pru7', 5608, 170, 5609, 172, 'Puesta en servicio', 'La Rioja', NULL, NULL, NULL, NULL),
(9, 'pru8', 5422, 89, 5423, 148, 'Cambio', 'Bahia', '2020-09-04', NULL, NULL, NULL),
(10, 'pru9', 4408, 280, 4409, 288, 'Puesta en servicio', 'Andalgala', '2020-08-31', '2020-09-04', NULL, NULL),
(11, 'pru11', 5122, 158, 5123, 170, 'puesta en s', 'Tandil', '2020-08-04', '2020-08-06', '4', '                         ninguna               ');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
