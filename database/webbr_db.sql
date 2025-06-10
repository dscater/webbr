-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 10-06-2025 a las 19:24:58
-- Versión del servidor: 8.0.30
-- Versión de PHP: 8.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `webbr_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paterno` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `materno` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ci` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ci_exp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fono` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dir` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_registro` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracions`
--

CREATE TABLE `configuracions` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre_sistema` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `razon_social` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dir` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `web` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `actividad` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `configuracions`
--

INSERT INTO `configuracions` (`id`, `nombre_sistema`, `alias`, `razon_social`, `nit`, `dir`, `telefono`, `web`, `actividad`, `correo`, `logo`, `created_at`, `updated_at`) VALUES
(1, 'WEBBR', 'WEBBR', 'WEBBR S.A.', NULL, 'ZONA LOS OLIVOS', '222222', NULL, 'ACTIVIDAD ECONOMICA', NULL, 'logo.png', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_accions`
--

CREATE TABLE `historial_accions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `accion` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `datos_original` json DEFAULT NULL,
  `datos_nuevo` json DEFAULT NULL,
  `modulo` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `historial_accions`
--

INSERT INTO `historial_accions` (`id`, `user_id`, `accion`, `descripcion`, `datos_original`, `datos_nuevo`, `modulo`, `fecha`, `hora`, `created_at`, `updated_at`) VALUES
(1, 1, 'CREACIÓN', 'EL USUARIO admin REGISTRO UN USUARIO', '{\"ci\": \"123456\", \"id\": 3, \"dir\": \"LOS OLIVOS\", \"fono\": \"777777\", \"tipo\": \"GERENTE\", \"acceso\": \"1\", \"ci_exp\": \"LP\", \"correo\": \"juan@gmail.com\", \"nombre\": \"JUAN\", \"materno\": \"MAMANI\", \"paterno\": \"PERES\", \"usuario\": \"JPERES\", \"created_at\": \"2025-06-09T19:33:15.000000Z\", \"updated_at\": \"2025-06-09T19:33:15.000000Z\", \"fecha_registro\": \"2025-06-09\"}', NULL, 'USUARIOS', '2025-06-09', '15:33:15', '2025-06-09 19:33:15', '2025-06-09 19:33:15'),
(2, 1, 'MODIFICACIÓN', 'EL USUARIO admin ACTUALIZÓ UN USUARIO', '{\"ci\": \"123456\", \"id\": 3, \"dir\": \"LOS OLIVOS\", \"fono\": \"777777\", \"foto\": null, \"tipo\": \"GERENTE\", \"acceso\": 1, \"ci_exp\": \"LP\", \"correo\": \"juan@gmail.com\", \"nombre\": \"JUAN\", \"status\": 1, \"materno\": \"MAMANI\", \"paterno\": \"PERES\", \"usuario\": \"JPERES\", \"created_at\": \"2025-06-09T19:33:15.000000Z\", \"updated_at\": \"2025-06-09T19:33:15.000000Z\", \"fecha_registro\": \"2025-06-09\"}', '{\"ci\": \"123456\", \"id\": 3, \"dir\": \"LOS OLIVOS\", \"fono\": \"7777778\", \"foto\": null, \"tipo\": \"SECRETARIA\", \"acceso\": \"0\", \"ci_exp\": \"LP\", \"correo\": \"juan@gmail.com\", \"nombre\": \"JUAN\", \"status\": 1, \"materno\": \"MAMANI\", \"paterno\": \"PERES\", \"usuario\": \"JPERES\", \"created_at\": \"2025-06-09T19:33:15.000000Z\", \"updated_at\": \"2025-06-09T19:36:53.000000Z\", \"fecha_registro\": \"2025-06-09\"}', 'USUARIOS', '2025-06-09', '15:36:53', '2025-06-09 19:36:53', '2025-06-09 19:36:53'),
(3, 1, 'MODIFICACIÓN', 'EL USUARIO admin ACTUALIZÓ UN USUARIO', '{\"ci\": \"123456\", \"id\": 3, \"dir\": \"LOS OLIVOS\", \"fono\": \"7777778\", \"foto\": null, \"tipo\": \"SECRETARIA\", \"acceso\": 0, \"ci_exp\": \"LP\", \"correo\": \"juan@gmail.com\", \"nombre\": \"JUAN\", \"status\": 1, \"materno\": \"MAMANI\", \"paterno\": \"PERES\", \"usuario\": \"JPERES\", \"created_at\": \"2025-06-09T19:33:15.000000Z\", \"updated_at\": \"2025-06-09T19:36:53.000000Z\", \"fecha_registro\": \"2025-06-09\"}', '{\"ci\": \"123456\", \"id\": 3, \"dir\": \"LOS OLIVOS\", \"fono\": \"7777778\", \"foto\": null, \"tipo\": \"GERENTE\", \"acceso\": \"1\", \"ci_exp\": \"LP\", \"correo\": \"juan@gmail.com\", \"nombre\": \"JUAN\", \"status\": 1, \"materno\": \"MAMANI\", \"paterno\": \"PERES\", \"usuario\": \"JPERES\", \"created_at\": \"2025-06-09T19:33:15.000000Z\", \"updated_at\": \"2025-06-09T19:36:59.000000Z\", \"fecha_registro\": \"2025-06-09\"}', 'USUARIOS', '2025-06-09', '15:36:59', '2025-06-09 19:36:59', '2025-06-09 19:36:59'),
(4, 1, 'MODIFICACIÓN', 'EL USUARIO admin ACTUALIZÓ UN USUARIO', '{\"ci\": \"123456\", \"id\": 3, \"dir\": \"LOS OLIVOS\", \"fono\": \"7777778\", \"foto\": null, \"tipo\": \"GERENTE\", \"acceso\": 1, \"ci_exp\": \"LP\", \"correo\": \"juan@gmail.com\", \"nombre\": \"JUAN\", \"status\": 1, \"materno\": \"MAMANI\", \"paterno\": \"PERES\", \"usuario\": \"JPERES\", \"created_at\": \"2025-06-09T19:33:15.000000Z\", \"updated_at\": \"2025-06-09T19:36:59.000000Z\", \"fecha_registro\": \"2025-06-09\"}', '{\"ci\": \"123456\", \"id\": 3, \"dir\": \"LOS OLIVOS\", \"fono\": \"7777778\", \"foto\": \"17494979433.jpg\", \"tipo\": \"GERENTE\", \"acceso\": \"1\", \"ci_exp\": \"LP\", \"correo\": \"juan@gmail.com\", \"nombre\": \"JUAN\", \"status\": 1, \"materno\": \"MAMANI\", \"paterno\": \"PERES\", \"usuario\": \"JPERES\", \"created_at\": \"2025-06-09T19:33:15.000000Z\", \"updated_at\": \"2025-06-09T19:39:03.000000Z\", \"fecha_registro\": \"2025-06-09\"}', 'USUARIOS', '2025-06-09', '15:39:03', '2025-06-09 19:39:03', '2025-06-09 19:39:03'),
(5, 1, 'MODIFICACIÓN', 'EL USUARIO admin ACTUALIZÓ LA CONTRASEÑA DE UN USUARIO', '{\"ci\": \"123456\", \"id\": 3, \"dir\": \"LOS OLIVOS\", \"fono\": \"7777778\", \"foto\": \"17494979433.jpg\", \"tipo\": \"GERENTE\", \"acceso\": 1, \"ci_exp\": \"LP\", \"correo\": \"juan@gmail.com\", \"nombre\": \"JUAN\", \"status\": 1, \"materno\": \"MAMANI\", \"paterno\": \"PERES\", \"usuario\": \"JPERES\", \"created_at\": \"2025-06-09T19:33:15.000000Z\", \"updated_at\": \"2025-06-09T19:39:03.000000Z\", \"fecha_registro\": \"2025-06-09\"}', '{\"ci\": \"123456\", \"id\": 3, \"dir\": \"LOS OLIVOS\", \"fono\": \"7777778\", \"foto\": \"17494979433.jpg\", \"tipo\": \"GERENTE\", \"acceso\": 1, \"ci_exp\": \"LP\", \"correo\": \"juan@gmail.com\", \"nombre\": \"JUAN\", \"status\": 1, \"materno\": \"MAMANI\", \"paterno\": \"PERES\", \"usuario\": \"JPERES\", \"created_at\": \"2025-06-09T19:33:15.000000Z\", \"updated_at\": \"2025-06-09T19:40:46.000000Z\", \"fecha_registro\": \"2025-06-09\"}', 'USUARIOS', '2025-06-09', '15:40:46', '2025-06-09 19:40:46', '2025-06-09 19:40:46'),
(6, 1, 'MODIFICACIÓN', 'EL USUARIO admin ACTUALIZÓ LA CONTRASEÑA DE UN USUARIO', '{\"ci\": \"123456\", \"id\": 3, \"dir\": \"LOS OLIVOS\", \"fono\": \"7777778\", \"foto\": \"17494979433.jpg\", \"tipo\": \"GERENTE\", \"acceso\": 1, \"ci_exp\": \"LP\", \"correo\": \"juan@gmail.com\", \"nombre\": \"JUAN\", \"status\": 1, \"materno\": \"MAMANI\", \"paterno\": \"PERES\", \"usuario\": \"JPERES\", \"created_at\": \"2025-06-09T19:33:15.000000Z\", \"updated_at\": \"2025-06-09T19:40:46.000000Z\", \"fecha_registro\": \"2025-06-09\"}', '{\"ci\": \"123456\", \"id\": 3, \"dir\": \"LOS OLIVOS\", \"fono\": \"7777778\", \"foto\": \"17494979433.jpg\", \"tipo\": \"GERENTE\", \"acceso\": 1, \"ci_exp\": \"LP\", \"correo\": \"juan@gmail.com\", \"nombre\": \"JUAN\", \"status\": 1, \"materno\": \"MAMANI\", \"paterno\": \"PERES\", \"usuario\": \"JPERES\", \"created_at\": \"2025-06-09T19:33:15.000000Z\", \"updated_at\": \"2025-06-09T19:41:01.000000Z\", \"fecha_registro\": \"2025-06-09\"}', 'USUARIOS', '2025-06-09', '15:41:01', '2025-06-09 19:41:01', '2025-06-09 19:41:01'),
(7, 1, 'CREACIÓN', 'EL USUARIO admin REGISTRO UN MUNICIPIO', '{\"id\": 1, \"nombre\": \"MUNICIPIO 1\", \"created_at\": \"2025-06-09T20:29:29.000000Z\", \"updated_at\": \"2025-06-09T20:29:29.000000Z\", \"fecha_registro\": \"2025-06-09\"}', NULL, 'MUNICIPIOs', '2025-06-09', '16:29:29', '2025-06-09 20:29:29', '2025-06-09 20:29:29'),
(8, 1, 'MODIFICACIÓN', 'EL USUARIO admin ACTUALIZÓ UN MUNICIPIO', '{\"id\": 1, \"nombre\": \"MUNICIPIO 1\", \"created_at\": \"2025-06-09T20:29:29.000000Z\", \"updated_at\": \"2025-06-09T20:29:29.000000Z\", \"fecha_registro\": \"2025-06-09\"}', '{\"id\": 1, \"nombre\": \"MUNICIPIO 1ASD\", \"created_at\": \"2025-06-09T20:29:29.000000Z\", \"updated_at\": \"2025-06-09T20:30:10.000000Z\", \"fecha_registro\": \"2025-06-09\"}', 'MUNICIPIOs', '2025-06-09', '16:30:10', '2025-06-09 20:30:10', '2025-06-09 20:30:10'),
(9, 1, 'MODIFICACIÓN', 'EL USUARIO admin ACTUALIZÓ UN MUNICIPIO', '{\"id\": 1, \"nombre\": \"MUNICIPIO 1ASD\", \"created_at\": \"2025-06-09T20:29:29.000000Z\", \"updated_at\": \"2025-06-09T20:30:10.000000Z\", \"fecha_registro\": \"2025-06-09\"}', '{\"id\": 1, \"nombre\": \"MUNICIPIO 1\", \"created_at\": \"2025-06-09T20:29:29.000000Z\", \"updated_at\": \"2025-06-09T20:30:14.000000Z\", \"fecha_registro\": \"2025-06-09\"}', 'MUNICIPIOs', '2025-06-09', '16:30:14', '2025-06-09 20:30:14', '2025-06-09 20:30:14'),
(10, 1, 'ELIMINACIÓN', 'EL USUARIO admin ELIMINÓ UN MUNICIPIO', '{\"id\": 1, \"nombre\": \"MUNICIPIO 1\", \"created_at\": \"2025-06-09T20:29:29.000000Z\", \"updated_at\": \"2025-06-09T20:30:14.000000Z\", \"fecha_registro\": \"2025-06-09\"}', NULL, 'MUNICIPIOs', '2025-06-09', '16:30:16', '2025-06-09 20:30:16', '2025-06-09 20:30:16'),
(11, 1, 'CREACIÓN', 'EL USUARIO admin REGISTRO UN MUNICIPIO', '{\"id\": 1, \"nombre\": \"MUNICIPIO 1\", \"created_at\": \"2025-06-09T20:30:27.000000Z\", \"updated_at\": \"2025-06-09T20:30:27.000000Z\", \"fecha_registro\": \"2025-06-09\"}', NULL, 'MUNICIPIOs', '2025-06-09', '16:30:27', '2025-06-09 20:30:27', '2025-06-09 20:30:27'),
(12, 1, 'CREACIÓN', 'EL USUARIO admin REGISTRO UN MUNICIPIO', '{\"id\": 1, \"nombre\": \"URBANIZACION 3\", \"created_at\": \"2025-06-09T21:35:06.000000Z\", \"updated_at\": \"2025-06-09T21:35:06.000000Z\", \"municipio_id\": \"1\", \"fecha_registro\": \"2025-06-09\"}', NULL, 'MUNICIPIOs', '2025-06-09', '17:35:06', '2025-06-09 21:35:06', '2025-06-09 21:35:06'),
(13, 1, 'MODIFICACIÓN', 'EL USUARIO admin ACTUALIZÓ UNA URBANIZACIÓN', '{\"id\": 1, \"nombre\": \"URBANIZACION 3\", \"created_at\": \"2025-06-09T21:35:06.000000Z\", \"updated_at\": \"2025-06-09T21:35:06.000000Z\", \"municipio_id\": 1, \"fecha_registro\": \"2025-06-09\"}', '{\"id\": 1, \"nombre\": \"URBANIZACION 1\", \"created_at\": \"2025-06-09T21:35:06.000000Z\", \"updated_at\": \"2025-06-10T17:53:29.000000Z\", \"municipio_id\": \"1\", \"fecha_registro\": \"2025-06-09\"}', 'URBANIZACIÓN', '2025-06-10', '13:53:29', '2025-06-10 17:53:29', '2025-06-10 17:53:29'),
(14, 1, 'CREACIÓN', 'EL USUARIO admin REGISTRO UN MUNICIPIO', '{\"id\": 1, \"nombre\": \"MANZANO 1\", \"created_at\": \"2025-06-10T17:54:14.000000Z\", \"updated_at\": \"2025-06-10T17:54:14.000000Z\", \"municipio_id\": \"1\", \"fecha_registro\": \"2025-06-10\", \"urbanizacion_id\": \"1\"}', NULL, 'MUNICIPIOs', '2025-06-10', '13:54:14', '2025-06-10 17:54:14', '2025-06-10 17:54:14'),
(15, 1, 'MODIFICACIÓN', 'EL USUARIO admin ACTUALIZÓ UN MUNICIPIO', '{\"id\": 1, \"nombre\": \"MANZANO 1\", \"created_at\": \"2025-06-10T17:54:14.000000Z\", \"updated_at\": \"2025-06-10T17:54:14.000000Z\", \"municipio_id\": 1, \"fecha_registro\": \"2025-06-10\", \"urbanizacion_id\": 1}', '{\"id\": 1, \"nombre\": \"MANZANO 1AS\", \"created_at\": \"2025-06-10T17:54:14.000000Z\", \"updated_at\": \"2025-06-10T17:54:19.000000Z\", \"municipio_id\": \"1\", \"fecha_registro\": \"2025-06-10\", \"urbanizacion_id\": \"1\"}', 'MUNICIPIOs', '2025-06-10', '13:54:19', '2025-06-10 17:54:19', '2025-06-10 17:54:19'),
(16, 1, 'MODIFICACIÓN', 'EL USUARIO admin ACTUALIZÓ UN MUNICIPIO', '{\"id\": 1, \"nombre\": \"MANZANO 1AS\", \"created_at\": \"2025-06-10T17:54:14.000000Z\", \"updated_at\": \"2025-06-10T17:54:19.000000Z\", \"municipio_id\": 1, \"fecha_registro\": \"2025-06-10\", \"urbanizacion_id\": 1}', '{\"id\": 1, \"nombre\": \"MANZANO 1\", \"created_at\": \"2025-06-10T17:54:14.000000Z\", \"updated_at\": \"2025-06-10T17:54:22.000000Z\", \"municipio_id\": \"1\", \"fecha_registro\": \"2025-06-10\", \"urbanizacion_id\": \"1\"}', 'MUNICIPIOs', '2025-06-10', '13:54:22', '2025-06-10 17:54:22', '2025-06-10 17:54:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `manzanos`
--

CREATE TABLE `manzanos` (
  `id` bigint UNSIGNED NOT NULL,
  `municipio_id` bigint UNSIGNED NOT NULL,
  `urbanizacion_id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `manzanos`
