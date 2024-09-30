-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-11-2023 a las 03:02:31
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `muebloide`
--
CREATE DATABASE IF NOT EXISTS `muebloide` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `muebloide`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulo`
--

CREATE TABLE IF NOT EXISTS `articulo` (
  `id_articulo` int(11) NOT NULL AUTO_INCREMENT,
  `id_categoria` tinyint(4) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `precio` float NOT NULL,
  `alto` float NOT NULL,
  `ancho` float NOT NULL,
  `profundidad` float NOT NULL,
  `imagePath` varchar(60) NOT NULL,
  PRIMARY KEY (`id_articulo`),
  KEY `id_categoria` (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `articulo`
--

INSERT INTO `articulo` (`id_articulo`, `id_categoria`, `nombre`, `precio`, `alto`, `ancho`, `profundidad`, `imagePath`) VALUES
(2, 1, 'Mesa de roble', 97599, 100, 80, 140, ''),
(3, 2, 'Silla de pino', 14500, 127, 40, 40, 'images/silla de pino.jpg'),
(4, 1, 'Mesa circular', 57000, 100, 130, 130, 'images/mesita.jpg'),
(5, 3, 'Futón de 2 cuerpos', 127900, 78, 160, 60, ''),
(6, 1, 'Mesa de Cristal', 172301, 75, 120, 80, ''),
(7, 2, 'Silla de Oficina', 79999, 90, 60, 50, ''),
(8, 3, 'Sillon Reclinable', 56500, 100, 85, 90, ''),
(9, 4, 'Cama King Size', 247110, 40, 200, 220, ''),
(10, 7, 'Comoda de Dormitorio', 51149.7, 80, 100, 40, ''),
(11, 6, 'Escritorio de Estudio', 129000, 75, 120, 60, ''),
(12, 1, 'Mesa de Centro', 347500, 45, 90, 60, ''),
(13, 2, 'Silla de Comedor', 16905.2, 95, 50, 45, ''),
(14, 3, 'Sillon de Relax', 349099, 110, 75, 85, ''),
(15, 4, 'Cama Individual', 139990, 75, 90, 200, ''),
(36, 1, 'Prueba con seguridad', 99999, 105, 55, 207, ''),
(37, 1, 'Prueba con seguridad', 99999, 105, 55, 207, ''),
(38, 1, 'Prueba con seguridad', 99999, 105, 55, 207, ''),
(39, 1, 'Prueba Nahue', 99999, 105, 55, 207, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `id_categoria` tinyint(4) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(30) NOT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `tipo`) VALUES
(1, 'Mesa'),
(2, 'Silla'),
(3, 'Sillon'),
(4, 'Cama'),
(6, 'Escritorio'),
(7, 'Comoda'),
(15, 'Mesada'),
(16, 'Muebles de exterior'),
(17, 'Muebles de exterior');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `email` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `password` varchar(80) NOT NULL,
  `apikey` varchar(100) NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`email`, `nombre`, `password`, `apikey`) VALUES
('nahuelseguel@gmail.com', 'Nahuel Seguel', '$2y$10$kAfxgVZ5hJK6Flf4JeKAe.ZlPtF197A/jB29txQSHJLZEAQ/BnmvG', '$2y$10$w6ATQYSLhFjFPaEbCIa3UuASUAaEehwsl4msp4FrjfRAfdKZ8nS1y'),
('pablodem32@gmail.com', 'Pablo Demateo', '$2y$10$rVoFGmLImp8QKwXIGP7VQeMwIoWaikZDBkLL8PB9D8/PBPfwdojfy', 'uKhVH94MJYlVRoAWQqdkvQt4lGJfttHpeojzC9hewwxCrShZiprD1rtCYzPw9OH4J2bhF++X/+lVkmQci+BLlA=='),
('webadmin', 'Administrador', '$2y$10$FF6r02TU9nzHXMJwm6jEo.UpI6RWVVuNc.kFZrAh9PIcADEcp2v2u', '$2y$10$x4LMsDG0R/f3vWuvIT4cK.Xfwxv/fF6OLYRjweEdMC4fGbMpr0NNm');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articulo`
--
ALTER TABLE `articulo`
  ADD CONSTRAINT `articulo_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
