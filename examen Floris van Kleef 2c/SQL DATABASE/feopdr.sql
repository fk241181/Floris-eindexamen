-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 23 feb 2025 om 22:26
-- Serverversie: 10.4.32-MariaDB
-- PHP-versie: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `feopdr`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'Adm!n123', '$2y$10$OAvxbP/oigZ.C6bRyBiMiuOSPcX92JFSuvNChyCb6O9LsUAb87Rdq');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `categorie` enum('drinken','eten','toetje') NOT NULL,
  `naam` varchar(200) NOT NULL,
  `prijs` decimal(5,2) NOT NULL,
  `afbeelding` varchar(255) DEFAULT 'placeholder.jpg',
  `beschrijving` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `menu`
--

INSERT INTO `menu` (`id`, `categorie`, `naam`, `prijs`, `afbeelding`, `beschrijving`) VALUES
(1, 'drinken', 'Cola', 2.50, 'cola.jpg', 'Cola 250ML '),
(2, 'eten', 'Pasta Bolognese', 12.50, 'pasta-bolognese.jpg', 'Een klassiek Italiaans gerecht met een rijke, hartige saus van mager gehakt, tomaten, ui, wortel en kruiden, geserveerd over een heerlijke portie pasta. Perfect voor een comfortmaaltijd!'),
(3, 'eten', 'Spaghetti Carbonara', 12.50, 'Spaghetti Carbonara.jpg', 'Een klassiek Italiaans pastagerecht met romige saus, spek en Parmezaanse kaas.'),
(4, 'eten', 'Ribeye Steak met Kruidenboter', 24.95, 'Ribeye Steak.jpg', 'Sappige ribeye steak, perfect gegrild en geserveerd met romige kruidenboter en frietjes.'),
(6, 'eten', 'Vegetarische Lasagne', 13.50, 'Vegetarische Lasagne.jpg', 'Heerlijke lasagne met gegrilde groenten, romige bechamelsaus en gesmolten kaas.'),
(7, 'eten', 'Kip Tandoori', 14.95, 'Kip Tandoori.jpg', 'Gekruide kip uit de oven met yoghurtmarinade, geserveerd met rijst en naanbrood.'),
(8, 'drinken', 'Mojito', 7.50, 'Mojito.jpg', 'Verfrissende cocktail met munt, limoen, rietsuiker en bruiswater.'),
(9, 'drinken', 'Aardbeien Smoothie', 5.00, 'Aardbeien Smoothie.jpg', 'Een gezonde en romige smoothie met verse aardbeien en yoghurt.'),
(10, 'drinken', 'Espresso Martini', 8.50, 'Espresso Martini.jpg', 'Een heerlijke koffiecocktail met espresso, wodka en koffielikeur.'),
(11, 'drinken', 'Verse IJsthee', 4.50, 'Verse IJsthee.jpg', 'Huisgemaakte ijsthee met citroen en honing, perfect voor warme dagen.'),
(12, 'drinken', 'Chocolademelk met Slagroom', 3.95, 'Chocolademelk.jpg', 'Warme chocolademelk met romige slagroom en chocoladeschaafsel.'),
(13, 'toetje', 'Tiramisu', 6.50, 'Tiramisu.jpg', 'Een Italiaanse klassieker met lagen mascarpone, espresso en cacaopoeder.'),
(14, 'toetje', 'Cheesecake met Aardbeien', 6.95, 'Cheesecake.jpg', 'Romige cheesecake met een knapperige bodem en verse aardbeientopping.'),
(15, 'toetje', 'Crème Brûlée', 7.00, 'Crème Brulèe.jpg', 'Franse custard met een gekarameliseerde suikerlaag, heerlijk knapperig.'),
(16, 'toetje', 'Chocolade Lava Cake', 7.50, 'Chocolade Lava Cake.jpg', 'Warm chocoladetaartje met een zachte, vloeibare kern, geserveerd met vanille-ijs.'),
(17, 'toetje', 'Panna Cotta met Frambozen', 6.75, 'Panna Cotta.jpg', 'Een zijdezachte Italiaanse pudding met frisse frambozensaus.');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `tafel` int(11) NOT NULL,
  `eten` varchar(255) DEFAULT NULL,
  `drinken` varchar(255) DEFAULT NULL,
  `toetje` varchar(255) DEFAULT NULL,
  `status` enum('besteld','in voorbereiding','geserveerd') DEFAULT 'besteld',
  `besteld_op` timestamp NOT NULL DEFAULT current_timestamp(),
  `menu_id` int(11) NOT NULL,
  `aantal` int(11) NOT NULL,
  `menu_naam` varchar(255) DEFAULT NULL,
  `TVG` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `orders`
