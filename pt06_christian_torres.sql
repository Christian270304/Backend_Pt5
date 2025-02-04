-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: proxysql-01.dd.scip.local
-- Tiempo de generación: 04-02-2025 a las 22:59:02
-- Versión del servidor: 10.10.7-MariaDB-1:10.10.7+maria~deb11
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pt06_christian_torres`
--
DROP DATABASE IF EXISTS pt06_christian_torres;
CREATE DATABASE IF NOT EXISTS pt06_christian_torres;
USE pt06_christian_torres;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articles`
--

CREATE TABLE `articles` (
  `id` int(10) UNSIGNED NOT NULL,
  `titol` varchar(255) NOT NULL,
  `cos` text NOT NULL,
  `ruta_imagen` varchar(255) NOT NULL,
  `creado_el` timestamp NOT NULL DEFAULT current_timestamp(),
  `modificado_el` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `articles`
--

INSERT INTO `articles` (`id`, `titol`, `cos`, `ruta_imagen`, `creado_el`, `modificado_el`, `user_id`) VALUES
(1, 'Max Verstappen', 'Bicampeón mundial con un estilo agresivo y dominio en pista; es el líder del equipo Red Bull.', 'images/articles/max-verstappen.jpg', '2024-10-25 18:00:39', '2024-11-30 20:10:28', 2),
(2, 'Sergio Pérez', 'Fuerte en carreras callejeras y estratégico, suele asegurar puntos valiosos para el equipo de Red Bull.', 'images/articles/sergio-perez.jpg', '2024-10-25 18:01:49', '2024-11-30 20:14:15', 2),
(3, 'Lewis Hamilton', 'Siete veces campeón mundial; un referente en la F1 con habilidad y experiencia inigualables.', 'images/articles/lewis-hamilton.jpg', '2024-10-25 18:02:51', '2024-11-30 20:14:34', 2),
(4, 'George Russell', 'Joven talento británico, destaca por su consistencia y enfoque meticuloso.', 'images/articles/george-russell.jpg', '2024-10-25 18:08:39', '2024-11-30 20:14:43', 2),
(5, 'Charles Leclerc', 'Piloto rápido y ambicioso; se destaca por sus habilidades en clasificación.', 'images/articles/charles-leclerc.jpg', '2024-10-25 18:08:57', '2024-11-30 20:27:04', 2),
(6, 'Carlos Sainz Jr.', 'Confiable y estratégico; sobresale en carreras largas y técnicas.', 'images/articles/carlos-sainz.jpg', '2024-10-25 18:09:43', '2024-11-30 20:27:20', 3),
(7, 'Fernando Alonso', 'Doble campeón del mundo; ha sorprendido con su regreso a la cima y su conocimiento técnico.', 'images/articles/fernando-alonso.jpg', '2024-10-25 18:10:02', '2024-11-30 20:27:35', 3),
(8, 'Lance Stroll', 'Talentoso en situaciones de lluvia; es consistente aunque menos experimentado que Alonso.', 'images/articles/lance-stroll.jpg', '2024-10-25 18:10:21', '2024-11-30 20:28:04', 3),
(9, 'Lando Norris', 'Joven británico talentoso; tiene gran control en el monoplaza y consistencia.', 'images/articles/lando-norris.jpg', '2024-10-25 18:11:00', '2024-11-30 20:28:16', 3),
(10, 'Oscar Piastri', 'Novato australiano con gran potencial y una rápida adaptación a la F1.', 'images/articles/oscar-piastri.jpg', '2024-10-25 18:11:17', '2024-11-30 20:28:28', 3),
(11, 'Esteban Ocon', 'Fuerte en carreras cuerpo a cuerpo y confiable para acumular puntos.', 'images/articles/esteban-ocon.jpg', '2024-10-25 18:11:57', '2024-11-30 20:28:44', 4),
(12, 'Pierre Gasly', 'Experimentado y tenaz; sobresale en condiciones cambiantes y tiene un estilo agresivo.', 'images/articles/pierre-gasly.jpg', '2024-10-25 18:12:12', '2024-11-30 20:28:58', 4),
(13, 'Valtteri Bottas', 'Ex de Mercedes, con experiencia y velocidad; aporta estabilidad al equipo.', 'images/articles/Valtteri-Bottas.jpeg', '2024-10-25 18:12:32', '2024-11-30 20:29:21', 4),
(14, 'Zhou Guanyu', 'Primer piloto chino en la F1; joven, rápido y en constante aprendizaje.', 'images/articles/zhou-guanyu.jpg', '2024-10-25 18:12:59', '2024-11-30 20:29:41', 4),
(15, 'Kevin Magnussen', 'Combativo y hábil en peleas cercanas; aporta experiencia al equipo.', 'images/articles/kevin-magnussen.jpg', '2024-10-25 18:13:16', '2024-11-30 20:30:02', 4),
(16, 'Nico Hülkenberg', 'Regresó a la F1 con Haas; confiable y experimentado, conocido por su consistencia.', 'images/articles/nico-hulkenberg.jpg', '2024-10-25 18:13:54', '2024-11-30 20:30:24', 5),
(17, 'Yuki Tsunoda', 'Piloto rápido y agresivo; en desarrollo, tiene gran potencial para mejorar.', 'images/articles/yuki-tsunoda.jpg', '2024-10-25 18:14:13', '2024-11-30 20:30:44', 5),
(18, 'Liam Lawson/Daniel Ricciardo', 'Ricciardo, experimentado y carismático, regresó a mitad de temporada; Lawson tomó su lugar temporalmente y mostró buen desempeño.', '', '2024-10-25 18:14:53', '2024-10-25 18:14:53', 5),
(19, 'Alex Albon', 'Rápido y consistente; ha logrado sacar buen rendimiento del auto.', 'images/articles/alex-albon.jpg', '2024-10-25 18:15:06', '2024-11-30 20:31:03', 5),
(20, 'Logan Sargeant', 'Novato estadounidense; en proceso de adaptación, pero con buen potencial..', '', '2024-10-25 18:15:23', '2024-10-25 18:15:23', 5);

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

--
-- Volcado de datos para la tabla `tokens`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `bio` text NOT NULL,
  `ruta_imagen` varchar(255) NOT NULL,
  `OAuth` varchar(100) NOT NULL,
  `creado_el` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `bio`, `ruta_imagen`, `OAuth`, `creado_el`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$dsMgJ6ZepuRmcqiFJesrbu08AIUZ/otBlaZ3uN8rFqW2j0XLf/gkG', '', '', '', '2024-10-19 14:16:02'),
(2, 'eduardo_81', 'n551bjajq@yahoo.es', '$2y$10$h5as3MdK7d.KbT3F3pWgh.wLg4ii5fIxtn8cjuLbSp4Y4zxkCKCV6', 'Apasionado por la tecnología y los gadgets. Siempre en busca de las últimas novedades en el mundo digital.', '', '', '2024-10-25 17:42:51'),
(3, 'gorka_63', 'zrt5pg2i@lycos.es', '$2y$10$fIxW5A8f2wGWp8TYH19gv.F3HL8tPT4opN5OZVAQ6CfONILrf3t26', 'Viajero incansable y amante de la fotografía. Capturando el mundo un clic a la vez.', '', '', '2024-10-25 17:43:10'),
(4, 'franciscojesus_74', '65swvtqw3@caramail.com', '$2y$10$pSn2uk1hfAGMa94eqAWChejtgcq5H0wFWvyGvyWFs2SgkUemg91Ma', 'Cocinero aficionado y fanático de la gastronomía. Siempre experimentando con nuevos sabores.', '', '', '2024-10-25 17:43:30'),
(5, 'merce_72', 'u3xtm8fwy@lycos.es', '$2y$10$3f/1U5MMrM4r8HYbnvvisekR2kEadUSnvs1sYYE1DvbndNMBxA/A.', 'Lectora empedernida y escritora en formación. Cada página es una nueva aventura.📚✒️', '', '', '2024-10-25 17:43:49');

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
