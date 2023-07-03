-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Июл 03 2023 г., 03:51
-- Версия сервера: 10.4.27-MariaDB
-- Версия PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `soundhub`
--

-- --------------------------------------------------------

--
-- Структура таблицы `album`
--

CREATE TABLE `album` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `id_artist` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `img` varchar(500) DEFAULT NULL,
  `url` varchar(50) DEFAULT NULL,
  `release_date` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `album`
--

INSERT INTO `album` (`id`, `name`, `id_artist`, `id_user`, `img`, `url`, `release_date`) VALUES
(1, 'MUDBLOOD', 10, 11, '../album/1.jpeg', '', 2018),
(2, 'ANTIWRLD\r\n', 10, 11, '../album/2.jpeg', '', 2017),
(3, 'Лимб', 3, 11, '../album/3.jpeg', '', 2017),
(4, 'Кривой эфир', 3, 11, '../album/4.jpeg', '', 2016),
(5, 'Art angels', 6, 11, '../album/5.jpeg', '', 2019),
(6, 'PHANTOM', 8, 11, '../album/6.jpeg', '', 2023),
(7, 'Bandana', 11, 11, '../album/7.jpeg', '', 2022),
(8, 'BORN TO TRAP', 11, 11, '../album/8.jpeg', '', 2020),
(9, 'Karmageddon\r\n', 11, 11, '../album/9.jpeg', '', 2016),
(10, 'Bad vibes forever\r\n‍\r\n', 9, 11, '../album/10.jpeg', '', 2016);

-- --------------------------------------------------------

--
-- Структура таблицы `artist`
--

CREATE TABLE `artist` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `id_genre` int(11) DEFAULT NULL,
  `img` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `artist`
--

INSERT INTO `artist` (`id`, `name`, `id_genre`, `img`) VALUES
(1, 'Три Дня Дождя', 1, '../artist/1.jpeg'),
(2, 'KxllSwxtch', 2, '../artist/2.jpeg'),
(3, 'ATL', 4, '../artist/3.jpeg'),
(4, 'Lil God Dan', 5, '../artist/4.jpeg'),
(5, 'Ooes', 2, '../artist/5.jpeg'),
(6, 'Grimes', 10, '../artist/6.jpeg'),
(7, 'Sqwore', 5, '../artist/7.jpeg'),
(8, 'H8.HOOD', 6, '../artist/8.jpeg'),
(9, 'XXXTentacion', 8, '../artist/9.jpeg'),
(10, 'СМН', 6, '../artist/10.jpeg'),
(11, 'Kizaru', 5, '../artist/11.jpeg');

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `artist_album_view`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `artist_album_view` (
`album_name` varchar(100)
,`artist_name` varchar(100)
);

-- --------------------------------------------------------

--
-- Структура таблицы `genre`
--

CREATE TABLE `genre` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `genre`
--

INSERT INTO `genre` (`id`, `name`) VALUES
(1, 'Рок'),
(2, 'Альтернатива'),
(3, 'Панк'),
(4, 'Рэп'),
(5, 'Хип-хоп'),
(6, 'Соул'),
(7, 'Кантри'),
(8, 'Джаз'),
(9, 'Свинг'),
(10, 'Электронная музыка'),
(11, 'Фонк');

-- --------------------------------------------------------

--
-- Структура таблицы `playlist`
--

