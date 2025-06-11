-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 11-06-2025 a las 21:03:24
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
(16, 1, 'MODIFICACIÓN', 'EL USUARIO admin ACTUALIZÓ UN MUNICIPIO', '{\"id\": 1, \"nombre\": \"MANZANO 1AS\", \"created_at\": \"2025-06-10T17:54:14.000000Z\", \"updated_at\": \"2025-06-10T17:54:19.000000Z\", \"municipio_id\": 1, \"fecha_registro\": \"2025-06-10\", \"urbanizacion_id\": 1}', '{\"id\": 1, \"nombre\": \"MANZANO 1\", \"created_at\": \"2025-06-10T17:54:14.000000Z\", \"updated_at\": \"2025-06-10T17:54:22.000000Z\", \"municipio_id\": \"1\", \"fecha_registro\": \"2025-06-10\", \"urbanizacion_id\": \"1\"}', 'MUNICIPIOs', '2025-06-10', '13:54:22', '2025-06-10 17:54:22', '2025-06-10 17:54:22'),
(26, 1, 'CREACIÓN', 'EL USUARIO admin REGISTRO UN TERRENO', '{\"id\": 10, \"bancos\": \"0\", \"limpio\": \"0\", \"nombre\": \"TERRENO 1\", \"plazas\": \"0\", \"seguro\": \"1\", \"bodegas\": \"0\", \"parques\": \"0\", \"tiendas\": \"0\", \"trafico\": \"Bajo\", \"escuelas\": \"1\", \"galpones\": \"1\", \"iglesias\": \"0\", \"mercados\": \"0\", \"negocios\": \"0\", \"publicar\": \"SI\", \"alumbrado\": \"0\", \"tipo_zona\": \"Residencial\", \"viviendas\": \"1\", \"created_at\": \"2025-06-11T20:51:05.000000Z\", \"hospitales\": \"0\", \"manzano_id\": \"1\", \"tipo_calle\": \"Pavimentada\", \"updated_at\": \"2025-06-11T20:51:05.000000Z\", \"ancho_calle\": \"Autopista\", \"gas_natural\": \"1\", \"agua_potable\": \"1\", \"areas_verdes\": \"Bajo\", \"conectividad\": \"Avenidas Principales\", \"municipio_id\": \"1\", \"centros_salud\": \"1\", \"costo_contado\": \"10000\", \"costo_credito\": \"13000\", \"en_desarrollo\": \"0\", \"alcantarillado\": \"0\", \"fecha_registro\": \"2025-06-11\", \"urbanizacion_id\": \"1\", \"terrenos_baldios\": \"0\", \"conexion_internet\": \"0\", \"energia_electrica\": \"0\", \"centros_educativos\": \"0\", \"nivel_urbanizacion\": \"Consolidado\", \"oficinas_servicios\": \"0\", \"recoleccion_basura\": \"0\", \"superficie_terreno\": \"1000 mt2\", \"topografia_entorno\": \"Plano\", \"centros_comerciales\": \"0\", \"espacios_recreativos\": \"0\", \"oficinas_gubarnamentales\": \"0\"}', NULL, 'TERRENOS', '2025-06-11', '16:51:05', '2025-06-11 20:51:05', '2025-06-11 20:51:05'),
(27, 1, 'CREACIÓN', 'EL USUARIO admin REGISTRO UN TERRENOadmin REGISTRÓ LAS IMAGENES DEL TERRENO TERRENO 1', '{\"id\": 10, \"bancos\": \"0\", \"limpio\": \"0\", \"nombre\": \"TERRENO 1\", \"plazas\": \"0\", \"seguro\": \"1\", \"bodegas\": \"0\", \"imagens\": [{\"id\": 17, \"ext\": \"jpg\", \"name\": \"0101749675065.jpg\", \"imagen\": \"0101749675065.jpg\", \"url_file\": \"http://webbr.test/imgs/terrenos/0101749675065.jpg\", \"created_at\": \"2025-06-11T20:51:05.000000Z\", \"imagen_b64\": \"data:image/png;base64,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\", \"terreno_id\": 10, \"updated_at\": \"2025-06-11T20:51:05.000000Z\", \"url_imagen\": \"http://webbr.test/imgs/terrenos/0101749675065.jpg\", \"url_archivo\": \"http://webbr.test/imgs/terrenos/0101749675065.jpg\"}, {\"id\": 18, \"ext\": \"jpg\", \"name\": \"1101749675065.jpg\", \"imagen\": \"1101749675065.jpg\", \"url_file\": \"http://webbr.test/imgs/terrenos/1101749675065.jpg\", \"created_at\": \"2025-06-11T20:51:05.000000Z\", \"imagen_b64\": \"data:image/png;base64,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\", \"terreno_id\": 10, \"updated_at\": \"2025-06-11T20:51:05.000000Z\", \"url_imagen\": \"http://webbr.test/imgs/terrenos/1101749675065.jpg\", \"url_archivo\": \"http://webbr.test/imgs/terrenos/1101749675065.jpg\"}], \"parques\": \"0\", \"tiendas\": \"0\", \"trafico\": \"Bajo\", \"escuelas\": \"1\", \"galpones\": \"1\", \"iglesias\": \"0\", \"mercados\": \"0\", \"negocios\": \"0\", \"publicar\": \"SI\", \"alumbrado\": \"0\", \"tipo_zona\": \"Residencial\", \"viviendas\": \"1\", \"created_at\": \"2025-06-11T20:51:05.000000Z\", \"hospitales\": \"0\", \"manzano_id\": \"1\", \"tipo_calle\": \"Pavimentada\", \"updated_at\": \"2025-06-11T20:51:05.000000Z\", \"ancho_calle\": \"Autopista\", \"gas_natural\": \"1\", \"agua_potable\": \"1\", \"areas_verdes\": \"Bajo\", \"conectividad\": \"Avenidas Principales\", \"municipio_id\": \"1\", \"centros_salud\": \"1\", \"costo_contado\": \"10000\", \"costo_credito\": \"13000\", \"en_desarrollo\": \"0\", \"alcantarillado\": \"0\", \"fecha_registro\": \"2025-06-11\", \"urbanizacion_id\": \"1\", \"terrenos_baldios\": \"0\", \"conexion_internet\": \"0\", \"energia_electrica\": \"0\", \"centros_educativos\": \"0\", \"nivel_urbanizacion\": \"Consolidado\", \"oficinas_servicios\": \"0\", \"recoleccion_basura\": \"0\", \"superficie_terreno\": \"1000 mt2\", \"topografia_entorno\": \"Plano\", \"centros_comerciales\": \"0\", \"espacios_recreativos\": \"0\", \"oficinas_gubarnamentales\": \"0\"}', NULL, 'TERRENOS', '2025-06-11', '16:51:05', '2025-06-11 20:51:05', '2025-06-11 20:51:05'),
(28, 1, 'MODIFICACIÓN', 'EL USUARIO admin ACTUALIZÓ UN TERRENO', '{\"id\": 10, \"bancos\": \"0\", \"limpio\": \"1\", \"nombre\": \"TERRENO 1\", \"plazas\": \"0\", \"seguro\": \"1\", \"status\": 1, \"bodegas\": \"0\", \"imagens\": [{\"id\": 17, \"imagen\": \"0101749675065.jpg\", \"created_at\": \"2025-06-11T20:51:05.000000Z\", \"terreno_id\": 10, \"updated_at\": \"2025-06-11T20:51:05.000000Z\"}, {\"id\": 18, \"imagen\": \"1101749675065.jpg\", \"created_at\": \"2025-06-11T20:51:05.000000Z\", \"terreno_id\": 10, \"updated_at\": \"2025-06-11T20:51:05.000000Z\"}, {\"id\": 23, \"imagen\": \"0101749675484.jpg\", \"created_at\": \"2025-06-11T20:58:04.000000Z\", \"terreno_id\": 10, \"updated_at\": \"2025-06-11T20:58:04.000000Z\"}, {\"id\": 24, \"imagen\": \"1101749675484.jpg\", \"created_at\": \"2025-06-11T20:58:04.000000Z\", \"terreno_id\": 10, \"updated_at\": \"2025-06-11T20:58:04.000000Z\"}], \"parques\": \"0\", \"tiendas\": \"0\", \"trafico\": \"Bajo\", \"vendido\": 0, \"escuelas\": \"1\", \"galpones\": \"1\", \"iglesias\": \"0\", \"mercados\": \"0\", \"negocios\": \"0\", \"publicar\": \"SI\", \"alumbrado\": \"0\", \"tipo_zona\": \"Residencial\", \"viviendas\": \"1\", \"created_at\": \"2025-06-11T20:51:05.000000Z\", \"hospitales\": \"0\", \"manzano_id\": \"1\", \"tipo_calle\": \"Pavimentada\", \"updated_at\": \"2025-06-11T20:58:04.000000Z\", \"ancho_calle\": \"Autopista\", \"gas_natural\": \"1\", \"agua_potable\": \"1\", \"areas_verdes\": \"Bajo\", \"conectividad\": \"Avenidas Principales\", \"municipio_id\": \"1\", \"centros_salud\": \"1\", \"costo_contado\": \"10000.00\", \"costo_credito\": \"13000.00\", \"en_desarrollo\": \"0\", \"alcantarillado\": \"0\", \"fecha_registro\": \"2025-06-11\", \"urbanizacion_id\": \"1\", \"terrenos_baldios\": \"0\", \"conexion_internet\": \"0\", \"energia_electrica\": \"0\", \"centros_educativos\": \"0\", \"nivel_urbanizacion\": \"Consolidado\", \"oficinas_servicios\": \"0\", \"recoleccion_basura\": \"0\", \"superficie_terreno\": \"1000 mt2\", \"topografia_entorno\": \"Plano\", \"centros_comerciales\": \"0\", \"espacios_recreativos\": \"0\", \"oficinas_gubarnamentales\": \"0\"}', '{\"id\": 10, \"bancos\": 0, \"limpio\": 0, \"nombre\": \"TERRENO 1\", \"plazas\": 0, \"seguro\": 1, \"status\": 1, \"bodegas\": 0, \"imagens\": [{\"id\": 17, \"ext\": \"jpg\", \"name\": \"0101749675065.jpg\", \"imagen\": \"0101749675065.jpg\", \"url_file\": \"http://webbr.test/imgs/terrenos/0101749675065.jpg\", \"created_at\": \"2025-06-11T20:51:05.000000Z\", \"imagen_b64\": \"data:image/png;base64,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\", \"terreno_id\": 10, \"updated_at\": \"2025-06-11T20:51:05.000000Z\", \"url_imagen\": \"http://webbr.test/imgs/terrenos/0101749675065.jpg\", \"url_archivo\": \"http://webbr.test/imgs/terrenos/0101749675065.jpg\"}, {\"id\": 18, \"ext\": \"jpg\", \"name\": \"1101749675065.jpg\", \"imagen\": \"1101749675065.jpg\", \"url_file\": \"http://webbr.test/imgs/terrenos/1101749675065.jpg\", \"created_at\": \"2025-06-11T20:51:05.000000Z\", \"imagen_b64\": \"data:image/png;base64,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\", \"terreno_id\": 10, \"updated_at\": \"2025-06-11T20:51:05.000000Z\", \"url_imagen\": \"http://webbr.test/imgs/terrenos/1101749675065.jpg\", \"url_archivo\": \"http://webbr.test/imgs/terrenos/1101749675065.jpg\"}, {\"id\": 23, \"ext\": \"jpg\", \"name\": \"0101749675484.jpg\", \"imagen\": \"0101749675484.jpg\", \"url_file\": \"http://webbr.test/imgs/terrenos/0101749675484.jpg\", \"created_at\": \"2025-06-11T20:58:04.000000Z\", \"imagen_b64\": \"data:image/png;base64,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\", \"terreno_id\": 10, \"updated_at\": \"2025-06-11T20:58:04.000000Z\", \"url_imagen\": \"http://webbr.test/imgs/terrenos/0101749675484.jpg\", \"url_archivo\": \"http://webbr.test/imgs/terrenos/0101749675484.jpg\"}, {\"id\": 24, \"ext\": \"jpg\", \"name\": \"1101749675484.jpg\", \"imagen\": \"1101749675484.jpg\", \"url_file\": \"http://webbr.test/imgs/terrenos/1101749675484.jpg\", \"created_at\": \"2025-06-11T20:58:04.000000Z\", \"imagen_b64\": \"data:image/png;base64,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\", \"terreno_id\": 10, \"updated_at\": \"2025-06-11T20:58:04.000000Z\", \"url_imagen\": \"http://webbr.test/imgs/terrenos/1101749675484.jpg\", \"url_archivo\": \"http://webbr.test/imgs/terrenos/1101749675484.jpg\"}], \"parques\": 0, \"tiendas\": 0, \"trafico\": \"Bajo\", \"vendido\": 0, \"escuelas\": 1, \"galpones\": 1, \"iglesias\": 0, \"mercados\": 0, \"negocios\": 0, \"publicar\": \"SI\", \"alumbrado\": 0, \"tipo_zona\": \"Residencial\", \"viviendas\": 1, \"created_at\": \"2025-06-11T20:51:05.000000Z\", \"hospitales\": 0, \"manzano_id\": 1, \"tipo_calle\": \"Pavimentada\", \"updated_at\": \"2025-06-11T20:51:05.000000Z\", \"ancho_calle\": \"Autopista\", \"gas_natural\": 1, \"agua_potable\": 1, \"areas_verdes\": \"Bajo\", \"conectividad\": \"Avenidas Principales\", \"municipio_id\": 1, \"centros_salud\": 1, \"costo_contado\": \"10000.00\", \"costo_credito\": \"13000.00\", \"en_desarrollo\": 0, \"alcantarillado\": 0, \"fecha_registro\": \"2025-06-11\", \"urbanizacion_id\": 1, \"terrenos_baldios\": 0, \"conexion_internet\": 0, \"energia_electrica\": 0, \"centros_educativos\": 0, \"nivel_urbanizacion\": \"Consolidado\", \"oficinas_servicios\": 0, \"recoleccion_basura\": 0, \"superficie_terreno\": \"1000 mt2\", \"topografia_entorno\": \"Plano\", \"centros_comerciales\": 0, \"espacios_recreativos\": 0, \"oficinas_gubarnamentales\": 0}', 'TERRENOS', '2025-06-11', '16:58:04', '2025-06-11 20:58:04', '2025-06-11 20:58:04');

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
  `vendido` int NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '1',
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `terrenos`
--

