-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.7.27-0ubuntu0.16.04.1 - (Ubuntu)
-- Операционная система:         Linux
-- HeidiSQL Версия:              10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры для таблица zf3_cms.application_settings
CREATE TABLE IF NOT EXISTS `application_settings` (
  `name` varchar(255) NOT NULL,
  `value` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы zf3_cms.application_settings: ~9 rows (приблизительно)
/*!40000 ALTER TABLE `application_settings` DISABLE KEYS */;
INSERT IGNORE INTO `application_settings` (`name`, `value`) VALUES
	('en.site.description', 'erfer'),
	('en.site.keywords', 'ferferf'),
	('en.site.title', 'erferf'),
	('mail.smtp.authentication', '0'),
	('mail.smtp.send', '0'),
	('mail.smtp.ssl', 'ssl'),
	('ru.site.description', 'dfvdfv'),
	('ru.site.keywords', 'dvdfv'),
	('ru.site.title', 'dfvgfv');
/*!40000 ALTER TABLE `application_settings` ENABLE KEYS */;

-- Дамп структуры для таблица zf3_cms.application_teams
CREATE TABLE IF NOT EXISTS `application_teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_en` varchar(255) NOT NULL,
  `title_ru` varchar(255) NOT NULL,
  `description_en` text NOT NULL,
  `description_ru` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы zf3_cms.application_teams: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `application_teams` DISABLE KEYS */;
INSERT IGNORE INTO `application_teams` (`id`, `title_en`, `title_ru`, `description_en`, `description_ru`) VALUES
	(1, '546456546', '546456456', 'tyhthtrh', 'tyhtyhtyh'),
	(2, '546456546', '546456456', 'tyhthtrh', 'tyhtyhtyh');
/*!40000 ALTER TABLE `application_teams` ENABLE KEYS */;

-- Дамп структуры для таблица zf3_cms.application_translates
CREATE TABLE IF NOT EXISTS `application_translates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `locale` varchar(5) NOT NULL,
  `translate` text NOT NULL,
  `translate_key_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `application_translates_application_translate_key__fk` (`translate_key_id`),
  CONSTRAINT `application_translates_application_translate_key__fk` FOREIGN KEY (`translate_key_id`) REFERENCES `application_translate_key` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы zf3_cms.application_translates: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `application_translates` DISABLE KEYS */;
INSERT IGNORE INTO `application_translates` (`id`, `locale`, `translate`, `translate_key_id`) VALUES
	(1, 'ru_RU', 'О нас', 3),
	(2, 'en_EN', 'About us', 3),
	(3, 'ru_RU', 'Что мы предлагаем', 4),
	(4, 'en_EN', 'Solutions', 4),
	(5, 'ru_RU', 'Аналитика', 5),
	(6, 'en_EN', 'Analytics', 5),
	(7, 'ru_RU', 'Обучение', 6),
	(8, 'en_EN', 'Training', 6),
	(9, 'ru_RU', 'Контакты', 7),
	(10, 'en_EN', 'Contacts', 7),
	(11, 'ru_RU', 'Социологическое исследование', 8),
	(12, 'en_EN', 'Sociological research', 8),
	(13, 'ru_RU', 'Маркетинговое исследование', 9),
	(14, 'en_EN', 'Market research', 9),
	(15, 'ru_RU', 'Мониторинг и проектная оценка', 10),
	(16, 'en_EN', 'Monitoring and Project Evaluation', 10),
	(17, 'ru_RU', 'Наша команда', 11),
	(18, 'en_EN', 'Our team', 11),
	(19, 'ru_RU', 'Миссия и Ценности', 12),
	(20, 'en_EN', 'Mission and Values', 12);
/*!40000 ALTER TABLE `application_translates` ENABLE KEYS */;

-- Дамп структуры для таблица zf3_cms.application_translate_key
CREATE TABLE IF NOT EXISTS `application_translate_key` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(20) NOT NULL,
  `translate_text` text NOT NULL,
  `js` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы zf3_cms.application_translate_key: ~1 rows (приблизительно)
/*!40000 ALTER TABLE `application_translate_key` DISABLE KEYS */;
INSERT IGNORE INTO `application_translate_key` (`id`, `module`, `translate_text`, `js`) VALUES
	(3, 'application', 'About us', 0),
	(4, 'application', 'Solutions', 0),
	(5, 'application', 'Analytics', 0),
	(6, 'application', 'Training', 0),
	(7, 'application', 'Contacts', 0),
	(8, 'application', 'Sociological research', 0),
	(9, 'application', 'Market research', 0),
	(10, 'application', 'Monitoring and Project Evaluation', 0),
	(11, 'application', 'Our team', 0),
	(12, 'application', 'Mission and Values', 0);
/*!40000 ALTER TABLE `application_translate_key` ENABLE KEYS */;

-- Дамп структуры для таблица zf3_cms.page_pages
CREATE TABLE IF NOT EXISTS `page_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_en` varchar(255) DEFAULT NULL,
  `title_ru` varchar(255) DEFAULT NULL,
  `description_en` longtext,
  `description_ru` longtext,
  `creation_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `page_pages_name_uindex` (`name`),
  KEY `page_pages_user_users__fk` (`user_id`),
  CONSTRAINT `page_pages_user_users__fk` FOREIGN KEY (`user_id`) REFERENCES `user_users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы zf3_cms.page_pages: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `page_pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `page_pages` ENABLE KEYS */;

-- Дамп структуры для таблица zf3_cms.storage_files
CREATE TABLE IF NOT EXISTS `storage_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_file_id` int(11) DEFAULT NULL,
  `type` tinytext,
  `storage_path` varchar(255) DEFAULT NULL,
  `parent_type` tinytext,
  `parent_id` int(11) DEFAULT NULL,
  `extension` tinytext,
  `name` varchar(255) DEFAULT NULL,
  `mime_major` tinytext,
  `mime_minor` tinytext,
  `size` int(10) unsigned DEFAULT NULL,
  `hash` tinytext,
  `owner_id` int(11) DEFAULT NULL,
  `owner_type` varchar(255) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `storage_files_storage_services__fk` (`service_id`),
  CONSTRAINT `storage_files_storage_services__fk` FOREIGN KEY (`service_id`) REFERENCES `storage_services` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы zf3_cms.storage_files: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `storage_files` DISABLE KEYS */;
INSERT IGNORE INTO `storage_files` (`id`, `parent_file_id`, `type`, `storage_path`, `parent_type`, `parent_id`, `extension`, `name`, `mime_major`, `mime_minor`, `size`, `hash`, `owner_id`, `owner_type`, `service_id`) VALUES
	(1, NULL, NULL, 'files/application_sliders/3/0000_6279.jpg', 'application_sliders', 3, 'jpg', 'c1.jpg', 'image', 'jpeg', 8127, 'b9fa6279463e1e45ed3cd6cfa7f64ba3', 1, 'user_users', 1),
	(2, 1, 'thumb.normal', 'files/application_sliders/3/0000_6279.jpg', 'application_sliders', 3, 'jpg', 'c1.jpg', 'image', 'jpeg', 8127, 'b9fa6279463e1e45ed3cd6cfa7f64ba3', 1, 'user_users', 1),
	(3, 1, 'thumb.icon', 'files/application_sliders/3/0000_1e5b.jpg', 'application_sliders', 3, 'jpg', 'c1.jpg', 'image', 'jpeg', 2204, '89be1e5b9def7c91f547135d8a359534', 1, 'user_users', 1),
	(4, NULL, NULL, 'files/application_sliders/4/0000_d56c.jpg', 'application_sliders', 4, 'jpg', 'c2.jpg', 'image', 'jpeg', 7815, '5507d56c7378e0e46b5986b100337ac1', 1, 'user_users', 1),
	(5, 4, 'thumb.normal', 'files/application_sliders/4/0000_d56c.jpg', 'application_sliders', 4, 'jpg', 'c2.jpg', 'image', 'jpeg', 7815, '5507d56c7378e0e46b5986b100337ac1', 1, 'user_users', 1),
	(6, 4, 'thumb.icon', 'files/application_sliders/4/0000_3c9b.jpg', 'application_sliders', 4, 'jpg', 'c2.jpg', 'image', 'jpeg', 2184, '75913c9b7c79e3778989375101623152', 1, 'user_users', 1),
	(7, NULL, NULL, 'files/application_sliders/5/0000_80ab.jpg', 'application_sliders', 5, 'jpg', 'c3.jpg', 'image', 'jpeg', 8506, 'e52d80abeb49a4c2f8dcaee2bba99a4f', 1, 'user_users', 1),
	(8, 7, 'thumb.normal', 'files/application_sliders/5/0000_80ab.jpg', 'application_sliders', 5, 'jpg', 'c3.jpg', 'image', 'jpeg', 8506, 'e52d80abeb49a4c2f8dcaee2bba99a4f', 1, 'user_users', 1),
	(9, 7, 'thumb.icon', 'files/application_sliders/5/0000_66c1.jpg', 'application_sliders', 5, 'jpg', 'c3.jpg', 'image', 'jpeg', 2238, '7f6c66c19d4d92c71dd9654b8acff78c', 1, 'user_users', 1),
	(10, NULL, NULL, 'files/application_sliders/6/0000_d10a.jpg', 'application_sliders', 6, 'jpg', 'c4.jpg', 'image', 'jpeg', 7661, '3d68d10af631838668921b7fb78a7ead', 1, 'user_users', 1),
	(11, 10, 'thumb.normal', 'files/application_sliders/6/0000_d10a.jpg', 'application_sliders', 6, 'jpg', 'c4.jpg', 'image', 'jpeg', 7661, '3d68d10af631838668921b7fb78a7ead', 1, 'user_users', 1),
	(12, 10, 'thumb.icon', 'files/application_sliders/6/0000_a809.jpg', 'application_sliders', 6, 'jpg', 'c4.jpg', 'image', 'jpeg', 2410, '30c5a809859e6556a102a2b77b31ec33', 1, 'user_users', 1),
	(13, NULL, NULL, 'files/application_sliders/7/0000_61d6.jpg', 'application_sliders', 7, 'jpg', 'c5.jpg', 'image', 'jpeg', 7870, 'bdaa61d6da3d340bd3e2832cb24f24a3', 1, 'user_users', 1),
	(14, 13, 'thumb.normal', 'files/application_sliders/7/0000_61d6.jpg', 'application_sliders', 7, 'jpg', 'c5.jpg', 'image', 'jpeg', 7870, 'bdaa61d6da3d340bd3e2832cb24f24a3', 1, 'user_users', 1),
	(15, 13, 'thumb.icon', 'files/application_sliders/7/0000_d659.jpg', 'application_sliders', 7, 'jpg', 'c5.jpg', 'image', 'jpeg', 2474, '0831d6593eb4514ecb3541003e490f08', 1, 'user_users', 1),
	(16, NULL, NULL, 'files/application_sliders/8/0000_f962.jpg', 'application_sliders', 8, 'jpg', 'c6.jpg', 'image', 'jpeg', 9275, 'c743f96282c484983f6951ef71bcaa34', 1, 'user_users', 1),
	(17, 16, 'thumb.normal', 'files/application_sliders/8/0000_f962.jpg', 'application_sliders', 8, 'jpg', 'c6.jpg', 'image', 'jpeg', 9275, 'c743f96282c484983f6951ef71bcaa34', 1, 'user_users', 1),
	(18, 16, 'thumb.icon', 'files/application_sliders/8/0000_f161.jpg', 'application_sliders', 8, 'jpg', 'c6.jpg', 'image', 'jpeg', 2387, '79cff161483948b7787c66c0ccecc9ee', 1, 'user_users', 1),
	(19, NULL, NULL, 'files/application_sliders/9/0000_1eaf.jpg', 'application_sliders', 9, 'jpg', 'c7.jpg', 'image', 'jpeg', 8034, '2f321eaf91647a683bf75970bf10965d', 1, 'user_users', 1),
	(20, 19, 'thumb.normal', 'files/application_sliders/9/0000_1eaf.jpg', 'application_sliders', 9, 'jpg', 'c7.jpg', 'image', 'jpeg', 8034, '2f321eaf91647a683bf75970bf10965d', 1, 'user_users', 1),
	(21, 19, 'thumb.icon', 'files/application_sliders/9/0000_1ee5.jpg', 'application_sliders', 9, 'jpg', 'c7.jpg', 'image', 'jpeg', 2132, 'c5ce1ee59bcbe800a355200de9d505d2', 1, 'user_users', 1),
	(22, NULL, NULL, 'files/application_sliders/10/0000_f1d2.jpg', 'application_sliders', 10, 'jpg', 'c8.jpg', 'image', 'jpeg', 6932, '34b4f1d232a62bfdb241d3bd68897c57', 1, 'user_users', 1),
	(23, 22, 'thumb.normal', 'files/application_sliders/10/0000_f1d2.jpg', 'application_sliders', 10, 'jpg', 'c8.jpg', 'image', 'jpeg', 6932, '34b4f1d232a62bfdb241d3bd68897c57', 1, 'user_users', 1),
	(24, 22, 'thumb.icon', 'files/application_sliders/10/0000_8e17.jpg', 'application_sliders', 10, 'jpg', 'c8.jpg', 'image', 'jpeg', 2164, '43d28e178f64cf1725deea766d1e7480', 1, 'user_users', 1);
/*!40000 ALTER TABLE `storage_files` ENABLE KEYS */;

-- Дамп структуры для таблица zf3_cms.storage_services
CREATE TABLE IF NOT EXISTS `storage_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) DEFAULT NULL,
  `config` text,
  `enabled` smallint(6) DEFAULT NULL,
  `default` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `storage_services_storage_types__fk` (`type_id`),
  CONSTRAINT `storage_services_storage_types__fk` FOREIGN KEY (`type_id`) REFERENCES `storage_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы zf3_cms.storage_services: ~1 rows (приблизительно)
/*!40000 ALTER TABLE `storage_services` DISABLE KEYS */;
INSERT IGNORE INTO `storage_services` (`id`, `type_id`, `config`, `enabled`, `default`) VALUES
	(1, 1, NULL, 1, 1);
/*!40000 ALTER TABLE `storage_services` ENABLE KEYS */;

-- Дамп структуры для таблица zf3_cms.storage_types
CREATE TABLE IF NOT EXISTS `storage_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL,
  `plugin` varchar(128) DEFAULT NULL,
  `form` varchar(128) DEFAULT NULL,
  `enabled` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы zf3_cms.storage_types: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `storage_types` DISABLE KEYS */;
