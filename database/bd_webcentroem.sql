-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 09-12-2023 a las 14:08:21
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
(1, 16, 'LUNES', '1', 'ACTIVO', '08:00:00', '12:00:00', '14:00:00', '18:00:00', '2023-12-09 14:04:49', '2023-12-09 14:04:49'),
(2, 16, 'MARTES', '2', 'ACTIVO', '08:00:00', '12:00:00', '14:00:00', '18:00:00', '2023-12-09 14:04:49', '2023-12-09 14:04:49'),
(3, 16, 'MIERCOLES', '3', 'ACTIVO', '08:00:00', '12:00:00', '14:00:00', '18:00:00', '2023-12-09 14:04:49', '2023-12-09 14:04:49'),
(4, 16, 'JUEVES', '4', 'ACTIVO', '08:00:00', '12:00:00', '14:00:00', '18:00:00', '2023-12-09 14:04:49', '2023-12-09 14:04:49'),
(5, 16, 'VIERNES', '5', 'ACTIVO', '08:00:00', '12:00:00', '14:00:00', '18:00:00', '2023-12-09 14:04:49', '2023-12-09 14:04:49');

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
(1, 1, '8009525', 'LAURA', 'GUTIERREZ', 'MELANI', '', '1626550531_New-Sac-Kings-Logo-3.0.jpg', '75635412', '85452111', 'SOLTERO', '1985-03-02', 0, '.', 'melani@gmail.com', 1, NULL, '2021-07-17 19:35:31', '', NULL, '', '', 1);

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
(17, 1, 1, 1, '2020-04-28', '2020-04-28');

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
(1, 'admin', 'melani@gmail.com', '$2y$10$wuTuUildBSgVYfvHomvXWuVLF6T1PWByEZJelnC9LOSQ/Xwcw2N3S', '2Nr2o0JcRd8JTJe3CZCWPM5OhblkExJmlOw6A2lcVfZM7L74D1W6wdTBxskB', 1, '2019-03-04 00:00:00', '2023-10-06 10:40:27');

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `calendario_atencions`
--
ALTER TABLE `calendario_atencions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cita_medica`
--
ALTER TABLE `cita_medica`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `codigo_usuario`
--
ALTER TABLE `codigo_usuario`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `conceptos`
--
ALTER TABLE `conceptos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `doctor_horarios`
--
ALTER TABLE `doctor_horarios`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `factura_conceptos`
--
ALTER TABLE `factura_conceptos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial_clinico`
--
ALTER TABLE `historial_clinico`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `horas`
--
ALTER TABLE `horas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `intervalo_horarios`
--
ALTER TABLE `intervalo_horarios`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'numero_documento,paterno,materno,nombre1,nombre2', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `persona_telegrams`
--
ALTER TABLE `persona_telegrams`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `prueba`
--
ALTER TABLE `prueba`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=265;

--
-- AUTO_INCREMENT de la tabla `recordatorios`
--
ALTER TABLE `recordatorios`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `telegram_updates`
--
ALTER TABLE `telegram_updates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
