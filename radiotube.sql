-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 25-03-2016 a las 11:52:52
-- Versión del servidor: 10.0.17-MariaDB
-- Versión de PHP: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `radiotube`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentario`
--

CREATE TABLE `comentario` (
  `id` int(11) NOT NULL,
  `videoId` int(11) NOT NULL,
  `comentario` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valoracion`
--

CREATE TABLE `valoracion` (
  `id` int(11) NOT NULL,
  `videoId` int(11) NOT NULL,
  `valoracion` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `video`
--

CREATE TABLE `video` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `autor` varchar(255) DEFAULT NULL,
  `descripcion` text,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `videoId` (`videoId`);

--
-- Indices de la tabla `valoracion`
--
ALTER TABLE `valoracion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `videoId` (`videoId`);

--
-- Indices de la tabla `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentario`
--
ALTER TABLE `comentario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT de la tabla `valoracion`
--
ALTER TABLE `valoracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT de la tabla `video`
--
ALTER TABLE `video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD CONSTRAINT `comentario_ibfk_1` FOREIGN KEY (`videoId`) REFERENCES `video` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `valoracion`
--
ALTER TABLE `valoracion`
  ADD CONSTRAINT `valoracion_ibfk_1` FOREIGN KEY (`videoId`) REFERENCES `video` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
