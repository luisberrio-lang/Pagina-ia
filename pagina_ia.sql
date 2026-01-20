-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-01-2026 a las 05:40:29
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
-- Base de datos: `pagina_ia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_12_21_184508_create_support_tickets_table', 1),
(5, '2025_12_24_012202_add_role_to_users_table', 1),
(6, '2025_12_24_014513_create_tools_table', 1),
(7, '2025_12_24_020000_add_price_details_to_tools_table', 1),
(8, '2026_01_08_025026_add_pack_fields_to_tools_table', 1),
(9, '2026_01_13_000001_add_old_prices_to_tools_table', 2),
(10, '2026_01_14_154930_add_bimestral_trimestral_to_tools_table', 2),
(11, '2026_01_14_161401_add_period_prices_and_prev_to_tools_table', 2),
(12, '2026_01_14_162339_add_prev_prices_to_tools_table', 2),
(13, '2026_01_13_000000_add_old_prices_to_tools_table', 3),
(14, '2025_12_24_020000_add_is_admin_to_users_table', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(120) NOT NULL,
  `email` varchar(160) NOT NULL,
  `subject` varchar(140) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'abierto',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `support_tickets`
--

INSERT INTO `support_tickets` (`id`, `user_id`, `name`, `email`, `subject`, `message`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Admin 2', 'admin2@tudominio.com', 'SDSDS', 'DFSDFDSF', 'abierto', '2026-01-15 20:31:29', '2026-01-15 20:31:29'),
(2, 1, 'Admin 2', 'admin2@tudominio.com', 'SSDF', 'DSFSDF', 'abierto', '2026-01-15 22:53:00', '2026-01-15 22:53:00'),
(3, 1, 'Admin 2', 'admin2@tudominio.com', 'DFSFS', 'SDFDSFDSF', 'abierto', '2026-01-15 23:03:45', '2026-01-15 23:03:45'),
(4, 1, 'Admin 2', 'admin2@tudominio.com', 'VSDVSD', 'SDFSDFSDF', 'abierto', '2026-01-15 23:27:45', '2026-01-15 23:27:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tools`
--

