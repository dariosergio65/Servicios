-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-09-2020 a las 17:43:06
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
-- Estructura de tabla para la tabla `vendedores`
--

CREATE TABLE `vendedores` (
  `id` int(5) NOT NULL DEFAULT 0,
  `Vendedor` varchar(17) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `vendedores`
--

INSERT INTO `vendedores` (`id`, `Vendedor`) VALUES
(1, 'Luis Vela'),
(2, 'Hugo Lopez'),
(3, 'NN'),
(4, 'CESAR VILLAGRA'),
(5, 'Andres Manzo'),
(6, 'FABIAN LLAMAZARES'),
(7, 'JONATAN GONZALEZ'),
(8, 'LIONEL MOCCIA'),
(9, 'FABIAN LLAMAZAREZ'),
(10, 'JONATAN JONZALEZ'),
(11, 'JONATAN GONZALES'),
(12, 'FABIAN LLMAZAREZ'),
(13, 'ROBERT SCHUMAN'),
(14, 'ROBERT SHUMAN'),
(15, 'RODRIGO IGLESIAS'),
(16, 'ROBERT'),
(17, 'CESAR SANTORO');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
