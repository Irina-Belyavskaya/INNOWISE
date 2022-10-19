-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Окт 19 2022 г., 11:13
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `innowise`
--

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL COMMENT 'идентификатор',
  `FIO` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'фамилия, имя и отчество',
  `Email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'почта',
  `Gender` varchar(10) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'пол',
  `Status` varchar(10) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'статус'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Таблица пользователей';

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id_user`, `FIO`, `Email`, `Gender`, `Status`) VALUES
(34, 'Irina Belyavskaya', 'ir200210b@mail.ru', 'female', 'inactive'),
(36, 'Poly Render', 'poly@mail.ru', 'female', 'inactive'),
(38, 'Kate Grand', 'marina@mail.ru', 'female', 'active'),
(39, 'Joe Kindston', 'joe@mail.ru', 'male', 'active'),
(46, 'Karina Joh', 'kar@mail.ru', 'female', 'active'),
(49, 'Marina Loval4', 'marina@mail.ru', 'female', 'inactive'),
(55, 'Lolo koli', 'a@yandex.ru', 'male', 'active'),
(60, 'Irina Belyavskaya', 'ir200210b@mail.ru', 'male', 'active'),
(62, 'Alex Grand', 'a@yandex.ru', 'male', 'active');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT COMMENT 'идентификатор', AUTO_INCREMENT=70;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