CREATE TABLE `tools` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tag` varchar(50) DEFAULT NULL,
  `title` varchar(120) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `short_desc` varchar(180) DEFAULT NULL,
  `badge_text` varchar(50) DEFAULT NULL,
  `highlights` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`highlights`)),
  `includes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`includes`)),
  `extras` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`extras`)),
  `audience` text DEFAULT NULL,
  `price_monthly` decimal(10,2) DEFAULT NULL,
  `prev_price_monthly` decimal(10,2) DEFAULT NULL,
  `price_bimestral` decimal(10,2) DEFAULT NULL,
  `prev_price_bimestral` decimal(10,2) DEFAULT NULL,
  `price_trimestral` decimal(10,2) DEFAULT NULL,
  `prev_price_trimestral` decimal(10,2) DEFAULT NULL,
  `old_price_monthly` decimal(10,2) DEFAULT NULL,
  `price_semestral` decimal(10,2) DEFAULT NULL,
  `prev_price_semestral` decimal(10,2) DEFAULT NULL,
  `old_price_semestral` decimal(10,2) DEFAULT NULL,
  `price_anual` decimal(10,2) DEFAULT NULL,
  `prev_price_anual` decimal(10,2) DEFAULT NULL,
  `old_price_anual` decimal(10,2) DEFAULT NULL,
  `savings_semestral` decimal(10,2) DEFAULT NULL,
  `savings_anual` decimal(10,2) DEFAULT NULL,
  `price` varchar(60) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `old_price_bimestral` decimal(10,2) DEFAULT NULL,
  `old_price_trimestral` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tools`
--

INSERT INTO `tools` (`id`, `tag`, `title`, `subtitle`, `short_desc`, `badge_text`, `highlights`, `includes`, `extras`, `audience`, `price_monthly`, `prev_price_monthly`, `price_bimestral`, `prev_price_bimestral`, `price_trimestral`, `prev_price_trimestral`, `old_price_monthly`, `price_semestral`, `prev_price_semestral`, `old_price_semestral`, `price_anual`, `prev_price_anual`, `old_price_anual`, `savings_semestral`, `savings_anual`, `price`, `details`, `sort_order`, `is_active`, `created_at`, `updated_at`, `old_price_bimestral`, `old_price_trimestral`) VALUES
(5, 'DESTACADO', 'CREATOR AI MASTER 2.0', 'Pack Premium de Inteligencia Artificial', 'Creator AI Master 2.0 es un pack avanzado de IA para creadores, marketers y empresas, con herramientas líderes para diseño, video, texto, voz y automatización.', NULL, '[\"CREA\",\"EDITA\",\"CORRE\",\"REPRODUCE\"]', '[{\"label\":\"Incluye\",\"text\":\"gemini+ chat gtpt\"},{\"label\":\"Incluye\",\"text\":\"php+ layouts +tik tik\"}]', '[\"\\ud83d\\udcdd Texto y Automatizaci\\u00f3n\",\"ChatGPT PRO\",\"Uso ilimitado\",\"Respuestas avanzadas\",\"Generaci\\u00f3n de contenido, c\\u00f3digo y estrategias\",\"\\ud83c\\udfa8 Dise\\u00f1o e Im\\u00e1genes\",\"MidJourney\",\"Im\\u00e1genes en alta calidad\",\"Uso comercial\",\"Canva AI Pro\",\"Plantillas premium\",\"Edici\\u00f3n con IA\",\"\\ud83c\\udfac Video y Animaci\\u00f3n\",\"CapCut PRO\",\"Exportaci\\u00f3n sin marca de agua\",\"Efectos con IA\"]', 'para estudiantes', 25.00, NULL, 22.00, NULL, 18.00, NULL, 100.00, 90.00, NULL, 100.00, 200.00, NULL, 400.00, NULL, NULL, NULL, NULL, 1, 1, '2026-01-16 03:40:07', '2026-01-16 08:13:51', 50.00, 36.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'client',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`, `is_admin`) VALUES
(1, 'Admin 2', 'admin2@tudominio.com', NULL, '$2y$12$kBp1VyQSOqpRw0vDd5RISO2gE/.HjMS5zv5aPSte/mZI5dXog3ipO', 'admin', NULL, '2026-01-15 07:43:33', '2026-01-15 07:43:33', 0),
(2, 'Test User', 'test@example.com', '2026-01-16 07:07:50', '$2y$12$7Ubfb5svJaZdU1.fpwZTCuz.TaUW7FP7.Hs1HW8Rg3ZN13TbOZAeC', 'client', 'q2VzQm2BV6', '2026-01-16 07:07:50', '2026-01-16 07:07:50', 0),
(3, 'Administrador', 'berriolab@gmail.com', NULL, '$2y$12$60YetNGI5rJX3LK6Oouuf.RyW8ZRuMSSfqWMJqf1GnqhU7j8Zj7lO', 'admin', NULL, '2026-01-16 07:07:50', '2026-01-16 07:07:50', 0),
(4, 'LUIS BERRIO', 'luis.berrio@tecsup.edu.pe', NULL, '$2y$12$2WZokbqr0BmLvINpygQfDe08YQjGygkK.RT7jgH0p6aW/.wq84A0G', 'client', NULL, '2026-01-16 07:17:13', '2026-01-16 07:17:13', 0),
(5, 'LUIS', 'washingtonberrio123@gmail.com', NULL, '$2y$12$hn1oN1nM1sY1nVupfc8Ag.lDY7HGVLGZnJsNxBbOuiSngUPdHDZLO', 'client', NULL, '2026-01-16 07:26:15', '2026-01-16 07:26:15', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `support_tickets_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `tools`
--
ALTER TABLE `tools`
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
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tools`
--
ALTER TABLE `tools`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD CONSTRAINT `support_tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
