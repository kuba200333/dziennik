-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 22 Gru 2022, 01:09
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
  `kod_odzyskania` int(6) NOT NULL,
  `admin` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `admin`
--

INSERT INTO `admin` (`id_nauczyciela`, `imie`, `nazwisko`, `login`, `email`, `haslo`, `kod_odzyskania`, `admin`) VALUES
(0, 'admin', 'admin', 'admin', 'kuba.wiercinski2003@gmail.com', '$2y$10$GYmVbfcCHw1Eq3WidhhRaexjb4R3hkbiT8MdQ1QBRhbW9fWmwtb6a', 274371, 0);

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
(23, 50, 'ob', '2022-12-20', 1, 8, 10, 124),
(24, 52, 'ob', '2022-12-19', 1, 1, 5, 157),
(25, 52, 'ob', '2022-12-19', 1, 3, 5, 138),
(26, 46, 'sp', '2022-12-19', 1, 5, 10, 124),
(27, 47, 'zw', '2022-12-19', 1, 5, 10, 124),
(28, 50, 'ob', '2022-12-19', 1, 5, 10, 124),
(29, 46, 'ob', '2022-12-20', 1, 4, 10, 124),
(30, 47, 'nb', '2022-12-20', 1, 4, 10, 124),
(31, 65, 'ob', '2022-12-20', 1, 4, 10, 124),
(32, 66, 'nb', '2022-12-20', 1, 4, 10, 124),
(33, 64, 'ob', '2022-12-20', 1, 4, 10, 124),
(34, 72, 'ob', '2022-12-20', 1, 4, 10, 124),
(35, 69, 'ob', '2022-12-20', 1, 4, 10, 124),
(36, 74, 'nb', '2022-12-20', 1, 4, 10, 124),
(37, 70, 'ob', '2022-12-20', 1, 4, 10, 124),
(38, 71, 'nb', '2022-12-20', 1, 4, 10, 124),
(39, 68, 'ob', '2022-12-20', 1, 4, 10, 124),
(40, 73, 'ob', '2022-12-20', 1, 4, 10, 124),
(41, 67, 'nb', '2022-12-20', 1, 4, 10, 124),
(42, 50, 'ob', '2022-12-20', 1, 4, 10, 124),
(43, 46, 'nb', '2022-12-20', 1, 3, 10, 124),
(44, 47, 'nb', '2022-12-20', 1, 3, 10, 124),
(45, 65, 'nb', '2022-12-20', 1, 3, 10, 124),
(46, 66, 'nb', '2022-12-20', 1, 3, 10, 124),
(47, 64, 'nb', '2022-12-20', 1, 3, 10, 124),
(48, 72, 'nb', '2022-12-20', 1, 3, 10, 124),
(49, 69, 'nb', '2022-12-20', 1, 3, 10, 124),
(50, 74, 'nb', '2022-12-20', 1, 3, 10, 124),
(51, 70, 'nb', '2022-12-20', 1, 3, 10, 124),
(52, 71, 'nb', '2022-12-20', 1, 3, 10, 124),
(53, 68, 'nb', '2022-12-20', 1, 3, 10, 124),
(54, 73, 'nb', '2022-12-20', 1, 3, 10, 124),
(55, 67, 'nb', '2022-12-20', 1, 3, 10, 124),
(56, 50, 'nb', '2022-12-20', 1, 3, 10, 124),
(57, 46, 'ob', '2022-12-19', 1, 1, 10, 124),
(58, 47, 'ob', '2022-12-19', 1, 1, 10, 124),
(59, 65, 'ob', '2022-12-19', 1, 1, 10, 124),
(60, 66, 'ob', '2022-12-19', 1, 1, 10, 124),
(61, 64, 'ob', '2022-12-19', 1, 1, 10, 124),
(62, 72, 'ob', '2022-12-19', 1, 1, 10, 124),
(63, 69, 'ob', '2022-12-19', 1, 1, 10, 124),
(64, 74, 'ob', '2022-12-19', 1, 1, 10, 124),
(65, 70, 'nb', '2022-12-19', 1, 1, 10, 124),
(66, 71, 'ob', '2022-12-19', 1, 1, 10, 124),
(67, 68, 'ob', '2022-12-19', 1, 1, 10, 124),
(68, 73, 'ob', '2022-12-19', 1, 1, 10, 124),
(69, 67, 'ob', '2022-12-19', 1, 1, 10, 124),
(70, 50, 'ob', '2022-12-19', 1, 1, 10, 124),
(71, 46, 'ob', '2022-12-19', 1, 1, 10, 124),
(72, 47, 'ob', '2022-12-19', 1, 1, 10, 124),
(73, 65, 'ob', '2022-12-19', 1, 1, 10, 124),
(74, 66, 'ob', '2022-12-19', 1, 1, 10, 124),
(75, 64, 'ob', '2022-12-19', 1, 1, 10, 124),
(76, 72, 'ob', '2022-12-19', 1, 1, 10, 124),
(77, 69, 'ob', '2022-12-19', 1, 1, 10, 124),
(78, 74, 'ob', '2022-12-19', 1, 1, 10, 124),
(79, 70, 'ob', '2022-12-19', 1, 1, 10, 124),
(80, 71, 'ob', '2022-12-19', 1, 1, 10, 124),
(81, 68, 'ob', '2022-12-19', 1, 1, 10, 124),
(82, 73, 'ob', '2022-12-19', 1, 1, 10, 124),
(83, 67, 'ob', '2022-12-19', 1, 1, 10, 124),
(84, 50, 'ob', '2022-12-19', 1, 1, 10, 124),
(85, 46, 'ob', '2022-12-20', 1, 1, 10, 124),
(86, 47, 'ob', '2022-12-20', 1, 1, 10, 124),
(87, 65, 'ob', '2022-12-20', 1, 1, 10, 124),
(88, 66, 'ob', '2022-12-20', 1, 1, 10, 124),
(89, 64, 'ob', '2022-12-20', 1, 1, 10, 124),
(90, 72, 'ob', '2022-12-20', 1, 1, 10, 124),
(91, 69, 'ob', '2022-12-20', 1, 1, 10, 124),
(92, 74, 'ob', '2022-12-20', 1, 1, 10, 124),
(93, 70, 'ob', '2022-12-20', 1, 1, 10, 124),
(94, 71, 'ob', '2022-12-20', 1, 1, 10, 124),
(95, 68, 'ob', '2022-12-20', 1, 1, 10, 124),
(96, 73, 'ob', '2022-12-20', 1, 1, 10, 124),
(97, 67, 'ob', '2022-12-20', 1, 1, 10, 124),
(98, 50, 'ob', '2022-12-20', 1, 1, 10, 124),
(99, 46, 'ob', '2022-12-20', 1, 1, 10, 124),
(100, 47, 'ob', '2022-12-20', 1, 1, 10, 124),
(101, 65, 'ob', '2022-12-20', 1, 1, 10, 124),
(102, 66, 'ob', '2022-12-20', 1, 1, 10, 124),
(103, 64, 'ob', '2022-12-20', 1, 1, 10, 124),
(104, 72, 'ob', '2022-12-20', 1, 1, 10, 124),
(105, 69, 'ob', '2022-12-20', 1, 1, 10, 124),
(106, 74, 'ob', '2022-12-20', 1, 1, 10, 124),
(107, 70, 'ob', '2022-12-20', 1, 1, 10, 124),
(108, 71, 'ob', '2022-12-20', 1, 1, 10, 124),
(109, 68, 'ob', '2022-12-20', 1, 1, 10, 124),
(110, 73, 'ob', '2022-12-20', 1, 1, 10, 124),
(111, 67, 'ob', '2022-12-20', 1, 1, 10, 124),
(112, 50, 'ob', '2022-12-20', 1, 1, 10, 124),
(113, 46, 'nb', '2022-12-19', 1, 2, 10, 124),
(114, 47, 'ob', '2022-12-19', 1, 2, 10, 124),
(115, 65, 'ob', '2022-12-19', 1, 2, 10, 124),
(116, 66, 'nb', '2022-12-19', 1, 2, 10, 124),
(117, 64, 'nb', '2022-12-19', 1, 2, 10, 124),
(118, 72, 'ob', '2022-12-19', 1, 2, 10, 124),
(119, 69, 'ob', '2022-12-19', 1, 2, 10, 124),
(120, 74, 'nb', '2022-12-19', 1, 2, 10, 124),
(121, 70, 'ob', '2022-12-19', 1, 2, 10, 124),
(122, 71, 'ob', '2022-12-19', 1, 2, 10, 124),
(123, 68, 'ob', '2022-12-19', 1, 2, 10, 124),
(124, 73, 'nb', '2022-12-19', 1, 2, 10, 124),
(125, 67, 'nb', '2022-12-19', 1, 2, 10, 124),
(126, 50, 'ob', '2022-12-19', 1, 2, 10, 124),
(127, 46, 'nb', '2022-12-19', 1, 3, 4, 128),
(128, 47, 'ob', '2022-12-19', 1, 3, 4, 128),
(129, 65, 'ob', '2022-12-19', 1, 3, 4, 128),
(130, 66, 'nb', '2022-12-19', 1, 3, 4, 128),
(131, 64, 'nb', '2022-12-19', 1, 3, 4, 128),
(132, 72, 'ob', '2022-12-19', 1, 3, 4, 128),
(133, 69, 'ob', '2022-12-19', 1, 3, 4, 128),
(134, 74, 'nb', '2022-12-19', 1, 3, 4, 128),
(135, 70, 'ob', '2022-12-19', 1, 3, 4, 128),
(136, 71, 'ob', '2022-12-19', 1, 3, 4, 128),
(137, 68, 'ob', '2022-12-19', 1, 3, 4, 128),
(138, 73, 'nb', '2022-12-19', 1, 3, 4, 128),
(139, 67, 'ob', '2022-12-19', 1, 3, 4, 128),
(140, 50, 'ob', '2022-12-19', 1, 3, 4, 128),
(141, 46, 'nb', '2022-12-19', 1, 4, 10, 124),
(142, 47, 'ob', '2022-12-19', 1, 4, 10, 124),
(143, 65, 'ob', '2022-12-19', 1, 4, 10, 124),
(144, 66, 'ob', '2022-12-19', 1, 4, 10, 124),
(145, 64, 'nb', '2022-12-19', 1, 4, 10, 124),
(146, 72, 'ob', '2022-12-19', 1, 4, 10, 124),
(147, 69, 'zw', '2022-12-19', 1, 4, 10, 124),
(148, 74, 'nb', '2022-12-19', 1, 4, 10, 124),
(149, 70, 'ob', '2022-12-19', 1, 4, 10, 124),
(150, 71, 'ob', '2022-12-19', 1, 4, 10, 124),
(151, 68, 'ob', '2022-12-19', 1, 4, 10, 124),
(152, 73, 'nb', '2022-12-19', 1, 4, 10, 124),
(153, 67, 'ob', '2022-12-19', 1, 4, 10, 124),
(154, 50, 'ob', '2022-12-19', 1, 4, 10, 124),
(155, 46, 'ob', '2022-12-22', 1, 1, 7, 134),
(156, 83, 'ob', '2022-12-19', 1, 2, 5, 138),
(157, 46, 'ob', '2022-12-19', 1, 1, 5, 138),
(158, 47, 'ob', '2022-12-19', 1, 1, 5, 138),
(159, 50, 'ob', '2022-12-19', 1, 1, 5, 138),
(160, 64, 'ob', '2022-12-19', 1, 1, 5, 138),
(161, 65, 'ob', '2022-12-19', 1, 1, 5, 138),
(162, 66, 'ob', '2022-12-19', 1, 1, 5, 138),
(163, 67, 'ob', '2022-12-19', 1, 1, 5, 138),
(164, 68, 'ob', '2022-12-19', 1, 1, 5, 138),
(165, 69, 'ob', '2022-12-19', 1, 1, 5, 138),
(166, 70, 'ob', '2022-12-19', 1, 1, 5, 138),
(167, 71, 'ob', '2022-12-19', 1, 1, 5, 138),
(168, 72, 'ob', '2022-12-19', 1, 1, 5, 138),
(169, 73, 'ob', '2022-12-19', 1, 1, 5, 138),
(170, 74, 'ob', '2022-12-19', 1, 1, 5, 138),
(171, 75, 'ob', '2022-12-19', 1, 1, 5, 138),
(172, 76, 'ob', '2022-12-19', 1, 1, 5, 138),
(173, 77, 'ob', '2022-12-19', 1, 1, 5, 138),
(174, 78, 'ob', '2022-12-19', 1, 1, 5, 138),
(175, 79, 'ob', '2022-12-19', 1, 1, 5, 138),
(176, 80, 'ob', '2022-12-19', 1, 1, 5, 138),
(177, 81, 'ob', '2022-12-19', 1, 1, 5, 138),
(178, 82, 'ob', '2022-12-19', 1, 1, 5, 138),
(179, 83, 'ob', '2022-12-19', 1, 1, 5, 138),
(180, 84, 'ob', '2022-12-19', 1, 1, 5, 138),
(181, 85, 'ob', '2022-12-19', 1, 1, 5, 138),
(182, 86, 'ob', '2022-12-19', 1, 1, 5, 138),
(183, 87, 'ob', '2022-12-19', 1, 1, 5, 138),
(184, 88, 'ob', '2022-12-19', 1, 1, 5, 138),
(185, 89, 'ob', '2022-12-19', 1, 1, 5, 138),
(186, 90, 'ob', '2022-12-19', 1, 1, 5, 138),
(187, 75, 'ob', '2022-12-19', 1, 4, 21, 156),
(188, 76, 'ob', '2022-12-19', 1, 4, 21, 156),
(189, 77, 'ob', '2022-12-19', 1, 4, 21, 156),
(190, 78, 'ob', '2022-12-19', 1, 4, 21, 156),
(191, 79, 'ob', '2022-12-19', 1, 4, 21, 156),
(192, 80, 'ob', '2022-12-19', 1, 4, 21, 156),
(193, 81, 'ob', '2022-12-19', 1, 4, 21, 156),
(194, 82, 'ob', '2022-12-19', 1, 4, 21, 156),
(195, 83, 'ob', '2022-12-19', 1, 4, 21, 156),
(196, 84, 'ob', '2022-12-19', 1, 4, 21, 156),
(197, 85, 'ob', '2022-12-19', 1, 4, 21, 156),
(198, 89, 'ob', '2022-12-19', 1, 4, 21, 156),
(199, 87, 'ob', '2022-12-19', 1, 4, 21, 156),
(200, 88, 'ob', '2022-12-19', 1, 4, 21, 156),
(201, 86, 'ob', '2022-12-19', 1, 4, 21, 156),
(202, 90, 'ob', '2022-12-19', 1, 4, 21, 156),
(203, 65, 'zw', '2022-12-19', 1, 5, 16, 156),
(204, 46, 'zw', '2022-12-19', 1, 5, 16, 156),
(205, 47, 'zw', '2022-12-19', 1, 5, 16, 156),
(206, 66, 'zw', '2022-12-19', 1, 5, 16, 156),
(207, 64, 'zw', '2022-12-19', 1, 5, 16, 156),
(208, 72, 'zw', '2022-12-19', 1, 5, 16, 156),
(209, 69, 'zw', '2022-12-19', 1, 5, 16, 156),
(210, 74, 'zw', '2022-12-19', 1, 5, 16, 156),
(211, 70, 'zw', '2022-12-19', 1, 5, 16, 156),
(212, 71, 'zw', '2022-12-19', 1, 5, 16, 156),
(213, 68, 'zw', '2022-12-19', 1, 5, 16, 156),
(214, 73, 'zw', '2022-12-19', 1, 5, 16, 156),
(215, 67, 'zw', '2022-12-19', 1, 5, 16, 156),
(216, 50, 'zw', '2022-12-19', 1, 5, 16, 156),
(217, 75, 'nb', '2022-12-19', 1, 1, 7, 136),
(218, 76, 'nb', '2022-12-19', 1, 1, 7, 136),
(219, 77, 'nb', '2022-12-19', 1, 1, 7, 136),
(220, 78, 'nb', '2022-12-19', 1, 1, 7, 136),
(221, 79, 'nb', '2022-12-19', 1, 1, 7, 136),
(222, 80, 'ob', '2022-12-19', 1, 1, 7, 136),
(223, 81, 'nb', '2022-12-19', 1, 1, 7, 136),
(224, 82, 'nb', '2022-12-19', 1, 1, 7, 136),
(225, 83, 'nb', '2022-12-19', 1, 1, 7, 136),
(226, 84, 'nb', '2022-12-19', 1, 1, 7, 136),
(227, 85, 'nb', '2022-12-19', 1, 1, 7, 136),
(228, 89, 'nb', '2022-12-19', 1, 1, 7, 136),
(229, 87, 'nb', '2022-12-19', 1, 1, 7, 136),
(230, 88, 'ob', '2022-12-19', 1, 1, 7, 136),
(231, 86, 'nb', '2022-12-19', 1, 1, 7, 136),
(232, 90, 'nb', '2022-12-19', 1, 1, 7, 136),
(233, 65, 'nb', '2022-12-21', 1, 6, 16, 156),
(234, 46, 'nb', '2022-12-21', 1, 6, 16, 156),
(235, 47, 'nb', '2022-12-21', 1, 6, 16, 156),
(236, 66, 'nb', '2022-12-21', 1, 6, 16, 156),
(237, 64, 'nb', '2022-12-21', 1, 6, 16, 156),
(238, 72, 'ob', '2022-12-21', 1, 6, 16, 156),
(239, 69, 'nb', '2022-12-21', 1, 6, 16, 156),
(240, 74, 'nb', '2022-12-21', 1, 6, 16, 156),
(241, 70, 'nb', '2022-12-21', 1, 6, 16, 156),
(242, 71, 'nb', '2022-12-21', 1, 6, 16, 156),
(243, 68, 'nb', '2022-12-21', 1, 6, 16, 156),
(244, 73, 'nb', '2022-12-21', 1, 6, 16, 156),
(245, 67, 'nb', '2022-12-21', 1, 6, 16, 156),
(246, 50, 'ob', '2022-12-21', 1, 6, 16, 156),
(247, 52, 'nb', '2022-12-21', 1, 5, 16, 156),
(248, 91, 'nb', '2022-12-21', 1, 5, 16, 156),
(249, 95, 'nb', '2022-12-24', 1, 1, 27, 153),
(250, 62, 'nb', '2022-12-24', 1, 1, 27, 153),
(251, 95, 'zw', '2022-12-26', 1, 2, 27, 153),
(252, 62, 'ob', '2022-12-26', 1, 2, 27, 153);

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
(19, 'test teoretyczny', 'test_teo', 3, 'mediumaquamarine'),
(20, 'test praktyczny', 'test praktyczny', 5, 'darkseagreen');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klasy`
--

CREATE TABLE `klasy` (
  `id_klasy` int(11) NOT NULL,
  `nazwa_klasy` varchar(40) NOT NULL,
  `skrot_klasy` varchar(20) NOT NULL,
  `id_nauczyciela` int(11) DEFAULT NULL,
  `wirt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `klasy`
