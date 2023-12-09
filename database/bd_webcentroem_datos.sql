-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 09-12-2023 a las 13:51:21
-- Versión del servidor: 8.0.30
-- Versión de PHP: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_webcentroem`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bot_telegrams`
--

CREATE TABLE `bot_telegrams` (
  `id` bigint UNSIGNED NOT NULL,
  `chat_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `comando` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `estado` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `bot_telegrams`
--

INSERT INTO `bot_telegrams` (`id`, `chat_id`, `comando`, `valor`, `estado`, `created_at`, `updated_at`) VALUES
(3, '255734496', '/start', NULL, 'ENVIADO', '2023-11-22 19:47:52', '2023-11-22 19:47:52'),
(4, '255734496', '/ci', '78945612', 'ENVIADO', '2023-11-22 19:47:52', '2023-11-22 19:48:09'),
(5, '255734496', '/start', NULL, 'ENVIADO', '2023-11-22 21:56:29', '2023-11-22 21:56:29'),
(6, '255734496', '/ci', '78945612', 'ENVIADO', '2023-11-22 21:56:29', '2023-11-22 22:00:34'),
(11, '255734496', '/confirmar', '7|SI', 'ENVIADO', '2023-11-22 22:30:37', '2023-11-22 22:30:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendario_atencions`
--

CREATE TABLE `calendario_atencions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `fecha_ini` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `calendario_atencions`
--

INSERT INTO `calendario_atencions` (`id`, `user_id`, `fecha_ini`, `fecha_fin`, `created_at`, `updated_at`) VALUES
(3, 16, '2023-12-20', '2023-12-25', '2023-12-06 21:42:52', '2023-12-06 21:42:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita_medica`
--

CREATE TABLE `cita_medica` (
  `id` int NOT NULL,
  `id_paciente` int NOT NULL,
  `id_especialidad` int NOT NULL,
  `id_doctor` bigint UNSIGNED NOT NULL,
  `fecha_cita` date NOT NULL,
  `hora` time NOT NULL,
  `estado` enum('PENDIENTE','ATENDIDO','NO ATENDIDO','CANCELADO') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'PENDIENTE',
  `prioridad` varchar(255) NOT NULL DEFAULT 'CONSULTA',
  `state` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `email_enviado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `cita_medica`
--

INSERT INTO `cita_medica` (`id`, `id_paciente`, `id_especialidad`, `id_doctor`, `fecha_cita`, `hora`, `estado`, `prioridad`, `state`, `created_at`, `updated_at`, `email_enviado`) VALUES
(1, 28, 2, 16, '2023-05-24', '08:00:00', 'ATENDIDO', 'BAJA', 1, '2023-05-22 20:34:51', '2023-12-09 09:48:34', 0),
(2, 42, 2, 16, '2023-05-24', '14:00:00', 'CANCELADO', 'MEDIA', 1, '2023-05-23 11:42:50', '2023-12-09 09:48:52', 0),
(3, 29, 2, 16, '2023-09-01', '08:15:00', 'NO ATENDIDO', 'CONSULTA', 1, '2023-08-31 12:41:32', '2023-10-06 10:05:24', 1),
(4, 30, 2, 16, '2023-09-01', '09:00:00', 'NO ATENDIDO', 'CONSULTA', 1, '2023-08-31 12:51:17', '2023-10-06 10:05:24', 1),
(5, 28, 1, 9, '2023-09-01', '08:00:00', 'NO ATENDIDO', 'ALTA', 1, '2023-08-31 13:23:28', '2023-12-09 09:49:04', 0),
(6, 34, 1, 9, '2023-09-01', '08:15:00', 'NO ATENDIDO', 'CONSULTA', 1, '2023-08-31 17:18:49', '2023-10-06 10:05:24', 0),
(7, 29, 2, 10, '2023-11-23', '08:00:00', 'NO ATENDIDO', 'CONSULTA', 1, '2023-11-22 18:13:22', '2023-12-06 11:09:54', 0),
(8, 28, 2, 16, '2023-12-07', '09:40:00', 'NO ATENDIDO', 'RECONSULTA', 1, '2023-12-06 17:44:33', '2023-12-09 09:48:23', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigo_usuario`
--

CREATE TABLE `codigo_usuario` (
  `id` int NOT NULL,
  `codigo` int NOT NULL,
  `id_role` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `codigo_usuario`
--

INSERT INTO `codigo_usuario` (`id`, `codigo`, `id_role`) VALUES
(1, 20001, 2),
(5, 10001, 1),
(6, 10002, 1),
(8, 20002, 2),
(9, 30001, 3),
(10, 10003, 1),
(11, 40001, 4),
(12, 40002, 4),
(16, 40003, 4),
(17, 40004, 4),
(18, 40005, 4),
(19, 20003, 2),
(20, 30002, 3),
(21, 20004, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conceptos`
--

CREATE TABLE `conceptos` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `costo` decimal(24,2) NOT NULL,
  `id_especialidad` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `conceptos`
--

INSERT INTO `conceptos` (`id`, `nombre`, `costo`, `id_especialidad`, `created_at`, `updated_at`) VALUES
(1, 'CONCEPTO #1', 200.00, 2, '2023-12-06 15:36:10', '2023-12-06 15:55:19'),
(2, 'CONCEPTO HUESOS', 340.00, 1, '2023-12-06 15:58:26', '2023-12-06 15:58:26'),
(3, 'CONCEPTO #2', 250.00, 2, '2023-12-06 15:59:12', '2023-12-06 15:59:12'),
(4, 'CONCEPTO HUESOS #2', 500.00, 1, '2023-12-06 15:59:27', '2023-12-06 15:59:27'),
(5, 'CONCEPTO #3', 700.00, 2, '2023-12-06 22:03:13', '2023-12-06 22:03:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int NOT NULL,
  `razon_social` varchar(150) NOT NULL,
  `alias` varchar(100) DEFAULT NULL,
  `ciudad` varchar(100) NOT NULL,
  `direccion` varchar(150) NOT NULL,
  `nit` varchar(20) DEFAULT NULL,
  `numero_autorizacion` varchar(100) DEFAULT NULL,
  `fecha_limite_emision` date DEFAULT NULL,
  `telefono` varchar(20) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `casilla` varchar(60) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `web` varchar(300) DEFAULT NULL,
  `logo` varchar(300) DEFAULT NULL,
  `actividad_economica` varchar(400) NOT NULL,
  `leyenda_factura` varchar(300) DEFAULT NULL,
  `cretated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `razon_social`, `alias`, `ciudad`, `direccion`, `nit`, `numero_autorizacion`, `fecha_limite_emision`, `telefono`, `celular`, `casilla`, `email`, `web`, `logo`, `actividad_economica`, `leyenda_factura`, `cretated_at`, `updated_at`) VALUES
(1, 'CLINICA DEL SUR', 'CLINICA DEL NORTE', 'SUCRE', 'Calle Rosendo Villa #14, Ciudad de Sucre. Bolivia.', '8574123', '7845126', '2022-04-23', '46457977', '74174112', '-', 'clinica@vida.net', 'http://clinica.com', '1696605647_photo_2023-10-06_09-28-33.jpg', 'SALVAR VIDAS', 'NUESTRO COMPROMISO ESTA CON LA SOCIEDAD', NULL, '2023-10-06 15:20:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctor_horarios`
--

CREATE TABLE `doctor_horarios` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `dia` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dia_num` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tm_hora_ini` time NOT NULL,
  `tm_hora_fin` time NOT NULL,
  `tt_hora_ini` time NOT NULL,
  `tt_hora_fin` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `doctor_horarios`
--

INSERT INTO `doctor_horarios` (`id`, `user_id`, `dia`, `dia_num`, `estado`, `tm_hora_ini`, `tm_hora_fin`, `tt_hora_ini`, `tt_hora_fin`, `created_at`, `updated_at`) VALUES
(1, 16, 'LUNES', '1', 'INACTIVO', '08:00:00', '12:00:00', '14:00:00', '18:00:00', '2023-05-19 20:04:31', '2023-05-19 20:45:41'),
(2, 16, 'MARTES', '2', 'ACTIVO', '08:00:00', '13:00:00', '14:00:00', '17:00:00', '2023-05-19 20:04:31', '2023-05-19 20:46:17'),
(3, 16, 'MIERCOLES', '3', 'ACTIVO', '08:00:00', '13:00:00', '14:00:00', '17:00:00', '2023-05-19 20:04:31', '2023-05-19 20:49:25'),
(4, 16, 'JUEVES', '4', 'ACTIVO', '08:00:00', '12:00:00', '14:00:00', '18:00:00', '2023-05-19 20:04:31', '2023-08-31 16:41:16'),
(5, 16, 'VIERNES', '5', 'ACTIVO', '08:00:00', '12:00:00', '14:00:00', '18:00:00', '2023-05-19 20:04:31', '2023-10-06 14:59:03'),
(6, 9, 'LUNES', '1', 'ACTIVO', '08:00:00', '12:00:00', '14:00:00', '18:00:00', '2023-08-31 17:22:51', '2023-08-31 17:22:51'),
(7, 9, 'MARTES', '2', 'ACTIVO', '08:00:00', '12:00:00', '14:00:00', '18:00:00', '2023-08-31 17:22:51', '2023-08-31 17:22:51'),
(8, 9, 'MIERCOLES', '3', 'ACTIVO', '08:00:00', '12:00:00', '14:00:00', '18:00:00', '2023-08-31 17:22:51', '2023-08-31 17:22:51'),
(9, 9, 'JUEVES', '4', 'ACTIVO', '08:00:00', '12:00:00', '14:00:00', '18:00:00', '2023-08-31 17:22:51', '2023-08-31 17:22:51'),
(10, 9, 'VIERNES', '5', 'ACTIVO', '08:00:00', '12:00:00', '14:00:00', '18:00:00', '2023-08-31 17:22:51', '2023-08-31 17:22:51'),
(11, 10, 'LUNES', '1', 'ACTIVO', '08:00:00', '12:00:00', '14:00:00', '18:00:00', '2023-10-06 15:09:24', '2023-10-06 15:09:24'),
(12, 10, 'MARTES', '2', 'ACTIVO', '08:00:00', '12:00:00', '14:00:00', '18:00:00', '2023-10-06 15:09:24', '2023-10-06 15:09:24'),
(13, 10, 'MIERCOLES', '3', 'ACTIVO', '08:00:00', '12:00:00', '14:00:00', '18:00:00', '2023-10-06 15:09:24', '2023-10-06 15:09:24'),
(14, 10, 'JUEVES', '4', 'ACTIVO', '08:00:00', '12:00:00', '14:00:00', '18:00:00', '2023-10-06 15:09:24', '2023-10-06 15:09:24'),
(15, 10, 'VIERNES', '5', 'ACTIVO', '08:00:00', '12:00:00', '14:00:00', '18:00:00', '2023-10-06 15:09:24', '2023-10-06 15:09:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidad`
--

CREATE TABLE `especialidad` (
  `id` int NOT NULL,
  `especialidad` varchar(300) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `state` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `especialidad`
--

INSERT INTO `especialidad` (`id`, `especialidad`, `state`, `created_at`, `updated_at`) VALUES
(1, 'HUESOS', 1, '2021-07-07 05:43:47', '2021-07-07 05:43:47'),
(2, 'MUSCULOS', 1, '2021-07-07 05:43:53', '2021-07-07 05:43:53'),
(3, 'RAYOS-X', 1, '2021-07-07 05:44:06', '2021-07-07 05:44:06'),
(4, 'OPERACIONES', 1, '2021-07-07 05:44:29', '2021-07-07 05:44:29'),
(5, 'OFTALMOLOGIA', 1, '2021-07-13 04:11:56', '2023-05-19 18:54:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `id` int NOT NULL,
  `id_paciente` int DEFAULT NULL,
  `tipo_paciente` varchar(255) NOT NULL,
  `institucion` varchar(255) DEFAULT NULL,
  `id_especialidad` int NOT NULL,
  `numero_autorizacion` varchar(110) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `codigo_control` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `fecha_limite_emision` date NOT NULL,
  `paciente_nombre` varchar(300) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `paciente_ci` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `fecha_factura` date NOT NULL,
  `nro_factura` int NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `descuento` decimal(24,2) NOT NULL DEFAULT '0.00',
  `monto_total` decimal(24,2) NOT NULL,
  `state` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`id`, `id_paciente`, `tipo_paciente`, `institucion`, `id_especialidad`, `numero_autorizacion`, `codigo_control`, `fecha_limite_emision`, `paciente_nombre`, `paciente_ci`, `fecha_factura`, `nro_factura`, `monto`, `descuento`, `monto_total`, `state`, `created_at`, `updated_at`) VALUES
(22, NULL, 'PACIENTE PARTICULAR', NULL, 1, '7845126', '15-H8-K7-A9-V6', '2022-04-23', 'JPERES', '9999', '2023-12-09', 21, 840.00, 0.00, 840.00, 1, '2023-12-09 13:19:21', '2023-12-09 09:19:21'),
(23, NULL, 'PACIENTE PARTICULAR', NULL, 2, '7845126', '72-66-11-52-00', '2022-04-23', 'JPERES #2', '0000', '2023-12-09', 22, 450.00, 50.00, 400.00, 1, '2023-12-09 13:26:43', '2023-12-09 09:26:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_conceptos`
--

CREATE TABLE `factura_conceptos` (
  `id` bigint UNSIGNED NOT NULL,
  `id_factura` bigint UNSIGNED NOT NULL,
  `id_concepto` bigint UNSIGNED NOT NULL,
  `concepto` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `costo` decimal(24,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `factura_conceptos`
--

INSERT INTO `factura_conceptos` (`id`, `id_factura`, `id_concepto`, `concepto`, `costo`, `created_at`, `updated_at`) VALUES
(1, 22, 2, 'CONCEPTO HUESOS', 340.00, '2023-12-09 13:19:21', '2023-12-09 13:19:21'),
(2, 22, 4, 'CONCEPTO HUESOS #2', 500.00, '2023-12-09 13:19:21', '2023-12-09 13:19:21'),
(3, 23, 1, 'CONCEPTO #1', 200.00, '2023-12-09 13:26:43', '2023-12-09 13:26:43'),
(4, 23, 3, 'CONCEPTO #2', 250.00, '2023-12-09 13:26:43', '2023-12-09 13:26:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_clinico`
--

CREATE TABLE `historial_clinico` (
  `id` int NOT NULL,
  `id_persona` int NOT NULL,
  `id_especialidad` int NOT NULL,
  `id_persona_doctor` int NOT NULL,
  `motivo_consulta` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `dolencia_actual` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `antecedente_familiar` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `antecedente_personal` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `diagnostico` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `state` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `historial_clinico`
--

INSERT INTO `historial_clinico` (`id`, `id_persona`, `id_especialidad`, `id_persona_doctor`, `motivo_consulta`, `dolencia_actual`, `antecedente_familiar`, `antecedente_personal`, `diagnostico`, `fecha_hora`, `state`, `created_at`, `updated_at`) VALUES
(1, 28, 1, 24, 'Motivo', 'dolencia.', 'antecendentes.', 'personales.', 'diagnostico.', '2021-07-16 16:01:00', 1, '2021-07-10 08:01:36', '2021-07-10 08:16:00'),
(2, 28, 1, 24, 'MOTIVOS', 'DOLENCIAS', 'ANTECEDENTES', 'PERSONALES', 'DIAGNOSTICO', '2021-07-10 10:10:00', 1, '2021-07-10 21:41:10', '2021-07-10 22:24:34'),
(3, 29, 1, 1, 'EL TRATAMIENTO TRATA DE FORTALECER LAS DEFENSAS DEL CUERPO HUMANO, TANTO MENTALES COMO FISICAS, ES\r\nPRIMORDIAL ESTUDIAR EL ENCEFALO SUPERIOR, EL TRATAMIENTO TRATA DE FORTALECER LAS DEFENSAS DEL CUERPO\r\nHUMANO, TANTO MENTALES COMO FISICAS, ES PRIMORDIAL ESTUDIAR EL ENCEFALO SUPERIOR, EL TRATAMIENTO TRATA', 'EL TRATAMIENTO TRATA DE FORTALECER LAS DEFENSAS DEL CUERPO HUMANO, TANTO MENTALES COMO FISICAS, ES\r\nPRIMORDIAL ESTUDIAR EL ENCEFALO SUPERIOR, EL TRATAMIENTO TRATA DE FORTALECER LAS DEFENSAS DEL CUERPO\r\nHUMANO, TANTO MENTALES COMO FISICAS, ES PRIMORDIAL ESTUDIAR EL ENCEFALO SUPERIOR, EL TRATAMIENTO TRATA', 'EL TRATAMIENTO TRATA DE FORTALECER LAS DEFENSAS DEL CUERPO HUMANO, TANTO MENTALES COMO FISICAS, ES\r\nPRIMORDIAL ESTUDIAR EL ENCEFALO SUPERIOR, EL TRATAMIENTO TRATA DE FORTALECER LAS DEFENSAS DEL CUERPO\r\nHUMANO, TANTO MENTALES COMO FISICAS, ES PRIMORDIAL ESTUDIAR EL ENCEFALO SUPERIOR, EL TRATAMIENTO TRATA', 'EL TRATAMIENTO TRATA DE FORTALECER LAS DEFENSAS DEL CUERPO HUMANO, TANTO MENTALES COMO FISICAS, ES\r\nPRIMORDIAL ESTUDIAR EL ENCEFALO SUPERIOR, EL TRATAMIENTO TRATA DE FORTALECER LAS DEFENSAS DEL CUERPO\r\nHUMANO, TANTO MENTALES COMO FISICAS, ES PRIMORDIAL ESTUDIAR EL ENCEFALO SUPERIOR, EL TRATAMIENTO TRATA', 'EL TRATAMIENTO TRATA DE FORTALECER LAS DEFENSAS DEL CUERPO HUMANO, TANTO MENTALES COMO FISICAS, ES\r\nPRIMORDIAL ESTUDIAR EL ENCEFALO SUPERIOR, EL TRATAMIENTO TRATA DE FORTALECER LAS DEFENSAS DEL CUERPO\r\nHUMANO, TANTO MENTALES COMO FISICAS, ES PRIMORDIAL ESTUDIAR EL ENCEFALO SUPERIOR, EL TRATAMIENTO TRATA', '2021-07-10 23:10:00', 1, '2021-07-11 01:05:07', '2021-07-16 17:56:34'),
(4, 28, 1, 31, '.', '.', '.', '.', '.', '2021-07-17 10:20:00', 1, '2021-07-17 21:18:08', '2021-07-17 21:18:08'),
(5, 30, 5, 1, '..', '.', '.', '.', '.', '2021-07-11 10:11:00', 1, '2021-07-17 21:33:10', '2021-07-17 21:33:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horas`
--

CREATE TABLE `horas` (
  `id` int NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `horas`
--

INSERT INTO `horas` (`id`, `hora`) VALUES
(1, '10:00:00'),
(2, '10:30:00'),
(3, '11:00:00'),
(4, '11:30:00'),
(5, '12:00:00'),
(6, '12:30:00'),
(7, '13:00:00'),
(8, '13:30:00'),
(9, '14:00:00'),
(10, '14:30:00'),
(11, '15:00:00'),
(12, '15:30:00'),
(13, '16:00:00'),
(14, '16:30:00'),
(15, '17:00:00'),
(16, '17:30:00'),
(17, '18:00:00'),
(18, '18:30:00'),
(19, '19:00:00'),
(20, '19:30:00'),
(21, '20:00:00'),
(22, '20:30:00'),
(23, '21:00:00'),
(24, '21:30:00'),
(25, '22:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `intervalo_horarios`
--

CREATE TABLE `intervalo_horarios` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `intervalo` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `intervalo_horarios`
--

INSERT INTO `intervalo_horarios` (`id`, `user_id`, `intervalo`, `created_at`, `updated_at`) VALUES
(1, 16, 20, '2023-10-06 14:56:21', '2023-10-06 15:04:31'),
(2, 9, 30, '2023-10-06 15:08:01', '2023-10-06 15:08:55'),
(3, 10, 15, '2023-10-06 15:09:24', '2023-10-06 15:09:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mes`
--

CREATE TABLE `mes` (
  `id` int NOT NULL,
  `mes` varchar(20) NOT NULL,
  `state` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `mes`
--

INSERT INTO `mes` (`id`, `mes`, `state`, `created_at`, `updated_at`) VALUES
(1, 'ENERO', 1, NULL, NULL),
(2, 'FEBRERO', 1, NULL, NULL),
(3, 'MARZO', 1, NULL, NULL),
(4, 'ABRIL', 1, NULL, NULL),
(5, 'MAYO', 1, NULL, NULL),
(6, 'JUNIO', 1, NULL, NULL),
(7, 'JULIO', 1, NULL, NULL),
(8, 'AGOSTO', 1, NULL, NULL),
(9, 'SEPTIEMBRE', 1, NULL, NULL),
(10, 'OCTUBRE', 1, NULL, NULL),
(11, 'NOVIEMBRE', 1, NULL, NULL),
(12, 'DICIEMBRE', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(2, '2023_05_19_152113_create_doctor_horarios_table', 1),
(3, '2023_05_23_121319_create_persona_telegrams_table', 2),
(4, '2023_05_23_121623_create_bot_telegrams_table', 3),
(5, '2023_05_23_123807_create_telegram_updates_table', 4),
(6, '2023_05_23_151427_create_recordatorios_table', 5),
(7, '2023_12_06_161938_create_calendario_antecions_table', 6),
(8, '2023_12_06_162203_create_calendario_atencions_table', 7),
(9, '2023_12_09_091035_create_factura_conceptos_table', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` int NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Registrar permiso', 'permiso.registrarPermiso', 'Permiso para registrar permisos', '2020-04-27 00:00:00', '2020-04-27 15:40:50'),
(2, 'Modificar permiso', 'permiso.modificarPermiso', 'Permiso para modificar un permiso', '2020-04-27 15:45:42', '2020-04-27 15:45:42'),
(3, 'Menu.Gestion.Usuarios', 'menu.gestion.usuarios', 'Permite visualizar el menu Gestión.Usuarios', '2020-05-05 21:32:59', '2020-05-05 21:32:59'),
(4, 'Menu.Form.Buscar.Usuario', 'menu.form.buscar.usuario', 'Permite visualizar el Menu.Form.Buscar.Usuario', '2020-05-05 21:33:44', '2020-05-05 21:33:44'),
(5, 'Menu.Roles', 'menu.roles', 'Permite visualizar el menu Roles', '2020-05-05 21:34:16', '2020-05-05 21:34:16'),
(6, 'Menu.Permisos', 'menu.permisos', 'Permite visualizar el menu Permisos', '2020-05-05 21:34:28', '2020-05-05 21:34:28'),
(7, 'Menu.Catalogos', 'menu.catalogos', 'Permite visualizar el catalogos', '2020-05-09 23:34:44', '2020-05-09 23:34:44'),
(51, 'ADMINISTRAR PACIENTES', 'administrar.pacientes', '.', '2021-07-16 15:28:23', '2021-07-16 15:28:23'),
(52, 'ADMINISTRAR ASIGNACION DE ESPECIALIDADES', 'administrar.asignacion.especialidad', '.', '2021-07-16 15:28:57', '2021-07-16 15:28:57'),
(53, 'ADMINISTRAR HISTORIALES CLINICOS', 'administrar.historiales.clinicos', '.', '2021-07-16 15:29:21', '2021-07-16 15:29:21'),
(54, 'ADMINISTRAR SEGUIMIENTO CONTROL', 'administrar.seguimiento.control', '.', '2021-07-16 15:30:56', '2021-07-16 15:30:56'),
(55, 'GENERAR REPORTES', 'generar.reportes', '.', '2021-07-16 15:31:26', '2021-07-16 15:31:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permission_role`
--

CREATE TABLE `permission_role` (
  `id` int NOT NULL,
  `permission_id` int NOT NULL,
  `role_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `permission_role`
--

INSERT INTO `permission_role` (`id`, `permission_id`, `role_id`, `created_at`, `updated_at`) VALUES
(4, 1, 1, '2020-05-05 04:00:00', '2020-05-05 04:00:00'),
(8, 7, 1, '2021-07-16 19:32:17', '2021-07-16 19:32:17'),
(9, 51, 1, '2021-07-16 19:32:17', '2021-07-16 19:32:17'),
(10, 52, 1, '2021-07-16 19:32:17', '2021-07-16 19:32:17'),
(11, 53, 1, '2021-07-16 19:32:17', '2021-07-16 19:32:17'),
(12, 54, 1, '2021-07-16 19:32:17', '2021-07-16 19:32:17'),
(13, 55, 1, '2021-07-16 19:32:17', '2021-07-16 19:32:17'),
(14, 51, 2, '2021-07-16 19:34:15', '2021-07-16 19:34:15'),
(16, 53, 2, '2021-07-16 19:34:15', '2021-07-16 19:34:15'),
(17, 54, 2, '2021-07-16 19:34:15', '2021-07-16 19:34:15'),
(18, 55, 2, '2021-07-16 19:34:15', '2021-07-16 19:34:15'),
(19, 51, 3, '2021-07-16 19:35:15', '2021-07-16 19:35:15'),
(20, 53, 3, '2021-07-16 19:35:15', '2021-07-16 19:35:15'),
(21, 55, 3, '2021-07-16 19:35:15', '2021-07-16 19:35:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permission_user`
--

CREATE TABLE `permission_user` (
  `id` int NOT NULL,
  `permission_id` int NOT NULL,
  `user_id` int NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `id` int NOT NULL COMMENT 'numero_documento,paterno,materno,nombre1,nombre2',
  `id_user` int DEFAULT NULL,
  `ci` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `paterno` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `materno` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `genero` enum('HOMBRE','MUJER','OTRO') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `foto` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `telefono` varchar(8) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `celular` varchar(8) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `estado_civil` enum('SOLTERO','CASADO','VIUDO','DIVORCIADO','CONVIVIENTE','') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `edad` int DEFAULT NULL,
  `direccion` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `state` tinyint(1) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `lugar_nacimiento` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `id_especialidad` int DEFAULT NULL,
  `domicilio` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `familiar_responsable` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `id_role` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id`, `id_user`, `ci`, `paterno`, `materno`, `nombre`, `genero`, `foto`, `telefono`, `celular`, `estado_civil`, `fecha_nacimiento`, `edad`, `direccion`, `email`, `state`, `created_at`, `updated_at`, `lugar_nacimiento`, `id_especialidad`, `domicilio`, `familiar_responsable`, `id_role`) VALUES
(1, 1, '8009525', 'LAURA', 'GUTIERREZ', 'MELANI', '', '1626550531_New-Sac-Kings-Logo-3.0.jpg', '75635412', '85452111', 'SOLTERO', '1985-03-02', 0, '.', 'melani@gmail.com', 1, NULL, '2021-07-17 19:35:31', '', NULL, '', '', 1),
(22, 7, '9214785', 'PEREZ', 'AQUINO', 'LUIS', NULL, '1625873075_New-Sac-Kings-Logo-3.0.jpg', '7777777', '7777777', 'SOLTERO', NULL, NULL, '.', 'fulanito@gmail.com', 1, '2021-07-09 23:24:36', '2021-07-17 16:46:07', NULL, NULL, NULL, NULL, 1),
(23, 8, '852364', 'TITO', 'MAIZ', 'JUAN', NULL, '1625873166_mision.jpg', '7777777', '7777777', 'SOLTERO', NULL, NULL, '.', 'juan@webcentroem.com', 1, '2021-07-09 23:26:06', '2023-10-06 10:40:27', NULL, NULL, NULL, NULL, 1),
(24, 9, '7412586', 'MANTIS', 'RELIGIOSA', 'LUCIA', NULL, '1625873204_New-Sac-Kings-Logo-3.0.jpg', '7777777', '7777777', 'SOLTERO', NULL, NULL, '.', 'lucia@webcentroem.com', 1, '2021-07-09 23:26:44', '2023-10-06 10:40:27', NULL, 1, NULL, NULL, 2),
(25, 10, '74125321', 'CONDORI', 'CHUQUIMIA', 'FREDDY', NULL, '1625873327_mision.jpg', '7777777', '7777777', 'SOLTERO', NULL, NULL, '.', 'freddy@webcentroem.com', 1, '2021-07-09 23:28:47', '2023-10-06 10:40:27', NULL, 2, NULL, NULL, 2),
(26, 11, '7412321', 'YUJRA', 'VALENCIA', 'MARIA', NULL, '1625873390_mision.jpg', '7777777', '7777777', 'SOLTERO', NULL, NULL, '.', 'maria@webcentroem.com', 1, '2021-07-09 23:29:50', '2023-11-01 11:15:12', NULL, 2, NULL, NULL, 3),
(27, 12, '1232145', 'MARTINS', 'LEON', 'LUCAS', NULL, '1625873432_New-Sac-Kings-Logo-3.0.jpg', '7777777', '7777777', 'SOLTERO', NULL, NULL, '.', 'lucas@webcentroem.com', 1, '2021-07-09 23:30:32', '2023-10-06 10:40:27', NULL, NULL, NULL, NULL, 1),
(28, 13, '78945612', '', '', 'ALBERTO', 'HOMBRE', '1625948854_vision.jpg', '', NULL, '', '2021-01-01', 20, '', '', 1, '2021-07-10 00:58:28', '2021-07-10 20:27:34', '', 1, 'EN SU CASA', '', 4),
(29, 14, '78945612', 'PEREZ', 'MAIZ', 'NANCI', 'MUJER', '1625940543_mision.jpg', '7451241', NULL, 'CONVIVIENTE', '2021-01-01', 20, '', 'NANCI@GMAIL.COM', 1, '2021-07-10 00:59:04', '2021-07-10 18:09:03', 'EN SU CASA', 1, 'EN SU CASA', 'UN SEñOR RESPONSABLE', 4),
(30, 15, '8411254', 'PEREZ', 'ZUARES', 'KIMBERLI', 'MUJER', NULL, '', NULL, 'SOLTERO', '2011-01-01', 10, '', '', 1, '2021-07-13 23:45:59', '2021-07-13 23:45:59', '', 5, '.', '', 4),
(31, 16, '12345678 LP', 'BERRIOS', 'CHAMBI', 'RUBEN', NULL, '1626540905_New-Sac-Kings-Logo-3.0.jpg', '77747477', '74747474', 'SOLTERO', NULL, NULL, 'LA PAZ, TEMBLADERANI #500', 'ruben@gmail.com', 1, '2021-07-17 16:55:05', '2021-08-21 19:49:11', NULL, 2, NULL, NULL, 2),
(32, 17, '4747478', '', '', 'NORMA', NULL, '1628549855_BRUJULA.jpg', '74747474', '74747474', 'SOLTERO', NULL, NULL, 'CERCA DE ALLA', 'norma@webcentroem.com', 1, '2021-08-09 22:57:35', '2023-10-06 10:40:27', NULL, 1, NULL, NULL, 3),
(34, 18, '1414145', 'PERES', 'PERES', 'LIMBER', 'HOMBRE', '1628566211_BRUJULA.jpg', '74747474', NULL, 'SOLTERO', '1990-10-10', 31, '', 'limber@gmail.com', 1, '2021-08-10 03:30:11', '2021-08-10 03:30:12', 'LA PAZ', 1, 'MI CASA', 'RUBEN', 4),
(35, 19, '7474744774', 'PATERNO', 'MATERNO', 'LIMBER', 'HOMBRE', NULL, '74747474', NULL, '', '1990-10-10', 20, '', 'limberl@gmail.com', 1, '2021-08-10 03:51:48', '2021-08-10 03:51:48', 'LA PAZ', 1, '.', 'RUBEN', 4),
(36, 20, '8787875', 'PEREZ', 'AQUINO', 'PETER', 'HOMBRE', '1628949770_BRUJULA.jpg', '74747474', NULL, 'CASADO', '1990-10-10', 31, '', 'peter@gmail.com', 1, '2021-08-14 14:02:51', '2021-08-14 14:02:52', 'LA PAZ', 1, 'LA PAZ - SOPOCACHI', 'RUBEN', 4),
(37, 21, '7654321', 'PEREZ', 'SANCHEZ', 'MONICA', 'MUJER', '1630252515_BRUJULA.jpg', '69584748', NULL, 'CASADO', '1985-10-10', 35, '', 'monica@gmail.com', 1, '2021-08-29 15:55:15', '2021-08-29 15:55:15', 'LA PAZ', 3, 'LA PAZ', 'DON JHONNY', 4),
(40, 24, '123456', 'MENDOZA', 'PAREDES', 'RAFAEL', 'HOMBRE', '1632165006_0 (1).jpg', '2885652', NULL, 'SOLTERO', '1990-05-12', 31, '', 'unetehost@gmail.com', 1, '2021-09-20 19:10:06', '2021-09-20 19:10:06', 'LA PAZ', 1, 'ZONA CENTRAL CALLE 3', 'JUAN MENDOZA', 4),
(41, 25, '55555', 'MORALES', '', 'JOSE', NULL, '1684855708_user_default.png', '22222', '777777', 'SOLTERO', NULL, NULL, 'LOS OLIVOS', 'jose@webcentroem.com', 1, '2023-05-23 15:28:28', '2023-10-06 10:40:27', NULL, NULL, NULL, NULL, 1),
(42, 26, '3333', 'GUTIERREZ', 'MAMANI', 'PAMELA', 'MUJER', NULL, '', NULL, '', '1999-03-22', 24, '', 'pamela@gmail.com', 1, '2023-05-23 11:40:24', '2023-08-31 10:51:38', 'LA PAZ', 1, 'LOS OLIVOS', '', 4),
(43, 27, '6666', 'ALCANTARA', 'MARTINEZ', 'PEDRO', 'HOMBRE', NULL, '222222', NULL, '', '1999-01-01', 24, '', 'pedro@gmail.com', 1, '2023-05-23 11:50:48', '2023-05-23 11:51:16', '', 2, 'LOS OLIVOS', '', 4),
(44, 28, '9090', 'GONZALES', 'GONZALES', 'ELVIS', 'HOMBRE', NULL, '', NULL, '', '2000-01-01', 23, '', 'elvis@gmail.com', 1, '2023-12-06 17:57:56', '2023-12-06 17:57:56', '', 2, 'LOS OLIVOS', '', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona_telegrams`
--

CREATE TABLE `persona_telegrams` (
  `id` bigint UNSIGNED NOT NULL,
  `persona_id` bigint UNSIGNED NOT NULL,
  `chat_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `persona_telegrams`
--

INSERT INTO `persona_telegrams` (`id`, `persona_id`, `chat_id`, `created_at`, `updated_at`) VALUES
(2, 29, '255734496', '2023-11-22 19:48:09', '2023-11-22 19:48:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prueba`
--

CREATE TABLE `prueba` (
  `id` int NOT NULL,
  `saludo` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `prueba`
--

INSERT INTO `prueba` (`id`, `saludo`, `created_at`) VALUES
(1, 'hola', '2021-08-29 14:18:47'),
(2, 'hola', '2021-08-29 14:57:06'),
(3, 'hola', '2021-08-29 14:57:20'),
(4, 'hola', '2021-08-29 15:14:00'),
(5, 'hola', '2021-08-29 15:15:00'),
(6, 'hola', '2021-08-29 15:31:00'),
(7, 'hola', '2021-08-29 15:32:00'),
(8, 'hola', '2021-08-29 15:35:00'),
(9, 'hola', '2021-08-29 15:36:00'),
(10, 'hola', '2021-08-29 15:40:00'),
(11, 'hola', '2021-08-29 15:41:00'),
(12, 'hola', '2021-08-29 15:42:00'),
(13, 'hola', '2021-08-29 15:43:00'),
(14, 'hola', '2021-08-29 15:44:00'),
(15, 'hola', '2021-08-29 15:45:00'),
(16, 'hola', '2021-08-29 15:46:00'),
(17, 'hola', '2021-08-29 15:47:00'),
(18, 'hola', '2021-08-29 15:48:00'),
(19, 'hola', '2021-08-29 15:49:00'),
(20, 'hola', '2021-08-29 15:50:00'),
(21, 'hola', '2021-08-29 15:52:00'),
(22, 'hola', '2021-08-29 15:53:00'),
(23, 'hola', '2021-08-29 15:54:00'),
(24, 'hola', '2021-08-29 15:55:00'),
(25, 'hola', '2021-08-29 15:56:00'),
(26, 'hola', '2021-08-29 15:57:00'),
(27, 'hola', '2021-08-29 15:58:00'),
(28, 'hola', '2021-08-29 16:01:00'),
(29, 'hola', '2021-08-29 16:01:00'),
(30, 'hola', '2021-08-29 16:02:00'),
(31, 'hola', '2021-08-29 16:02:00'),
(32, 'hola', '2021-08-29 16:03:00'),
(33, 'hola', '2021-08-29 16:03:00'),
(34, 'hola', '2021-08-29 16:04:00'),
(35, 'hola', '2021-08-29 16:04:00'),
(36, 'hola', '2021-08-29 16:05:00'),
(37, 'hola', '2021-08-29 16:05:00'),
(38, 'hola', '2021-08-29 16:06:46'),
(39, 'hola', '2021-08-29 16:07:02'),
(40, 'hola', '2021-08-29 16:07:07'),
(41, 'hola', '2021-08-29 16:08:54'),
(42, 'hola', '2021-09-15 19:08:01'),
(43, 'hola', '2021-09-15 19:09:00'),
(44, 'hola', '2021-09-15 19:10:00'),
(45, 'hola', '2021-09-15 19:11:00'),
(46, 'hola', '2021-09-15 19:12:00'),
(47, 'hola', '2021-09-15 19:13:00'),
(48, 'hola', '2021-09-15 19:14:00'),
(49, 'hola', '2021-09-15 19:15:00'),
(50, 'hola', '2021-09-15 19:16:00'),
(51, 'hola', '2021-09-15 19:17:00'),
(52, 'hola', '2021-09-15 19:18:00'),
(53, 'hola', '2021-09-15 19:19:00'),
(54, 'hola', '2021-09-15 19:20:00'),
(55, 'hola', '2021-09-15 19:21:00'),
(56, 'hola', '2021-09-15 19:22:00'),
(57, 'hola', '2021-09-15 19:23:00'),
(58, 'hola', '2021-09-15 19:24:00'),
(59, 'hola', '2021-09-15 19:25:00'),
(60, 'hola', '2021-09-15 19:26:00'),
(61, 'hola', '2021-09-15 19:27:00'),
(62, 'hola', '2021-09-15 19:28:00'),
(63, 'hola', '2021-09-15 19:29:00'),
(64, 'hola', '2021-09-15 19:30:00'),
(65, 'hola', '2021-09-15 19:31:00'),
(66, 'hola', '2021-09-15 19:32:00'),
(67, 'hola', '2021-09-15 19:33:00'),
(68, 'hola', '2021-09-15 19:34:00'),
(69, 'hola', '2021-09-15 19:35:00'),
(70, 'hola', '2021-09-15 19:36:00'),
(71, 'hola', '2021-09-15 19:37:00'),
(72, 'hola', '2021-09-15 19:38:00'),
(73, 'hola', '2021-09-15 19:39:00'),
(74, 'hola', '2021-09-15 19:40:00'),
(75, 'hola', '2021-09-15 19:41:00'),
(76, 'hola', '2021-09-15 19:42:00'),
(77, 'hola', '2021-09-15 19:43:00'),
(78, 'hola', '2021-09-15 19:44:00'),
(79, 'hola', '2021-09-15 19:45:00'),
(80, 'hola', '2021-09-15 19:46:00'),
(81, 'hola', '2021-09-15 19:47:00'),
(82, 'hola', '2021-09-15 19:48:00'),
(83, 'hola', '2021-09-15 19:49:00'),
(84, 'hola', '2021-09-15 19:50:00'),
(85, 'hola', '2021-09-15 19:51:00'),
(86, 'hola', '2021-09-15 19:52:00'),
(87, 'hola', '2021-09-15 19:53:00'),
(88, 'hola', '2021-09-15 19:54:00'),
(89, 'hola', '2021-09-15 19:55:00'),
(90, 'hola', '2021-09-16 19:35:01'),
(91, 'hola', '2021-09-16 19:36:00'),
(92, 'hola', '2021-09-16 19:37:00'),
(93, 'hola', '2021-09-16 19:38:00'),
(94, 'hola', '2021-09-16 19:39:00'),
(95, 'hola', '2021-09-16 19:40:00'),
(96, 'hola', '2021-09-16 19:41:00'),
(97, 'hola', '2021-09-16 19:42:00'),
(98, 'hola', '2021-09-16 19:43:00'),
(99, 'hola', '2021-09-16 19:44:00'),
(100, 'hola', '2021-09-16 19:45:00'),
(101, 'hola', '2021-09-16 19:46:00'),
(102, 'hola', '2021-09-16 19:47:00'),
(103, 'hola', '2021-09-16 19:48:00'),
(104, 'hola', '2021-09-16 19:49:00'),
(105, 'hola', '2021-09-16 19:50:00'),
(106, 'hola', '2021-09-16 19:51:00'),
(107, 'hola', '2021-09-16 19:52:00'),
(108, 'hola', '2021-09-16 19:53:00'),
(109, 'hola', '2021-09-16 19:54:00'),
(110, 'hola', '2021-09-16 19:55:00'),
(111, 'hola', '2021-09-16 19:56:00'),
(112, 'hola', '2021-09-16 19:57:00'),
(113, 'hola', '2021-09-16 19:58:00'),
(114, 'hola', '2021-09-16 19:59:00'),
(115, 'hola', '2021-09-16 20:00:00'),
(116, 'hola', '2021-09-16 20:01:00'),
(117, 'hola', '2021-09-16 20:02:00'),
(118, 'hola', '2021-09-16 20:03:00'),
(119, 'hola', '2021-09-16 20:04:00'),
(120, 'hola', '2021-09-16 20:05:00'),
(121, 'hola', '2021-09-16 20:06:00'),
(122, 'hola', '2021-09-16 20:07:00'),
(123, 'hola', '2021-09-16 20:08:00'),
(124, 'hola', '2021-09-16 20:09:00'),
(125, 'hola', '2021-09-16 20:10:00'),
(126, 'hola', '2021-09-16 20:11:00'),
(127, 'hola', '2021-09-16 20:12:00'),
(128, 'hola', '2021-09-16 20:12:01'),
(129, 'hola', '2021-09-16 20:13:00'),
(130, 'hola', '2021-09-16 20:13:00'),
(131, 'hola', '2021-09-16 20:14:00'),
(132, 'hola', '2021-09-16 20:14:00'),
(133, 'hola', '2021-09-16 20:15:00'),
(134, 'hola', '2021-09-16 20:15:00'),
(135, 'hola', '2021-09-16 20:16:00'),
(136, 'hola', '2021-09-16 20:16:00'),
(137, 'hola', '2021-09-16 20:17:00'),
(138, 'hola', '2021-09-16 20:17:00'),
(139, 'hola', '2021-09-16 20:22:00'),
(140, 'hola', '2021-09-16 20:23:00'),
(141, 'hola', '2021-09-16 20:24:00'),
(142, 'hola', '2021-09-16 20:25:00'),
(143, 'hola', '2021-09-16 20:26:00'),
(144, 'hola', '2021-09-16 20:27:00'),
(145, 'hola', '2021-09-16 20:28:00'),
(146, 'hola', '2021-09-16 20:29:00'),
(147, 'hola', '2021-09-16 20:30:00'),
(148, 'hola', '2021-09-16 20:31:00'),
(149, 'hola', '2021-09-16 20:32:00'),
(150, 'hola', '2021-09-16 20:33:00'),
(151, 'hola', '2021-09-16 20:34:00'),
(152, 'hola', '2021-09-16 20:35:00'),
(153, 'hola', '2021-09-16 20:36:00'),
(154, 'hola', '2021-09-16 20:37:00'),
(155, 'hola', '2021-09-16 20:38:00'),
(156, 'hola', '2021-09-16 20:39:00'),
(157, 'hola', '2021-09-16 20:40:00'),
(158, 'hola', '2021-09-16 20:41:00'),
(159, 'hola', '2021-09-16 20:42:00'),
(160, 'hola', '2021-09-16 20:43:00'),
(161, 'hola', '2021-09-16 20:44:00'),
(162, 'hola', '2021-09-16 20:45:00'),
(163, 'hola', '2021-09-16 20:46:00'),
(164, 'hola', '2021-09-16 20:47:00'),
(165, 'hola', '2021-09-16 20:48:00'),
(166, 'hola', '2021-09-16 20:49:00'),
(167, 'hola', '2021-09-16 20:50:00'),
(168, 'hola', '2021-09-16 20:51:01'),
(169, 'hola', '2021-09-16 20:52:00'),
(170, 'hola', '2021-09-16 20:53:00'),
(171, 'hola', '2021-09-16 20:54:00'),
(172, 'hola', '2021-09-16 20:55:00'),
(173, 'hola', '2021-09-16 20:56:00'),
(174, 'hola', '2021-09-16 20:57:00'),
(175, 'hola', '2021-09-16 20:58:00'),
(176, 'hola', '2021-09-16 20:59:00'),
(177, 'hola', '2021-09-16 21:00:00'),
(178, 'hola', '2021-09-16 21:01:00'),
(179, 'hola', '2021-09-16 21:02:00'),
(180, 'hola', '2021-09-16 21:03:00'),
(181, 'hola', '2021-09-16 21:04:00'),
(182, 'hola', '2021-09-16 21:05:01'),
(183, 'hola', '2021-09-16 21:06:00'),
(184, 'hola', '2021-09-16 21:07:00'),
(185, 'hola', '2021-09-16 21:08:00'),
(186, 'hola', '2021-09-16 21:09:00'),
(187, 'hola', '2021-09-16 21:10:00'),
(188, 'hola', '2021-09-16 21:11:00'),
(189, 'hola', '2021-09-16 21:12:00'),
(190, 'hola', '2021-09-16 21:13:00'),
(191, 'hola', '2021-09-16 21:14:00'),
(192, 'hola', '2021-09-16 21:15:00'),
(193, 'hola', '2021-09-16 21:16:00'),
(194, 'hola', '2021-09-16 21:17:00'),
(195, 'hola', '2021-09-16 21:18:00'),
(196, 'hola', '2021-09-16 21:19:00'),
(197, 'hola', '2021-09-16 21:20:00'),
(198, 'hola', '2021-09-16 21:21:01'),
(199, 'hola', '2021-09-16 21:22:25'),
(200, 'hola', '2021-09-16 21:23:01'),
(201, 'hola', '2021-09-16 21:24:00'),
(202, 'hola', '2021-09-16 21:25:00'),
(203, 'hola', '2021-09-16 21:26:00'),
(204, 'hola', '2021-09-16 21:27:01'),
(205, 'hola', '2021-09-16 21:28:00'),
(206, 'hola', '2021-09-16 21:29:01'),
(207, 'hola', '2021-09-16 21:30:00'),
(208, 'hola', '2021-09-16 21:31:00'),
(209, 'hola', '2021-09-16 21:32:00'),
(210, 'hola', '2021-09-16 21:33:00'),
(211, 'hola', '2021-09-16 21:34:00'),
(212, 'hola', '2021-09-16 21:35:00'),
(213, 'hola', '2021-09-16 21:36:00'),
(214, 'hola', '2021-09-16 21:37:00'),
(215, 'hola', '2021-09-16 21:38:01'),
(216, 'hola', '2021-09-16 21:39:00'),
(217, 'hola', '2021-09-16 21:40:00'),
(218, 'hola', '2021-09-16 21:41:00'),
(219, 'hola', '2021-09-16 21:42:00'),
(220, 'hola', '2021-09-16 21:43:00'),
(221, 'hola', '2021-09-16 21:44:00'),
(222, 'hola', '2021-09-16 21:45:00'),
(223, 'hola', '2021-09-16 21:46:01'),
(224, 'hola', '2021-09-16 21:47:01'),
(225, 'hola', '2021-09-16 21:48:00'),
(226, 'hola', '2021-09-20 19:09:00'),
(227, 'hola', '2021-09-20 19:10:00'),
(228, 'hola', '2021-09-20 19:11:00'),
(229, 'hola', '2021-09-20 19:12:00'),
(230, 'hola', '2021-09-20 19:13:00'),
(231, 'hola', '2021-09-20 19:16:00'),
(232, 'hola', '2021-09-20 19:17:00'),
(233, 'hola', '2021-09-20 19:18:00'),
(234, 'hola', '2021-09-20 19:19:00'),
(235, 'hola', '2021-09-20 19:20:00'),
(236, 'hola', '2021-09-20 19:21:00'),
(237, 'hola', '2021-09-20 19:22:00'),
(238, 'hola', '2021-09-20 19:23:00'),
(239, 'hola', '2021-09-20 19:23:00'),
(240, 'hola', '2021-09-20 19:24:00'),
(241, 'hola', '2021-09-20 19:24:00'),
(242, 'hola', '2023-05-23 19:02:24'),
(243, 'hola', '2023-05-23 19:02:57'),
(244, 'hola', '2023-05-23 19:04:08'),
(245, 'hola', '2023-05-23 19:05:45'),
(246, 'hola', '2023-05-23 19:06:02'),
(247, 'hola', '2023-05-23 19:06:12'),
(248, 'hola', '2023-05-23 19:06:38'),
(249, 'hola', '2023-05-23 19:06:58'),
(250, 'hola', '2023-05-23 19:07:22'),
(251, 'hola', '2023-05-23 19:07:47'),
(252, 'hola', '2023-05-23 19:08:42'),
(253, 'hola', '2023-05-23 19:09:03'),
(254, 'hola', '2023-05-23 19:09:53'),
(255, 'hola', '2023-05-23 19:21:22'),
(256, 'hola', '2023-05-23 19:22:06'),
(257, 'hola', '2023-05-23 19:25:53'),
(258, 'hola', '2023-05-23 19:26:08'),
(259, 'hola', '2023-05-23 19:28:40'),
(260, 'hola', '2023-05-23 19:28:52'),
(261, 'hola', '2023-05-23 19:32:34'),
(262, 'hola', '2023-08-31 18:03:03'),
(263, 'hola', '2023-08-31 18:58:41'),
(264, 'hola', '2023-08-31 19:59:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recordatorios`
--

CREATE TABLE `recordatorios` (
  `id` bigint UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `recordatorios`
--

INSERT INTO `recordatorios` (`id`, `fecha`, `created_at`, `updated_at`) VALUES
(1, '2023-05-23', '2023-05-23 19:33:54', '2023-05-23 19:33:54'),
(2, '2023-08-30', '2023-08-30 20:02:46', '2023-08-30 20:02:46'),
(3, '2023-08-31', '2023-08-31 21:17:01', '2023-08-31 21:17:01'),
(4, '2023-09-13', '2023-09-13 16:08:41', '2023-09-13 16:08:41'),
(5, '2023-09-24', '2023-09-24 22:40:39', '2023-09-24 22:40:39'),
(6, '2023-10-06', '2023-10-06 13:34:53', '2023-10-06 13:34:53'),
(7, '2023-11-01', '2023-11-01 14:49:23', '2023-11-01 14:49:23'),
(8, '2023-11-07', '2023-11-07 15:38:58', '2023-11-07 15:38:58'),
(9, '2023-11-08', '2023-11-08 14:30:22', '2023-11-08 14:30:22'),
(10, '2023-11-22', '2023-11-22 22:30:37', '2023-11-22 22:30:37'),
(11, '2023-12-06', '2023-12-06 14:42:19', '2023-12-06 14:42:19'),
(12, '2023-12-07', '2023-12-08 00:01:53', '2023-12-08 00:01:53'),
(13, '2023-12-08', '2023-12-08 20:06:07', '2023-12-08 20:06:07'),
(14, '2023-12-09', '2023-12-09 12:21:55', '2023-12-09 12:21:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `special` enum('','all-access','no-access') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT '',
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `description`, `special`, `created_at`, `updated_at`) VALUES
(1, 'ADMINISTRADOR', 'administrador', '..', NULL, NULL, '2021-07-16'),
(2, 'DOCTOR', 'doctor', '.', NULL, NULL, '2021-07-07'),
(3, 'SECRETARIA', 'secretaria', '.', NULL, '2020-04-27', '2021-07-07'),
(4, 'PACIENTE', 'paciente', '.', NULL, '2021-07-07', '2021-07-07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_user`
--

CREATE TABLE `role_user` (
  `id` int NOT NULL,
  `role_id` int NOT NULL,
  `user_id` int NOT NULL,
  `state` tinyint(1) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `role_user`
--

INSERT INTO `role_user` (`id`, `role_id`, `user_id`, `state`, `created_at`, `updated_at`) VALUES
(17, 1, 1, 1, '2020-04-28', '2020-04-28'),
(26, 1, 7, 1, '2021-07-09', '2021-07-09'),
(27, 1, 8, 1, '2021-07-09', '2021-07-09'),
(28, 2, 9, 1, '2021-07-09', '2021-07-09'),
(29, 2, 10, 1, '2021-07-09', '2021-07-09'),
(30, 3, 11, 1, '2021-07-09', '2021-07-09'),
(31, 1, 12, 1, '2021-07-09', '2021-07-09'),
(32, 4, 14, 1, '2021-07-10', '2021-07-10'),
(33, 4, 15, 1, '2021-07-13', '2021-07-13'),
(34, 4, 13, 1, NULL, NULL),
(36, 2, 16, 1, '2021-07-17', '2021-07-17'),
(37, 3, 17, 1, '2021-08-09', '2021-08-09'),
(38, 4, 18, 1, '2021-08-10', '2021-08-10'),
(39, 4, 19, 1, '2021-08-10', '2021-08-10'),
(40, 4, 20, 1, '2021-08-14', '2021-08-14'),
(41, 4, 21, 1, '2021-08-29', '2021-08-29'),
(44, 4, 24, 1, '2021-09-20', '2021-09-20'),
(45, 1, 25, 1, '2023-05-23', '2023-05-23'),
(46, 4, 26, 1, '2023-05-23', '2023-05-23'),
(47, 4, 27, 1, '2023-05-23', '2023-05-23'),
(48, 4, 28, 1, '2023-12-06', '2023-12-06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguimiento`
--

CREATE TABLE `seguimiento` (
  `id` int NOT NULL,
  `id_persona` int NOT NULL,
  `id_especialidad` int NOT NULL,
  `id_persona_doctor` int NOT NULL,
  `tratamiento` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `descripcion_evolucion` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `medicamento` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `state` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `seguimiento`
--

INSERT INTO `seguimiento` (`id`, `id_persona`, `id_especialidad`, `id_persona_doctor`, `tratamiento`, `descripcion_evolucion`, `medicamento`, `fecha_hora`, `state`, `created_at`, `updated_at`) VALUES
(1, 28, 1, 24, 'TAMIENTO', 'DESCRIPCION', 'MEDICAMENTO', '2021-07-10 10:20:00', 1, '2021-07-10 19:27:52', '2021-07-10 19:27:52'),
(2, 29, 1, 1, 'EL TRATAMIENTO TRATA DE FORTALECER LAS DEFENSAS DEL CUERPO HUMANO, TANTO MENTALES COMO FISICAS, ES PRIMORDIAL ESTUDIAR EL ENCEFALO SUPERIOR, EL TRATAMIENTO TRATA DE FORTALECER LAS DEFENSAS DEL CUERPO HUMANO, TANTO MENTALES COMO FISICAS, ES PRIMORDIAL ESTUDIAR EL', 'EL TRATAMIENTO TRATA DE FORTALECER LAS DEFENSAS DEL CUERPO HUMANO, TANTO MENTALES COMO FISICAS, ES PRIMORDIAL ESTUDIAR EL ENCEFALO SUPERIOR, EL TRATAMIENTO TRATA DE FORTALECER LAS DEFENSAS DEL CUERPO HUMANO, TANTO MENTALES COMO FISICAS, ES PRIMORDIAL ESTUDIAR EL', 'EL TRATAMIENTO TRATA DE FORTALECER LAS DEFENSAS DEL CUERPO HUMANO, TANTO MENTALES COMO FISICAS, ES PRIMORDIAL ESTUDIAR EL ENCEFALO SUPERIOR, EL TRATAMIENTO TRATA DE FORTALECER LAS DEFENSAS DEL CUERPO HUMANO, TANTO MENTALES COMO FISICAS, ES PRIMORDIAL ESTUDIAR EL', '2021-07-11 10:20:00', 1, '2021-07-11 00:58:20', '2021-07-16 18:48:49'),
(3, 29, 1, 1, 'EL TRATAMIENTO TRATA DE FORTALECER LAS DEFENSAS DEL CUERPO HUMANO, TANTO MENTALES COMO FISICAS, ES PRIMORDIAL ESTUDIAR EL ENCEFALO SUPERIOR, EL TRATAMIENTO TRATA DE FORTALECER LAS DEFENSAS DEL CUERPO HUMANO, TANTO MENTALES COMO FISICAS, ES PRIMORDIAL ESTUDIAR EL ENCEFALO SUPERIOR, EL TRATAMIENTO TRATA DE FORTALECER LAS DEFENSAS DEL CUERPO HUMANO, TANTO MENTALES COMO FISICAS, ES PRIMORDIAL', 'EL TRATAMIENTO TRATA DE FORTALECER LAS DEFENSAS DEL CUERPO HUMANO, TANTO MENTALES COMO FISICAS, ES PRIMORDIAL ESTUDIAR EL ENCEFALO SUPERIOR, EL TRATAMIENTO TRATA DE FORTALECER LAS DEFENSAS DEL CUERPO HUMANO, TANTO MENTALES COMO FISICAS, ES PRIMORDIAL ESTUDIAR EL ENCEFALO SUPERIOR, EL TRATAMIENTO TRATA DE FORTALECER LAS DEFENSAS DEL CUERPO HUMANO, TANTO MENTALES COMO FISICAS, ES PRIMORDIAL', 'EL TRATAMIENTO TRATA DE FORTALECER LAS DEFENSAS DEL CUERPO HUMANO, TANTO MENTALES COMO FISICAS, ES PRIMORDIAL ESTUDIAR EL ENCEFALO SUPERIOR, EL TRATAMIENTO TRATA DE FORTALECER LAS DEFENSAS DEL CUERPO HUMANO, TANTO MENTALES COMO FISICAS, ES PRIMORDIAL ESTUDIAR EL ENCEFALO SUPERIOR, EL TRATAMIENTO TRATA DE FORTALECER LAS DEFENSAS DEL CUERPO HUMANO, TANTO MENTALES COMO FISICAS, ES PRIMORDIAL', '2021-07-11 10:20:00', 1, '2021-07-11 00:58:56', '2021-07-16 18:48:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `telegram_updates`
--

CREATE TABLE `telegram_updates` (
  `id` bigint UNSIGNED NOT NULL,
  `update_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `password` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `state` tinyint(1) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `state`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'melani@gmail.com', '$2y$10$wuTuUildBSgVYfvHomvXWuVLF6T1PWByEZJelnC9LOSQ/Xwcw2N3S', '2Nr2o0JcRd8JTJe3CZCWPM5OhblkExJmlOw6A2lcVfZM7L74D1W6wdTBxskB', 1, '2019-03-04 00:00:00', '2023-10-06 10:40:27'),
(7, '10001', 'fulanito@gmail.com', '$2y$10$zilrSbbGImsnexkrngzK2evtBehtlXela/spO86U9wO80VFLtoyia', NULL, 1, '2021-07-09 23:24:36', '2023-10-06 10:40:27'),
(8, '10002', 'juan@webcentroem.com', '$2y$10$rSWByV/f0UaiYqABvQI7run9bVO2Mbo7D3fgJs1hUdTIKWIutiZgK', NULL, 1, '2021-07-09 23:26:06', '2023-10-06 10:40:27'),
(9, '20001', 'lucia@webcentroem.com', '$2y$10$2CW7YY.iY0spTEsHeYMWKeoSGo6inwBaviihw6BfSyy3FF3v8fRaS', NULL, 1, '2021-07-09 23:26:44', '2023-10-06 10:40:27'),
(10, '20002', 'freddy@webcentroem.com', '$2y$10$6vnMhnn97eCKgok4gxPWXud.vX10VciZ9CECNl3gVZYBrce1Il2Vm', NULL, 1, '2021-07-09 23:28:47', '2023-10-06 10:40:27'),
(11, '30001', 'maria@webcentroem.com', '$2y$10$8wJ.2jEoGVt6rN2KIOgs9up4k08bx7EFX4gSYWZdwknT63sgUV5XK', NULL, 1, '2021-07-09 23:29:50', '2023-10-06 10:40:27'),
(12, '10003', 'lucas@webcentroem.com', '$2y$10$IaTU/OGlKCTcKJh5V3OydOIHgK04AlQ8lTu4pakQGc4.Ol2JLvPDe', NULL, 1, '2021-07-09 23:30:33', '2023-10-06 10:40:27'),
(13, '40001', '10004@sis.net', '$2y$10$z5ueybtJNEE6DvZSjnGbZeCxANCG9QIUUjAodOutQPKSkSCNRvdfy', NULL, 1, '2021-07-10 00:58:28', '2021-07-10 00:58:28'),
(14, '40002', '10005@sis.net', '$2y$10$qR1hWTvfDYTUEL/JPSxeKe9tcdUSeVYVQhaShN35Ni9a6HIFDdiAO', NULL, 1, '2021-07-10 00:59:05', '2021-07-10 01:21:26'),
(15, '40005', '40005@sis.net', '$2y$10$0fuhgU7WU13C/lHeO3sxuuPlPmidQcNYLvA8OVqzNBr4GT5r/Dyda', NULL, 1, '2021-07-13 23:45:59', '2021-07-13 23:45:59'),
(16, '20003', 'ruben@gmail.com', '$2y$10$AcH5eHyziuqgzmTZr/s15.gGJGnZDordxKYpASs0GPZDlModaiT62', NULL, 1, '2021-07-17 16:55:06', '2023-10-06 10:40:27'),
(17, '30002', 'norma@webcentroem.com', '$2y$10$m.EyI7AW3Y8Csn.baWbYauyZWZ1nCUAdkX30HlVWo3GzOV0lNziLO', NULL, 1, '2021-08-09 22:57:36', '2023-10-06 10:40:27'),
(18, 'limber@gmail.com', 'limber@gmail.com', '$2y$10$wuTuUildBSgVYfvHomvXWuVLF6T1PWByEZJelnC9LOSQ/Xwcw2N3S', NULL, 1, '2021-08-10 03:30:12', '2021-08-10 03:30:12'),
(19, 'limberl@gmail.com', 'limberl@gmail.com', '$2y$10$0IkqyZhhjIkYW5luknitP./HrmWKIwyE7D3yUMqUGkobrp.ZJUWi.', NULL, 1, '2021-08-10 03:51:48', '2021-08-10 03:51:48'),
(20, 'peter@gmail.com', 'peter@gmail.com', '$2y$10$Ox27OsVGqZvl88zMJbhale0/otDxPjO7S78bnQyn0cKA8iFiBMC8W', NULL, 1, '2021-08-14 14:02:52', '2021-08-14 14:02:52'),
(21, 'monica@gmail.com', 'monica@gmail.com', '$2y$10$YcGwGqhrNHbI8rsur659OOmjgUmengcqXazhQbO1FDsjrk/KpE.tK', NULL, 1, '2021-08-29 15:55:15', '2021-08-29 15:55:15'),
(24, 'unetehost@gmail.com', 'unetehost@gmail.com', '$2y$10$D4F3REy/SGWaCsDp75ikAul8wJjth1torQWTgaZXLWh9gJUHAH5Sm', NULL, 1, '2021-09-20 19:10:06', '2021-09-20 19:10:06'),
(25, '20004', 'jose@webcentroem.com', '$2y$10$RYfsb17OcxCK3jVBdv56D.cJu.l36440dVdXXUS4YnZ71Yqn.ZX5u', NULL, 1, '2023-05-23 15:28:28', '2023-10-06 10:40:27'),
(26, 'pamela@gmail.com', 'pamela@gmail.com', '$2y$10$wBPzoTNfNFuJbFZBc34oauSub/PP7Zt/f3It17pt5/sFDFx5wwI7y', NULL, 1, '2023-05-23 11:40:24', '2023-05-23 11:40:24'),
(27, 'pedro@gmail.com', 'pedro@gmail.com', '$2y$10$eNMgu4.bLC9EbuZJFiSrhOEqtDyYskt4cH8b/NFeoeRh8smJAiKRO', NULL, 1, '2023-05-23 11:50:48', '2023-05-23 11:51:16'),
(28, 'elvis@gmail.com', 'elvis@gmail.com', '$2y$10$VlptPO286C3nbQikzna/5OSP71p6.7KqJJN13NgqKB/uQMWMRpgq2', NULL, 1, '2023-12-06 17:57:56', '2023-12-06 17:57:56');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bot_telegrams`
--
ALTER TABLE `bot_telegrams`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `calendario_atencions`
--
ALTER TABLE `calendario_atencions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cita_medica`
--
ALTER TABLE `cita_medica`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `codigo_usuario`
--
ALTER TABLE `codigo_usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `conceptos`
--
ALTER TABLE `conceptos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `doctor_horarios`
--
ALTER TABLE `doctor_horarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `factura_conceptos`
--
ALTER TABLE `factura_conceptos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `historial_clinico`
--
ALTER TABLE `historial_clinico`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `horas`
--
ALTER TABLE `horas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `intervalo_horarios`
--
ALTER TABLE `intervalo_horarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mes`
--
ALTER TABLE `mes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_slug_unique` (`slug`);

--
-- Indices de la tabla `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permission_role_uk` (`permission_id`,`role_id`),
  ADD KEY `permission_role_permission_id_foreign` (`permission_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `persona_telegrams`
--
ALTER TABLE `persona_telegrams`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `prueba`
--
ALTER TABLE `prueba`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `recordatorios`
--
ALTER TABLE `recordatorios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Indices de la tabla `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_user_uk` (`role_id`,`user_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`),
  ADD KEY `role_user_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `seguimiento`
--
ALTER TABLE `seguimiento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `telegram_updates`
--
ALTER TABLE `telegram_updates`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bot_telegrams`
--
ALTER TABLE `bot_telegrams`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `calendario_atencions`
--
ALTER TABLE `calendario_atencions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cita_medica`
--
ALTER TABLE `cita_medica`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `codigo_usuario`
--
ALTER TABLE `codigo_usuario`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `conceptos`
--
ALTER TABLE `conceptos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `doctor_horarios`
--
ALTER TABLE `doctor_horarios`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `factura_conceptos`
--
ALTER TABLE `factura_conceptos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `historial_clinico`
--
ALTER TABLE `historial_clinico`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `horas`
--
ALTER TABLE `horas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `intervalo_horarios`
--
ALTER TABLE `intervalo_horarios`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `mes`
--
ALTER TABLE `mes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de la tabla `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'numero_documento,paterno,materno,nombre1,nombre2', AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `persona_telegrams`
--
ALTER TABLE `persona_telegrams`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `prueba`
--
ALTER TABLE `prueba`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=265;

--
-- AUTO_INCREMENT de la tabla `recordatorios`
--
ALTER TABLE `recordatorios`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `seguimiento`
--
ALTER TABLE `seguimiento`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `telegram_updates`
--
ALTER TABLE `telegram_updates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`),
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Filtros para la tabla `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
