-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-05-2021 a las 14:55:38
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.11

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
-- Estructura de tabla para la tabla `agentes`
--

CREATE TABLE `agentes` (
  `dni` int(15) NOT NULL,
  `Agente` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Celular` varchar(25) NOT NULL,
  `Direccion` varchar(200) NOT NULL,
  `id_estado` int(5) NOT NULL DEFAULT 7,
  `Vence` date DEFAULT NULL,
  `OBS` varchar(255) NOT NULL,
  `Activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `agentes`
--

INSERT INTO `agentes` (`dni`, `Agente`, `Celular`, `Direccion`, `id_estado`, `Vence`, `OBS`, `Activo`) VALUES
(333, 'Borrar', '555', '', 7, NULL, '', 0),
(11889834, 'Luis Albamonte', '11 5482 6951', '', 8, '2020-09-10', 'Sin drogas ni alcohol', 1),
(13158500, 'Eduardo Morgan', '15 4577 8427', '', 4, '2022-03-25', 'Sin altura', 1),
(17611227, 'Darío Moreda', '11 3034 8609 ', '', 7, '2020-12-15', '', 1),
(20507223, 'José Luis Cardullo', '11 6799 4799', '', 7, '2021-04-01', 'Chofer', 1),
(22608997, 'Marcos Gabriel Ojeda', '11 3096 2304', '', 7, '2021-02-10', 'Microhematuria', 1),
(23722925, 'Luis Marcelo Cabrera', '1164773557', '', 3, '2020-12-16', 'FALTAN EEG-PSICOTEST Y ESTUDIOS AUDIOMETRICOS COMPLETOS. Turno 16-04-2021', 1),
(24549398, 'Daniel Gallo', '15 6866 0174', '', 7, '2021-02-15', 'H.T.A. alta - Turno 19-04-2021', 1),
(24822325, 'Raul Antonio Zaliega', '15 5417 9191', '', 4, '2021-09-01', 'No Apto Altura', 1),
(25824337, 'Javier Rubén Alberto Lopez', '11 4098 9888', '', 7, '2021-02-13', 'CITAR POR ERITRO ELEVADO 45 mm 1hs', 1),
(26145001, 'Nestor Hugo Mattei', '15 3459 7700', 'Calle 854 nº2342 San Francisco Solano, Quilmes. Entre 894 y 895', 2, '2021-02-10', 'TURNO 21-04-2021', 1),
(26274783, 'Diego Machado', '', '', 7, NULL, '', 0),
(26328612, 'Gustavo Fariña', '11 3655 8294', '', 4, '2021-07-15', 'Apto Altura. Habilitado Edenor', 1),
(26558634, 'José Luis Quiroz', '', '', 8, '2021-02-10', 'Ver Gallo', 1),
(27048478, 'Alejandro Ramirez', '11 6101 4383', '', 7, '2020-07-15', 'Globulos Blancos elevados', 1),
(27152585, 'Edgardo Salvador Flores', '11 5041 6454', 'Calle 9 s/n manzana 7 edificio 6 Claypole, Alte. Brown, BA', 4, '2022-02-24', 'Apto Altura', 1),
(27727804, 'Pablo Aranda', '11 6201 0825', '', 7, '2021-02-12', 'Glucemia Alta', 1),
(28131069, 'Diego Armando Suarez', '11 3597 7827', 'Bogotá 4870, Ezpeleta, Quilmes', 8, '2021-02-26', 'No quiere hacer servicios. Habilitado Edenor.', 1),
(28946756, 'Andres Manzo', '11 6737 9075', '', 7, '2020-02-08', 'Renunció 08-04-2021', 0),
(29006842, 'Hector Nuñez', '11 6908 6879', '', 7, '2020-12-10', '', 1),
(30086782, 'Hugo Hoffmann', '11 6372 6374', 'Sempere 3513, Claypole (casa)', 7, '2022-02-24', 'Globulos Blancos elevados 12400. Habilitado Edenor', 1),
(31650688, 'Pablo Emanuel Alonso', '11 5369 7148', '', 7, '2021-11-02', 'APTO C - LITIASIS BILIAR-HTA - CONTROL Y TTO', 1),
(32811694, 'Sergio Zabalegui', '', '', 7, '2021-04-01', 'No hace servicios.', 1),
(37171789, 'Fernando Sebastian Waisan', '11 5002 7041', '', 2, '2021-04-15', 'TURNO 21-04-2021', 1),
(38266927, 'Matías Ezequiel Mambrín', '11 6815 2517', '', 2, '2022-04-29', 'turno en PAL 23-04-2021', 1),
(42057714, 'Gustavo Anibal Castillo', '11 5812 3186', '', 4, '2022-04-22', 'Con Altura', 1),
(94187700, 'Josías Reyes', '', '', 8, '2020-09-10', 'Sin drogas ni alcohol', 1),
(94276863, 'Fermín Ruiz Villalba', '11 5011 8193', '', 4, '2022-03-11', 'Habilitado Edenor', 1),
(95336352, 'Ever Serrano Martinez', '11 6898 1410', '', 4, '2022-03-30', 'Con Altura', 1),
(95874459, 'Ronald Quijada', '', '', 8, NULL, 'Renunció año 2020', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `agentes`
--
ALTER TABLE `agentes`
  ADD PRIMARY KEY (`dni`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
