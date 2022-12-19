-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 18 Gru 2022, 22:15
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

--
-- Zrzut danych tabeli `frekwencja`
--

INSERT INTO `frekwencja` (`id_frekwencji`, `id_ucznia`, `typ_ob`, `data`, `semestr`, `nr_lekcji`, `id_przedmiot`, `id_nauczyciel`) VALUES
(1, 46, 'ob', '2022-12-19', 0, 1, 10, 124),
(2, 47, 'ob', '2022-12-19', 0, 1, 10, 124),
(3, 50, 'ob', '2022-12-19', 0, 1, 10, 124),
(4, 46, 'ob', '2022-12-19', 0, 1, 10, 124),
(5, 47, 'zw', '2022-12-19', 0, 1, 10, 124),
(6, 50, 'ob', '2022-12-19', 0, 1, 10, 124),
(7, 46, 'ob', '2022-12-19', 1, 1, 10, 124),
(8, 47, 'ob', '2022-12-19', 1, 1, 10, 124),
(9, 50, 'ob', '2022-12-19', 1, 1, 10, 124),
(10, 46, 'ob', '2022-12-19', 1, 8, 10, 124),
(11, 47, 'ob', '2022-12-19', 1, 8, 10, 124),
(12, 50, 'ob', '2022-12-19', 1, 8, 10, 124),
(13, 52, 'nb', '2022-12-19', 1, 1, 14, 124),
(14, 52, 'nb', '2022-12-19', 1, 2, 14, 124),
(15, 46, 'ob', '2022-12-19', 1, 1, 10, 124),
(16, 47, 'ob', '2022-12-19', 1, 1, 10, 124),
(17, 50, 'ob', '2022-12-19', 1, 1, 10, 124),
(18, 46, 'zw', '2022-12-20', 1, 4, 10, 124),
(19, 47, 'zw', '2022-12-20', 1, 4, 10, 124),
(20, 50, 'zw', '2022-12-20', 1, 4, 10, 124),
(21, 46, 'ob', '2022-12-20', 1, 8, 10, 124),
(22, 47, 'nb', '2022-12-20', 1, 8, 10, 124),
(23, 50, 'ob', '2022-12-20', 1, 8, 10, 124);

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
(17, 'egzamin próbny %', 'egzamin', 0, 'khaki'),
(19, 'test teoretyczny', 'test_teo', 5, 'mediumaquamarine');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klasy`
--

CREATE TABLE `klasy` (
  `id_klasy` int(11) NOT NULL,
  `nazwa_klasy` varchar(11) NOT NULL,
  `skrot_klasy` varchar(11) NOT NULL,
  `id_nauczyciela` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `klasy`
--

INSERT INTO `klasy` (`id_klasy`, `nazwa_klasy`, `skrot_klasy`, `id_nauczyciela`) VALUES
(93, '4A TECH', '4TA', 124),
(94, '4B TECH', '4TB', 125),
(96, '4C TECH', '4TC', 126),
(97, '4D TECH', '4TD', 127),
(98, '4IG T', '4TIG', 128),
(99, '4L T', '4TL', 129),
(100, '4S T', '4TS', 130),
(101, '4HŻ T', '4THŻ', 131),
(103, '2TE', '2TE', 148),
(104, '3TA', '3TA', 135),
(108, '1LD', '1LD', 142),
(109, '2TA', '2TA', 152),
(110, '1C SB', '1C', 153),
(111, '1TA', '1TA', 155);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kopia_oceny`
--