--

INSERT INTO `klasy` (`id_klasy`, `nazwa_klasy`, `skrot_klasy`, `id_nauczyciela`, `wirt`) VALUES
(93, '4A TECH', '4TA', 124, 0),
(94, '4B TECH', '4TB', 125, 0),
(96, '4C TECH', '4TC', 126, 0),
(97, '4D TECH', '4TD', 127, 0),
(98, '4IG T', '4TIG', 128, 0),
(99, '4L T', '4TL', 129, 0),
(100, '4S T', '4TS', 130, 0),
(101, '4HŻ T', '4THŻ', 131, 0),
(103, '2TE', '2TE', 148, 0),
(104, '3TA', '3TA', 135, 0),
(108, '1LD', '1LD', 142, 0),
(109, '2TA', '2TA', 152, 0),
(110, '1C SB', '1C', 153, 0),
(111, '1TA', '1TA', 155, 0),
(113, '4TIG Technik Informatyk', '4TIG_inf', NULL, 1),
(114, '4TIG Technik Grafiki', '4TIG_graf', NULL, 1),
(118, 'zind_WP_4TIG', 'zind_WP_4TIG', NULL, 1),
(120, '4TA_4TB Religia TAK', '4TA_4TB_rel_tak', NULL, 1),
(121, '1TF', '1TF', 163, 0);

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
(74, 113, 10, 124),
(75, 113, 16, 156),
(76, 114, 21, 156),
(77, 93, 16, 156),
(78, 113, 12, 134),
(79, 98, 4, 128),
(80, 113, 17, 143),
(81, 114, 17, 135),
(82, 114, 7, 136),
(83, 113, 7, 134),
(84, 114, 20, 133),
(85, 113, 13, 134),
(86, 114, 11, 137),
(87, 98, 5, 138),
(88, 98, 14, 128),
(89, 113, 9, 139),
(90, 114, 9, 140),
(91, 98, 22, 141),
(92, 114, 23, 140),
(93, 98, 6, 142),
(94, 118, 5, 138),
(95, 120, 28, 159),
(97, 121, 4, 126),
(98, 109, 27, 153);

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
  `kod_odzyskania` int(6) DEFAULT NULL,
  `admin` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `nauczyciele`
