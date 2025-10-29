-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-10-2025 a las 20:26:02
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `contenedores_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `barba`
--

CREATE TABLE `barba` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `barba`
--

INSERT INTO `barba` (`id`, `titulo`, `descripcion`, `imagen`, `precio`) VALUES
(0, 'clasico', 'un clasico', 'uploads/68fc02b9cbae4_clasico_barba.jpeg', 3000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config_atencion`
--

CREATE TABLE `config_atencion` (
  `dia_semana` varchar(10) NOT NULL,
  `manana_inicio` time NOT NULL DEFAULT '07:00:00',
  `manana_fin` time NOT NULL DEFAULT '12:00:00',
  `tarde_inicio` time NOT NULL DEFAULT '16:00:00',
  `tarde_fin` time NOT NULL DEFAULT '21:00:00',
  `intervalo` int(11) NOT NULL DEFAULT 30
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `config_atencion`
--

INSERT INTO `config_atencion` (`dia_semana`, `manana_inicio`, `manana_fin`, `tarde_inicio`, `tarde_fin`, `intervalo`) VALUES
('domingo', '07:00:00', '12:00:00', '16:00:00', '21:00:00', 30),
('jueves', '07:00:00', '12:00:00', '16:00:00', '21:00:00', 30),
('lunes', '07:00:00', '12:00:00', '16:00:00', '21:00:00', 30),
('martes', '07:00:00', '12:00:00', '16:00:00', '21:00:00', 30),
('miercoles', '07:00:00', '12:00:00', '16:00:00', '21:00:00', 30),
('sabado', '07:00:00', '12:00:00', '16:00:00', '21:00:00', 30),
('viernes', '07:00:00', '12:00:00', '16:00:00', '21:00:00', 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contenidos`
--

CREATE TABLE `contenidos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contenidos`
--

INSERT INTO `contenidos` (`id`, `titulo`, `descripcion`, `imagen`, `precio`) VALUES
(1, 'corte', 'cortesito pa', 'uploads/68f9ae61a8ef4_Espacios-pequenyos-mesas-comedor.jpg', 3500.00),
(2, 'Taper feid', 'Alto corte pa turro mal', 'uploads/68f99e82aa3bb_corte_de_cabello.jpg', 8000.00),
(3, 'corte americano', 're gringo amigo', 'uploads/68f99eb1ca720_corte-barba.jpg', 4000.00),
(4, 'Platinado', 'facha', 'uploads/68fc008bb8369_platinado.jpg', 5000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

CREATE TABLE `horarios` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `disponible` enum('si','no') NOT NULL DEFAULT 'si'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `horarios`
--

INSERT INTO `horarios` (`id`, `fecha`, `hora`, `disponible`) VALUES
(1, '2025-10-26', '07:00:00', 'si'),
(2, '2025-10-26', '07:30:00', 'si'),
(3, '2025-10-26', '08:00:00', 'si'),
(4, '2025-10-26', '08:30:00', 'si'),
(5, '2025-10-26', '09:00:00', 'si'),
(6, '2025-10-26', '09:30:00', 'si'),
(7, '2025-10-26', '10:00:00', 'si'),
(8, '2025-10-26', '10:30:00', 'si'),
(9, '2025-10-26', '11:00:00', 'si'),
(10, '2025-10-26', '11:30:00', 'si'),
(11, '2025-10-26', '16:00:00', 'si'),
(12, '2025-10-26', '16:30:00', 'si'),
(13, '2025-10-26', '17:00:00', 'si'),
(14, '2025-10-26', '17:30:00', 'si'),
(15, '2025-10-26', '18:00:00', 'si'),
(16, '2025-10-26', '18:30:00', 'si'),
(17, '2025-10-26', '19:00:00', 'si'),
(18, '2025-10-26', '19:30:00', 'si'),
(19, '2025-10-26', '20:00:00', 'si'),
(20, '2025-10-26', '20:30:00', 'si'),
(21, '2025-10-27', '07:00:00', 'no'),
(22, '2025-10-27', '07:30:00', 'si'),
(23, '2025-10-27', '08:00:00', 'si'),
(24, '2025-10-27', '08:30:00', 'si'),
(25, '2025-10-27', '09:00:00', 'si'),
(26, '2025-10-27', '09:30:00', 'si'),
(27, '2025-10-27', '10:00:00', 'si'),
(28, '2025-10-27', '10:30:00', 'si'),
(29, '2025-10-27', '11:00:00', 'si'),
(30, '2025-10-27', '11:30:00', 'si'),
(31, '2025-10-27', '16:00:00', 'si'),
(32, '2025-10-27', '16:30:00', 'si'),
(33, '2025-10-27', '17:00:00', 'si'),
(34, '2025-10-27', '17:30:00', 'si'),
(35, '2025-10-27', '18:00:00', 'si'),
(36, '2025-10-27', '18:30:00', 'si'),
(37, '2025-10-27', '19:00:00', 'si'),
(38, '2025-10-27', '19:30:00', 'si'),
(39, '2025-10-27', '20:00:00', 'si'),
(40, '2025-10-27', '20:30:00', 'si'),
(41, '2025-10-28', '07:00:00', 'si'),
(42, '2025-10-28', '07:30:00', 'no'),
(43, '2025-10-28', '08:00:00', 'si'),
(44, '2025-10-28', '08:30:00', 'si'),
(45, '2025-10-28', '09:00:00', 'si'),
(46, '2025-10-28', '09:30:00', 'si'),
(47, '2025-10-28', '10:00:00', 'si'),
(48, '2025-10-28', '10:30:00', 'si'),
(49, '2025-10-28', '11:00:00', 'si'),
(50, '2025-10-28', '11:30:00', 'si'),
(51, '2025-10-28', '16:00:00', 'si'),
(52, '2025-10-28', '16:30:00', 'si'),
(53, '2025-10-28', '17:00:00', 'si'),
(54, '2025-10-28', '17:30:00', 'si'),
(55, '2025-10-28', '18:00:00', 'si'),
(56, '2025-10-28', '18:30:00', 'si'),
(57, '2025-10-28', '19:00:00', 'si'),
(58, '2025-10-28', '19:30:00', 'si'),
(59, '2025-10-28', '20:00:00', 'si'),
(60, '2025-10-28', '20:30:00', 'si'),
(61, '2025-10-29', '07:00:00', 'si'),
(62, '2025-10-29', '07:30:00', 'si'),
(63, '2025-10-29', '08:00:00', 'si'),
(64, '2025-10-29', '08:30:00', 'si'),
(65, '2025-10-29', '09:00:00', 'si'),
(66, '2025-10-29', '09:30:00', 'si'),
(67, '2025-10-29', '10:00:00', 'si'),
(68, '2025-10-29', '10:30:00', 'si'),
(69, '2025-10-29', '11:00:00', 'si'),
(70, '2025-10-29', '11:30:00', 'si'),
(71, '2025-10-29', '16:00:00', 'si'),
(72, '2025-10-29', '16:30:00', 'si'),
(73, '2025-10-29', '17:00:00', 'si'),
(74, '2025-10-29', '17:30:00', 'si'),
(75, '2025-10-29', '18:00:00', 'si'),
(76, '2025-10-29', '18:30:00', 'si'),
(77, '2025-10-29', '19:00:00', 'si'),
(78, '2025-10-29', '19:30:00', 'si'),
(79, '2025-10-29', '20:00:00', 'si'),
(80, '2025-10-29', '20:30:00', 'si'),
(81, '2025-10-30', '07:00:00', 'si'),
(82, '2025-10-30', '07:30:00', 'si'),
(83, '2025-10-30', '08:00:00', 'si'),
(84, '2025-10-30', '08:30:00', 'si'),
(85, '2025-10-30', '09:00:00', 'si'),
(86, '2025-10-30', '09:30:00', 'si'),
(87, '2025-10-30', '10:00:00', 'si'),
(88, '2025-10-30', '10:30:00', 'si'),
(89, '2025-10-30', '11:00:00', 'si'),
(90, '2025-10-30', '11:30:00', 'si'),
(91, '2025-10-30', '16:00:00', 'si'),
(92, '2025-10-30', '16:30:00', 'si'),
(93, '2025-10-30', '17:00:00', 'si'),
(94, '2025-10-30', '17:30:00', 'si'),
(95, '2025-10-30', '18:00:00', 'si'),
(96, '2025-10-30', '18:30:00', 'si'),
(97, '2025-10-30', '19:00:00', 'si'),
(98, '2025-10-30', '19:30:00', 'si'),
(99, '2025-10-30', '20:00:00', 'si'),
(100, '2025-10-30', '20:30:00', 'si'),
(101, '2025-10-31', '07:00:00', 'si'),
(102, '2025-10-31', '07:30:00', 'si'),
(103, '2025-10-31', '08:00:00', 'si'),
(104, '2025-10-31', '08:30:00', 'si'),
(105, '2025-10-31', '09:00:00', 'si'),
(106, '2025-10-31', '09:30:00', 'si'),
(107, '2025-10-31', '10:00:00', 'si'),
(108, '2025-10-31', '10:30:00', 'si'),
(109, '2025-10-31', '11:00:00', 'si'),
(110, '2025-10-31', '11:30:00', 'si'),
(111, '2025-10-31', '16:00:00', 'si'),
(112, '2025-10-31', '16:30:00', 'si'),
(113, '2025-10-31', '17:00:00', 'si'),
(114, '2025-10-31', '17:30:00', 'si'),
(115, '2025-10-31', '18:00:00', 'si'),
(116, '2025-10-31', '18:30:00', 'si'),
(117, '2025-10-31', '19:00:00', 'si'),
(118, '2025-10-31', '19:30:00', 'si'),
(119, '2025-10-31', '20:00:00', 'si'),
(120, '2025-10-31', '20:30:00', 'si'),
(121, '2025-11-01', '07:00:00', 'si'),
(122, '2025-11-01', '07:30:00', 'si'),
(123, '2025-11-01', '08:00:00', 'si'),
(124, '2025-11-01', '08:30:00', 'si'),
(125, '2025-11-01', '09:00:00', 'si'),
(126, '2025-11-01', '09:30:00', 'si'),
(127, '2025-11-01', '10:00:00', 'si'),
(128, '2025-11-01', '10:30:00', 'si'),
(129, '2025-11-01', '11:00:00', 'si'),
(130, '2025-11-01', '11:30:00', 'si'),
(131, '2025-11-01', '16:00:00', 'si'),
(132, '2025-11-01', '16:30:00', 'si'),
(133, '2025-11-01', '17:00:00', 'si'),
(134, '2025-11-01', '17:30:00', 'si'),
(135, '2025-11-01', '18:00:00', 'si'),
(136, '2025-11-01', '18:30:00', 'si'),
(137, '2025-11-01', '19:00:00', 'si'),
(138, '2025-11-01', '19:30:00', 'si'),
(139, '2025-11-01', '20:00:00', 'si'),
(140, '2025-11-01', '20:30:00', 'si'),
(261, '2025-11-02', '07:00:00', 'no'),
(262, '2025-11-02', '07:30:00', 'si'),
(263, '2025-11-02', '08:00:00', 'si'),
(264, '2025-11-02', '08:30:00', 'si'),
(265, '2025-11-02', '09:00:00', 'si'),
(266, '2025-11-02', '09:30:00', 'si'),
(267, '2025-11-02', '10:00:00', 'si'),
(268, '2025-11-02', '10:30:00', 'si'),
(269, '2025-11-02', '11:00:00', 'si'),
(270, '2025-11-02', '11:30:00', 'si'),
(271, '2025-11-02', '16:00:00', 'si'),
(272, '2025-11-02', '16:30:00', 'si'),
(273, '2025-11-02', '17:00:00', 'si'),
(274, '2025-11-02', '17:30:00', 'si'),
(275, '2025-11-02', '18:00:00', 'si'),
(276, '2025-11-02', '18:30:00', 'si'),
(277, '2025-11-02', '19:00:00', 'si'),
(278, '2025-11-02', '19:30:00', 'si'),
(279, '2025-11-02', '20:00:00', 'si'),
(280, '2025-11-02', '20:30:00', 'si'),
(401, '2025-11-03', '07:00:00', 'si'),
(402, '2025-11-03', '07:30:00', 'si'),
(403, '2025-11-03', '08:00:00', 'si'),
(404, '2025-11-03', '08:30:00', 'si'),
(405, '2025-11-03', '09:00:00', 'si'),
(406, '2025-11-03', '09:30:00', 'si'),
(407, '2025-11-03', '10:00:00', 'si'),
(408, '2025-11-03', '10:30:00', 'si'),
(409, '2025-11-03', '11:00:00', 'si'),
(410, '2025-11-03', '11:30:00', 'si'),
(411, '2025-11-03', '16:00:00', 'si'),
(412, '2025-11-03', '16:30:00', 'si'),
(413, '2025-11-03', '17:00:00', 'si'),
(414, '2025-11-03', '17:30:00', 'si'),
(415, '2025-11-03', '18:00:00', 'si'),
(416, '2025-11-03', '18:30:00', 'si'),
(417, '2025-11-03', '19:00:00', 'si'),
(418, '2025-11-03', '19:30:00', 'si'),
(419, '2025-11-03', '20:00:00', 'si'),
(420, '2025-11-03', '20:30:00', 'si'),
(701, '2025-11-04', '07:00:00', 'si'),
(702, '2025-11-04', '07:30:00', 'si'),
(703, '2025-11-04', '08:00:00', 'si'),
(704, '2025-11-04', '08:30:00', 'si'),
(705, '2025-11-04', '09:00:00', 'si'),
(706, '2025-11-04', '09:30:00', 'si'),
(707, '2025-11-04', '10:00:00', 'si'),
(708, '2025-11-04', '10:30:00', 'si'),
(709, '2025-11-04', '11:00:00', 'si'),
(710, '2025-11-04', '11:30:00', 'si'),
(711, '2025-11-04', '16:00:00', 'si'),
(712, '2025-11-04', '16:30:00', 'si'),
(713, '2025-11-04', '17:00:00', 'si'),
(714, '2025-11-04', '17:30:00', 'si'),
(715, '2025-11-04', '18:00:00', 'si'),
(716, '2025-11-04', '18:30:00', 'si'),
(717, '2025-11-04', '19:00:00', 'si'),
(718, '2025-11-04', '19:30:00', 'si'),
(719, '2025-11-04', '20:00:00', 'si'),
(720, '2025-11-04', '20:30:00', 'si');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `intro_servicios`
--

CREATE TABLE `intro_servicios` (
  `id` int(11) NOT NULL,
  `servicio` varchar(50) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `intro_servicios`
--

INSERT INTO `intro_servicios` (`id`, `servicio`, `titulo`, `descripcion`) VALUES
(1, 'corte', 'Corte1', 'Los mejores cortes modernos y clásicos y listo'),
(2, 'tintura', 'Tintura', 'Tintes profesionales para un look fresco.'),
(3, 'lavado', 'Lavado', 'Lavados profundos y revitalizantes.'),
(4, 'barba', 'Barba', 'Arreglos de barba precisos y estilizados.'),
(5, 'peinado', 'Peinado', 'Peinados creativos y duraderos.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lavado`
--

CREATE TABLE `lavado` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expiry` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `password_resets`
--

INSERT INTO `password_resets` (`id`, `correo`, `token`, `expiry`, `created_at`) VALUES
(1, 'brian1@gmail.com', 'fa932bdf190ba785da7586d35137cdde377769354f026f684158f428050bc856', '2025-10-22 07:36:18', '2025-10-22 04:36:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peinado`
--

CREATE TABLE `peinado` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `portada`
--

CREATE TABLE `portada` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `imagen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `portada`
--

INSERT INTO `portada` (`id`, `titulo`, `descripcion`, `imagen`) VALUES
(1, 'barber shopp', 'barberia kpe', '68f8655d15b20_index img.jpg'),
(2, 'Servicios de Barber Shop', 'La mejor calidad y precio en todos los servicios ofrecidos junto a la mejor atencion.', '68f9b4481d28f_barber_serv.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id_reserva` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `category_key` varchar(50) NOT NULL,
  `sub_table` varchar(50) NOT NULL,
  `sena_pagada` decimal(10,2) DEFAULT 0.00,
  `status` varchar(50) DEFAULT 'pendiente',
  `sub_id` int(11) NOT NULL,
  `subservicio_name` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`id_reserva`, `id_usuario`, `fecha`, `hora`, `category_key`, `sub_table`, `sena_pagada`, `status`, `sub_id`, `subservicio_name`) VALUES
(1, 2, '2025-10-26', '09:00:00', 'corte', 'corte', 4000.00, 'ocupado', 2, ''),
(3, 2, '2025-10-26', '10:00:00', 'corte', 'corte', 4000.00, 'cancelado', 2, ''),
(4, 2, '2025-10-26', '07:00:00', 'corte', 'corte', 2000.00, 'pendiente', 3, 'corte americano'),
(6, 2, '2025-10-27', '07:00:00', 'corte', 'corte', 4000.00, 'pendiente', 2, 'Taper feid'),
(7, 2, '2025-10-28', '07:30:00', 'tintura', 'tintura', 2500.00, 'pendiente', 0, 'Platinado'),
(8, 2, '2025-11-02', '07:00:00', 'corte', 'corte', 4000.00, 'pendiente', 2, 'Taper feid');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id` int(11) NOT NULL,
  `seccion` varchar(50) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id`, `seccion`, `titulo`, `descripcion`, `imagen`, `link`) VALUES