CREATE TABLE `kopia_oceny` (
  `id_oceny` int(11) NOT NULL,
  `id_przedmiotu` int(11) NOT NULL,
  `id_kategorii` int(11) NOT NULL,
  `semestr` int(1) NOT NULL,
  `ocena` float NOT NULL,
  `data` date NOT NULL,
  `id_nauczyciela` int(11) NOT NULL,
  `id_ucznia` int(11) NOT NULL,
  `komentarz` varchar(100) NOT NULL
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

--
-- Zrzut danych tabeli `nauczanie`
--

INSERT INTO `nauczanie` (`id`, `id_klasy`, `id_przedmiot`, `id_nauczyciel`) VALUES
(33, 98, 10, 124),
(36, 98, 20, 133),
(37, 98, 4, 128),
(38, 98, 12, 134),
(40, 98, 17, 135),
(41, 98, 7, 134),
(42, 98, 13, 134),
(43, 98, 7, 136),
(44, 98, 11, 137),
(45, 98, 5, 138),
(46, 98, 14, 128),
(47, 98, 9, 139),
(48, 98, 9, 140),
(49, 98, 22, 141),
(50, 98, 17, 143),
(51, 98, 23, 140),
(52, 98, 6, 142),
(57, 93, 14, 124),
(58, 108, 14, 142),
(59, 108, 14, 142),
(60, 109, 27, 153),
(61, 110, 14, 153),
(62, 110, 7, 153),
(64, 109, 14, 152),
(65, 111, 4, 155),
(66, 98, 16, 156),
(67, 96, 14, 126),
(68, 96, 4, 126);

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
(123, 'Michał', 'dyr. Grycz', 'admin', 'admin', 'admin', 901331),
(124, 'Marcin', 'Wojciechowski', 'wojciechowski_marcin', 'kuba.wiercinski2003@gmail.com', '$2y$10$c5WQejjizc4fsRhwLz1ey.NvmKUegqsKVRsyrkG5RX9z7h5mryS9O', 0),
(125, 'Edyta', 'Wierzbicka', 'wierzbicka_edyta', 'kuba.wiercinski2003@gmail.com', '$2y$10$7m7qyhUWNE4f.F5XNf/M2.BjsrTG.jrcvFcGgc761Rcg0XonbyUhm', 0),
(126, 'Małgorzata', 'Kręwicka', 'krewicka_malgorzata', 'kuba.wiercinski2003@gmail.com', '$2y$10$jfoqzx3OAXy9hEk62O.o5OcyzgxE17s9tQGbMJi41af8IV/ECWCEW', 0),
(127, 'Iwona', 'Olejnik', 'olejnik_iwona', 'kuba.wiercinski2003@gmail.com', '$2y$10$T3.2RdDsd.dfbTM8l6Ki7unb8.lrvkEEKhRMIPB9mmBeF7TCxWWGO', 0),
(128, 'Jolanta', 'Kortiak-Gulbinowicz', 'kortiak-gulbinowicz_jolanta', 'kuba.wiercinski2003@gmail.com', '$2y$10$eugYqaI6pnYwGINgnKrdL.GqV0UzBG4uy9okkkfimEFrbPVUVf/Jy', 0),
(129, 'Kinga', 'Gryczyńska-Rozdeba', 'gryczynska-rozdeba_kinga', 'kuba.wiercinski2003@gmail.com', '$2y$10$REhK1TOJU6XCbQAGncx/oebBlMy.zLeu1qAKbEX/B4nKu2.QFP.te', 0),
(130, 'Marlena', 'Szechyńska', 'szechynska_marlena', 'kuba.wiercinski2003@gmail.com', '$2y$10$3yhuoBrkWgNjJN0BdGFhq.w4.QQ/q4t/7RxBrhmHFCxa1IsbPkbnq', 0),
(131, 'Małgorzata', 'Fabiszewska', 'fabiszewska_malgorzata', 'kuba.wiercinski2003@gmail.com', '$2y$10$DFTQjQ56PcLAmfOs5hC7/OSdELZ0gxzdaBIqkwxxnNY0uCeQ.meIe', 0),
(133, 'Maciej', 'Gielnik', 'gielnik_maciej', 'kuba.wiercinski2003@gmail.com', '$2y$10$grF3dUJbEAt6RtZj.ctbLO/B3.CtOcsmzZYImRruRbM0W/twEK/BK', 0),
(134, 'Michał', 'Grycz', 'grycz_michal', 'kuba.wiercinski2003@gmail.com', '$2y$10$hV03VTyOzZtv05do2XEIoOxco4GtkPGZOkSm.VsEhjizamGHWPot.', 0),
(135, 'Ewa', 'Chmiel', 'chmiel_ewa', 'kuba.wiercinski2003@gmail.com', '$2y$10$vlrvJzgx9O6.UxkR5P6AU.Wx9D7QOcAUy5h1esLXr2rbLQRfdgzS6', 0),
(136, 'Robert', 'Raźniak', 'razniak_robert', 'kuba.wiercinski2003@gmail.com', '$2y$10$nehktqIhaXI6.yVfgs8y4.hiDj0ALiutjGdZfifAICpOgeYF7SDZm', 0),
(137, 'Paweł', 'Włochowicz', 'wlochowicz_pawel', 'kuba.wiercinski2003@gmail.com', '$2y$10$AuainS2iBNlYMBNEgpzi8.2rfLaqcOzX06g9bjRQvz0r5.sozwcDi', 0),
(138, 'Jolanta', 'Lipko', 'lipko_jolanta', 'kuba.wiercinski2003@gmail.com', '$2y$10$vTkhrn8lkg2yGR7QtRMdx.kWG5adtW5cKSY6T9.8khTMvLjfLf5Im', 0),
(139, 'Julia', 'Janiszyn', 'janiszyn_julia', 'kuba.wiercinski2003@gmail.com', '$2y$10$nJ5.O23eDgvzkEpuHRAs8.1qFI0izMhjXuhE2CBxe4ucTU.UkZcB6', 0),
(140, 'Ariel', 'Kenik', 'kenik_ariel', 'kuba.wiercinski2003@gmail.com', '$2y$10$Zz0SXNB3qJSBDFYOeAc0l.HofdXETRMTc0q8NRZ5JkwSI1yM.OPrC', 0),
(141, 'Anna', 'Siurnicka', 'siurnicka_anna', 'kuba.wiercinski2003@gmail.com', '$2y$10$QVBgegXx9dOamk333oOf3u/x3Ys1jQbvtnWuMkWGlZ7qnI1bSrbfy', 0),
(142, 'Mariusz', 'Gruszecki', 'gruszecki_mariusz', 'kuba.wiercinski2003@gmail.com', '$2y$10$KpuFfgLhOrcuLqte7c7.8eaauShWi8gKfITe1Ofk1PK7veoEtqcy2', 0),
(143, 'Ewa', 'Kielec-Philipse', 'kielec-philipse', 'kuba.wiercinski2003@gmail.com', '$2y$10$zDl7/zjC3BRH0Elct.PSfO0FUKhFqKSRkl4O6x41x1sSN.SHJCqlC', 0),
(144, 'Katarzyna', 'Marcinko', 'marcinko_katarzyna', 'marcinko_katarzyna@gmail.com', '$2y$10$dnopFP/4PVf0oXtVzJZ0A.D22vPAOWFYmFBEXVMvntA/cqzWTVZa.', 0),
(145, 'Stanisław', 'Pawłowski', 'pawlowski_stanislaw', 'pawlowski_stanislaw@sdsd.sdas', '$2y$10$qol.2Zw0NUUjBBaLkOBr/u3dDRmzh5Wiz/V6.9kkM64Yh7Gj7rYCS', 0),
(146, 'Paweł', 'Zaranek', 'zaranek_pawel', 'zaranek_pawel@fdfd.sdffsd', '$2y$10$JoMi5pzZs80Yg0MCLGCaLuENIZsJxe5tf6TxXA1NdvipfAsqvW69W', 0),
(147, 'Karolina', 'Grygowska', 'grygowska_karolina', 'grygowska_karolina@grygowska.pl', '$2y$10$tvb4M/nQcUv8.0B8NAt03OiZyjFFejyfXK7bWozp07LiT8LrZU95m', 0),
(148, 'Agnieszka', 'Hoffmann', 'hoffmann_agnieszka', 'hoffmann_agnieszka@wp.pl', '$2y$10$3EGWBcNekNG0zVUC1ROnoeTulf4LWDzmM9QHDq3RhlpA5.P7DTa5K', 0),
(150, 'Wioleta', 'Pilipczuk', 'pilipczuk_wioleta', 'pilipczuk_wioleta@wp.pl', '$2y$10$Xte4hw8LiG7.hCckV/zImuq8O5rcDczctdMV5LdasFY0p5pcxbeLa', 0),
(151, 'Marcin', 'Gałka', 'galka_marcin', 'galka_marcin@wp.pl', '$2y$10$Y7.pqJE1Kbu7tflCUfQVQesDq4x.0WqnkaaMLzTL04z0CUt5oYrYy', 0),
(152, 'Urszula', 'Maciejczuk-Tytus', 'maciejczuk-tytus_urszula', 'kuba.wiercinski2003@gmail.com', '$2y$10$uyFDxj39GuJggIeh7LlsjeiVbaNhdVNLAkh3..TtCnLTaw/IZplQK', 926053),
(153, 'Anna', 'Ihma-Kasprzyk', 'ihma-kasprzyk_anna', 'ihma-kasprzyk_anna@wp.pl', '$2y$10$zpF/5yvOzvkQTZh/l3yLjOKQ6XMnHfTCuvjujnahzy0z3COl0UmlS', 0),
(155, 'Barbara', 'Szwarc', 'szwarc_barbara', 'kuba.wiercinski2003@gmail.com', '$2y$10$AzCc4sw2mY/YAUJm1I.i3uEPLiRNjbXztS9SS0/7h9r6mdYQE4oZa', 653088),
(156, 'Artur', 'Ślązak', 'slazak_artur', 'slazak_artur@wp.pl', '$2y$10$J1F8TBLTxa0vyw6BzZy9rOAWik7H1sXD4rhLXJLuK6XpSJHEb6fm6', 0);

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

--
-- Zrzut danych tabeli `oceny`
--

INSERT INTO `oceny` (`id_oceny`, `id_przedmiotu`, `id_kategorii`, `semestr`, `ocena`, `waga`, `data`, `id_nauczyciela`, `id_ucznia`, `komentarz`) VALUES
(77, 6, 8, 1, 6, 0, '2022-12-17', 123, 50, ''),
(78, 7, 8, 1, 6, 0, '2022-12-17', 123, 50, ''),
(80, 9, 8, 1, 4, 0, '2022-12-17', 123, 50, ''),
(81, 17, 8, 1, 5, 0, '2022-12-17', 123, 50, ''),
(82, 4, 8, 1, 4, 0, '2022-12-17', 123, 50, ''),
(83, 5, 8, 1, 6, 0, '2022-12-17', 123, 50, ''),
(84, 10, 8, 1, 6, 0, '2022-12-17', 123, 50, ''),
(86, 13, 8, 1, 6, 0, '2022-12-17', 123, 50, ''),
(87, 10, 7, 2, 6, 0, '2023-01-01', 123, 50, ''),
(88, 13, 7, 2, 6, 0, '2023-01-01', 123, 50, ''),
(89, 12, 8, 1, 6, 0, '2022-12-17', 123, 50, ''),
(90, 12, 7, 2, 6, 0, '2023-01-01', 123, 50, ''),
(91, 16, 8, 1, 6, 0, '2022-12-17', 123, 50, ''),
(92, 16, 7, 2, 6, 0, '2023-01-01', 123, 50, ''),
(93, 11, 8, 1, 6, 0, '2022-12-17', 123, 50, ''),
(94, 16, 19, 1, 6, 5, '2022-12-17', 123, 50, ''),
(95, 16, 17, 1, 80, 0, '2022-12-17', 123, 50, ''),
(105, 10, 17, 1, 98, 0, '2022-12-18', 124, 50, '');

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

--
-- Zrzut danych tabeli `oceny_zachowanie`
--

INSERT INTO `oceny_zachowanie` (`id_oceny`, `id_przedmiotu`, `id_kategorii`, `semestr`, `ocena`, `data`, `id_nauczyciela`, `id_ucznia`, `komentarz`) VALUES
(24, 8, 9, 1, 0, '2022-12-11', 123, 51, ''),
(25, 8, 8, 1, 6, '2022-12-17', 123, 50, ''),
(26, 8, 10, 2, 0, '2023-01-02', 123, 50, ''),
(27, 8, 8, 1, 6, '2022-12-17', 123, 50, '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `przedmioty`
--

CREATE TABLE `przedmioty` (
  `id_przedmiotu` int(11) NOT NULL,
  `nazwa_przedmiotu` varchar(70) DEFAULT NULL,
  `skrot_przedmiotu` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `przedmioty`
--

INSERT INTO `przedmioty` (`id_przedmiotu`, `nazwa_przedmiotu`, `skrot_przedmiotu`) VALUES
(4, 'język polski', 'j.polski'),
(5, 'matematyka', 'mat'),
(6, 'historia i społeczeństwo', 'his.i.społ'),
(7, 'informatyka', 'inf'),
(8, 'zachowanie', 'zachowanie'),
(9, 'język angielski', 'j.ang'),
(10, 'projektowanie baz danych', 'proj.baz.dan'),
(11, 'wychowanie fizyczne', 'wf'),
(12, 'tworzenie stron internetowych i aplikacji internetowych', 'tw.str.i.apl.int'),
(13, 'systemy baz danych', 'sys.baz.dan'),
(14, 'godzina wychowawcza', 'godz.wych'),
(16, 'witryny i aplikacje internetowe', 'witr.i.apl.int'),
(17, 'język niemiecki', 'j.niem'),
(18, 'wiedza o społeczeństwie', 'wos'),
(19, 'doradztwo zawodowe', 'doradztwo zawodowe'),
(20, 'maszyny i urządzenia cyfrowe', 'masz.i.urz.cyfr'),
(21, 'modelowanie i drukowanie 3D', 'mod.i.dr.3D'),
(22, 'działalność gospodarcza', 'dział.gosp'),
(23, 'język angielski zawodowy', 'j.ang_zaw'),
(24, 'testowa', 'testowa'),
(25, 'testowy', 'testowy'),
(26, 'aktywny na rynku pracy', 'akt.na.ryn.prac'),
(27, 'systemy operacyjne', 'sys.oper');

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

--
-- Zrzut danych tabeli `uczniowie`
--

INSERT INTO `uczniowie` (`id_ucznia`, `imie_ucznia`, `nazwisko_ucznia`, `id_klasy`, `funkcja`) VALUES
(46, 'Mateusz', 'Fedorowicz', 98, 4),
(47, 'Mateusz', 'Gros', 98, 4),
(50, 'Jakub', 'Wierciński', 98, 4),
(52, 'Patryk', 'Strzeboński', 93, 4),
(53, 'Oskar', 'Olek', 103, 4),
(54, 'Oliwia', 'Kurłowicz', 103, 4),
(55, 'Nikola', 'Więzowska', 103, 4),
(61, 'Antoni', 'Woźniak', 104, 4),
(62, 'Oskar', 'Romańczuk', 109, 4),
(63, '1TA', '1TA', 111, 4);

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
-- Indeksy dla tabeli `kopia_oceny`
--
ALTER TABLE `kopia_oceny`
  ADD PRIMARY KEY (`id_oceny`),
  ADD KEY `ocena_nauczyciel` (`id_nauczyciela`),
  ADD KEY `ocena_uczen` (`id_ucznia`);

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
  MODIFY `id_frekwencji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT dla tabeli `kategorie_ocen`
--
ALTER TABLE `kategorie_ocen`
  MODIFY `id_kategorii` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT dla tabeli `klasy`
--
ALTER TABLE `klasy`
  MODIFY `id_klasy` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT dla tabeli `kopia_oceny`
--
ALTER TABLE `kopia_oceny`
  MODIFY `id_oceny` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `nauczanie`
--
ALTER TABLE `nauczanie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT dla tabeli `nauczyciele`
--
ALTER TABLE `nauczyciele`
  MODIFY `id_nauczyciela` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT dla tabeli `oceny`
--
ALTER TABLE `oceny`
  MODIFY `id_oceny` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT dla tabeli `oceny_zachowanie`
--
ALTER TABLE `oceny_zachowanie`
  MODIFY `id_oceny` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT dla tabeli `przedmioty`
--
ALTER TABLE `przedmioty`
  MODIFY `id_przedmiotu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT dla tabeli `uczniowie`
--
ALTER TABLE `uczniowie`
  MODIFY `id_ucznia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

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