--

INSERT INTO `nauczyciele` (`id_nauczyciela`, `imie`, `nazwisko`, `login`, `email`, `haslo`, `kod_odzyskania`, `admin`) VALUES
(123, 'admin', 'admin', 'admin', 'admin', 'admin', 901331, 1),
(124, 'Marcin', 'Wojciechowski', 'wojciechowski_marcin', 'kuba.wiercinski2003@gmail.com', '$2y$10$c5WQejjizc4fsRhwLz1ey.NvmKUegqsKVRsyrkG5RX9z7h5mryS9O', 0, 0),
(125, 'Edyta', 'Wierzbicka', 'wierzbicka_edyta', 'kuba.wiercinski2003@gmail.com', '$2y$10$7m7qyhUWNE4f.F5XNf/M2.BjsrTG.jrcvFcGgc761Rcg0XonbyUhm', 0, 0),
(126, 'Małgorzata', 'Kręwicka', 'krewicka_malgorzata', 'kuba.wiercinski2003@gmail.com', '$2y$10$jfoqzx3OAXy9hEk62O.o5OcyzgxE17s9tQGbMJi41af8IV/ECWCEW', 0, 0),
(127, 'Iwona', 'Olejnik', 'olejnik_iwona', 'kuba.wiercinski2003@gmail.com', '$2y$10$T3.2RdDsd.dfbTM8l6Ki7unb8.lrvkEEKhRMIPB9mmBeF7TCxWWGO', 0, 0),
(128, 'Jolanta', 'Kortiak-Gulbinowicz', 'kortiak-gulbinowicz_jolanta', 'kuba.wiercinski2003@gmail.com', '$2y$10$eugYqaI6pnYwGINgnKrdL.GqV0UzBG4uy9okkkfimEFrbPVUVf/Jy', 0, 0),
(129, 'Kinga', 'Gryczyńska-Rozdeba', 'gryczynska-rozdeba_kinga', 'kuba.wiercinski2003@gmail.com', '$2y$10$REhK1TOJU6XCbQAGncx/oebBlMy.zLeu1qAKbEX/B4nKu2.QFP.te', 0, 0),
(130, 'Marlena', 'Szechyńska', 'szechynska_marlena', 'kuba.wiercinski2003@gmail.com', '$2y$10$3yhuoBrkWgNjJN0BdGFhq.w4.QQ/q4t/7RxBrhmHFCxa1IsbPkbnq', 0, 0),
(131, 'Małgorzata', 'Fabiszewska', 'fabiszewska_malgorzata', 'kuba.wiercinski2003@gmail.com', '$2y$10$DFTQjQ56PcLAmfOs5hC7/OSdELZ0gxzdaBIqkwxxnNY0uCeQ.meIe', 0, 0),
(133, 'Maciej', 'Gielnik', 'gielnik_maciej', 'kuba.wiercinski2003@gmail.com', '$2y$10$grF3dUJbEAt6RtZj.ctbLO/B3.CtOcsmzZYImRruRbM0W/twEK/BK', 0, 0),
(134, 'Michał', 'Grycz', 'grycz_michal', 'kuba.wiercinski2003@gmail.com', '$2y$10$hV03VTyOzZtv05do2XEIoOxco4GtkPGZOkSm.VsEhjizamGHWPot.', 0, 1),
(135, 'Ewa', 'Chmiel', 'chmiel_ewa', 'kuba.wiercinski2003@gmail.com', '$2y$10$vlrvJzgx9O6.UxkR5P6AU.Wx9D7QOcAUy5h1esLXr2rbLQRfdgzS6', 0, 0),
(136, 'Robert', 'Raźniak', 'razniak_robert', 'kuba.wiercinski2003@gmail.com', '$2y$10$nehktqIhaXI6.yVfgs8y4.hiDj0ALiutjGdZfifAICpOgeYF7SDZm', 0, 0),
(137, 'Paweł', 'Włochowicz', 'wlochowicz_pawel', 'kuba.wiercinski2003@gmail.com', '$2y$10$AuainS2iBNlYMBNEgpzi8.2rfLaqcOzX06g9bjRQvz0r5.sozwcDi', 0, 0),
(138, 'Jolanta', 'Lipko', 'lipko_jolanta', 'kuba.wiercinski2003@gmail.com', '$2y$10$vTkhrn8lkg2yGR7QtRMdx.kWG5adtW5cKSY6T9.8khTMvLjfLf5Im', 0, 0),
(139, 'Julia', 'Janiszyn', 'janiszyn_julia', 'kuba.wiercinski2003@gmail.com', '$2y$10$nJ5.O23eDgvzkEpuHRAs8.1qFI0izMhjXuhE2CBxe4ucTU.UkZcB6', 0, 0),
(140, 'Ariel', 'Kenik', 'kenik_ariel', 'kuba.wiercinski2003@gmail.com', '$2y$10$Zz0SXNB3qJSBDFYOeAc0l.HofdXETRMTc0q8NRZ5JkwSI1yM.OPrC', 0, 0),
(141, 'Anna', 'Siurnicka', 'siurnicka_anna', 'kuba.wiercinski2003@gmail.com', '$2y$10$QVBgegXx9dOamk333oOf3u/x3Ys1jQbvtnWuMkWGlZ7qnI1bSrbfy', 0, 0),
(142, 'Mariusz', 'Gruszecki', 'gruszecki_mariusz', 'kuba.wiercinski2003@gmail.com', '$2y$10$KpuFfgLhOrcuLqte7c7.8eaauShWi8gKfITe1Ofk1PK7veoEtqcy2', 0, 0),
(143, 'Ewa', 'Kielec-Philipse', 'kielec-philipse', 'kuba.wiercinski2003@gmail.com', '$2y$10$zDl7/zjC3BRH0Elct.PSfO0FUKhFqKSRkl4O6x41x1sSN.SHJCqlC', 0, 0),
(144, 'Katarzyna', 'Marcinko', 'marcinko_katarzyna', 'marcinko_katarzyna@gmail.com', '$2y$10$dnopFP/4PVf0oXtVzJZ0A.D22vPAOWFYmFBEXVMvntA/cqzWTVZa.', 0, 0),
(145, 'Stanisław', 'Pawłowski', 'pawlowski_stanislaw', 'pawlowski_stanislaw@sdsd.sdas', '$2y$10$qol.2Zw0NUUjBBaLkOBr/u3dDRmzh5Wiz/V6.9kkM64Yh7Gj7rYCS', 0, 0),
(146, 'Paweł', 'Zaranek', 'zaranek_pawel', 'zaranek_pawel@fdfd.sdffsd', '$2y$10$JoMi5pzZs80Yg0MCLGCaLuENIZsJxe5tf6TxXA1NdvipfAsqvW69W', 0, 0),
(147, 'Karolina', 'Grygowska', 'grygowska_karolina', 'grygowska_karolina@grygowska.pl', '$2y$10$tvb4M/nQcUv8.0B8NAt03OiZyjFFejyfXK7bWozp07LiT8LrZU95m', 0, 0),
(148, 'Agnieszka', 'Hoffmann', 'hoffmann_agnieszka', 'hoffmann_agnieszka@wp.pl', '$2y$10$3EGWBcNekNG0zVUC1ROnoeTulf4LWDzmM9QHDq3RhlpA5.P7DTa5K', 0, 0),
(150, 'Wioleta', 'Pilipczuk', 'pilipczuk_wioleta', 'pilipczuk_wioleta@wp.pl', '$2y$10$Xte4hw8LiG7.hCckV/zImuq8O5rcDczctdMV5LdasFY0p5pcxbeLa', 0, 0),
(151, 'Marcin', 'Gałka', 'galka_marcin', 'galka_marcin@wp.pl', '$2y$10$Y7.pqJE1Kbu7tflCUfQVQesDq4x.0WqnkaaMLzTL04z0CUt5oYrYy', 0, 0),
(152, 'Urszula', 'Maciejczuk-Tytus', 'maciejczuk-tytus_urszula', 'kuba.wiercinski2003@gmail.com', '$2y$10$uyFDxj39GuJggIeh7LlsjeiVbaNhdVNLAkh3..TtCnLTaw/IZplQK', 926053, 0),
(153, 'Anna', 'Ihma-Kasprzyk', 'ihma-kasprzyk_anna', 'ihma-kasprzyk_anna@wp.pl', '$2y$10$zpF/5yvOzvkQTZh/l3yLjOKQ6XMnHfTCuvjujnahzy0z3COl0UmlS', 0, 0),
(155, 'Barbara', 'Szwarc', 'szwarc_barbara', 'kuba.wiercinski2003@gmail.com', '$2y$10$AzCc4sw2mY/YAUJm1I.i3uEPLiRNjbXztS9SS0/7h9r6mdYQE4oZa', 653088, 0),
(156, 'Artur', 'Ślązak', 'slazak_artur', 'slazak_artur@wp.pl', '$2y$10$J1F8TBLTxa0vyw6BzZy9rOAWik7H1sXD4rhLXJLuK6XpSJHEb6fm6', 0, 0),
(157, 'Barbara', 'Micał', 'mical_barbara', 'mical_barbara@wp.pl', '$2y$10$YAlKSRvWXFUgNv2ohm4skuiPuz/.1Hlx5IHOd3n7xNzW315ecajei', 0, 0),
(158, 'Marcin', 'Olesiński', 'olesinski_marcin', 'olesinski_marcin@wp.pl', '$2y$10$8KoigU4iLETsdowMBOKqmub8sowNfeMu03cXFZAy6biOHjSX/wY.i', 0, 0),
(159, 'Marek', 'Miecznik', 'miecznik_marek', 'miecznik_marek@kuria.pl', '$2y$10$M5vl6l8/L7JltaW2NXh.Aeu2nGegr8VyT/hNcsIrOQlvX1fybYyte', 0, 0),
(162, 'Sabina', 'Olech', 'olech_sabina', 'olech_sabina@wp.pl', '$2y$10$qa2Wlu56GhkHIVrDJxfMx.7L8MN5AsQkWDa7E4N/gZApDxQ3Lvzjm', NULL, 1),
(163, 'Ewa', 'Frąckiewicz', 'frackiewicz_ewa', 'frackiewicz_ewa@wp.pl', '$2y$10$xLbjbTOoIb7csp2rD/n0buL2.BICaSg8L2fhx7jxFoetCILHeXDmO', NULL, 0);

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
  `komentarz` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `oceny`
