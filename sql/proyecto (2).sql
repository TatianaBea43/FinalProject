-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-05-2017 a las 17:45:53
-- Versión del servidor: 10.1.21-MariaDB
-- Versión de PHP: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto`
--
CREATE DATABASE IF NOT EXISTS `proyecto` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `proyecto`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno`
--

DROP TABLE IF EXISTS `alumno`;
CREATE TABLE `alumno` (
  `id` int(11) NOT NULL,
  `apellidos` varchar(45) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `dni` varchar(10) NOT NULL,
  `direccion` varchar(60) NOT NULL,
  `telefono` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `estudios` varchar(100) NOT NULL,
  `tecnologias` varchar(100) NOT NULL,
  `preferencias` varchar(100) NOT NULL,
  `id_tutor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `alumno`
--

INSERT INTO `alumno` (`id`, `apellidos`, `nombre`, `dni`, `direccion`, `telefono`, `email`, `estudios`, `tecnologias`, `preferencias`, `id_tutor`) VALUES
(60, 'Labraña Graña', 'Tatiana', '53114734Y', '', '660272514', 'tatianabeatriz43@hotmail.com', '', '', '', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

DROP TABLE IF EXISTS `empresas`;
CREATE TABLE `empresas` (
  `id` int(11) NOT NULL,
  `razon_social` varchar(100) NOT NULL,
  `direccion` varchar(60) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telefono` varchar(9) NOT NULL,
  `tutor` varchar(50) NOT NULL,
  `estado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`id`, `razon_social`, `direccion`, `email`, `telefono`, `tutor`, `estado`) VALUES
(1, 'Bobaloo', 'C/Juan xx', 'fsdfasd@hotmail.com', '999888777', 'Jose María', 1),
(2, 'Farfala', 'c/ Segovia 25', 'dasda@gmail.com', '999666333', 'fsdf', 0),
(3, 'Golondrina', 'fasdf', 'fsadfsd@email.com', '777888999', 'fasdfsd', 0),
(4, 'fdsfad', 'fsdfsd', 'fsdf@fmail.com', '778878999', 'fasdfasd', 1),
(5, 'gfadf', 'gdsfgdf', 'gadfgdf@gmail.com', '777888999', 'fasdfasd', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fct`
--

DROP TABLE IF EXISTS `fct`;
CREATE TABLE `fct` (
  `id` int(11) NOT NULL,
  `alumno` int(11) NOT NULL,
  `tutor` int(11) NOT NULL,
  `inicio` date NOT NULL,
  `fin` date NOT NULL,
  `horas` int(5) NOT NULL,
  `empresa` int(11) NOT NULL,
  `vacante` int(11) NOT NULL,
  `tutor_empresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fcthoras`
--

DROP TABLE IF EXISTS `fcthoras`;
CREATE TABLE `fcthoras` (
  `id` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `fecha` varchar(50) NOT NULL,
  `num_horas` tinyint(4) NOT NULL,
  `observaciones` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `fcthoras`
--

INSERT INTO `fcthoras` (`id`, `id_alumno`, `fecha`, `num_horas`, `observaciones`) VALUES
(9, 60, '18/05/2017', 3, 'fasdfasdfsd'),
(10, 60, '18/05/2017', 6, 'fasdfsadfsd'),
(11, 60, '18/05/2017', 6, 'gasdfsgd'),
(12, 60, '18/05/2017', 8, 'gadfgdfgdfg'),
(13, 60, '19/05/2017', 8, 'jbñpjkvñk'),
(14, 60, '18/05/2017', 5, 'ftSEFRSDF'),
(15, 60, '10/05/2017', 4, 'AFSDFSDF'),
(16, 60, '18/05/2017', 6, 'gadfgdf'),
(17, 60, '02/05/2017', 8, 'ghsdfgdfg'),
(18, 60, '11/05/2017', 3, 'fasdfsdfsda'),
(19, 60, '10/05/2017', 44, 'fasdfsdfasd'),
(20, 60, '18/05/2017', 3, 'fASDASD'),
(21, 60, '02/05/2017', 4, 'Dasdasd'),
(22, 60, '11/05/2017', 6, 'fasdfasd');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposusuario`
--

DROP TABLE IF EXISTS `tiposusuario`;
CREATE TABLE `tiposusuario` (
  `id` int(11) NOT NULL,
  `tipo` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tiposusuario`
--

INSERT INTO `tiposusuario` (`id`, `tipo`) VALUES
(1, 'admin'),
(2, 'alumno'),
(3, 'tutor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tutor`
--

DROP TABLE IF EXISTS `tutor`;
CREATE TABLE `tutor` (
  `id` int(11) NOT NULL,
  `apellidos` varchar(45) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `dni` varchar(10) NOT NULL,
  `telefono` int(11) NOT NULL,
  `email` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tutor`
--

INSERT INTO `tutor` (`id`, `apellidos`, `nombre`, `dni`, `telefono`, `email`) VALUES
(4, '', '', '', 0, ''),
(7, 'Pérez', 'Arturo', '53114734Y', 369225588, 'arturo@gmail.com'),
(57, 'Labraña Graña', 'Rogelia', '53114734Y', 660272514, 'tatianabeatriz43@hotmail.com'),
(58, 'Labraña Graña', 'Tatiana Beatriz', '53114734Y', 660272514, 'tatianabeatriz43@hotmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tutor_empresa`
--

DROP TABLE IF EXISTS `tutor_empresa`;
CREATE TABLE `tutor_empresa` (
  `id` int(11) NOT NULL,
  `apellidos` varchar(45) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `email` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `usuario` varchar(25) NOT NULL,
  `passwd` varchar(100) NOT NULL,
  `tipousuario` int(11) NOT NULL,
  `alta` datetime NOT NULL,
  `baja` datetime NOT NULL,
  `activo` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `usuario`, `passwd`, `tipousuario`, `alta`, `baja`, `activo`) VALUES
(46, 'administrador', '$2y$10$7fmgwD4e5wohWxiNV7bNn.RljZ0GpLSIRA3E0byAXkPX3c.tpeWz.', 1, '2017-05-13 21:20:37', '0000-00-00 00:00:00', 1),
(60, 'FCT17LabTat', '$2y$10$PLvYpBvTzQO/M3t8czrc8OxZ/sP4te4ggQe127y7onpnHVuBMbPre', 2, '2017-05-18 01:39:12', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vacante`
--

DROP TABLE IF EXISTS `vacante`;
CREATE TABLE `vacante` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `ciclo_solicitado` varchar(25) NOT NULL,
  `tecnologias` varchar(100) NOT NULL,
  `empresa` int(11) NOT NULL,
  `estado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `fct`
--
ALTER TABLE `fct`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `fcthoras`
--
ALTER TABLE `fcthoras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tiposusuario`
--
ALTER TABLE `tiposusuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tutor`
--
ALTER TABLE `tutor`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tutor_empresa`
--
ALTER TABLE `tutor_empresa`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `vacante`
--
ALTER TABLE `vacante`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `fct`
--
ALTER TABLE `fct`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `fcthoras`
--
ALTER TABLE `fcthoras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT de la tabla `tiposusuario`
--
ALTER TABLE `tiposusuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `tutor_empresa`
--
ALTER TABLE `tutor_empresa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT de la tabla `vacante`
--
ALTER TABLE `vacante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
