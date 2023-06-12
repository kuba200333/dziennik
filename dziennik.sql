-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 12 Cze 2023, 10:28
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
-- Baza danych: `dziennik`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `changelog`
--

CREATE TABLE `changelog` (
  `id` int(11) NOT NULL,
  `id_dane` int(11) NOT NULL,
  `typ` text COLLATE utf8_polish_ci NOT NULL,
  `data` date NOT NULL,
  `zmiana` text COLLATE utf8_polish_ci NOT NULL,
  `zmieniajacy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `frekwencja`
--

CREATE TABLE `frekwencja` (
  `id_frekwencji` int(11) NOT NULL,
  `id_ucznia` int(11) NOT NULL,
  `typ_ob` varchar(2) COLLATE utf8_polish_ci NOT NULL,
  `data` date NOT NULL,
  `semestr` int(1) NOT NULL,
  `nr_lekcji` int(11) NOT NULL,
  `id_przedmiot` int(11) NOT NULL,
  `id_nauczyciel` int(11) NOT NULL,
  `temat` text COLLATE utf8_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `funkcje`
--

CREATE TABLE `funkcje` (
  `id_funkcji` int(11) NOT NULL,
  `nazwa` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `skrot` varchar(20) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

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
-- Struktura tabeli dla tabeli `kategorie_frekwencji`
--

CREATE TABLE `kategorie_frekwencji` (
  `id` int(11) NOT NULL,
  `nazwa_frekwencji` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `skrot_frekwencji` varchar(2) COLLATE utf8_polish_ci NOT NULL,
  `kolor` varchar(20) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `kategorie_frekwencji`
--

INSERT INTO `kategorie_frekwencji` (`id`, `nazwa_frekwencji`, `skrot_frekwencji`, `kolor`) VALUES
(1, 'obecność', 'ob', 'lightskyblue'),
(2, 'nieobecność', 'nb', 'khaki'),
(3, 'nieobecność usprawiedliwiona', 'u', 'greenyellow'),
(4, 'zwolnienie', 'zw', 'darkgray'),
(5, 'spóźnienie', 'sp', 'darkorange');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategorie_ocen`
--

CREATE TABLE `kategorie_ocen` (
  `id_kategorii` int(11) NOT NULL,
  `nazwa_kategorii` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `skrót_kategorii` varchar(15) COLLATE utf8_polish_ci NOT NULL,
  `waga` int(11) NOT NULL,
  `kolor` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

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
(11, 'aktywność', 'akt', 1, 'mediumslateblue'),
(12, 'zadanie domowe', 'zad_dom', 1, 'darkorange '),
(13, 'praca klasowa', 'prac_klas', 5, 'red'),
(14, 'praca na lekcji', 'prac_lekc', 3, 'lightsalmon'),
(15, 'inna', 'inna', 1, 'khaki'),
(16, 'praca pisemna', 'prac_pis', 3, 'lightsalmon'),
(17, 'egzamin próbny %', 'egzamin', 0, 'khaki'),
(19, 'test teoretyczny', 'test_teo', 3, 'mediumaquamarine'),
(20, 'test praktyczny', 'test praktyczny', 5, 'darkseagreen'),
(21, 'konkurs/zawody', 'konk_zaw', 5, 'deeppink'),
(22, 'prezentacja', 'prez', 3, 'lightpink');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klasy`
--

CREATE TABLE `klasy` (
  `id_klasy` int(11) NOT NULL,
  `nazwa_klasy` varchar(60) COLLATE utf8_polish_ci NOT NULL,
  `skrot_klasy` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `id_nauczyciela` int(11) DEFAULT NULL,
  `wirt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `nauczanie`
--

CREATE TABLE `nauczanie` (
  `id` int(11) NOT NULL,
  `id_klasy` int(11) NOT NULL,
  `id_przedmiot` int(11) NOT NULL,
  `id_nauczyciel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `nauczyciele`
--

CREATE TABLE `nauczyciele` (
  `id_nauczyciela` int(11) NOT NULL,
  `imie` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `nazwisko` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `login` text COLLATE utf8_polish_ci NOT NULL,
  `email` text COLLATE utf8_polish_ci NOT NULL,
  `haslo` text COLLATE utf8_polish_ci NOT NULL,
  `kod_odzyskania` int(6) DEFAULT NULL,
  `admin` int(1) NOT NULL,
  `dezakt` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `nauczyciele`
--

INSERT INTO `nauczyciele` (`id_nauczyciela`, `imie`, `nazwisko`, `login`, `email`, `haslo`, `kod_odzyskania`, `admin`, `dezakt`) VALUES
(177, 'administrator', 'administrator', 'administrator_administrator', 'administrator@administrator.pl', '$2y$10$mhWJRWBYb58hpJA7jdIlqe8biv01kjpQ0NOCrB9SQ3Fd57ISBW6/S', NULL, 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `oceny`
--

CREATE TABLE `oceny` (
  `id_oceny` int(11) NOT NULL,
  `id_przedmiotu` int(11) NOT NULL,
  `id_kategorii` int(11) NOT NULL,
  `semestr` int(1) NOT NULL,
  `ocena` float DEFAULT NULL,
  `waga` int(11) NOT NULL,
  `nie_licz` int(1) NOT NULL,
  `data` date NOT NULL,
  `id_nauczyciela` int(11) NOT NULL,
  `id_ucznia` int(11) NOT NULL,
  `komentarz` varchar(100) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

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
  `komentarz` varchar(100) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `oceny_zachowanie2`
--

CREATE TABLE `oceny_zachowanie2` (
  `id_oceny` int(11) NOT NULL,
  `id_przedmiotu` int(11) NOT NULL,
  `id_kategorii` int(11) NOT NULL,
  `semestr` int(1) NOT NULL,
  `ocena` int(1) NOT NULL,
  `data` date NOT NULL,
  `id_nauczyciela` int(11) NOT NULL,
  `id_ucznia` int(11) NOT NULL,
  `komentarz` varchar(100) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `plan_lekcji`
--

CREATE TABLE `plan_lekcji` (
  `id_lekcji` int(11) NOT NULL,
  `nr_lekcji` int(11) NOT NULL,
  `dzien` int(11) NOT NULL,
  `od` date NOT NULL DEFAULT current_timestamp(),
  `do` date NOT NULL,
  `id_klasy` int(11) NOT NULL,
  `id_nauczyciela` int(11) NOT NULL,
  `id_przedmiotu` int(11) NOT NULL,
  `sala` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `przedmioty`
--

CREATE TABLE `przedmioty` (
  `id_przedmiotu` int(11) NOT NULL,
  `nazwa_przedmiotu` varchar(70) COLLATE utf8_polish_ci DEFAULT NULL,
  `skrot_przedmiotu` varchar(20) COLLATE utf8_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `przedmioty`
--

INSERT INTO `przedmioty` (`id_przedmiotu`, `nazwa_przedmiotu`, `skrot_przedmiotu`) VALUES
(8, 'zachowanie', 'zachowanie');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `przyp_wirt`
--

CREATE TABLE `przyp_wirt` (
  `id` int(11) NOT NULL,
  `id_macierz` int(11) NOT NULL,
  `id_wirt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `realizacja_programu`
--

CREATE TABLE `realizacja_programu` (
  `id` int(11) NOT NULL,
  `data` date NOT NULL,
  `id_klasy` int(11) NOT NULL,
  `id_przedmiot` int(11) NOT NULL,
  `id_nauczyciel` int(11) NOT NULL,
  `lekcja` int(11) NOT NULL,
  `temat` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `semestry`
--

CREATE TABLE `semestry` (
  `id` int(11) NOT NULL,
  `od` date NOT NULL,
  `do` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `semestry`
--

INSERT INTO `semestry` (`id`, `od`, `do`) VALUES
(1, '2022-09-01', '2022-12-31'),
(2, '2023-01-01', '2023-06-30');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `typ_zastepstw`
--

CREATE TABLE `typ_zastepstw` (
  `id` int(11) NOT NULL,
  `nazwa` text COLLATE utf8_polish_ci NOT NULL,
  `skrot` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `typ_zastepstw`
--

INSERT INTO `typ_zastepstw` (`id`, `nazwa`, `skrot`) VALUES
(1, 'zastępstwo płatne', 'zastępstwo'),
(2, 'łączenie grup', 'połącz'),
(3, 'moduł wycieczek', 'wycieczka'),
(4, 'lekcja biblioteczna', 'biblioteka'),
(5, 'opieka', 'opieka'),
(6, 'doradztwo zawodowe', 'dor_zaw'),
(7, 'przesunięcie lekcji', 'przesunięcie'),
(8, 'zajęcia odwołane', 'odwołane');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uczniowie`
--

CREATE TABLE `uczniowie` (
  `id_ucznia` int(11) NOT NULL,
  `nr_dziennik` int(3) NOT NULL,
  `imie_ucznia` varchar(20) COLLATE utf8_polish_ci DEFAULT NULL,
  `nazwisko_ucznia` varchar(30) COLLATE utf8_polish_ci DEFAULT NULL,
  `id_klasy` int(11) DEFAULT NULL,
  `funkcja` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wirtualne_klasy`
--

CREATE TABLE `wirtualne_klasy` (
  `id` int(11) NOT NULL,
  `id_klasy` int(11) NOT NULL,
  `id_ucznia` int(11) NOT NULL,
  `imie_ucznia` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `nazwisko_ucznia` varchar(30) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zachowanie_ucznia`
--

CREATE TABLE `zachowanie_ucznia` (
  `id_oceny` int(11) NOT NULL,
  `id_przedmiotu` int(11) NOT NULL,
  `id_kategorii` int(11) NOT NULL,
  `semestr` int(1) NOT NULL,
  `ocena` int(1) NOT NULL,
  `data` date NOT NULL,
  `id_nauczyciela` int(11) NOT NULL,
  `id_ucznia` int(11) NOT NULL,
  `komentarz` varchar(100) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zastepstwa`
--

CREATE TABLE `zastepstwa` (
  `id` int(11) NOT NULL,
  `id_naucz_nb` int(11) NOT NULL,
  `id_nauczyciel` int(11) DEFAULT NULL,
  `id_przedmiot` int(11) DEFAULT NULL,
  `id_klasy` int(11) DEFAULT NULL,
  `data` date NOT NULL,
  `nr_lekcji` int(11) NOT NULL,
  `typ` int(11) NOT NULL,
  `sala` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `changelog`
--
ALTER TABLE `changelog`
  ADD PRIMARY KEY (`id`);

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
-- Indeksy dla tabeli `kategorie_frekwencji`
--
ALTER TABLE `kategorie_frekwencji`
  ADD PRIMARY KEY (`id`);

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
-- Indeksy dla tabeli `oceny_zachowanie2`
--
ALTER TABLE `oceny_zachowanie2`
  ADD PRIMARY KEY (`id_oceny`);

--
-- Indeksy dla tabeli `plan_lekcji`
--
ALTER TABLE `plan_lekcji`
  ADD PRIMARY KEY (`id_lekcji`),
  ADD KEY `id_klasy` (`id_klasy`),
  ADD KEY `id_nauczyciela` (`id_nauczyciela`),
  ADD KEY `id_przedmiotu` (`id_przedmiotu`);

--
-- Indeksy dla tabeli `przedmioty`
--
ALTER TABLE `przedmioty`
  ADD PRIMARY KEY (`id_przedmiotu`),
  ADD UNIQUE KEY `nazwa_przedmiotu` (`nazwa_przedmiotu`);

--
-- Indeksy dla tabeli `przyp_wirt`
--
ALTER TABLE `przyp_wirt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_macierz` (`id_macierz`),
  ADD KEY `id_wirt` (`id_wirt`);

--
-- Indeksy dla tabeli `realizacja_programu`
--
ALTER TABLE `realizacja_programu`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `semestry`
--
ALTER TABLE `semestry`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `typ_zastepstw`
--
ALTER TABLE `typ_zastepstw`
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
-- Indeksy dla tabeli `zachowanie_ucznia`
--
ALTER TABLE `zachowanie_ucznia`
  ADD PRIMARY KEY (`id_oceny`);

--
-- Indeksy dla tabeli `zastepstwa`
--
ALTER TABLE `zastepstwa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_klasy` (`id_klasy`),
  ADD KEY `id_nauczyciel` (`id_nauczyciel`),
  ADD KEY `id_naucz_nb` (`id_naucz_nb`),
  ADD KEY `id_przedmiot` (`id_przedmiot`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `changelog`
--
ALTER TABLE `changelog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `frekwencja`
--
ALTER TABLE `frekwencja`
  MODIFY `id_frekwencji` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `kategorie_frekwencji`
--
ALTER TABLE `kategorie_frekwencji`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `kategorie_ocen`
--
ALTER TABLE `kategorie_ocen`
  MODIFY `id_kategorii` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT dla tabeli `klasy`
--
ALTER TABLE `klasy`
  MODIFY `id_klasy` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `nauczanie`
--
ALTER TABLE `nauczanie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `nauczyciele`
--
ALTER TABLE `nauczyciele`
  MODIFY `id_nauczyciela` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT dla tabeli `oceny`
--
ALTER TABLE `oceny`
  MODIFY `id_oceny` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `oceny_zachowanie`
--
ALTER TABLE `oceny_zachowanie`
  MODIFY `id_oceny` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `oceny_zachowanie2`
--
ALTER TABLE `oceny_zachowanie2`
  MODIFY `id_oceny` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `plan_lekcji`
--
ALTER TABLE `plan_lekcji`
  MODIFY `id_lekcji` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `przedmioty`
--
ALTER TABLE `przedmioty`
  MODIFY `id_przedmiotu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT dla tabeli `przyp_wirt`
--
ALTER TABLE `przyp_wirt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `realizacja_programu`
--
ALTER TABLE `realizacja_programu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `typ_zastepstw`
--
ALTER TABLE `typ_zastepstw`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `uczniowie`
--
ALTER TABLE `uczniowie`
  MODIFY `id_ucznia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `wirtualne_klasy`
--
ALTER TABLE `wirtualne_klasy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `zachowanie_ucznia`
--
ALTER TABLE `zachowanie_ucznia`
  MODIFY `id_oceny` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `zastepstwa`
--
ALTER TABLE `zastepstwa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
-- Ograniczenia dla tabeli `plan_lekcji`
--
ALTER TABLE `plan_lekcji`
  ADD CONSTRAINT `plan_lekcji_ibfk_1` FOREIGN KEY (`id_klasy`) REFERENCES `klasy` (`id_klasy`),
  ADD CONSTRAINT `plan_lekcji_ibfk_2` FOREIGN KEY (`id_nauczyciela`) REFERENCES `nauczyciele` (`id_nauczyciela`),
  ADD CONSTRAINT `plan_lekcji_ibfk_3` FOREIGN KEY (`id_przedmiotu`) REFERENCES `przedmioty` (`id_przedmiotu`);

--
-- Ograniczenia dla tabeli `przyp_wirt`
--
ALTER TABLE `przyp_wirt`
  ADD CONSTRAINT `przyp_wirt_ibfk_1` FOREIGN KEY (`id_macierz`) REFERENCES `klasy` (`id_klasy`),
  ADD CONSTRAINT `przyp_wirt_ibfk_2` FOREIGN KEY (`id_wirt`) REFERENCES `klasy` (`id_klasy`);

--
-- Ograniczenia dla tabeli `uczniowie`
--
ALTER TABLE `uczniowie`
  ADD CONSTRAINT `klasy` FOREIGN KEY (`id_klasy`) REFERENCES `klasy` (`id_klasy`);

--
-- Ograniczenia dla tabeli `zastepstwa`
--
ALTER TABLE `zastepstwa`
  ADD CONSTRAINT `zastepstwa_ibfk_1` FOREIGN KEY (`id_klasy`) REFERENCES `klasy` (`id_klasy`),
  ADD CONSTRAINT `zastepstwa_ibfk_2` FOREIGN KEY (`id_nauczyciel`) REFERENCES `nauczyciele` (`id_nauczyciela`),
  ADD CONSTRAINT `zastepstwa_ibfk_3` FOREIGN KEY (`id_naucz_nb`) REFERENCES `nauczyciele` (`id_nauczyciela`),
  ADD CONSTRAINT `zastepstwa_ibfk_4` FOREIGN KEY (`id_przedmiot`) REFERENCES `przedmioty` (`id_przedmiotu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