INSERT IGNORE INTO `storage_types` (`id`, `title`, `plugin`, `form`, `enabled`) VALUES
	(1, 'Local Storage', 'Storage\\Storage\\Local', '', 1),
	(2, 'Virtual File System', 'Storage\\Storage\\Vfs', NULL, NULL);
/*!40000 ALTER TABLE `storage_types` ENABLE KEYS */;

-- Дамп структуры для таблица zf3_cms.user_allows
CREATE TABLE IF NOT EXISTS `user_allows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_allows_user_levels__fk` (`level_id`),
  KEY `user_allows_user_permissions__fk` (`permission_id`),
  CONSTRAINT `user_allows_user_levels__fk` FOREIGN KEY (`level_id`) REFERENCES `user_levels` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_allows_user_permissions__fk` FOREIGN KEY (`permission_id`) REFERENCES `user_permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы zf3_cms.user_allows: ~5 rows (приблизительно)
/*!40000 ALTER TABLE `user_allows` DISABLE KEYS */;
INSERT IGNORE INTO `user_allows` (`id`, `level_id`, `permission_id`) VALUES
	(14, 1, 1),
	(15, 1, 2),
	(16, 1, 3),
	(17, 1, 4),
	(18, 1, 5);
/*!40000 ALTER TABLE `user_allows` ENABLE KEYS */;

