-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-03-2017 a las 21:19:46
-- Versión del servidor: 5.7.14
-- Versión de PHP: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de datos: `wordpress`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wp_ars_prices`
--

DROP TABLE IF EXISTS `wp_ars_prices`;
CREATE TABLE `wp_ars_prices` (
  `ars_prices_id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `origin_post_id` int(10) UNSIGNED NOT NULL,
  `valid_from` date NOT NULL,
  `valid_to` date NOT NULL,
  `days` varchar(14) NOT NULL,
  `base_price` float UNSIGNED NOT NULL,
  `base_pax` tinyint(3) UNSIGNED NOT NULL,
  `base_nights` tinyint(3) UNSIGNED NOT NULL,
  `extra_night_price` float UNSIGNED NOT NULL,
  `extra_pax_price` float UNSIGNED NOT NULL,
  `extra_pax_type` set('N','B') NOT NULL,
  `minimum_stay` tinyint(3) UNSIGNED NOT NULL,
  `maximum_stay` tinyint(3) UNSIGNED NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `valid` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wp_ars_prices_options`
--

DROP TABLE IF EXISTS `wp_ars_prices_options`;
CREATE TABLE `wp_ars_prices_options` (
  `ars_prices_options_id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `minimum_stay` tinyint(3) UNSIGNED NOT NULL,
  `maximum_stay` tinyint(3) UNSIGNED NOT NULL,
  `type` set('PC','PP','PN','PPN','PB') NOT NULL,
  `rate` float NOT NULL,
  `valid` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wp_ars_prices_supplements`
--

DROP TABLE IF EXISTS `wp_ars_prices_supplements`;
CREATE TABLE `wp_ars_prices_supplements` (
  `ars_prices_supplements_id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `sales_from` date NOT NULL,
  `sales_to` date NOT NULL,
  `applies_from` date NOT NULL,
  `applies_to` date NOT NULL,
  `obligatory_minimum_stay` tinyint(3) UNSIGNED NOT NULL,
  `minimum_stay` tinyint(3) UNSIGNED NOT NULL,
  `maximum_stay` tinyint(3) UNSIGNED NOT NULL,
  `rate` float UNSIGNED NOT NULL,
  `type` set('PC','PP','PN','PPN','PB') NOT NULL,
  `days` varchar(14) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `valid` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `wp_ars_prices`
--
ALTER TABLE `wp_ars_prices`
  ADD PRIMARY KEY (`ars_prices_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indices de la tabla `wp_ars_prices_options`
--
ALTER TABLE `wp_ars_prices_options`
  ADD PRIMARY KEY (`ars_prices_options_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indices de la tabla `wp_ars_prices_supplements`
--
ALTER TABLE `wp_ars_prices_supplements`
  ADD PRIMARY KEY (`ars_prices_supplements_id`),
  ADD KEY `post_id` (`post_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `wp_ars_prices`
--
ALTER TABLE `wp_ars_prices`
  MODIFY `ars_prices_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT de la tabla `wp_ars_prices_options`
--
ALTER TABLE `wp_ars_prices_options`
  MODIFY `ars_prices_options_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `wp_ars_prices_supplements`
--
ALTER TABLE `wp_ars_prices_supplements`
  MODIFY `ars_prices_supplements_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;