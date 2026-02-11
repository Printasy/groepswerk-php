-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Gegenereerd op: 11 feb 2026 om 00:37
-- Serverversie: 9.1.0
-- PHP-versie: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `erp-app2`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(190) NOT NULL,
  `email` varchar(190) NOT NULL DEFAULT '',
  `phone` varchar(50) NOT NULL DEFAULT '',
  `company` varchar(190) NOT NULL DEFAULT '',
  `vat` varchar(50) NOT NULL DEFAULT '',
  `address` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `company`, `vat`, `address`, `created_at`, `updated_at`) VALUES
(1, 'Customer A', 'contact@customera.com', '012-1111111', 'Company A', 'BE0123456789', 'Straat 1, 8500 Kortrijk', '2026-02-10 10:00:00', '2026-02-10 10:00:00'),
(2, 'Customer B', 'info@customerb.com', '012-2222222', 'Company B', 'BE0234567891', 'Straat 2, 9000 Gent', '2026-02-10 10:15:00', '2026-02-10 10:15:00'),
(3, 'Customer C', 'support@customerc.com', '012-3333333', 'Company C', 'BE0345678912', 'Straat 3, 2000 Antwerpen', '2026-02-10 10:30:00', '2026-02-10 10:30:00'),
(4, 'Customer D', 'sales@customerd.com', '012-4444444', 'Company D', 'BE0456789123', 'Straat 4, 3000 Leuven', '2026-02-10 10:45:00', '2026-02-10 10:45:00'),
(5, 'Customer E', 'hello@customere.com', '012-5555555', 'Company E', 'BE0567891234', 'Straat 5, 1000 Brussel', '2026-02-10 11:00:00', '2026-02-10 11:00:00'),
(6, 'Customer A', 'contact@customera.com', '0470-111111', 'Company A', 'BE0123456789', 'Kerkstraat 1, 8500 Kortrijk', '2026-02-10 23:58:01', '2026-02-10 23:58:01'),
(7, 'Customer B', 'info@customerb.com', '0470-222222', 'Company B', 'BE0234567891', 'Stationsstraat 12, 9000 Gent', '2026-02-10 23:58:01', '2026-02-10 23:58:01'),
(8, 'Customer C', 'support@customerc.com', '0470-333333', 'Company C', 'BE0345678912', 'Markt 5, 2000 Antwerpen', '2026-02-10 23:58:01', '2026-02-10 23:58:01'),
(9, 'Customer D', 'sales@customerd.com', '0470-444444', 'Company D', 'BE0456789123', 'Nieuwstraat 99, 3000 Leuven', '2026-02-10 23:58:01', '2026-02-10 23:58:01');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(190) NOT NULL,
  `sku` varchar(100) NOT NULL,
  `verkoopprijs` decimal(10,2) NOT NULL DEFAULT '0.00',
  `inkoopprijs` decimal(10,2) DEFAULT NULL,
  `supplier_id` int DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sku` (`sku`),
  KEY `fk_products_supplier` (`supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `products`
--

INSERT INTO `products` (`id`, `name`, `sku`, `verkoopprijs`, `inkoopprijs`, `supplier_id`, `created_at`, `updated_at`) VALUES
(1, 'Fiets', '1234', 1000.00, 500.00, NULL, '2026-02-10 11:37:46', '2026-02-10 11:37:46'),
(2, 'Laptop', '2345', 1500.00, 1200.00, 2, '2026-02-10 12:00:00', '2026-02-10 12:00:00'),
(3, 'Stoel', '3456', 85.50, 40.00, 3, '2026-02-10 12:15:30', '2026-02-10 12:15:30'),
(4, 'Tafel', '4567', 250.00, 150.00, 1, '2026-02-10 12:30:00', '2026-02-10 12:30:00'),
(5, 'Lamp', '5678', 60.00, 25.00, 2, '2026-02-10 12:45:00', '2026-02-10 12:45:00');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
CREATE TABLE IF NOT EXISTS `suppliers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(190) NOT NULL,
  `email` varchar(190) NOT NULL DEFAULT '',
  `phone` varchar(50) NOT NULL DEFAULT '',
  `website` varchar(255) NOT NULL DEFAULT '',
  `address` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `email`, `phone`, `website`, `address`, `created_at`, `updated_at`) VALUES
(1, 'Supplier A', 'contact@suppliera.com', '012-3456789', 'https://www.suppliera.com', 'Straat 1, Stad A', '2026-02-10 10:00:00', '2026-02-10 10:00:00'),
(2, 'Supplier B', 'info@supplierb.com', '012-9876543', 'https://www.supplierb.com', 'Straat 2, Stad B', '2026-02-10 10:15:00', '2026-02-10 10:15:00'),
(3, 'Supplier C', 'support@supplierc.com', '012-1122334', 'https://www.supplierc.com', 'Straat 3, Stad C', '2026-02-10 10:30:00', '2026-02-10 10:30:00'),
(4, 'Supplier D', 'sales@supplierd.com', '012-5566778', 'https://www.supplierd.com', 'Straat 4, Stad D', '2026-02-10 10:45:00', '2026-02-10 10:45:00'),
(5, 'Supplier E', 'hello@suppliere.com', '012-9988776', 'https://www.suppliere.com', 'Straat 5, Stad E', '2026-02-10 11:00:00', '2026-02-10 11:00:00');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(190) NOT NULL,
  `email` varchar(190) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `password_hash` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `password_hash`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'User', 'user@erpapp.com', 'user', '$2y$12$ToFzT1fQttWMoBB5VlinWuRG1pajC7ZB1svy86uVM/e8RZziw7YOW', 1, '2026-02-09 23:29:22', '2026-02-09 23:29:22'),
(3, 'admin', 'admin@erpapp.com', 'admin', '$2y$12$mxPI4tQSDI914QyAfWd.ve69XSxx76vP6bC1H8g4UniaP4vj9QD7q', 1, '2026-02-09 23:30:05', '2026-02-09 23:30:05');

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
