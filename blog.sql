-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 13 Haz 2022, 21:23:35
-- Sunucu sürümü: 10.4.24-MariaDB
-- PHP Sürümü: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `blog`
--

DELIMITER $$
--
-- Yordamlar
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `addCategory` (IN `Name` VARCHAR(255), IN `Description` TEXT, IN `Id` INT(11))   BEGIN
    INSERT INTO categories (categoryName, categoryDesc, categoryAuthor) VALUES (Name,Description,Id);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `addPost` (IN `Title` VARCHAR(255), IN `Content` TEXT, IN `Tags` VARCHAR(255), IN `Category` VARCHAR(255), IN `Author` INT(11))   BEGIN
    INSERT INTO posts (postTitle, postContent, postTags, postCategory, postAuthor) VALUES (Title, Content, Tags, Category, Author);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteCategoryById` (IN `categoryId` INT(11))   BEGIN
	DELETE FROM categories WHERE id = categoryId;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deletePostById` (IN `postId` INT(11))   BEGIN
	DELETE FROM posts WHERE id = postId;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getCategories` ()   BEGIN
    SELECT c.id, c.categoryName, c.categoryDesc, u.name, c.created_at FROM categories c INNER JOIN users u ON c.categoryAuthor = u.id GROUP BY c.id DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getCategoryById` (IN `categoryId` INT(11))   BEGIN
	SELECT * FROM categories WHERE id = categoryId;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getPostById` (IN `postId` INT(11))   BEGIN
	SELECT p.id, u.name, p.postTitle, p.postContent, p.postTags, p.postCategory, c.categoryName, p.created_at FROM posts p INNER JOIN users u ON u.id = p.postAuthor INNER JOIN categories c ON c.id = p.postCategory WHERE p.id = postId GROUP BY p.id DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getPosts` ()   BEGIN
    SELECT p.id, u.name, p.postTitle, p.postContent, p.postTags, p.postCategory, c.categoryName, p.created_at FROM posts p INNER JOIN users u ON u.id = p.postAuthor INNER JOIN categories c ON c.id = p.postCategory GROUP BY p.id DESC LIMIT 100;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getUserById` (IN `userId` INT(11))   BEGIN
	SELECT * FROM users WHERE id = userId;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getUsers` ()   BEGIN
	SELECT * FROM users GROUP BY 'id' DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateCategoryById` (IN `Id` INT(11), IN `Name` VARCHAR(255), IN `Description` VARCHAR(255))   BEGIN
    UPDATE categories SET categoryName = Name, categoryDesc = Description WHERE id = Id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updatePostById` (IN `Id` INT(11), IN `Title` VARCHAR(255), IN `Tags` VARCHAR(255), IN `Content` TEXT, IN `Category` INT(11))   BEGIN
    UPDATE posts SET postTitle = Title, postContent = Content, postTags = Tags, postCategory = Category WHERE id = Id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `categories`
--

CREATE TABLE `categories` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY,
  `categoryName` varchar(255) NOT NULL,
  `categoryDesc` text NOT NULL,
  `categoryAuthor` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `categories`
--

INSERT INTO `categories` (`id`, `categoryName`, `categoryDesc`, `categoryAuthor`, `created_at`, `updated_at`) VALUES
(4, 'deneme1212333', 'dgfspoıhjmıosdfghdfg1', 1, '2022-06-12 22:33:40', '2022-06-12 22:33:40'),
(5, 'deneme1212333', 'dgfspoıhjmıosdfghdfg1', 1, '2022-06-12 22:43:57', '2022-06-12 22:43:57');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `bio` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `isAdmin` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `bio`, `password`, `isAdmin`, `created_at`, `updated_at`) VALUES
(1, 'Emirkan', 'relakith', 'relakith@gmail.com', 'sdfglşkfsdgjfsdgolfgsdıonjfgdsoıknjfgsdoınfgsd\r\n', '3ba7c0ceeaed61eab7e98daf4d1235a5', 1, '2022-06-12 16:44:53', '2022-06-12 16:44:53');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `posts`
--

CREATE TABLE `posts` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY,
  `postTitle` varchar(255) NOT NULL,
  `postContent` text NOT NULL,
  `postTags` varchar(255) NOT NULL,
  `postCategory` int(11) NOT NULL,
  `postAuthor` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  FOREIGN KEY (postCategory) REFERENCES categories(id),
  FOREIGN KEY (postAuthor) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `posts`
--

INSERT INTO `posts` (`id`, `postTitle`, `postContent`, `postTags`, `postCategory`, `postAuthor`, `created_at`, `updated_at`) VALUES
(2, 'deneme 1', '<p><strong>sadfgoıjandsfıojsndofınjsadofnsdaoıfnsdoıfnsdoaıufnhsuofnhusjdjfnhsauıf</strong></p>', 'etiket1', 4, 1, '2022-06-12 21:05:40', '2022-06-12 21:05:40'),
(3, 'deneme 2', 'sadfgoıjandsfıojsndofınjsadofnsdaoıfnsdoıfnsdoaıufnhsuofnhusjdjfnhs', 'etiket1', 4, 1, '2022-06-12 22:14:52', '2022-06-12 22:14:52'),
(4, 'deneme post1232', '<p>dfgfgfsdgdsfdfsg</p>', 'dsfgdsgdsgdsfgf', 4, 1, '2022-06-12 22:27:11', '2022-06-12 22:27:11');
