-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-10-2024 a las 21:19:26
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pt05_christian_torres`
--
DROP DATABASE IF EXISTS pt05_christian_torres;
CREATE DATABASE IF NOT EXISTS pt05_christian_torres;
USE pt05_christian_torres;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articles`
--

CREATE TABLE `articles` (
  `id` int(10) UNSIGNED NOT NULL,
  `titol` varchar(255) NOT NULL,
  `cos` text NOT NULL,
  `creado_el` timestamp NOT NULL DEFAULT current_timestamp(),
  `modificado_el` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `articles`
--

INSERT INTO `articles` (`id`, `titol`, `cos`, `creado_el`, `modificado_el`, `user_id`) VALUES
(1, 'Max Verstappen', 'Bicampeón mundial con un estilo agresivo y dominio en pista; es el líder del equipo Red Bull.', '2024-10-25 18:00:39', '2024-10-25 18:02:09', 2),
(2, 'Sergio Pérez', 'Fuerte en carreras callejeras y estratégico, suele asegurar puntos valiosos para el equipo de Red Bull.', '2024-10-25 18:01:49', '2024-10-25 18:01:49', 2),
(3, 'Lewis Hamilton', 'Siete veces campeón mundial; un referente en la F1 con habilidad y experiencia inigualables.', '2024-10-25 18:02:51', '2024-10-25 18:02:51', 2),
(4, 'George Russell', 'Joven talento británico, destaca por su consistencia y enfoque meticuloso.', '2024-10-25 18:08:39', '2024-10-25 18:08:39', 2),
(5, 'Charles Leclerc', 'Piloto rápido y ambicioso; se destaca por sus habilidades en clasificación.', '2024-10-25 18:08:57', '2024-10-25 18:08:57', 2),
(6, 'Carlos Sainz Jr.', 'Confiable y estratégico; sobresale en carreras largas y técnicas.', '2024-10-25 18:09:43', '2024-10-25 18:09:43', 3),
(7, 'Fernando Alonso', 'Doble campeón del mundo; ha sorprendido con su regreso a la cima y su conocimiento técnico.', '2024-10-25 18:10:02', '2024-10-25 18:10:02', 3),
(8, 'Lance Stroll', 'Talentoso en situaciones de lluvia; es consistente aunque menos experimentado que Alonso.', '2024-10-25 18:10:21', '2024-10-25 18:10:21', 3),
(9, 'Lando Norris', 'Joven británico talentoso; tiene gran control en el monoplaza y consistencia.', '2024-10-25 18:11:00', '2024-10-25 18:11:00', 3),
(10, 'Oscar Piastri', 'Novato australiano con gran potencial y una rápida adaptación a la F1.', '2024-10-25 18:11:17', '2024-10-25 18:11:17', 3),
(11, 'Esteban Ocon', 'Fuerte en carreras cuerpo a cuerpo y confiable para acumular puntos.', '2024-10-25 18:11:57', '2024-10-25 18:11:57', 4),
(12, 'Pierre Gasly', 'Experimentado y tenaz; sobresale en condiciones cambiantes y tiene un estilo agresivo.', '2024-10-25 18:12:12', '2024-10-25 18:12:12', 4),
(13, 'Valtteri Bottas', 'Ex de Mercedes, con experiencia y velocidad; aporta estabilidad al equipo.', '2024-10-25 18:12:32', '2024-10-25 18:12:32', 4),
(14, 'Zhou Guanyu', 'Primer piloto chino en la F1; joven, rápido y en constante aprendizaje.', '2024-10-25 18:12:59', '2024-10-25 18:12:59', 4),
(15, 'Kevin Magnussen', 'Combativo y hábil en peleas cercanas; aporta experiencia al equipo.', '2024-10-25 18:13:16', '2024-10-25 18:13:16', 4),
(16, 'Nico Hülkenberg', 'Regresó a la F1 con Haas; confiable y experimentado, conocido por su consistencia.', '2024-10-25 18:13:54', '2024-10-25 18:13:54', 5),
(17, 'Yuki Tsunoda', 'Piloto rápido y agresivo; en desarrollo, tiene gran potencial para mejorar.', '2024-10-25 18:14:13', '2024-10-25 18:14:13', 5),
(18, 'Liam Lawson/Daniel Ricciardo', 'Ricciardo, experimentado y carismático, regresó a mitad de temporada; Lawson tomó su lugar temporalmente y mostró buen desempeño.', '2024-10-25 18:14:53', '2024-10-25 18:14:53', 5),
(19, 'Alex Albon', 'Rápido y consistente; ha logrado sacar buen rendimiento del auto.', '2024-10-25 18:15:06', '2024-10-25 18:15:06', 5),
(20, 'Logan Sargeant', 'Novato estadounidense; en proceso de adaptación, pero con buen potencial..', '2024-10-25 18:15:23', '2024-10-25 18:15:23', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tokens`
--

CREATE TABLE `tokens` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `token` varchar(100) NOT NULL,
  `expira` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `ruta_imagen` varchar(255) NOT NULL,
  `creado_el` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `ruta_imagen`, `creado_el`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$dsMgJ6ZepuRmcqiFJesrbu08AIUZ/otBlaZ3uN8rFqW2j0XLf/gkG', '', '2024-10-19 14:16:02'),
(2, 'eduardo_81', 'n551bjajq@yahoo.es', '$2y$10$h5as3MdK7d.KbT3F3pWgh.wLg4ii5fIxtn8cjuLbSp4Y4zxkCKCV6', '', '2024-10-25 17:42:51'),
(3, 'gorka_63', 'zrt5pg2i@lycos.es', '$2y$10$fIxW5A8f2wGWp8TYH19gv.F3HL8tPT4opN5OZVAQ6CfONILrf3t26', '', '2024-10-25 17:43:10'),
(4, 'franciscojesus_74', '65swvtqw3@caramail.com', '$2y$10$pSn2uk1hfAGMa94eqAWChejtgcq5H0wFWvyGvyWFs2SgkUemg91Ma', '', '2024-10-25 17:43:30'),
(5, 'merce_72', 'u3xtm8fwy@lycos.es', '$2y$10$3f/1U5MMrM4r8HYbnvvisekR2kEadUSnvs1sYYE1DvbndNMBxA/A.', '', '2024-10-25 17:43:49');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_users_id` (`user_id`);

--
-- Indices de la tabla `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `user_id_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `token_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