--

INSERT INTO `oceny` (`id_oceny`, `id_przedmiotu`, `id_kategorii`, `semestr`, `ocena`, `waga`, `nie_licz`, `data`, `id_nauczyciela`, `id_ucznia`, `komentarz`) VALUES
(77, 6, 8, 1, 6, 0, 0, '2022-12-17', 123, 50, ''),
(78, 7, 8, 1, 6, 0, 0, '2022-12-17', 123, 50, ''),
(80, 9, 8, 1, 4, 0, 0, '2022-12-17', 123, 50, ''),
(81, 17, 8, 1, 5, 0, 0, '2022-12-17', 123, 50, ''),
(82, 4, 8, 1, 4, 0, 0, '2022-12-17', 123, 50, ''),
(83, 5, 8, 1, 6, 0, 0, '2022-12-17', 123, 50, ''),
(84, 10, 8, 1, 6, 0, 0, '2022-12-17', 123, 50, ''),
(86, 13, 8, 1, 6, 0, 0, '2022-12-17', 123, 50, ''),
(87, 10, 7, 2, 6, 0, 0, '2023-01-01', 123, 50, ''),
(88, 13, 7, 2, 6, 0, 0, '2023-01-01', 123, 50, ''),
(89, 12, 8, 1, 6, 0, 0, '2022-12-17', 123, 50, ''),
(90, 12, 7, 2, 6, 0, 0, '2023-01-01', 123, 50, ''),
(91, 16, 8, 1, 6, 0, 0, '2022-12-17', 123, 50, ''),
(92, 16, 7, 2, 6, 0, 0, '2023-01-01', 123, 50, ''),
(93, 11, 8, 1, 6, 0, 0, '2022-12-17', 123, 50, ''),
(94, 16, 19, 1, 6, 3, 0, '2022-12-17', 123, 50, ''),
(95, 16, 17, 1, 80, 0, 0, '2022-12-17', 123, 50, ''),
(105, 10, 17, 1, 98, 0, 0, '2022-12-18', 124, 50, ''),
(106, 5, 3, 1, 1, 4, 0, '2022-12-18', 157, 52, ''),
(110, 5, 13, 1, 6, 5, 0, '2022-12-18', 138, 52, ''),
(111, 5, 16, 1, 6, 3, 0, '2022-12-18', 138, 52, ''),
(114, 5, 20, 1, 6, 5, 0, '2022-12-18', 138, 52, ''),
(116, 5, 19, 1, 6, 3, 0, '2022-12-18', 138, 52, ''),
(118, 5, 20, 1, 6, 5, 0, '2022-12-18', 138, 52, ''),
(119, 12, 20, 1, 6, 5, 0, '2022-12-18', 146, 52, ''),
(120, 12, 1, 1, 5, 1, 0, '2022-12-18', 145, 52, ''),
(121, 10, 20, 1, 0, 5, 0, '2022-12-19', 124, 46, ''),
(122, 10, 20, 1, 0, 5, 0, '2022-12-19', 124, 47, ''),
(123, 10, 20, 1, 0, 5, 0, '2022-12-19', 124, 65, ''),
(124, 10, 20, 1, 0, 5, 0, '2022-12-19', 124, 66, ''),
(125, 10, 20, 1, 0, 5, 0, '2022-12-19', 124, 64, ''),
(127, 10, 20, 1, 0, 5, 0, '2022-12-19', 124, 69, ''),
(128, 10, 20, 1, 0, 5, 0, '2022-12-19', 124, 74, ''),
(129, 10, 20, 1, 6, 5, 0, '2022-12-19', 124, 70, ''),
(130, 10, 20, 1, 0, 5, 0, '2022-12-19', 124, 71, ''),
(131, 10, 20, 1, 0, 5, 0, '2022-12-19', 124, 68, ''),
(132, 10, 20, 1, 0, 5, 0, '2022-12-19', 124, 73, ''),
(133, 10, 20, 1, 0, 5, 0, '2022-12-19', 124, 67, ''),
(134, 10, 20, 1, 6, 5, 0, '2022-12-19', 124, 50, ''),
(135, 10, 11, 1, 5, 1, 0, '2022-12-19', 124, 70, ''),
(136, 10, 11, 1, 5, 1, 0, '2022-12-19', 124, 70, ''),
(137, 10, 11, 1, 6, 1, 0, '2022-12-19', 124, 50, ''),
(138, 10, 20, 1, 4, 5, 0, '2022-12-19', 124, 50, 'próba'),
(139, 10, 14, 1, 6, 3, 0, '2022-12-20', 124, 46, 'test'),
(140, 10, 14, 1, 6, 3, 0, '2022-12-20', 124, 70, 'test'),
(141, 10, 14, 1, 4, 3, 0, '2022-12-20', 124, 67, 'test'),
(142, 10, 14, 1, 6, 3, 0, '2022-12-20', 124, 50, 'test'),
(143, 10, 8, 1, 5, 0, 0, '2022-12-27', 124, 46, ''),
(144, 10, 8, 1, 3, 0, 0, '2022-12-27', 124, 47, ''),
(145, 10, 8, 1, 6, 0, 0, '2022-12-27', 124, 65, ''),
(146, 10, 8, 1, 6, 0, 0, '2022-12-27', 124, 66, ''),
(147, 10, 8, 1, 4, 0, 0, '2022-12-27', 124, 64, ''),
(148, 10, 8, 1, 4, 0, 0, '2022-12-27', 124, 72, ''),
(149, 10, 8, 1, 2, 0, 0, '2022-12-27', 124, 69, ''),
(150, 10, 8, 1, 3, 0, 0, '2022-12-27', 124, 74, ''),
(151, 10, 8, 1, 5, 0, 0, '2022-12-27', 124, 70, ''),
(152, 10, 8, 1, 4, 0, 0, '2022-12-27', 124, 71, ''),
(153, 10, 8, 1, 6, 0, 0, '2022-12-27', 124, 68, ''),
(154, 10, 8, 1, 5, 0, 0, '2022-12-27', 124, 73, ''),
(155, 10, 8, 1, 4, 0, 0, '2022-12-27', 124, 67, ''),
(156, 10, 17, 1, 7, 0, 0, '2022-12-20', 124, 47, ''),
(157, 10, 17, 1, 10, 0, 0, '2022-12-20', 124, 64, ''),
(158, 10, 17, 1, 7, 0, 0, '2022-12-20', 124, 47, ''),
(159, 10, 17, 1, 10, 0, 0, '2022-12-20', 124, 64, ''),
(160, 10, 17, 1, 7, 0, 0, '2022-12-20', 124, 47, ''),
(161, 10, 17, 1, 10, 0, 0, '2022-12-20', 124, 64, ''),
(162, 10, 13, 1, 5, 5, 0, '2022-12-21', 124, 46, ''),
(163, 10, 13, 1, 5, 5, 0, '2022-12-21', 124, 65, ''),
(164, 10, 13, 1, 5, 5, 0, '2022-12-21', 124, 64, ''),
(165, 10, 13, 1, 5, 5, 0, '2022-12-21', 124, 69, ''),
(166, 10, 13, 1, 5, 5, 0, '2022-12-21', 124, 70, ''),
(167, 10, 13, 1, 5, 5, 0, '2022-12-21', 124, 68, ''),
(168, 10, 13, 1, 5, 5, 0, '2022-12-21', 124, 67, ''),
(169, 10, 13, 1, 6, 5, 0, '2022-12-21', 124, 50, ''),
(170, 10, 12, 1, 1, 1, 0, '2022-12-20', 124, 69, ''),
(171, 10, 20, 1, 6, 5, 0, '2022-12-19', 124, 72, ''),
(173, 10, 7, 2, 6, 0, 0, '2023-01-01', 124, 72, ''),
(174, 4, 13, 1, 1, 5, 0, '2022-12-19', 128, 69, ''),
(175, 4, 11, 1, 0.25, 1, 0, '2022-12-19', 128, 72, ''),
(176, 4, 11, 1, 1, 1, 0, '2022-12-19', 128, 69, ''),
(177, 4, 4, 1, 1, 2, 0, '2022-12-19', 128, 65, ''),
(178, 4, 4, 1, 5, 2, 0, '2022-12-19', 128, 72, ''),
(179, 4, 4, 1, 5, 2, 0, '2022-12-19', 128, 50, ''),
(180, 10, 17, 1, 100, 0, 0, '2022-12-19', 124, 46, ''),
(181, 10, 17, 1, 40, 0, 0, '2022-12-19', 124, 71, ''),
(182, 10, 17, 1, 80, 0, 0, '2022-12-19', 124, 50, ''),
(183, 7, 11, 1, 5, 1, 0, '2022-12-19', 134, 65, ''),
(184, 5, 14, 1, 5, 3, 0, '2022-12-19', 138, 75, ''),
(185, 5, 14, 1, 6, 3, 0, '2022-12-19', 138, 84, ''),
(186, 7, 20, 1, 4, 5, 0, '2022-12-19', 136, 75, 'praca semestralna'),
(187, 7, 20, 1, 4, 5, 0, '2022-12-19', 136, 76, 'praca semestralna'),
(188, 7, 20, 1, 2, 5, 0, '2022-12-19', 136, 77, 'praca semestralna'),
(189, 7, 20, 1, 5, 5, 0, '2022-12-19', 136, 78, 'praca semestralna'),
(190, 7, 20, 1, 3, 5, 0, '2022-12-19', 136, 79, 'praca semestralna'),
(191, 7, 20, 1, 5, 5, 0, '2022-12-19', 136, 80, 'praca semestralna'),
(192, 7, 20, 1, 4.75, 5, 0, '2022-12-19', 136, 82, 'praca semestralna'),
(193, 7, 20, 1, 4.5, 5, 0, '2022-12-19', 136, 83, 'praca semestralna'),
(194, 7, 20, 1, 3.75, 5, 0, '2022-12-19', 136, 84, 'praca semestralna'),
(195, 7, 20, 1, 3.75, 5, 0, '2022-12-19', 136, 85, 'praca semestralna'),
(196, 7, 20, 1, 4, 5, 0, '2022-12-19', 136, 89, 'praca semestralna'),
(197, 7, 20, 1, 4, 5, 0, '2022-12-19', 136, 87, 'praca semestralna'),
(198, 7, 20, 1, 3.5, 5, 0, '2022-12-19', 136, 88, 'praca semestralna'),
(199, 7, 20, 1, 3.75, 5, 0, '2022-12-19', 136, 86, 'praca semestralna'),
(200, 7, 20, 1, 2, 5, 0, '2022-12-19', 136, 90, 'praca semestralna'),
(201, 13, 8, 1, 4, 0, 0, '2022-12-20', 134, 46, ''),
(202, 13, 8, 1, 2, 0, 0, '2022-12-20', 134, 47, ''),
(203, 13, 8, 1, 6, 0, 0, '2022-12-20', 134, 65, ''),
(204, 13, 8, 1, 5, 0, 0, '2022-12-20', 134, 66, ''),
(205, 13, 8, 1, 4, 0, 0, '2022-12-20', 134, 64, ''),
(206, 13, 8, 1, 3, 0, 0, '2022-12-20', 134, 72, ''),
(207, 13, 8, 1, 3, 0, 0, '2022-12-20', 134, 69, ''),
(208, 13, 8, 1, 3, 0, 0, '2022-12-20', 134, 74, ''),
(209, 13, 8, 1, 3, 0, 0, '2022-12-20', 134, 70, ''),
(210, 13, 8, 1, 3, 0, 0, '2022-12-20', 134, 71, ''),
(211, 13, 8, 1, 6, 0, 0, '2022-12-20', 134, 68, ''),
(212, 13, 8, 1, 6, 0, 0, '2022-12-20', 134, 73, ''),
(213, 13, 8, 1, 4, 0, 0, '2022-12-20', 134, 67, ''),
(214, 13, 8, 1, 6, 0, 0, '2022-12-20', 134, 50, ''),
(215, 28, 11, 1, 5, 1, 0, '2022-12-20', 162, 93, ''),
(216, 28, 11, 1, 6, 1, 0, '2022-12-20', 162, 91, ''),
(217, 28, 11, 1, 6, 1, 0, '2022-12-20', 162, 91, ''),
(218, 28, 2, 1, 6, 3, 0, '2022-12-20', 162, 91, ''),
(223, 17, 8, 1, NULL, 0, 0, '2022-12-21', 134, 75, ''),
(224, 4, 11, 1, 1, 1, 0, '2022-12-21', 126, 94, ''),
(225, 4, 8, 1, 0.01, 0, 1, '2022-12-21', 126, 94, ''),
(226, 4, 11, 1, 1.75, 1, 1, '2022-12-21', 126, 94, ''),
(227, 21, 8, 1, 3, 0, 1, '2022-12-16', 156, 75, ''),
(228, 21, 8, 1, 4, 0, 1, '2022-12-16', 156, 76, ''),
(229, 21, 8, 1, 2, 0, 1, '2022-12-16', 156, 77, ''),
(230, 21, 8, 1, 6, 0, 1, '2022-12-16', 156, 78, ''),
(231, 21, 8, 1, 3, 0, 1, '2022-12-16', 156, 79, ''),
(232, 21, 8, 1, 6, 0, 1, '2022-12-16', 156, 80, ''),
(233, 21, 8, 1, 4, 0, 1, '2022-12-16', 156, 81, ''),
(234, 21, 8, 1, 5, 0, 1, '2022-12-16', 156, 82, ''),
(235, 21, 8, 1, 5, 0, 1, '2022-12-16', 156, 83, ''),
(236, 21, 8, 1, 4, 0, 1, '2022-12-16', 156, 84, ''),
(237, 21, 8, 1, 5, 0, 1, '2022-12-16', 156, 85, ''),
(238, 21, 8, 1, 5, 0, 1, '2022-12-16', 156, 89, ''),
(239, 21, 8, 1, 5, 0, 1, '2022-12-16', 156, 87, ''),
(240, 21, 8, 1, 5, 0, 1, '2022-12-16', 156, 88, ''),
(241, 21, 8, 1, 5, 0, 1, '2022-12-16', 156, 86, ''),
(242, 21, 8, 1, 2, 0, 1, '2022-12-16', 156, 90, ''),
(243, 27, 2, 1, 1, 3, 1, '2022-12-21', 153, 95, ''),
(244, 27, 2, 1, 1, 3, 1, '2022-12-21', 153, 62, ''),
(245, 27, 13, 1, 6, 5, 0, '2022-12-21', 153, 62, '');

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
(25, 8, 8, 1, 6, '2022-12-17', 123, 50, ''),
(30, 8, 8, 1, 2, '2022-12-19', 124, 69, ''),
(31, 8, 8, 1, 2, '2022-12-21', 134, 75, '');

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
(26, 'aktywny na rynku pracy', 'akt.na.ryn.prac'),
(27, 'systemy operacyjne', 'sys.oper'),
(28, 'religia', 'rel');

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
(63, '1TA', '1TA', 111, 4),
(64, 'Mikołaj', 'Krępa', 98, 4),
(65, 'Bartłomiej', 'Guź', 98, 4),
(66, 'Cezary', 'Janowicz', 98, 4),
(67, 'Marcin', 'Prochowski', 98, 4),
(68, 'Aleksander', 'Morsi', 98, 4),
(69, 'Dominik', 'Lewandowski', 98, 4),
(70, 'Eryk', 'Mituła', 98, 4),
(71, 'Mariusz', 'Mituła', 98, 4),
(72, 'Kacper', 'Kukliński', 98, 4),
(73, 'Konrad', 'Ołdakowski', 98, 4),
(74, 'Maciej', 'Mikołajczyk', 98, 4),
(75, 'Maciej', 'Bartoszewicz', 98, 4),
(76, 'Oliwia', 'Gniazdowska', 98, 4),
(77, 'Gracjan', 'Godyniak', 98, 4),
(78, 'Kamil', 'Lechforowicz', 98, 4),
(79, 'Mateusz', 'Michel', 98, 4),
(80, 'Kacper', 'Muzyczuk', 98, 4),
(81, 'Julia', 'Obszyńska', 98, 4),
(82, 'Oliwia', 'Paprocka', 98, 4),
(83, 'Weronika', 'Pniewska', 98, 4),
(84, 'Aleksander', 'Rachuta', 98, 4),
(85, 'Roksana', 'Skwarczyńska', 98, 4),
(86, 'Karolina', 'Słomińska', 98, 4),
(87, 'Jakub', 'Staszewski', 98, 4),
(88, 'Bartosz', 'Szymański', 98, 4),
(89, 'Bartosz', 'Śledziński', 98, 4),
(90, 'Dominik', 'Urbaniak', 98, 4),
(91, 'Natalia', 'Rzymczyk', 93, 4),
(92, 'Wiktor', 'Wnukiewicz', 94, 4),
(93, 'Maciej', 'Bęben', 94, 4),
(94, 'Estera', 'Kubisiak', 121, 4),
(95, 'Filip', 'Popiel', 109, 4);

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
-- Zrzut danych tabeli `wirtualne_klasy`
--

