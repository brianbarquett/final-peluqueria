-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-10-2025 a las 03:47:49
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
(3, 'corte americano', 're gringo amigo', 'uploads/68f99eb1ca720_corte-barba.jpg', 4000.00);

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
(2, 'Cortes', 'Lo mejor en cortes', '68f9b4481d28f_barber_serv.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id_reserva` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'section-1', 'Corte de Cabello', 'Cortes modernos y clásicos para todos los estilos.', 'section-1_1761109004.jpg', 'corte.php'),
(2, 'section-2', 'Tintura', 'Colores vibrantes y personalizados para realzar tu look.', 'section-2_1761108971.jpg', 'tintura.php'),
(3, 'section-3', 'Peinado', 'Peinados elegantes para cualquier ocasión especial.', 'section-3_1761109311.jpg', 'peinado.php'),
(4, 'section-4', 'Barba', 'Afeitado y diseño de barba profesional.', 'section-4_1761108991.jpg', 'barba.php'),
(5, 'section-5', 'Lavados', 'Lavado de cabello.', 'section-5_1761109211.jpg', 'tratamientos.php');

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
  `rol` varchar(50) DEFAULT 'cliente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `nombre`, `dni`, `edad`, `telefono`, `contrasena`, `correo`, `rol`) VALUES
(1, 'brian', '44982569', 22, '3704597493', '123456', 'brian@gmail.com', 'admin'),
(2, 'brian', '44555666', 22, '3704597493', '$2y$10$WQdMrI5RCOdyqQ/G3t/4CeVxiNjtJz56o8UYwFk3KN4ZLtJfEXify', 'brian1@gmail.com', 'admin'),
(3, 'dalila', '43807979', 24, '3704121212', '$2y$10$1GblGIiiiNW.bgGmr1ezqumkYKi7haYthNZv/3tlGKeeoHpFZKCLG', 'dali@gmail.com', 'cliente');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `contenidos`
--
ALTER TABLE `contenidos`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT;

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
