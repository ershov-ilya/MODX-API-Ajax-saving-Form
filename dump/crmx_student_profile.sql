-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Дек 11 2014 г., 13:17
-- Версия сервера: 5.5.9
-- Версия PHP: 5.3.28

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `gnewsbs_crm`
--

-- --------------------------------------------------------

--
-- Структура таблицы `crmx_student_profile`
--

CREATE TABLE IF NOT EXISTS `crmx_student_profile` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `modxuserid` int(10) unsigned DEFAULT NULL,
  `sign` char(64) NOT NULL DEFAULT '' COMMENT 'Проверочный хэш',
  `updated` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT 'Имя',
  `secondname` varchar(100) NOT NULL DEFAULT '' COMMENT 'Фамилия',
  `patronymic` varchar(100) NOT NULL DEFAULT '' COMMENT 'Отчество',
  `dob` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Дата рождения',
  `gender` int(1) NOT NULL DEFAULT '0' COMMENT 'Пол',
  `studgroup` varchar(100) NOT NULL DEFAULT '' COMMENT 'Учебная группа',
  `affiliate` varchar(100) NOT NULL DEFAULT '' COMMENT 'Филиал',
  `phone` varchar(100) NOT NULL DEFAULT '' COMMENT 'Тел. моб.',
  `email` varchar(100) NOT NULL DEFAULT '',
  `mother_fullname` varchar(100) NOT NULL DEFAULT '' COMMENT 'ФИО мамы',
  `mother_phone` varchar(100) NOT NULL DEFAULT '' COMMENT 'Тел. мамы',
  `father_fullname` varchar(100) NOT NULL DEFAULT '' COMMENT 'ФИО папы',
  `father_phone` varchar(100) NOT NULL DEFAULT '' COMMENT 'Тел. папы',
  `vkcomID` varchar(100) NOT NULL DEFAULT '' COMMENT 'ID vk.com',
  `interests` varchar(255) NOT NULL DEFAULT 'a:0:{}' COMMENT 'Интересы',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
