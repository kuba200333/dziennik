-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 19 Gru 2022, 23:18
-- Wersja serwera: 10.4.22-MariaDB
-- Wersja PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `testowa`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `admin`
--

CREATE TABLE `admin` (
  `id_nauczyciela` int(11) NOT NULL,
  `imie` varchar(20) NOT NULL,
  `nazwisko` varchar(30) NOT NULL,
  `login` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `email` text NOT NULL,
  `haslo` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `kod_odzyskania` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `admin`
--

INSERT INTO `admin` (`id_nauczyciela`, `imie`, `nazwisko`, `login`, `email`, `haslo`, `kod_odzyskania`) VALUES
(0, 'admin', 'admin', 'admin', 'kuba.wiercinski2003@gmail.com', '$2y$10$GYmVbfcCHw1Eq3WidhhRaexjb4R3hkbiT8MdQ1QBRhbW9fWmwtb6a', 274371);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `frekwencja`
--

CREATE TABLE `frekwencja` (
  `id_frekwencji` int(11) NOT NULL,
  `id_ucznia` int(11) NOT NULL,
  `typ_ob` varchar(2) NOT NULL,
  `data` date NOT NULL,
  `semestr` int(1) NOT NULL,
  `nr_lekcji` int(11) NOT NULL,
  `id_przedmiot` int(11) NOT NULL,
  `id_nauczyciel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `funkcje`
--

CREATE TABLE `funkcje` (
  `id_funkcji` int(11) NOT NULL,
  `nazwa` varchar(20) NOT NULL,
  `skrot` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `funkcje`
--

INSERT INTO `funkcje` (`id_funkcji`, `nazwa`, `skrot`) VALUES
(0, 'gospodarz', 'gospodarz'),
(1, 'zastępca', 'zastępca'),
(2, 'skarbnik', 'skarbnik'),
(4, 'uczeń', 'uczeń');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategorie_ocen`
--

CREATE TABLE `kategorie_ocen` (
  `id_kategorii` int(11) NOT NULL,
  `nazwa_kategorii` varchar(30) NOT NULL,
  `skrót_kategorii` varchar(15) NOT NULL,
  `waga` int(11) NOT NULL,
  `kolor` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `kategorie_ocen`
--

INSERT INTO `kategorie_ocen` (`id_kategorii`, `nazwa_kategorii`, `skrót_kategorii`, `waga`, `kolor`) VALUES
(1, 'zadanie', 'zad', 1, 'silver'),
(2, 'kartkówka', 'kartk', 3, 'mediumorchid'),
(3, 'sprawdzian', 'spr', 4, 'greenyellow'),
(4, 'odpowiedź ustna', 'odp_ust', 2, 'yellow'),
(5, 'proponowana śródroczna', 'prop_srodr', 0, 'lightskyblue'),
(6, 'proponowana roczna', 'prop_rocz', 0, 'lightskyblue'),
(7, 'roczna', 'roczna', 0, 'lightskyblue'),
(8, 'śródroczna', 'śródroczna', 0, 'lightskyblue'),
(9, 'uwaga', 'uwaga', 0, 'lightsalmon'),
(10, 'pochwała', 'pochwała', 0, 'darkseagreen'),
(11, 'aktywność', 'akt', 1, 'silver'),
(12, 'zadanie domowe', 'zad_dom', 1, 'darkorange '),
(13, 'praca klasowa', 'prac_klas', 5, 'red'),
(14, 'praca na lekcji', 'prac_lekc', 3, 'lightsalmon'),
(15, 'inna', 'inna', 1, 'khaki'),
(16, 'praca pisemna', 'prac_pis', 3, 'lightsalmon'),
(17, 'egzamin próbny %', 'egzamin', 0, 'khaki');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klasy`
--

CREATE TABLE `klasy` (
  `id_klasy` int(11) NOT NULL,
  `nazwa_klasy` varchar(40) NOT NULL,
  `skrot_klasy` varchar(11) NOT NULL,
  `id_nauczyciela` int(11) DEFAULT NULL,
  `wirt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `nauczanie`
--

CREATE TABLE `nauczanie` (
  `id` int(11) NOT NULL,
  `id_klasy` int(11) NOT NULL,
  `id_przedmiot` int(11) NOT NULL,
  `id_nauczyciel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `nauczyciele`
--

CREATE TABLE `nauczyciele` (
  `id_nauczyciela` int(11) NOT NULL,
  `imie` varchar(20) NOT NULL,
  `nazwisko` varchar(30) NOT NULL,
  `login` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `email` text NOT NULL,
  `haslo` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `kod_odzyskania` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `nauczyciele`
--

INSERT INTO `nauczyciele` (`id_nauczyciela`, `imie`, `nazwisko`, `login`, `email`, `haslo`, `kod_odzyskania`) VALUES
(1, 'admin', 'admin', 'admin', 'admin', 'admin', 901331);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `oceny`
--

CREATE TABLE `oceny` (
  `id_oceny` int(11) NOT NULL,
  `id_przedmiotu` int(11) NOT NULL,
  `id_kategorii` int(11) NOT NULL,
  `semestr` int(1) NOT NULL,
  `ocena` float NOT NULL,
  `waga` int(11) NOT NULL,
  `data` date NOT NULL,
  `id_nauczyciela` int(11) NOT NULL,
  `id_ucznia` int(11) NOT NULL,
  `komentarz` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `oceny_zachowanie`
--

CREATE TABLE `oceny_zachowanie` (
  `id_oceny` int(11) NOT NULL,
  `id_przedmiotu` int(11) NOT NULL,
  `id_kategorii` int(11) NOT NULL,
  `semestr` int(1) NOT NULL,
  `ocena` int(1) NOT NULL,
  `data` date NOT NULL,
  `id_nauczyciela` int(11) NOT NULL,
  `id_ucznia` int(11) NOT NULL,
  `komentarz` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `przedmioty`
--

CREATE TABLE `przedmioty` (
  `id_przedmiotu` int(11) NOT NULL,
  `nazwa_przedmiotu` varchar(70) DEFAULT NULL,
  `skrot_przedmiotu` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `semestry`
--

CREATE TABLE `semestry` (
  `id` int(11) NOT NULL,
  `od` date NOT NULL,
  `do` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `semestry`
--

INSERT INTO `semestry` (`id`, `od`, `do`) VALUES
(1, '2022-09-01', '2022-12-31'),
(2, '2023-01-01', '2023-06-30');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uczniowie`
--

CREATE TABLE `uczniowie` (
  `id_ucznia` int(11) NOT NULL,
  `imie_ucznia` varchar(20) DEFAULT NULL,
  `nazwisko_ucznia` varchar(30) DEFAULT NULL,
  `id_klasy` int(11) DEFAULT NULL,
  `funkcja` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wirtualne_klasy`
--

CREATE TABLE `wirtualne_klasy` (
  `id` int(11) NOT NULL,
  `id_klasy` int(11) NOT NULL,
  `id_ucznia` int(11) NOT NULL,
  `imie_ucznia` varchar(20) NOT NULL,
  `nazwisko_ucznia` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_nauczyciela`);

--
-- Indeksy dla tabeli `frekwencja`
--
ALTER TABLE `frekwencja`
  ADD PRIMARY KEY (`id_frekwencji`),
  ADD KEY `uczen_obecnosc` (`id_ucznia`),
  ADD KEY `przedmiot_obecnosc` (`id_przedmiot`),
  ADD KEY `nauczyciel_obecnosc` (`id_nauczyciel`);

--
-- Indeksy dla tabeli `funkcje`
--
ALTER TABLE `funkcje`
  ADD PRIMARY KEY (`id_funkcji`);

--
-- Indeksy dla tabeli `kategorie_ocen`
--
ALTER TABLE `kategorie_ocen`
  ADD PRIMARY KEY (`id_kategorii`),
  ADD UNIQUE KEY `kategorie_ocen` (`nazwa_kategorii`),
  ADD UNIQUE KEY `skrót_kategorii` (`skrót_kategorii`);

--
-- Indeksy dla tabeli `klasy`
--
ALTER TABLE `klasy`
  ADD PRIMARY KEY (`id_klasy`),
  ADD KEY `naucz` (`id_nauczyciela`);

--
-- Indeksy dla tabeli `nauczanie`
--
ALTER TABLE `nauczanie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `klasy_nauczanie` (`id_klasy`);

--
-- Indeksy dla tabeli `nauczyciele`
--
ALTER TABLE `nauczyciele`
  ADD PRIMARY KEY (`id_nauczyciela`),
  ADD UNIQUE KEY `login` (`login`) USING HASH;

--
-- Indeksy dla tabeli `oceny`
--
ALTER TABLE `oceny`
  ADD PRIMARY KEY (`id_oceny`),
  ADD KEY `ocena_nauczyciel` (`id_nauczyciela`),
  ADD KEY `ocena_uczen` (`id_ucznia`);

--
-- Indeksy dla tabeli `oceny_zachowanie`
--
ALTER TABLE `oceny_zachowanie`
  ADD PRIMARY KEY (`id_oceny`);

--
-- Indeksy dla tabeli `przedmioty`
--
ALTER TABLE `przedmioty`
  ADD PRIMARY KEY (`id_przedmiotu`);

--
-- Indeksy dla tabeli `semestry`
--
ALTER TABLE `semestry`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `uczniowie`
--
ALTER TABLE `uczniowie`
  ADD PRIMARY KEY (`id_ucznia`),
  ADD KEY `klasy` (`id_klasy`);

--
-- Indeksy dla tabeli `wirtualne_klasy`
--
ALTER TABLE `wirtualne_klasy`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `admin`
--
ALTER TABLE `admin`
  MODIFY `id_nauczyciela` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `frekwencja`
--
ALTER TABLE `frekwencja`
  MODIFY `id_frekwencji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT dla tabeli `kategorie_ocen`
--
ALTER TABLE `kategorie_ocen`
  MODIFY `id_kategorii` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT dla tabeli `klasy`
--
ALTER TABLE `klasy`
  MODIFY `id_klasy` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT dla tabeli `nauczanie`
--
ALTER TABLE `nauczanie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT dla tabeli `nauczyciele`
--
ALTER TABLE `nauczyciele`
  MODIFY `id_nauczyciela` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT dla tabeli `oceny`
--
ALTER TABLE `oceny`
  MODIFY `id_oceny` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- AUTO_INCREMENT dla tabeli `oceny_zachowanie`
--
ALTER TABLE `oceny_zachowanie`
  MODIFY `id_oceny` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT dla tabeli `przedmioty`
--
ALTER TABLE `przedmioty`
  MODIFY `id_przedmiotu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT dla tabeli `uczniowie`
--
ALTER TABLE `uczniowie`
  MODIFY `id_ucznia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT dla tabeli `wirtualne_klasy`
--
ALTER TABLE `wirtualne_klasy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `frekwencja`
--
ALTER TABLE `frekwencja`
  ADD CONSTRAINT `nauczyciel_obecnosc` FOREIGN KEY (`id_nauczyciel`) REFERENCES `nauczyciele` (`id_nauczyciela`),
  ADD CONSTRAINT `przedmiot_obecnosc` FOREIGN KEY (`id_przedmiot`) REFERENCES `przedmioty` (`id_przedmiotu`),
  ADD CONSTRAINT `uczen_obecnosc` FOREIGN KEY (`id_ucznia`) REFERENCES `uczniowie` (`id_ucznia`);

--
-- Ograniczenia dla tabeli `klasy`
--
ALTER TABLE `klasy`
  ADD CONSTRAINT `naucz` FOREIGN KEY (`id_nauczyciela`) REFERENCES `nauczyciele` (`id_nauczyciela`);

--
-- Ograniczenia dla tabeli `nauczanie`
--
ALTER TABLE `nauczanie`
  ADD CONSTRAINT `klasy_nauczanie` FOREIGN KEY (`id_klasy`) REFERENCES `klasy` (`id_klasy`);

--
-- Ograniczenia dla tabeli `oceny`
--
ALTER TABLE `oceny`
  ADD CONSTRAINT `ocena_nauczyciel` FOREIGN KEY (`id_nauczyciela`) REFERENCES `nauczyciele` (`id_nauczyciela`),
  ADD CONSTRAINT `ocena_uczen` FOREIGN KEY (`id_ucznia`) REFERENCES `uczniowie` (`id_ucznia`);

--
-- Ograniczenia dla tabeli `uczniowie`
--
ALTER TABLE `uczniowie`
  ADD CONSTRAINT `klasy` FOREIGN KEY (`id_klasy`) REFERENCES `klasy` (`id_klasy`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