(1, 'section-1', 'Corte de Cabello', 'Cortes modernos y clásicos para todos los estilos.', 'section-1_1761109004.jpg', 'servicios/corte.php'),
(2, 'section-2', 'Tintura', 'Colores vibrantes y personalizados para realzar tu look.', 'section-2_1761108971.jpg', 'servicios/tintura.php'),
(3, 'section-3', 'Peinado', 'Peinados elegantes para cualquier ocasión especial.', 'section-3_1761109311.jpg', 'servicios/peinado.php'),
(4, 'section-4', 'Barba', 'Afeitado y diseño de barba profesional.', 'section-4_1761108991.jpg', 'servicios/barba.php'),
(5, 'section-5', 'Lavados', 'Lavado de cabello.', 'section-5_1761109211.jpg', 'servicios/tratamientos.php');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tintura`
--

CREATE TABLE `tintura` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tintura`
--

INSERT INTO `tintura` (`id`, `titulo`, `descripcion`, `imagen`, `precio`) VALUES
(0, 'Platinado', 'facha', 'uploads/68fc03666cc5d_platinado.jpg', 5000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `dni` varchar(20) NOT NULL,
  `edad` int(11) NOT NULL CHECK (`edad` >= 16),
  `telefono` varchar(20) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `rol` varchar(50) DEFAULT 'cliente',
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `nombre`, `dni`, `edad`, `telefono`, `contrasena`, `correo`, `rol`, `foto`) VALUES
(1, 'brian', '44982569', 22, '3704597493', '123456', 'brian@gmail.com', 'admin', ''),
(2, 'brian', '44555666', 22, '3704597493', '$2y$10$WQdMrI5RCOdyqQ/G3t/4CeVxiNjtJz56o8UYwFk3KN4ZLtJfEXify', 'brian1@gmail.com', 'admin', '6901978d8cf09_brian_perfil.jpg'),
(3, 'dalila', '43807979', 24, '3704121212', '$2y$10$1GblGIiiiNW.bgGmr1ezqumkYKi7haYthNZv/3tlGKeeoHpFZKCLG', 'dali@gmail.com', 'cliente', '69022a7ae7168_brian_2.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `config_atencion`
--
ALTER TABLE `config_atencion`
  ADD PRIMARY KEY (`dia_semana`);

--
-- Indices de la tabla `contenidos`
--
ALTER TABLE `contenidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_horario` (`fecha`,`hora`);

--
-- Indices de la tabla `intro_servicios`
--
ALTER TABLE `intro_servicios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `servicio` (`servicio`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `portada`
--
ALTER TABLE `portada`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id_reserva`),
  ADD UNIQUE KEY `unique_reserva` (`fecha`,`hora`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `seccion` (`seccion`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idusuario`),
  ADD UNIQUE KEY `dni` (`dni`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `contenidos`
--
ALTER TABLE `contenidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `horarios`
--
ALTER TABLE `horarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=721;

--
-- AUTO_INCREMENT de la tabla `intro_servicios`
--
ALTER TABLE `intro_servicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `portada`
--
ALTER TABLE `portada`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`idusuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