--

INSERT INTO `manzanos` (`id`, `municipio_id`, `urbanizacion_id`, `nombre`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'MANZANO 1', '2025-06-10', '2025-06-10 17:54:14', '2025-06-10 17:54:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2024_01_31_165641_create_configuracions_table', 1),
(2, '2024_11_02_153317_create_users_table', 1),
(3, '2024_11_02_153318_create_historial_accions_table', 1),
(4, '2025_06_09_155723_create_municipios_table', 2),
(5, '2025_06_09_155810_create_urbanizacions_table', 2),
(6, '2025_06_09_155819_create_manzanos_table', 2),
(7, '2025_06_09_155832_create_terrenos_table', 2),
(8, '2025_06_09_155780_create_clientes_table', 3),
(9, '2025_06_09_155900_create_preventas_table', 4),
(10, '2025_06_09_155922_create_ventas_table', 4),
(11, '2025_06_09_160854_create_terreno_imagens_table', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipios`
--

CREATE TABLE `municipios` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_registro` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `municipios`
--

INSERT INTO `municipios` (`id`, `nombre`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(1, 'MUNICIPIO 1', '2025-06-09', '2025-06-09 20:30:27', '2025-06-09 20:30:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preventas`
--

CREATE TABLE `preventas` (
  `id` bigint UNSIGNED NOT NULL,
  `terreno_id` bigint UNSIGNED NOT NULL,
  `cliente_id` bigint UNSIGNED NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_registro` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `terrenos`
--

CREATE TABLE `terrenos` (
  `id` bigint UNSIGNED NOT NULL,
  `municipio_id` bigint UNSIGNED NOT NULL,
  `urbanizacion_id` bigint UNSIGNED NOT NULL,
  `manzano_id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_calle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ancho_calle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conectividad` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trafico` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_zona` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agua_potable` int NOT NULL,
  `alcantarillado` int NOT NULL,
  `energia_electrica` int NOT NULL,
  `gas_natural` int NOT NULL,
  `alumbrado` int NOT NULL,
  `recoleccion_basura` int NOT NULL,
  `conexion_internet` int NOT NULL,
  `escuelas` int NOT NULL,
  `centros_educativos` int NOT NULL,
  `hospitales` int NOT NULL,
  `centros_salud` int NOT NULL,
  `centros_comerciales` int NOT NULL,
  `mercados` int NOT NULL,
  `tiendas` int NOT NULL,
  `parques` int NOT NULL,
  `plazas` int NOT NULL,
  `espacios_recreativos` int NOT NULL,
  `iglesias` int NOT NULL,
  `oficinas_gubarnamentales` int NOT NULL,
  `oficinas_servicios` int NOT NULL,
  `bancos` int NOT NULL,
  `areas_verdes` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nivel_urbanizacion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seguro` int NOT NULL,
  `limpio` int NOT NULL,
  `en_desarrollo` int NOT NULL,
  `viviendas` int NOT NULL,
  `negocios` int NOT NULL,
  `bodegas` int NOT NULL,
  `galpones` int NOT NULL,
  `terrenos_baldios` int NOT NULL,
  `topografia_entorno` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `superficie_terreno` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `costo_contado` decimal(24,2) NOT NULL,
  `costo_credito` decimal(24,2) NOT NULL,
  `publicar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `terreno_imagens`
--

CREATE TABLE `terreno_imagens` (
  `id` bigint UNSIGNED NOT NULL,
  `terreno_id` bigint UNSIGNED NOT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `urbanizacions`
--

CREATE TABLE `urbanizacions` (
  `id` bigint UNSIGNED NOT NULL,
  `municipio_id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `urbanizacions`
--

INSERT INTO `urbanizacions` (`id`, `municipio_id`, `nombre`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(1, 1, 'URBANIZACION 1', '2025-06-09', '2025-06-09 21:35:06', '2025-06-10 17:53:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `usuario` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paterno` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `materno` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ci` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ci_exp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dir` varchar(600) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fono` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `acceso` int NOT NULL,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_registro` date NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `usuario`, `nombre`, `paterno`, `materno`, `ci`, `ci_exp`, `dir`, `correo`, `fono`, `password`, `acceso`, `tipo`, `foto`, `fecha_registro`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', 'admin', '', '0', '', '', NULL, '', '$2y$12$65d4fgZsvBV5Lc/AxNKh4eoUdbGyaczQ4sSco20feSQANshNLuxSC', 1, 'GERENTE', NULL, '2025-06-05', 1, NULL, NULL),
(3, 'JPERES', 'JUAN', 'PERES', 'MAMANI', '123456', 'LP', 'LOS OLIVOS', 'juan@gmail.com', '7777778', '$2y$12$3pGAeeS4eMg38npSTNhN9ee90e9ZDPxHmNLA7LGnW3gBmlSIaefMi', 1, 'GERENTE', '1749498986_3.jpg', '2025-06-09', 1, '2025-06-09 19:33:15', '2025-06-09 19:56:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` bigint UNSIGNED NOT NULL,
  `terreno_id` bigint UNSIGNED NOT NULL,
  `cliente_id` bigint UNSIGNED NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_registro` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `configuracions`
--
ALTER TABLE `configuracions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `historial_accions`
--
ALTER TABLE `historial_accions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `historial_accions_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `manzanos`
--
ALTER TABLE `manzanos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `manzanos_municipio_id_foreign` (`municipio_id`),
  ADD KEY `manzanos_urbanizacion_id_foreign` (`urbanizacion_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `municipios`
--
ALTER TABLE `municipios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `preventas`
--
ALTER TABLE `preventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `preventas_terreno_id_foreign` (`terreno_id`),
  ADD KEY `preventas_cliente_id_foreign` (`cliente_id`);

--
-- Indices de la tabla `terrenos`
--
ALTER TABLE `terrenos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `terrenos_municipio_id_foreign` (`municipio_id`),
  ADD KEY `terrenos_urbanizacion_id_foreign` (`urbanizacion_id`),
  ADD KEY `terrenos_manzano_id_foreign` (`manzano_id`);

--
-- Indices de la tabla `terreno_imagens`
--
ALTER TABLE `terreno_imagens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `terreno_imagens_terreno_id_foreign` (`terreno_id`);

--
-- Indices de la tabla `urbanizacions`
--
ALTER TABLE `urbanizacions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `urbanizacions_municipio_id_foreign` (`municipio_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ventas_terreno_id_foreign` (`terreno_id`),
  ADD KEY `ventas_cliente_id_foreign` (`cliente_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `configuracions`
--
ALTER TABLE `configuracions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `historial_accions`
--
ALTER TABLE `historial_accions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `manzanos`
--
ALTER TABLE `manzanos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `municipios`
--
ALTER TABLE `municipios`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `preventas`
--
ALTER TABLE `preventas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `terrenos`
--
ALTER TABLE `terrenos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `terreno_imagens`
--
ALTER TABLE `terreno_imagens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `urbanizacions`
--
ALTER TABLE `urbanizacions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `historial_accions`
--
ALTER TABLE `historial_accions`
  ADD CONSTRAINT `historial_accions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `manzanos`
--
ALTER TABLE `manzanos`
  ADD CONSTRAINT `manzanos_municipio_id_foreign` FOREIGN KEY (`municipio_id`) REFERENCES `municipios` (`id`),
  ADD CONSTRAINT `manzanos_urbanizacion_id_foreign` FOREIGN KEY (`urbanizacion_id`) REFERENCES `urbanizacions` (`id`);

--
-- Filtros para la tabla `preventas`
--
ALTER TABLE `preventas`
  ADD CONSTRAINT `preventas_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `preventas_terreno_id_foreign` FOREIGN KEY (`terreno_id`) REFERENCES `terrenos` (`id`);

--
-- Filtros para la tabla `terrenos`
--
ALTER TABLE `terrenos`
  ADD CONSTRAINT `terrenos_manzano_id_foreign` FOREIGN KEY (`manzano_id`) REFERENCES `manzanos` (`id`),
  ADD CONSTRAINT `terrenos_municipio_id_foreign` FOREIGN KEY (`municipio_id`) REFERENCES `municipios` (`id`),
  ADD CONSTRAINT `terrenos_urbanizacion_id_foreign` FOREIGN KEY (`urbanizacion_id`) REFERENCES `urbanizacions` (`id`);

--
-- Filtros para la tabla `terreno_imagens`
--
ALTER TABLE `terreno_imagens`
  ADD CONSTRAINT `terreno_imagens_terreno_id_foreign` FOREIGN KEY (`terreno_id`) REFERENCES `terrenos` (`id`);

--
-- Filtros para la tabla `urbanizacions`
--
ALTER TABLE `urbanizacions`
  ADD CONSTRAINT `urbanizacions_municipio_id_foreign` FOREIGN KEY (`municipio_id`) REFERENCES `municipios` (`id`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `ventas_terreno_id_foreign` FOREIGN KEY (`terreno_id`) REFERENCES `terrenos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