INSERT INTO `terrenos` (`id`, `municipio_id`, `urbanizacion_id`, `manzano_id`, `nombre`, `tipo_calle`, `ancho_calle`, `conectividad`, `trafico`, `tipo_zona`, `agua_potable`, `alcantarillado`, `energia_electrica`, `gas_natural`, `alumbrado`, `recoleccion_basura`, `conexion_internet`, `escuelas`, `centros_educativos`, `hospitales`, `centros_salud`, `centros_comerciales`, `mercados`, `tiendas`, `parques`, `plazas`, `espacios_recreativos`, `iglesias`, `oficinas_gubarnamentales`, `oficinas_servicios`, `bancos`, `areas_verdes`, `nivel_urbanizacion`, `seguro`, `limpio`, `en_desarrollo`, `viviendas`, `negocios`, `bodegas`, `galpones`, `terrenos_baldios`, `topografia_entorno`, `superficie_terreno`, `costo_contado`, `costo_credito`, `publicar`, `vendido`, `status`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(10, 1, 1, 1, 'TERRENO 1', 'Pavimentada', 'Autopista', 'Avenidas Principales', 'Bajo', 'Residencial', 1, 1, 1, 1, 1, 1, 0, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Bajo', 'Consolidado', 1, 1, 0, 1, 0, 0, 1, 0, 'Plano', '1000 mt2', 10000.00, 13000.00, 'SI', 0, 1, '2025-06-11', '2025-06-11 20:51:05', '2025-06-11 21:03:03');

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

--
-- Volcado de datos para la tabla `terreno_imagens`
--

INSERT INTO `terreno_imagens` (`id`, `terreno_id`, `imagen`, `created_at`, `updated_at`) VALUES
(25, 10, '0101749675626.jpg', '2025-06-11 21:00:26', '2025-06-11 21:00:26');

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `terreno_imagens`
--
ALTER TABLE `terreno_imagens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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