INSERT INTO `wirtualne_klasy` (`id`, `id_klasy`, `id_ucznia`, `imie_ucznia`, `nazwisko_ucznia`) VALUES
(115, 113, 65, 'Bartłomiej', 'Guź'),
(116, 113, 46, 'Mateusz', 'Fedorowicz'),
(117, 113, 47, 'Mateusz', 'Gros'),
(118, 113, 66, 'Cezary', 'Janowicz'),
(119, 113, 64, 'Mikołaj', 'Krępa'),
(120, 113, 72, 'Kacper', 'Kukliński'),
(121, 113, 69, 'Dominik', 'Lewandowski'),
(122, 113, 74, 'Maciej', 'Mikołajczyk'),
(123, 113, 70, 'Eryk', 'Mituła'),
(124, 113, 71, 'Mariusz', 'Mituła'),
(125, 113, 68, 'Aleksander', 'Morsi'),
(126, 113, 73, 'Konrad', 'Ołdakowski'),
(127, 113, 67, 'Marcin', 'Prochowski'),
(128, 113, 50, 'Jakub', 'Wierciński'),
(129, 114, 75, 'Maciej', 'Bartoszewicz'),
(130, 114, 76, 'Oliwia', 'Gniazdowska'),
(131, 114, 77, 'Gracjan', 'Godyniak'),
(134, 114, 78, 'Kamil', 'Lechforowicz'),
(135, 114, 79, 'Mateusz', 'Michel'),
(136, 114, 80, 'Kacper', 'Muzyczuk'),
(137, 114, 81, 'Julia', 'Obszyńska'),
(138, 114, 82, 'Oliwia', 'Paprocka'),
(139, 114, 83, 'Weronika', 'Pniewska'),
(140, 114, 84, 'Aleksander', 'Rachuta'),
(141, 114, 85, 'Roksana', 'Skwarczyńska'),
(142, 118, 83, 'Weronika', 'Pniewska'),
(143, 114, 89, 'Bartosz', 'Śledziński'),
(144, 114, 87, 'Jakub', 'Staszewski'),
(145, 114, 88, 'Bartosz', 'Szymański'),
(146, 114, 86, 'Karolina', 'Słomińska'),
(147, 114, 90, 'Dominik', 'Urbaniak'),
(148, 120, 91, 'Natalia', 'Rzymczyk'),
(149, 120, 93, 'Maciej', 'Bęben');

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
  `komentarz` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `zachowanie_ucznia`
