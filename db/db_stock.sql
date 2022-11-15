-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-11-2022 a las 19:27:38
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_stock`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alcohol_content`
--

CREATE TABLE `alcohol_content` (
  `id_alcohol_content` int(11) NOT NULL,
  `name` varchar(65) NOT NULL,
  `brand` varchar(45) NOT NULL,
  `id_drink` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `alcohol_content`
--

INSERT INTO `alcohol_content` (`id_alcohol_content`, `name`, `brand`, `id_drink`) VALUES
(1, 'Vermouth', 'Cinzano', 1),
(2, 'Vodka', 'Grey Goose', 12),
(11, 'Appetizer', 'Fernet', 22);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category`
--

CREATE TABLE `category` (
  `id_category` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `amount` int(100) NOT NULL,
  `id_alcohol_content` int(11) NOT NULL,
  `photo` varchar(350) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `category`
--

INSERT INTO `category` (`id_category`, `name`, `amount`, `id_alcohol_content`, `photo`) VALUES
(12, 'Vodka', 20, 2, 'https://http2.mlstatic.com/D_NQ_NP_991387-MLA45405870490_032021-O.webp');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `drink`
--

CREATE TABLE `drink` (
  `id_drink` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `amount` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `drink`
--

INSERT INTO `drink` (`id_drink`, `name`, `brand`, `amount`) VALUES
(22, 'sdfsads', 'asdasd2112', 2231321);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `email`, `password`) VALUES
(1, 'santiagoshinder@gmail.com', '$2y$10$/ae.O/iUehGvkr6r7TDTye8IZRbLPMbnXDfL5BiQlruCKufm9Pyvu');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alcohol_content`
--
ALTER TABLE `alcohol_content`
  ADD PRIMARY KEY (`id_alcohol_content`);

--
-- Indices de la tabla `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`),
  ADD KEY `fk_category_alcoholContent` (`id_alcohol_content`);

--
-- Indices de la tabla `drink`
--
ALTER TABLE `drink`
  ADD PRIMARY KEY (`id_drink`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alcohol_content`
--
ALTER TABLE `alcohol_content`
  MODIFY `id_alcohol_content` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `drink`
--
ALTER TABLE `drink`
  MODIFY `id_drink` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `fk_category_alcoholContent` FOREIGN KEY (`id_alcohol_content`) REFERENCES `alcohol_content` (`id_alcohol_content`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
