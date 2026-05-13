-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: fdb1029.awardspace.net
-- Tiempo de generación: 13-05-2026 a las 15:33:47
-- Versión del servidor: 8.0.32
-- Versión de PHP: 8.1.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `4499402_rentamobiliario`
--

CREATE DATABASE IF NOT EXISTS `4499402_rentamobiliario`
DEFAULT CHARACTER SET utf8mb4
COLLATE utf8mb4_0900_ai_ci;

USE `4499402_rentamobiliario`;

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `alquiler`
-- --------------------------------------------------------

CREATE TABLE `alquiler` (
  `id_alquiler` int NOT NULL AUTO_INCREMENT,
  `id_cliente` int DEFAULT NULL,
  `id_mobiliario` int DEFAULT NULL,
  `fecha_evento` date NOT NULL,
  `hora_evento` time NOT NULL,
  `hora_entrega` time NOT NULL,
  `fecha_devolucion` date NOT NULL,
  `hora_devolucion` time NOT NULL,
  `total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_alquiler`),
  KEY `id_cliente` (`id_cliente`),
  KEY `id_mobiliario` (`id_mobiliario`)
);

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `carpas`
-- --------------------------------------------------------

CREATE TABLE `carpas` (
  `id_tipo_c` int NOT NULL AUTO_INCREMENT,
  `nombre_carpas` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_general_ci NOT NULL,
  `colores_carpas` varchar(8) COLLATE utf8mb4_general_ci NOT NULL,
  `costo_carpas` decimal(10,2) NOT NULL,
  `existencia_carpas` int NOT NULL,
  PRIMARY KEY (`id_tipo_c`)
);

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `cliente`
-- --------------------------------------------------------

CREATE TABLE `cliente` (
  `id_cliente` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `apellidos` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `correo` varchar(28) COLLATE utf8mb4_general_ci NOT NULL,
  `no_telefono` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `id_domicilio_c` int DEFAULT NULL,
  PRIMARY KEY (`id_cliente`),
  KEY `id_domicilio_c` (`id_domicilio_c`)
);

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `domicilio_c`
-- --------------------------------------------------------

CREATE TABLE `domicilio_c` (
  `id_domicilio_c` int NOT NULL AUTO_INCREMENT,
  `estado` varchar(14) COLLATE utf8mb4_general_ci NOT NULL,
  `municipio` varchar(19) COLLATE utf8mb4_general_ci NOT NULL,
  `colonia` varchar(19) COLLATE utf8mb4_general_ci NOT NULL,
  `calle` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `no_calle` int NOT NULL,
  PRIMARY KEY (`id_domicilio_c`)
);

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `domicilio_e`
-- --------------------------------------------------------

CREATE TABLE `domicilio_e` (
  `id_domicilio_e` int NOT NULL AUTO_INCREMENT,
  `estado_e` varchar(14) COLLATE utf8mb4_general_ci NOT NULL,
  `municipio_e` varchar(19) COLLATE utf8mb4_general_ci NOT NULL,
  `colonia_e` varchar(19) COLLATE utf8mb4_general_ci NOT NULL,
  `calle_e` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `no_calle_e` int NOT NULL,
  PRIMARY KEY (`id_domicilio_e`)
);

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `flables`
-- --------------------------------------------------------

CREATE TABLE `flables` (
  `id_tipo_f` int NOT NULL AUTO_INCREMENT,
  `nombre_inflables` varchar(14) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion_inflables` text COLLATE utf8mb4_general_ci NOT NULL,
  `costo_fables` decimal(10,2) NOT NULL,
  `existencia_flables` int NOT NULL,
  PRIMARY KEY (`id_tipo_f`)
);

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `mesas`
-- --------------------------------------------------------

CREATE TABLE `mesas` (
  `id_tipo_me` int NOT NULL AUTO_INCREMENT,
  `existencia_mesas` int NOT NULL,
  `nombre_mesas` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion_mesas` text COLLATE utf8mb4_general_ci NOT NULL,
  `capacidad` int NOT NULL,
  `costo_me` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_tipo_me`)
);

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `mobiliario`
-- --------------------------------------------------------

CREATE TABLE `mobiliario` (
  `id_mobiliario` int NOT NULL AUTO_INCREMENT,
  `id_tipo_s` int DEFAULT NULL,
  `id_tipo_me` int DEFAULT NULL,
  `id_tipo_ma` int DEFAULT NULL,
  `id_tipo_c` int DEFAULT NULL,
  `id_tipo_f` int DEFAULT NULL,
  `cantidad_si` int NOT NULL,
  `cantidad_me` int NOT NULL,
  `cantidad_ma` int NOT NULL,
  `cantidad_c` int NOT NULL,
  `cantidad_f` int NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_mobiliario`),
  KEY `id_tipo_s` (`id_tipo_s`),
  KEY `id_tipo_me` (`id_tipo_me`),
  KEY `id_tipo_ma` (`id_tipo_ma`),
  KEY `id_tipo_c` (`id_tipo_c`),
  KEY `id_tipo_f` (`id_tipo_f`)
);

-- --------------------------------------------------------
-- Restricciones para tablas
-- --------------------------------------------------------

ALTER TABLE `alquiler`
  ADD CONSTRAINT `alquiler_ibfk_1`
  FOREIGN KEY (`id_cliente`)
  REFERENCES `cliente` (`id_cliente`),

  ADD CONSTRAINT `alquiler_ibfk_2`
  FOREIGN KEY (`id_mobiliario`)
  REFERENCES `mobiliario` (`id_mobiliario`);

ALTER TABLE `cliente`
  ADD CONSTRAINT `cliente_ibfk_1`
  FOREIGN KEY (`id_domicilio_c`)
  REFERENCES `domicilio_c` (`id_domicilio_c`);

ALTER TABLE `mobiliario`
  ADD CONSTRAINT `mobiliario_ibfk_1`
  FOREIGN KEY (`id_tipo_s`)
  REFERENCES `sillas` (`id_tipo_s`),

  ADD CONSTRAINT `mobiliario_ibfk_2`
  FOREIGN KEY (`id_tipo_me`)
  REFERENCES `mesas` (`id_tipo_me`),

  ADD CONSTRAINT `mobiliario_ibfk_3`
  FOREIGN KEY (`id_tipo_ma`)
  REFERENCES `manteles` (`id_tipo_ma`),

  ADD CONSTRAINT `mobiliario_ibfk_4`
  FOREIGN KEY (`id_tipo_c`)
  REFERENCES `carpas` (`id_tipo_c`),

  ADD CONSTRAINT `mobiliario_ibfk_5`
  FOREIGN KEY (`id_tipo_f`)
  REFERENCES `flables` (`id_tipo_f`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
