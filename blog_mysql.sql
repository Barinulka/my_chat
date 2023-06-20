-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Май 02 2023 г., 17:23
-- Версия сервера: 8.0.32-0ubuntu4
-- Версия PHP: 8.1.12-1ubuntu4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `blog.mysql`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `uuid` varchar(255) NOT NULL,
  `author_uuid` varchar(255) NOT NULL,
  `post_uuid` varchar(255) NOT NULL,
  `text` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`uuid`, `author_uuid`, `post_uuid`, `text`) VALUES
('98bd6437-1586-47b1-a5d6-fc9694a62776', '859f546c-685a-4dc7-9c7c-acafe70a59c7', 'aff55332-44dc-4634-ad48-738763642860', 'Voluptatum saepe est necessitatibus distinctio. Repellat est eum quod consectetur in qui aut. Iste est deleniti tenetur eligendi harum explicabo. Rerum adipisci commodi cupiditate eos in voluptatem.'),
('c3e07d8f-1767-4a15-ab25-7b9fe1347cf4', '667fbb79-55ea-4982-adec-c72e950414f0', 'aff55332-44dc-4634-ad48-738763642860', 'Suscipit quidem voluptatem error omnis. Consequatur earum voluptates perspiciatis voluptatibus ad. Facere deleniti non sit dolores quia sed occaecati. Provident tempora consequatur voluptatem et atque.');

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `uuid` varchar(255) NOT NULL,
  `author_uuid` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`uuid`, `author_uuid`, `title`, `text`) VALUES
('0705d895-5c66-4fed-bde2-42aec9472f0c', '859f546c-685a-4dc7-9c7c-acafe70a59c7', 'Molestias optio reiciendis.', 'Dolor aspernatur error sint eum qui. Error sed dolores quia nostrum ipsa debitis. Qui esse quibusdam occaecati voluptatum molestias.'),
('19b12489-d3bc-4724-a36d-343a112c5df7', 'f259b5f4-ea52-48a9-8fc2-b8b358899ae4', 'Aut omnis dolor.', 'Perferendis odio unde earum porro architecto. Qui soluta quia amet nihil. Unde sit qui illo possimus repellat distinctio. Et perspiciatis qui quae nesciunt perspiciatis recusandae.'),
('2752fb16-7d4a-42ea-8665-3fc2916f0087', '667fbb79-55ea-4982-adec-c72e950414f0', 'Dignissimos nam commodi asperiores.', 'Consequuntur corporis consequatur et non. Tempora vel aut exercitationem dolor sapiente. Libero ut suscipit iste provident consequatur saepe.'),
('58af2938-e452-4c65-a808-a66a7376deea', '8ec5c99b-aff9-49f2-908a-b33103fe4335', 'Cum eveniet nam vitae.', 'Non aut sunt amet quia odio harum. Sint saepe et vitae unde est fugiat dolor temporibus. Ullam fuga rerum doloribus omnis.'),
('893a9904-cf06-4e62-bf92-ad63a792dc65', '025fc4ff-f116-48fa-a8db-9db914677683', 'Vel dolorem molestiae optio eum.', 'In eius molestias quidem. Qui tempore neque corrupti voluptatum ea officia facilis. Eligendi et aperiam a consectetur rerum.'),
('9f3fd51d-79c7-4b9e-985e-61b7723ca68d', 'a95ba5da-7439-45dc-a3d0-e53b9269015c', 'Nobis odio aliquam.', 'Quia et cumque voluptas aspernatur. Consequuntur molestias iusto architecto. Aut in nesciunt deleniti doloribus natus optio consequatur dolores.'),
('aff55332-44dc-4634-ad48-738763642860', '64bb310b-2cd8-43e5-9fe0-a5cf74786597', 'Quae cum.', 'Esse quibusdam delectus rerum earum. Hic id corrupti et cum porro. Eum voluptas nemo consequatur. Vel laudantium a ab a explicabo voluptatem nisi.');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `uuid` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`uuid`, `login`, `first_name`, `last_name`) VALUES
('025fc4ff-f116-48fa-a8db-9db914677683', 'enim', 'Варвара', 'Костина'),
('1a6a4367-e69d-4382-8fdc-d253733f9f7f', 'saepe', 'Антонина', 'Матвеева'),
('64bb310b-2cd8-43e5-9fe0-a5cf74786597', 'doloribus', 'Валерия', 'Исакова'),
('667fbb79-55ea-4982-adec-c72e950414f0', 'eligendi', 'Мария', 'Дьячкова'),
('834a15ba-475b-413d-963b-9dacb9e37daf', 'barsik', 'Alexey', 'Barsikov'),
('859f546c-685a-4dc7-9c7c-acafe70a59c7', 'animi', 'Дина', 'Тарасова'),
('8a64840b-1153-4a31-9bd9-4c575fb56e97', 'molestiae', 'Изабелла', 'Федотова'),
('8dc77764-54ab-4795-b5cc-4a52d5402846', 'barinulka', 'Alexey', 'Barinov'),
('8ec5c99b-aff9-49f2-908a-b33103fe4335', 'modi', 'Дарья', 'Савельева'),
('a250f9f5-caa7-42e5-b305-32aa5822b588', 'test', 'Test', 'User'),
('a95ba5da-7439-45dc-a3d0-e53b9269015c', 'voluptas', 'Ярослава', 'Наумова'),
('e95bbb8b-61c1-451c-81b8-0d3b99c280eb', 'admin', 'Super', 'Admin'),
('f259b5f4-ea52-48a9-8fc2-b8b358899ae4', 'labore', 'Нелли', 'Русакова');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`uuid`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`uuid`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `login` (`login`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