--

INSERT INTO `orders` (`id`, `tafel`, `eten`, `drinken`, `toetje`, `status`, `besteld_op`, `menu_id`, `aantal`, `menu_naam`, `TVG`) VALUES
(36, 1, NULL, NULL, NULL, 'geserveerd', '2025-02-23 20:27:00', 3, 3, 'Spaghetti Carbonara', ''),
(37, 1, NULL, NULL, NULL, 'besteld', '2025-02-23 20:27:00', 8, 7, 'Mojito', ''),
(38, 1, NULL, NULL, NULL, 'besteld', '2025-02-23 20:27:00', 10, 32, 'Espresso Martini', ''),
(39, 1, NULL, NULL, NULL, 'besteld', '2025-02-23 20:27:00', 11, 3, 'Verse IJsthee', ''),
(40, 1, NULL, NULL, NULL, 'besteld', '2025-02-23 20:27:00', 17, 3, 'Panna Cotta met Frambozen', '');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `password` varchar(200) NOT NULL,
  `Tafel` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `password`, `Tafel`) VALUES
(1, '$2y$10$6H1n9oCH2QeoJTIfEYQWn.KzXft6TSJNRY9UIV2KKJ/naGdMmavSq', '1'),
(2, '$2y$10$L1Tvp7uQYdfclnwd4/7EqOEhLp/5KJ0juNNMMzRnsybsfPIeYezIu', '2'),
(3, '$2y$10$/tzNYKCwJnMS1rvXtBgh7uY03Ami5VLybLz8CFBeCLol6yofQmFQm', '3'),
(4, '$2y$10$jnxd5NRPO71sOhevSzATV.aKdyoT0z5.yZLnIqDESQlDHTO1C4Enu', '4'),
(5, '$2y$10$7IWYWKerIkoGfPjBKWKGMuJcRQDcPzSlxCvDzieOgxEedTdNDnl6W', '5'),
(6, '$2y$10$1q2iDe//iEBfKpRsvhujBOm7M8kdTYX.KgbaDi3Ri5N.OjayylF/u', '6'),
(7, '$2y$10$F7MkezW2UrSL0rGhPJjZo.fVFX1WSyxj9ycurSbG0d.mIXlfi8yuC', '7'),
(8, '$2y$10$X5vFEjoLer.z6Pw8JXVlyuna5ZIb9LbtNPCNCV1QRDlMMdDRGrPzK', '8'),
(9, '$2y$10$ESszLbJ0VjPPzqnjapF05uOm3XzChCiqq3/zTxJqb9D3L9o.1GjEi', '9'),
(10, '$2y$10$f2Ki/3PrdMikgzaXzYu75.yxYmq/Lq8uk4rbhPEQYm9CMBvmQd.k2', '10'),
(11, '$2y$10$ia7seq7ML1hd2b.3d.4EZek9btVh4TkL64HQzaHD/G5ky8iD3lgLa', '11'),
(12, '$2y$10$k1KjAZ0BC1uwwgubaS.wfeNoLjd4rnj3UpxL.H0wXOnbrIWvzzNKK', '12'),
(13, '$2y$10$QlTh2ZuDE5iQkmoRpiAciufTiHhrmq912FvSLZr8dsFjE6NRN/46e', '13'),
(14, '$2y$10$AGdsE5Vlap4WHWmAoooot.Tti41RusHA3rPQSOuGJbdhlgIYkDYja', '14'),
(15, '$2y$10$CHqYhx6xyL6WHvL4iFVcr.6mvp00TvrDPU.u70pvMXzNQdhgRM3r2', '15'),
(16, '$2y$10$auL2iVfT9ewcp1stG6nikOsFyRj.J9PlN2HYC.SqS0vdRMAeJ./yu', '16'),
(17, '$2y$10$U6jEgg1L9fla64pF/YcoT.VkO6HW/p7zKZeiffhbgPg0oHAhucARq', '17'),
(18, '$2y$10$pX3DIjb9/kRlGsRTVSuTt.Q61fSXbdRCajjEW8PSkTIPEzZhOnK7S', '18'),
(19, '$2y$10$LqnsceG/i9ILiB9yFMeV/.EJrk1aAi9EOd7oK9ea.cqmGycchm0MG', '19'),
(20, '$2y$10$jkz1STPVYRbWwjc0zeITfeuqow0WhYmnsrvjN3.MpsTU.4fwgH/Rq', '20');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexen voor tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT voor een tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
