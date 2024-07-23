-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Erstellungszeit: 23. Jul 2024 um 13:49
-- Server-Version: 10.4.28-MariaDB
-- PHP-Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `timothyklimke_abibuzz`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `3831f1c3-d1dc-4c16-a31b-c3f46f993c5a______beichten`
--

CREATE TABLE `3831f1c3-d1dc-4c16-a31b-c3f46f993c5a______beichten` (
  `beichte` varchar(5000) DEFAULT NULL,
  `datum` datetime DEFAULT NULL,
  `status` varchar(64) DEFAULT NULL,
  `uuid` char(36) DEFAULT NULL,
  `autor` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `3831f1c3-d1dc-4c16-a31b-c3f46f993c5a______group_log`
--

CREATE TABLE `3831f1c3-d1dc-4c16-a31b-c3f46f993c5a______group_log` (
  `log` varchar(1000) DEFAULT NULL,
  `datum` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `3831f1c3-d1dc-4c16-a31b-c3f46f993c5a______group_settings`
--

CREATE TABLE `3831f1c3-d1dc-4c16-a31b-c3f46f993c5a______group_settings` (
  `einstellung` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `3831f1c3-d1dc-4c16-a31b-c3f46f993c5a______group_users`
--

CREATE TABLE `3831f1c3-d1dc-4c16-a31b-c3f46f993c5a______group_users` (
  `username` varchar(23) DEFAULT NULL,
  `uuid` char(36) NOT NULL,
  `first_name` varchar(20) DEFAULT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `password_hash` char(128) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `default_pass` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `3831f1c3-d1dc-4c16-a31b-c3f46f993c5a______group_users`
--

INSERT INTO `3831f1c3-d1dc-4c16-a31b-c3f46f993c5a______group_users` (`username`, `uuid`, `first_name`, `last_name`, `password_hash`, `role`, `default_pass`) VALUES
('TimothyKli', '970c81f7-001e-4c55-97bd-c093e22047d9', 'Timothy', 'Klimke', '$2y$10$Ka3ekAaMXcn6u6ksYbTgNOeeB5NO131zsqeRdnfkAmaE4xD5webyK', 'oa', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `3831f1c3-d1dc-4c16-a31b-c3f46f993c5a______rankings_list`
--

CREATE TABLE `3831f1c3-d1dc-4c16-a31b-c3f46f993c5a______rankings_list` (
  `titel` varchar(128) DEFAULT NULL,
  `beschreibung` varchar(1000) DEFAULT NULL,
  `auswahlListeUUID` char(36) DEFAULT NULL,
  `antwortenListeUUID` char(36) DEFAULT NULL,
  `status` varchar(64) DEFAULT NULL,
  `datum` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `3831f1c3-d1dc-4c16-a31b-c3f46f993c5a______storys`
--

CREATE TABLE `3831f1c3-d1dc-4c16-a31b-c3f46f993c5a______storys` (
  `story` varchar(5000) DEFAULT NULL,
  `datum` datetime DEFAULT NULL,
  `status` varchar(64) DEFAULT NULL,
  `uuid` char(36) DEFAULT NULL,
  `titel` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `3831f1c3-d1dc-4c16-a31b-c3f46f993c5a______surveys_list`
--

CREATE TABLE `3831f1c3-d1dc-4c16-a31b-c3f46f993c5a______surveys_list` (
  `titel` varchar(128) DEFAULT NULL,
  `beschreibung` varchar(1000) DEFAULT NULL,
  `status` varchar(64) DEFAULT NULL,
  `datum` datetime DEFAULT NULL,
  `antwortenListeUUID` char(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `3831f1c3-d1dc-4c16-a31b-c3f46f993c5a______votes_list`
--

CREATE TABLE `3831f1c3-d1dc-4c16-a31b-c3f46f993c5a______votes_list` (
  `titel` varchar(128) DEFAULT NULL,
  `beschreibung` varchar(1000) DEFAULT NULL,
  `auswahlListeUUID` char(36) DEFAULT NULL,
  `antwortenListeUUID` char(36) DEFAULT NULL,
  `status` varchar(64) DEFAULT NULL,
  `datum` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `3831f1c3-d1dc-4c16-a31b-c3f46f993c5a______zitate`
--

CREATE TABLE `3831f1c3-d1dc-4c16-a31b-c3f46f993c5a______zitate` (
  `zitat` varchar(5000) DEFAULT NULL,
  `datum` datetime DEFAULT NULL,
  `status` varchar(64) DEFAULT NULL,
  `uuid` char(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_users`
--

CREATE TABLE `admin_users` (
  `username` varchar(20) DEFAULT NULL,
  `uuid` char(36) NOT NULL,
  `first_name` varchar(20) DEFAULT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `password_hash` char(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `admin_users`
--

INSERT INTO `admin_users` (`username`, `uuid`, `first_name`, `last_name`, `password_hash`) VALUES
('Admin-TK', 'f5caf163-bfbc-48c6-8a3d-d51b0c5a42d7', 'Timothy', 'Klimke', '$2y$10$Ex7cs6BHqQNItmtCwcuQUuTY6GfyDkYHi1PKRtZp5F1PmSuHIK1Ri');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `audit_log`
--

CREATE TABLE `audit_log` (
  `date` datetime DEFAULT NULL,
  `admin_account_uuid` char(36) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `info` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `facilities`
--

CREATE TABLE `facilities` (
  `name` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `uuid` char(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `facilities`
--

INSERT INTO `facilities` (`name`, `address`, `uuid`) VALUES
('Humboldt-Gymnasium Ulm', 'Karl-Schefold-Straße 18, 89073 Ulm', 'f7c7258a-43e3-4ace-a655-352b664dbfa1'),
('Kepler-Gymnasium Ulm', 'Karl-Schefold-Straße 16, 89073 Ulm', '0353690a-d22c-4b10-8acb-79f4cbd486d0'),
('Schubart-Gymnasium Ulm', 'Innere Wallstraße 30, 89077 Ulm', 'db70ea2b-a0df-413c-88fb-c33f459b263f');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `group_list`
--

CREATE TABLE `group_list` (
  `uuid` char(36) NOT NULL,
  `title` varchar(64) DEFAULT NULL,
  `info` varchar(1000) DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  `organisation_account_uuid` char(36) DEFAULT NULL,
  `facility_uuid` char(36) DEFAULT NULL,
  `contact_email` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `group_list`
--

INSERT INTO `group_list` (`uuid`, `title`, `info`, `creation_date`, `organisation_account_uuid`, `facility_uuid`, `contact_email`) VALUES
('3831f1c3-d1dc-4c16-a31b-c3f46f993c5a', 'Abi 25', 'Abi am HGU', '2024-07-09 16:33:16', '970c81f7-001e-4c55-97bd-c093e22047d9', 'f7c7258a-43e3-4ace-a655-352b664dbfa1', 'timothyklimke@icloud.com');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `3831f1c3-d1dc-4c16-a31b-c3f46f993c5a______group_users`
--
ALTER TABLE `3831f1c3-d1dc-4c16-a31b-c3f46f993c5a______group_users`
  ADD PRIMARY KEY (`uuid`);

--
-- Indizes für die Tabelle `group_list`
--
ALTER TABLE `group_list`
  ADD PRIMARY KEY (`uuid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
