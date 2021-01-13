-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Erstellungszeit: 13. Jan 2021 um 14:49
-- Server-Version: 5.7.30-0ubuntu0.16.04.1
-- PHP-Version: 7.1.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Datenbank: `mylist`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `list`
--

CREATE TABLE `list` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('game','series','book','') NOT NULL DEFAULT '' COMMENT 'game, movie, book',
  `image` varchar(255) NOT NULL DEFAULT 'link to imagee',
  `platform` enum('mac','rg350','tv','windows','book','kindle') DEFAULT NULL,
  `launcher` enum('netflix','prime','snes','origin','steam','serienstream') DEFAULT NULL,
  `status` enum('active','backlog','done','') NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT 'foreign key to users.name'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `subitems`
--

CREATE TABLE `subitems` (
  `id` int(11) NOT NULL,
  `listid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` text,
  `order` int(11) NOT NULL,
  `status` enum('active','backlog','done','') NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `username` varchar(255) NOT NULL,
  `mail` varchar(45) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `list`
--
ALTER TABLE `list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name_idx` (`user`);

--
-- Indizes für die Tabelle `subitems`
--
ALTER TABLE `subitems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_idx` (`listid`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `list`
--
ALTER TABLE `list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `subitems`
--
ALTER TABLE `subitems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `list`
--
ALTER TABLE `list`
  ADD CONSTRAINT `name` FOREIGN KEY (`user`) REFERENCES `users` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `subitems`
--
ALTER TABLE `subitems`
  ADD CONSTRAINT `id` FOREIGN KEY (`listid`) REFERENCES `list` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;