--

INSERT INTO `zachowanie_ucznia` (`id_oceny`, `id_przedmiotu`, `id_kategorii`, `semestr`, `ocena`, `data`, `id_nauczyciela`, `id_ucznia`, `komentarz`) VALUES
(1, 8, 9, 1, 0, '2022-12-20', 134, 75, '');

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
  ADD PRIMARY KEY (`id_przedmiotu`),
  ADD UNIQUE KEY `nazwa_przedmiotu` (`nazwa_przedmiotu`);

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
-- Indeksy dla tabeli `zachowanie_ucznia`
--
ALTER TABLE `zachowanie_ucznia`
  ADD PRIMARY KEY (`id_oceny`);

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
  MODIFY `id_frekwencji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=253;

--
-- AUTO_INCREMENT dla tabeli `kategorie_ocen`
--
ALTER TABLE `kategorie_ocen`
  MODIFY `id_kategorii` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT dla tabeli `klasy`
--
ALTER TABLE `klasy`
  MODIFY `id_klasy` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT dla tabeli `kopia_oceny`
--
ALTER TABLE `kopia_oceny`
  MODIFY `id_oceny` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `nauczanie`
--
ALTER TABLE `nauczanie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT dla tabeli `nauczyciele`
--
ALTER TABLE `nauczyciele`
  MODIFY `id_nauczyciela` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT dla tabeli `oceny`
--
ALTER TABLE `oceny`
  MODIFY `id_oceny` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT dla tabeli `oceny_zachowanie`
--
ALTER TABLE `oceny_zachowanie`
  MODIFY `id_oceny` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT dla tabeli `przedmioty`
--
ALTER TABLE `przedmioty`
  MODIFY `id_przedmiotu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT dla tabeli `uczniowie`
--
ALTER TABLE `uczniowie`
  MODIFY `id_ucznia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT dla tabeli `wirtualne_klasy`
--
ALTER TABLE `wirtualne_klasy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT dla tabeli `zachowanie_ucznia`
--
ALTER TABLE `zachowanie_ucznia`
  MODIFY `id_oceny` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
