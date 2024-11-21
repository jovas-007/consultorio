-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-03-2023 a las 21:36:58
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `consultorio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `llaves`
--

CREATE TABLE `llaves` (
  `id` int(11) NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `indice` int(11) NOT NULL,
  `cadena` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `llaves`
--

INSERT INTO `llaves` (`id`, `tipo`, `indice`, `cadena`) VALUES
(1, 'grupoSangre', 1, 'A+'),
(2, 'grupoSangre', 2, 'A-'),
(3, 'grupoSangre', 3, 'B+'),
(4, 'grupoSangre', 4, 'B-'),
(5, 'grupoSangre', 5, 'AB+'),
(6, 'grupoSangre', 6, 'AB-'),
(7, 'grupoSangre', 7, 'O+'),
(8, 'grupoSangre', 8, 'O-'),
(9, 'genero', 1, 'Masculino'),
(10, 'genero', 2, 'Femenino'),
(11, 'genero', 3, 'Otro'),
(12, 'edoCivil', 1, 'Soltero'),
(13, 'edoCivil', 2, 'Casado'),
(14, 'edoCivil', 3, 'Divorciado'),
(15, 'edoCivil', 4, 'Viudo'),
(16, 'edoCivil', 5, 'Unión libre'),
(17, 'diaSemana', 0, 'Lunes'),
(18, 'diaSemana', 1, 'Martes'),
(19, 'diaSemana', 2, 'Miércoles'),
(20, 'diaSemana', 3, 'Jueves'),
(21, 'diaSemana', 4, 'Viernes'),
(22, 'diaSemana', 5, 'Sábado'),
(23, 'diaSemana', 6, 'Domingo'),
(24, 'duracion', 1, '15'),
(25, 'duracion', 2, '20'),
(26, 'duracion', 3, '30'),
(27, 'duracion', 4, '45'),
(28, 'duracion', 5, '60'),
(29, 'edoCita', 1, 'Pendiente'),
(30, 'edoCita', 2, 'Confirmada'),
(31, 'edoCita', 3, 'Cita realizada'),
(32, 'edoCita', 4, 'Cancelada'),
(33, 'edoCita', 0, 'Libre');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `llaves`
--
ALTER TABLE `llaves`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `llaves`
--
ALTER TABLE `llaves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
