-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2025. Okt 23. 15:41
-- Kiszolgáló verziója: 10.4.32-MariaDB
-- PHP verzió: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `projekt`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `autok`
--

CREATE TABLE `autok` (
  `alvazszam` char(17) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL COMMENT 'Kocsi alvázszáma',
  `rendszam` char(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL COMMENT 'Kocsi rendszáma',
  `marka` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL COMMENT 'Kocsi márkája',
  `tipus` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL COMMENT 'Kocsi modellneve',
  `szin` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL COMMENT 'Kocsi szine',
  `gydatum` date DEFAULT NULL COMMENT 'Kocsi gyártási dátuma',
  `uzema` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL COMMENT 'Kocsi üzemanyagtipusa ',
  `hengeru` int(4) DEFAULT NULL COMMENT 'Kocsi hengerűrtartalma',
  `teljesitmeny` int(7) NOT NULL COMMENT 'Kocsi teljesitménye',
  `kep` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL COMMENT 'Kép az autóról',
  `muszakilej` date NOT NULL COMMENT 'Műszaki lejárata',
  `forgalome` tinyint(1) NOT NULL COMMENT 'Autó forgalomban van-e',
  `biztositase` tinyint(1) NOT NULL COMMENT 'Autón van-e biztositás?',
  `korozese` tinyint(1) NOT NULL COMMENT 'Autó körözés alatt van-e?',
  `tulajdonossz` int(3) DEFAULT NULL COMMENT 'Kocsi tulajdonosainak száma',
  `motorkod` char(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL COMMENT 'Autó motorkódja',
  `kornyezetved` char(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL COMMENT 'Autó környezetvédelmi besorolása',
  `gepjkat` char(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL COMMENT 'Gépjármű kategóriája EU szabályozás szerint',
  `utassz` int(2) NOT NULL COMMENT 'Autóban szállitható utasok száma',
  `valtotip` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL COMMENT 'Autó sebességváltójának tipusa',
  `kivitel` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL COMMENT 'Kocsi karosszéria tipusa',
  `tomeg` int(6) NOT NULL COMMENT 'Kocsi saját tömege (kg) ',
  `vontattomf` int(6) DEFAULT NULL COMMENT 'Autó vontatható tömege fékkel',
  `vontattomfn` int(6) DEFAULT NULL COMMENT 'Autó vontatható tömege fék nélkül'
) ;

--
-- A tábla adatainak kiíratása `autok`
--

INSERT INTO `autok` (`alvazszam`, `rendszam`, `marka`, `tipus`, `szin`, `gydatum`, `uzema`, `hengeru`, `teljesitmeny`, `kep`, `muszakilej`, `forgalome`, `biztositase`, `korozese`, `tulajdonossz`, `motorkod`, `kornyezetved`, `gepjkat`, `utassz`, `valtotip`, `kivitel`, `tomeg`, `vontattomf`, `vontattomfn`) VALUES
('JH4DC5380TS000111', 'TES789', 'Honda', 'Civic', 'fekete', '2018-11-09', 'benzin', 1498, 129, 'honda-civic.jpg', '2025-12-15', 1, 1, 0, 1, 'L15B7', 'EU6', 'M1', 5, 'automata', 'sedan', 1250, 1000, 500),
('VF1CLBA0H12345678', 'ABC123', 'Renault', 'Clio', 'piros', '2016-03-14', 'benzin', 1197, 88, 'renault-clio.jpg', '2025-09-30', 1, 1, 0, 2, 'D4F', 'EU5', 'M1', 5, 'manuális', 'ferdehátú', 1090, 900, 450),
('WAUZZZ8KXCA000222', 'ADM001', 'Audi', 'A4', 'szürke', '2020-05-12', 'dízel', 1968, 150, 'audi-a4.jpg', '2026-08-01', 1, 1, 0, 1, 'DFGA', 'EU6', 'M1', 5, 'automata', 'kombi', 1470, 1700, 750),
('WAUZZZ8V4GA123456', 'AAAZ675', 'Audi', 'A3 Sportback', 'Fekete', '2016-05-12', 'Benzin', 1395, 110, 'audi-a3.jpg', '2025-07-30', 1, 1, 0, 1, 'CZEA', 'EURO6', 'M1', 5, 'Automata', 'ferdehátú', 1280, NULL, NULL),
('WVWZZZ1JZXW000001', 'XYZ456', 'Volkswagen', 'Golf', 'fehér', '2010-06-22', 'dízel', 1598, 105, 'golf.jpg', '2026-04-01', 1, 1, 0, 3, 'CAYC', 'EU5', 'M1', 5, 'manuális', 'ferdehátú', 1210, 1300, 600);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalok`
--

CREATE TABLE `felhasznalok` (
  `felhasznalo_id` int(11) NOT NULL COMMENT 'Felhasználó azonosító',
  `felhasznalonev` varchar(50) NOT NULL COMMENT 'Bejelentkezési név',
  `jelszo` varchar(255) NOT NULL COMMENT 'Felhasználó jelszava',
  `email` varchar(100) DEFAULT NULL COMMENT 'Email cím',
  `szerep` enum('admin','felhasznalo') NOT NULL DEFAULT 'felhasznalo' COMMENT 'Felhasználói szerep'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `felhasznalok`
--

INSERT INTO `felhasznalok` (`felhasznalo_id`, `felhasznalonev`, `jelszo`, `email`, `szerep`) VALUES
(1, 'nagyp35', 'nagyp-35', 'nagyp35@gmail.com', 'felhasznalo'),
(2, 'szabojozsef31', 'szabojozsef-31', 'szabojozsef31@gmail.com', 'felhasznalo'),
(3, 'tothtamas89', 'tothtamas-89', 'tothtamas89@gmail.com', 'felhasznalo'),
(4, 'szaboem76', 'szaboe-76', 'szaboe76@gmail.com', 'felhasznalo'),
(5, 'molnarjonatan99', 'molnarjonatan-99', 'molnarjonatan99@gmail.com', 'admin');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `muszaki_vizsga`
--

CREATE TABLE `muszaki_vizsga` (
  `mvid` int(11) NOT NULL COMMENT 'Műszaki vizsga azonositó',
  `alvazszam` char(17) NOT NULL COMMENT 'Kocsi alvázszáma (FK)',
  `mvdatum` date NOT NULL COMMENT 'Műszaki vizsga dátuma',
  `eredmeny` varchar(40) NOT NULL COMMENT 'Műszaki vizsga ',
  `kmallas` int(20) NOT NULL COMMENT 'Kocsi kilóméterállása'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `muszaki_vizsga`
--

INSERT INTO `muszaki_vizsga` (`mvid`, `alvazszam`, `mvdatum`, `eredmeny`, `kmallas`) VALUES
(1, 'WAUZZZ8V4GA123456', '2025-10-01', 'Megfelelt', 240000),
(2, 'WAUZZZ8V4GA123456', '2025-08-01', 'Nem felelt meg', 240000),
(3, 'JH4DC5380TS000111', '2024-01-04', 'Megfelelt', 200000),
(4, 'VF1CLBA0H12345678', '2023-06-03', 'Megfelelt', 320000),
(5, 'WVWZZZ1JZXW000001', '2025-02-03', 'Megfelelt', 290000),
(6, 'WAUZZZ8KXCA000222', '2023-07-09', 'Megfelelt', 185000),
(7, 'WAUZZZ8V4GA123456', '2021-08-05', 'Megfelelt', 140000),
(8, 'WAUZZZ8V4GA123456', '2019-07-30', 'Megfelelt', 100000),
(9, 'JH4DC5380TS000111', '2022-01-03', 'Megfelelt', 180000),
(10, 'JH4DC5380TS000111', '2020-01-05', 'Megfelelt', 240000),
(11, 'JH4DC5380TS000111', '2018-01-09', 'Megfelelt', 190000),
(12, 'VF1CLBA0H12345678', '2025-06-09', 'Nem felelt meg', 350000),
(13, 'VF1CLBA0H12345678', '2021-06-02', 'Megfelelt', 270000),
(14, 'VF1CLBA0H12345678', '2019-06-05', 'Megfelelt', 235000),
(15, 'WAUZZZ8KXCA000222', '2025-10-03', 'Megfelelt', 200000),
(16, 'WAUZZZ8V4GA123456', '2023-10-28', 'Megfelelt', 176000),
(17, 'WAUZZZ8KXCA000222', '2023-10-22', 'Nem felelt meg', 176000),
(18, 'WAUZZZ8KXCA000222', '2021-10-09', 'Megfelelt', 140000),
(19, 'WAUZZZ8KXCA000222', '2019-10-10', 'Megfelelt', 90000),
(20, 'WVWZZZ1JZXW000001', '2023-02-02', 'Megfelelt', 240000),
(21, 'WVWZZZ1JZXW000001', '2021-02-15', 'Megfelelt', 200000),
(22, 'WVWZZZ1JZXW000001', '2019-02-01', 'Megfelelt', 170000);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `piaci_ar`
--

CREATE TABLE `piaci_ar` (
  `pa_id` int(11) NOT NULL COMMENT 'Piaci ár azonositó',
  `alvazszam` char(17) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL COMMENT 'Autó alvázszáma (FK)',
  `ar` int(12) NOT NULL COMMENT 'Kocsi piaci ára forintban'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `piaci_ar`
--

INSERT INTO `piaci_ar` (`pa_id`, `alvazszam`, `ar`) VALUES
(1, 'WAUZZZ8V4GA123456', 1200000),
(3, 'WAUZZZ8KXCA000222', 1500000),
(4, 'JH4DC5380TS000111', 300000),
(5, 'VF1CLBA0H12345678', 600000),
(6, 'WVWZZZ1JZXW000001', 890000);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `tulajdonlas`
--

CREATE TABLE `tulajdonlas` (
  `tu_id` int(11) NOT NULL COMMENT 'Tulajdonlás id',
  `alvazszam` char(17) NOT NULL COMMENT 'Kocsi alvázszáma (FK)',
  `t_id` int(11) NOT NULL COMMENT 'Tulajdonos azonositó (FK)',
  `datumtol` date NOT NULL COMMENT 'Tulajdonlás kezdete',
  `datumig` date DEFAULT NULL COMMENT 'Tulajdonlás vége'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `tulajdonlas`
--

INSERT INTO `tulajdonlas` (`tu_id`, `alvazszam`, `t_id`, `datumtol`, `datumig`) VALUES
(1, 'WAUZZZ8V4GA123456', 1, '2025-07-16', '2025-07-24'),
(2, 'WAUZZZ8V4GA123456', 2, '2025-04-16', '2025-06-24'),
(3, 'JH4DC5380TS000111', 3, '2012-02-03', '2025-07-02'),
(4, 'VF1CLBA0H12345678', 4, '2021-05-29', NULL),
(5, 'WAUZZZ8KXCA000222', 5, '2024-07-08', NULL),
(6, 'VF1CLBA0H12345678', 1, '2023-02-03', NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `tulajdonos`
--

CREATE TABLE `tulajdonos` (
  `t_id` int(50) NOT NULL COMMENT 'Tulajdonos azonositó',
  `nev` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL COMMENT 'Tulajdonos neve',
  `iranyitoszam` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL COMMENT 'Tulajdonos irányitószáma',
  `telepules` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL COMMENT 'Tulajdonos települése',
  `utcahsz` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL COMMENT 'Tulajdonos utcájának neve és házszáma',
  `telefonszam` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL COMMENT 'Tulajdonos telefonszáma'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `tulajdonos`
--

INSERT INTO `tulajdonos` (`t_id`, `nev`, `iranyitoszam`, `telepules`, `utcahsz`, `telefonszam`) VALUES
(1, 'Nagy Péter', '9000', 'Győr', 'Petőfi Sándor utca 24', '0620124567'),
(2, 'Kiss Lajos', '9000', 'Győr', 'Kiss János utca 56', '+367012345'),
(3, 'Szabó József', '1014', 'Budapest', 'Arany János utca 2', '0630456789'),
(4, 'Tóth Tamás', '1014', 'Budapest', 'Szabadság utca 23', '+367089787'),
(5, 'Kovács Emese', '4000', 'Debrecen', 'Táncsics Mihály utca 45', '0630543245');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `autok`
--
ALTER TABLE `autok`
  ADD PRIMARY KEY (`alvazszam`),
  ADD UNIQUE KEY `alvázszám` (`alvazszam`,`rendszam`),
  ADD UNIQUE KEY `alvázszám_2` (`alvazszam`,`rendszam`),
  ADD UNIQUE KEY `rendszám_2` (`rendszam`);

--
-- A tábla indexei `felhasznalok`
--
ALTER TABLE `felhasznalok`
  ADD PRIMARY KEY (`felhasznalo_id`),
  ADD UNIQUE KEY `felhasznalonev` (`felhasznalonev`);

--
-- A tábla indexei `muszaki_vizsga`
--
ALTER TABLE `muszaki_vizsga`
  ADD PRIMARY KEY (`mvid`),
  ADD UNIQUE KEY `mvid` (`mvid`),
  ADD KEY `mv-autók` (`alvazszam`);

--
-- A tábla indexei `piaci_ar`
--
ALTER TABLE `piaci_ar`
  ADD PRIMARY KEY (`pa_id`),
  ADD UNIQUE KEY `alvazszam` (`alvazszam`),
  ADD UNIQUE KEY `alvazszam_2` (`alvazszam`);

--
-- A tábla indexei `tulajdonlas`
--
ALTER TABLE `tulajdonlas`
  ADD PRIMARY KEY (`tu_id`),
  ADD KEY `tulajdonlas-autok` (`alvazszam`),
  ADD KEY `tulajdonlas-tulajdonos` (`t_id`);

--
-- A tábla indexei `tulajdonos`
--
ALTER TABLE `tulajdonos`
  ADD PRIMARY KEY (`t_id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `felhasznalok`
--
ALTER TABLE `felhasznalok`
  MODIFY `felhasznalo_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Felhasználó azonosító', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT a táblához `muszaki_vizsga`
--
ALTER TABLE `muszaki_vizsga`
  MODIFY `mvid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Műszaki vizsga azonositó', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT a táblához `piaci_ar`
--
ALTER TABLE `piaci_ar`
  MODIFY `pa_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Piaci ár azonositó', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT a táblához `tulajdonlas`
--
ALTER TABLE `tulajdonlas`
  MODIFY `tu_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Tulajdonlás id', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT a táblához `tulajdonos`
--
ALTER TABLE `tulajdonos`
  MODIFY `t_id` int(50) NOT NULL AUTO_INCREMENT COMMENT 'Tulajdonos azonositó', AUTO_INCREMENT=7;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `muszaki_vizsga`
--
ALTER TABLE `muszaki_vizsga`
  ADD CONSTRAINT `mv-autók` FOREIGN KEY (`alvazszam`) REFERENCES `autok` (`alvazszam`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `piaci_ar`
--
ALTER TABLE `piaci_ar`
  ADD CONSTRAINT `pa-autók` FOREIGN KEY (`alvazszam`) REFERENCES `autok` (`alvazszam`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `tulajdonlas`
--
ALTER TABLE `tulajdonlas`
  ADD CONSTRAINT `tulajdonlas-autok` FOREIGN KEY (`alvazszam`) REFERENCES `autok` (`alvazszam`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tulajdonlas-tulajdonos` FOREIGN KEY (`t_id`) REFERENCES `tulajdonos` (`t_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