-- Дамп структуры для таблица zf3_cms.user_levels
CREATE TABLE IF NOT EXISTS `user_levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL,
  `description` text,
  `type` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы zf3_cms.user_levels: ~1 rows (приблизительно)
/*!40000 ALTER TABLE `user_levels` DISABLE KEYS */;
INSERT IGNORE INTO `user_levels` (`id`, `title`, `description`, `type`) VALUES
	(1, 'admin', 'admin', 'admin');
/*!40000 ALTER TABLE `user_levels` ENABLE KEYS */;

-- Дамп структуры для таблица zf3_cms.user_logins
CREATE TABLE IF NOT EXISTS `user_logins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы zf3_cms.user_logins: ~22 rows (приблизительно)
/*!40000 ALTER TABLE `user_logins` DISABLE KEYS */;
INSERT IGNORE INTO `user_logins` (`id`, `user_id`, `username`, `status`, `ip`, `creation_date`) VALUES
	(1, 1, 'admin', 1, '127.0.0.1', '2018-10-09 11:56:37'),
	(2, 1, 'admin', 1, '127.0.0.1', '2018-10-09 11:57:45'),
	(3, 1, 'admin', 1, '127.0.0.1', '2018-10-09 12:15:02'),
	(4, 1, 'admin', 1, '127.0.0.1', '2018-10-10 11:09:52'),
	(5, 1, 'admin', 1, '127.0.0.1', '2018-10-10 12:58:21'),
	(6, 1, 'admin', 1, '127.0.0.1', '2018-10-12 11:50:18'),
	(7, 1, 'admin', 1, '127.0.0.1', '2018-10-12 13:40:41'),
	(8, 1, 'admin', 1, '127.0.0.1', '2018-10-19 10:07:25'),
	(9, 1, 'admin', 1, '127.0.0.1', '2018-11-09 10:42:19'),
	(10, 1, 'admin', 1, '127.0.0.1', '2018-11-09 11:07:27'),
	(11, 1, 'admin', 1, '127.0.0.1', '2018-11-11 05:16:55'),
	(12, 1, 'admin', 1, '127.0.0.1', '2018-11-11 07:21:19'),
	(13, 1, 'admin', 1, '127.0.0.1', '2018-11-11 11:07:12'),
	(14, 1, 'admin', 1, '127.0.0.1', '2019-10-28 13:32:16'),
	(15, 1, 'admin', 1, '127.0.0.1', '2019-11-02 08:54:50'),
	(16, 1, 'admin', 1, '127.0.0.1', '2019-11-03 14:07:04'),
	(17, 1, 'admin', 1, '127.0.0.1', '2019-11-03 14:09:02'),
	(18, 1, 'admin', 1, '127.0.0.1', '2019-11-03 16:16:30'),
	(19, 1, 'admin', 1, '127.0.0.1', '2019-11-12 18:11:17'),
	(20, 1, 'admin', 1, '127.0.0.1', '2019-11-17 11:25:29'),
	(21, 1, 'admin', 1, '127.0.0.1', '2019-11-17 12:23:47'),
	(22, 1, 'admin', 1, '127.0.0.1', '2019-11-17 13:59:28');