CREATE TABLE `playlist` (
  `id` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `img` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `playlist`
--

INSERT INTO `playlist` (`id`, `id_user`, `name`, `img`) VALUES
(1, 11, 'Плейлист01', '../playlist/1.jpeg\r\n'),
(82, 11, 'фывфывфв', '../playlist/64a20ed2092ee.jpeg'),
(83, 11, 'asdasdasdasd', '../playlist/64a20f4e9fe5a.jpeg'),
(86, 11, 'Плейлист02', '../playlist/64a210d76a0e2.jpeg'),
(87, 11, 'Плейлист02', '../playlist/64a210e053b34.jpeg');

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `playlist_track_view`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `playlist_track_view` (
`track_name` varchar(50)
,`playlist_name` varchar(100)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `playlist_view`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `playlist_view` (
`name` varchar(100)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `popular_tracks_view`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `popular_tracks_view` (
`track_name` varchar(50)
,`plays_number` bigint(21)
);

-- --------------------------------------------------------

--
-- Структура таблицы `track`
--

CREATE TABLE `track` (
  `id` int(11) NOT NULL,
  `id_artist` int(11) DEFAULT NULL,
  `id_album` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_playlist` int(11) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `duration` varchar(5) NOT NULL,
  `plays_number` varchar(10000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `track`
--

INSERT INTO `track` (`id`, `id_artist`, `id_album`, `id_user`, `id_playlist`, `name`, `duration`, `plays_number`) VALUES
(1, 10, 1, 11, 1, 'Дом ленинградского техно', '02:29', '1238'),
(2, 3, 3, 11, 82, 'Священный рэйв', '02:45', '1516'),
(3, 3, 3, 11, 1, 'Шаман', '01:59', '125'),
(4, 3, 3, 11, 1, 'В унисон', '02:17', '1051'),
(5, 3, 3, 11, 1, 'Архитектор', '02:28', '6492'),
(6, 11, 8, 11, 1, 'Block Baby', '03:28', '67105'),
(7, 11, 8, 11, NULL, 'Изи арифметика', '02:30', '3968'),
(10, 9, 10, NULL, NULL, 'Ex Bitch', '02:01', '195710'),
(11, 9, 10, NULL, NULL, 'Ugly', '01:41', '589495');

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `tracks_by_year_view`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `tracks_by_year_view` (
`name` varchar(50)
,`release_date` year(4)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `track_artist_view`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `track_artist_view` (
`name` varchar(50)
,`duration` varchar(5)
,`plays_number` varchar(10000)
);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `password` varchar(500) DEFAULT NULL,
  `photo` varchar(500) DEFAULT NULL,
  `admin` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `photo`, `admin`) VALUES
(9, 'user', 'qwe', '21334', '202cb962ac59075b964b07152d234b70', '', NULL),
(11, 'ohae', '123', '3213213', '202cb962ac59075b964b07152d234b70', '../avatar/64a20440e6775.jpeg', '1'),
(12, 'help', '123', '2133213123', '202cb962ac59075b964b07152d234b70', '0', NULL),
(13, 'help02', '123456', '999922', 'e10adc3949ba59abbe56e057f20f883e', '0', NULL),
(14, 'Lololoshka', 'Lololoshka', '768676768', 'b60b38a28d86db920f57842bf6d8cd05', '', NULL),
(15, 'help', '123', '+1 (231) 31', '202cb962ac59075b964b07152d234b70', '', NULL),
(17, 'qwe', 'user@email.ru', '+1 (231) 31', '76d80224611fc919a5d54f0ff9fba446', '', NULL);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `users_view`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `users_view` (
`name` varchar(100)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `user_library_view`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `user_library_view` (
`track_name` varchar(50)
,`user_name` varchar(100)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `user_playlist_view`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `user_playlist_view` (
`playlist_name` varchar(100)
,`user_name` varchar(100)
);

-- --------------------------------------------------------

--
-- Структура для представления `artist_album_view`
--
DROP TABLE IF EXISTS `artist_album_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `artist_album_view`  AS SELECT `album`.`name` AS `album_name`, `artist`.`name` AS `artist_name` FROM (`album` join `artist` on(`album`.`id_artist` = `artist`.`id`)) WHERE `artist`.`name` = 'ATL''ATL'  ;

-- --------------------------------------------------------

--
-- Структура для представления `playlist_track_view`
--
DROP TABLE IF EXISTS `playlist_track_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `playlist_track_view`  AS SELECT `track`.`name` AS `track_name`, `playlist`.`name` AS `playlist_name` FROM (`track` join `playlist` on(`track`.`id_playlist` = `playlist`.`id`)) WHERE `playlist`.`name` = 'Плейлист01''Плейлист01'  ;

-- --------------------------------------------------------

--
-- Структура для представления `playlist_view`
--
DROP TABLE IF EXISTS `playlist_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `playlist_view`  AS SELECT `playlist`.`name` AS `name` FROM `playlist``playlist`  ;

-- --------------------------------------------------------

--
-- Структура для представления `popular_tracks_view`
--
DROP TABLE IF EXISTS `popular_tracks_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `popular_tracks_view`  AS SELECT `track`.`name` AS `track_name`, cast(`track`.`plays_number` as signed) AS `plays_number` FROM `track` ORDER BY cast(`track`.`plays_number` as signed) AS `DESCdesc` ASC  ;

-- --------------------------------------------------------

--
-- Структура для представления `tracks_by_year_view`
--
DROP TABLE IF EXISTS `tracks_by_year_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `tracks_by_year_view`  AS SELECT `track`.`name` AS `name`, `album`.`release_date` AS `release_date` FROM (`track` join `album` on(`track`.`id_album` = `album`.`id`)) WHERE extract(year from `album`.`release_date`) = '2017''2017'  ;

-- --------------------------------------------------------

--
-- Структура для представления `track_artist_view`
--
DROP TABLE IF EXISTS `track_artist_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `track_artist_view`  AS SELECT `track`.`name` AS `name`, `track`.`duration` AS `duration`, `track`.`plays_number` AS `plays_number` FROM (`track` join `artist` on(`track`.`id_artist` = `artist`.`id`)) WHERE `artist`.`name` = 'ATL''ATL'  ;

-- --------------------------------------------------------

--
-- Структура для представления `users_view`
--
DROP TABLE IF EXISTS `users_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `users_view`  AS SELECT `users`.`name` AS `name` FROM `users``users`  ;

-- --------------------------------------------------------

--
-- Структура для представления `user_library_view`
--
DROP TABLE IF EXISTS `user_library_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_library_view`  AS SELECT `track`.`name` AS `track_name`, `users`.`name` AS `user_name` FROM (`track` join `users` on(`track`.`id_user` = `users`.`id`)) WHERE `users`.`id` = '11''11'  ;

-- --------------------------------------------------------

--
-- Структура для представления `user_playlist_view`
--
DROP TABLE IF EXISTS `user_playlist_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_playlist_view`  AS SELECT `playlist`.`name` AS `playlist_name`, `users`.`name` AS `user_name` FROM (`playlist` join `users` on(`playlist`.`id_user` = `users`.`id`)) WHERE `users`.`name` = 'ohae''ohae'  ;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_artist` (`id_artist`),
  ADD KEY `id_user` (`id_user`);

--
-- Индексы таблицы `artist`
--
ALTER TABLE `artist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_genre` (`id_genre`);

--
-- Индексы таблицы `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `playlist`
--
ALTER TABLE `playlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Индексы таблицы `track`
--
ALTER TABLE `track`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_album` (`id_album`),
  ADD KEY `id_artist` (`id_artist`),
  ADD KEY `id_playlist` (`id_playlist`),
  ADD KEY `id_user` (`id_user`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `album`
--
ALTER TABLE `album`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `artist`
--
ALTER TABLE `artist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `genre`
--
ALTER TABLE `genre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `playlist`
--
ALTER TABLE `playlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT для таблицы `track`
--
ALTER TABLE `track`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `album`
--
ALTER TABLE `album`
  ADD CONSTRAINT `album_ibfk_1` FOREIGN KEY (`id_artist`) REFERENCES `artist` (`id`),
  ADD CONSTRAINT `album_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `artist`
--
ALTER TABLE `artist`
  ADD CONSTRAINT `artist_ibfk_1` FOREIGN KEY (`id_genre`) REFERENCES `genre` (`id`);

--
-- Ограничения внешнего ключа таблицы `playlist`
--
ALTER TABLE `playlist`
  ADD CONSTRAINT `playlist_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `track`
--
ALTER TABLE `track`
  ADD CONSTRAINT `track_ibfk_1` FOREIGN KEY (`id_album`) REFERENCES `album` (`id`),
  ADD CONSTRAINT `track_ibfk_2` FOREIGN KEY (`id_artist`) REFERENCES `artist` (`id`),
  ADD CONSTRAINT `track_ibfk_4` FOREIGN KEY (`id_playlist`) REFERENCES `playlist` (`id`),
  ADD CONSTRAINT `track_ibfk_5` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
