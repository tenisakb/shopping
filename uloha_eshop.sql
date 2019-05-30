-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Stř 29. kvě 2019, 22:19
-- Verze serveru: 10.1.34-MariaDB
-- Verze PHP: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `uloha_eshop`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `cards`
--

CREATE TABLE `cards` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `card_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `cards`
--

INSERT INTO `cards` (`id`, `user_id`, `card_type_id`) VALUES
(1, 5, 1),
(2, 2, 1),
(3, 2, 1),
(4, 4, 1),
(5, 4, 2),
(6, 0, 2),
(7, 7, 2),
(8, 6, 2),
(9, 0, 2);

-- --------------------------------------------------------

--
-- Struktura tabulky `card_types`
--

CREATE TABLE `card_types` (
  `id` int(11) NOT NULL,
  `type` varchar(40) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `card_types`
--

INSERT INTO `card_types` (`id`, `type`) VALUES
(1, 'Temporary'),
(2, 'Basic');

-- --------------------------------------------------------

--
-- Struktura tabulky `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `info` varchar(80) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `items`
--

INSERT INTO `items` (`id`, `price`, `info`) VALUES
(1, 500, 'item 1'),
(2, 650, 'item2'),
(3, 300, 'info 3');

-- --------------------------------------------------------

--
-- Struktura tabulky `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `card_id`, `created_date`) VALUES
(1, 1, 1, '2019-05-29 18:48:42'),
(2, 1, 1, '2019-05-29 18:48:45'),
(3, 3, 5, '2019-05-29 18:51:41');

-- --------------------------------------------------------

--
-- Struktura tabulky `order_has_item`
--

CREATE TABLE `order_has_item` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `order_has_item`
--

INSERT INTO `order_has_item` (`id`, `order_id`, `item_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 2, 2),
(4, 3, 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(32) COLLATE utf8_czech_ci NOT NULL,
  `surname` varchar(32) COLLATE utf8_czech_ci NOT NULL,
  `address` varchar(80) COLLATE utf8_czech_ci NOT NULL,
  `email` varchar(40) COLLATE utf8_czech_ci NOT NULL,
  `phone` varchar(16) COLLATE utf8_czech_ci NOT NULL,
  `registered_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `address`, `email`, `phone`, `registered_date`) VALUES
(1, 'Marek', 'Novák', 'J.B. Ruzinska 15', 'mareknov@gmail.com', '777757575', '2019-05-29 16:52:41'),
(2, 'Petr', 'Novak', 'A.S. Kafkova 18', 'derek4654@gmail.com', '778987987', '2019-05-29 17:59:49'),
(3, 'Dominik', 'Petr', 'Petrova 45', 'asassafd@seznam.cz', '798798798', '2019-05-29 18:02:45'),
(4, 'Dominik', 'Šejna', 'Šejnova 15', 'sejny@sejny.net', '777897878', '2019-05-29 18:10:30'),
(5, 'Patrik', 'Chrudim', 'TestAddres', 'testemail@test.com', '777123456', '2019-05-29 18:11:15'),
(6, 'Tomas', 'Jakovljevic', 'TestAddresss', 'test@test.com', '777123456', '2019-05-29 18:15:17'),
(7, 'Dominik', 'Novak', 'TestAddress', 'test@test.com', '777987987', '2019-05-29 18:19:32');

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `card_type_id` (`card_type_id`);

--
-- Klíče pro tabulku `card_types`
--
ALTER TABLE `card_types`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `card_id` (`card_id`);

--
-- Klíče pro tabulku `order_has_item`
--
ALTER TABLE `order_has_item`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pro tabulku `card_types`
--
ALTER TABLE `card_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pro tabulku `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pro tabulku `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pro tabulku `order_has_item`
--
ALTER TABLE `order_has_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