/*!40000 ALTER TABLE `user_logins` ENABLE KEYS */;

-- Дамп структуры для таблица zf3_cms.user_permissions
CREATE TABLE IF NOT EXISTS `user_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы zf3_cms.user_permissions: ~5 rows (приблизительно)
/*!40000 ALTER TABLE `user_permissions` DISABLE KEYS */;
INSERT IGNORE INTO `user_permissions` (`id`, `name`, `description`) VALUES
	(1, 'languages.list', 'Languages List Page'),
	(2, 'settings.permissions', 'Permission Page'),
	(3, 'settings.general', 'Settings General Page'),
	(4, 'languages.create', 'Languages Add Page'),
	(5, 'settings.mail', 'Mail Settings');
/*!40000 ALTER TABLE `user_permissions` ENABLE KEYS */;

-- Дамп структуры для таблица zf3_cms.user_users
CREATE TABLE IF NOT EXISTS `user_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(60) NOT NULL,
  `level_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `locale` char(5) NOT NULL DEFAULT 'en_EN',
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_users_email_uindex` (`email`),
  UNIQUE KEY `user_users_username_uindex` (`username`),
  KEY `user_users_user_levels__fk` (`level_id`),
  CONSTRAINT `user_users_user_levels__fk` FOREIGN KEY (`level_id`) REFERENCES `user_levels` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы zf3_cms.user_users: ~1 rows (приблизительно)
/*!40000 ALTER TABLE `user_users` DISABLE KEYS */;
INSERT IGNORE INTO `user_users` (`id`, `email`, `username`, `password`, `level_id`, `status`, `locale`, `creation_date`) VALUES
	(1, 'kazakbaev-89@mail.ru', 'admin', '$2y$10$FEznmCetodvLsMrr5/raPuupsdZp2WxmXgYcm3TH2ZBrHq.DYGDQG', 1, 1, 'en_EN', '2018-10-09 11:55:21');
/*!40000 ALTER TABLE `user_users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
