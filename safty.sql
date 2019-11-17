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

-- Дамп структуры для таблица safety.application_clients
CREATE TABLE IF NOT EXISTS `application_clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_en` varchar(255) DEFAULT NULL,
  `title_ru` varchar(255) DEFAULT NULL,
  `description_en` text,
  `description_ru` text,
  `modified_date` datetime NOT NULL,
  `creation_date` datetime NOT NULL,
  `file_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `application_clients_storage_files_id_fk` (`file_id`),
  CONSTRAINT `application_clients_storage_files_id_fk` FOREIGN KEY (`file_id`) REFERENCES `storage_files` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы safety.application_clients: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `application_clients` DISABLE KEYS */;
INSERT IGNORE INTO `application_clients` (`id`, `title_en`, `title_ru`, `description_en`, `description_ru`, `modified_date`, `creation_date`, `file_id`, `status`) VALUES
	(1, NULL, 'werferf', NULL, 'werfwerfwerf', '2019-03-25 03:09:11', '2019-03-25 03:09:11', 67, 1),
	(2, NULL, 'rtgergertg', NULL, 'ertgergergerg', '2019-03-25 05:54:01', '2019-03-25 05:54:01', 70, 1);
/*!40000 ALTER TABLE `application_clients` ENABLE KEYS */;

-- Дамп структуры для таблица safety.application_menu
CREATE TABLE IF NOT EXISTS `application_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `type` enum('standard','hidden','custom') CHARACTER SET utf8 NOT NULL DEFAULT 'standard',
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `application_menu_name_uindex` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Дамп данных таблицы safety.application_menu: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `application_menu` DISABLE KEYS */;
INSERT IGNORE INTO `application_menu` (`id`, `name`, `type`, `title`) VALUES
	(1, 'main_menu', 'standard', 'Main Menu');
/*!40000 ALTER TABLE `application_menu` ENABLE KEYS */;

-- Дамп структуры для таблица safety.application_menu_items
CREATE TABLE IF NOT EXISTS `application_menu_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `module` varchar(50) NOT NULL,
  `label` varchar(255) NOT NULL,
  `plugin` varchar(255) DEFAULT NULL,
  `params` text NOT NULL,
  `enabled` int(11) DEFAULT NULL,
  `custom` tinyint(1) NOT NULL DEFAULT '0',
  `order` smallint(6) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `application_menu_items_application_menu_id_fk` (`menu_id`),
  KEY `application_menu_items_application_menu_items_id_fk` (`parent_id`),
  CONSTRAINT `application_menu_items_application_menu_id_fk` FOREIGN KEY (`menu_id`) REFERENCES `application_menu` (`id`),
  CONSTRAINT `application_menu_items_application_menu_items_id_fk` FOREIGN KEY (`parent_id`) REFERENCES `application_menu_items` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Дамп данных таблицы safety.application_menu_items: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `application_menu_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `application_menu_items` ENABLE KEYS */;

-- Дамп структуры для таблица safety.application_offers
CREATE TABLE IF NOT EXISTS `application_offers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_en` varchar(255) NOT NULL,
  `title_ru` varchar(255) NOT NULL,
  `description_ru` text NOT NULL,
  `description_en` text NOT NULL,
  `modified_date` datetime NOT NULL,
  `creation_date` datetime NOT NULL,
  `file_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `application_offers_storage_files__fk` (`file_id`) USING BTREE,
  KEY `application_offers_user_users__fk` (`user_id`) USING BTREE,
  CONSTRAINT `application_offers_storage_files__fk` FOREIGN KEY (`file_id`) REFERENCES `storage_files` (`id`),
  CONSTRAINT `application_offers_user_users__fk` FOREIGN KEY (`user_id`) REFERENCES `user_users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Дамп данных таблицы safety.application_offers: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `application_offers` DISABLE KEYS */;
INSERT IGNORE INTO `application_offers` (`id`, `title_en`, `title_ru`, `description_ru`, `description_en`, `modified_date`, `creation_date`, `file_id`, `user_id`, `status`) VALUES
	(1, 'Volunteering at CBT/KCBTA', 'Volunteering at CBT/KCBTA', '<p><br></p><p align="justify"><span style="font-family: verdana, geneva, sans-serif; font-size: 12pt;"><em><strong>a. General Information</strong></em></span></p><p>\r\n<br></p><p align="justify"><span style="font-family: verdana, geneva, sans-serif; font-size: 12pt;">–<em>Why volunteer with CBT?</em></span><br>\r\n<span style="font-family: verdana, geneva, sans-serif; font-size: 12pt;">If\r\n you would like to support CBT groups and the KCBTA in reaching their \r\ngoals, such as participation of local stakeholders, contribution to \r\nlocal economic development and promoting and practicing socially and \r\necologically sustainable tourism, why not volunteer with us?</span></p><p>\r\n<br></p><p align="justify"><span style="font-family: verdana, geneva, sans-serif; font-size: 12pt;">CBT\r\n groups in Kyrgyzstan will appreciate your contribution like i.e. \r\nlanguage skills; looking at CBT organizations with a ‘foreign eye’ and \r\nthus possibly having the ability to give further inputs or come up with \r\nnew ideas; working experience in fields relevant for CBT groups \r\nactivities; technical skills and others. In return, you will have the \r\nchance to get a deeper insight into the daily work of CBT groups by \r\nactively participating in a CBT community. Moreover, there will be \r\nenough time to explore local culture, national traditions, study a new \r\nlanguage and learn about the country’s history.</span></p><p>\r\n<br></p><p align="justify"><span style="font-family: verdana, geneva, sans-serif; font-size: 12pt;">If\r\n you don’t have a possibility to come to Kyrgyzstan, there is still \r\nanother option of volunteering with us. You just need a computer, access\r\n to the web and you are ready for internet volunteering. CBT groups and \r\nthe KCBTA will be happy to receive your support by translating or \r\ncorrecting documents or giving feedback on CBT activities.</span></p><p>\r\n<br></p><p align="justify"><span style="font-family: verdana, geneva, sans-serif; font-size: 12pt;">–<em>Remuneration and Supervision</em></span><br>\r\n<span style="font-family: verdana, geneva, sans-serif; font-size: 12pt;">CBT\r\n groups and / or the KCBTA will help you in organizing visa, reaching \r\nyour destination after arrival in Bishkek and provide you with other \r\ninformation needed. During your stay in Kyrgyzstan, the KCBTA main \r\noffice will be an additional supervisor for you – apart from your \r\nsupervisor at CBT group.</span><br>\r\n<span style="font-family: verdana, geneva, sans-serif; font-size: 12pt;">For\r\n volunteering, we cannot provide remuneration or social insurance, but \r\neach CBT group will do their best do offer you some compensation for \r\nyour work – for instance, provide you with accommodation (a private \r\nguesthouse, share with local family, CBT destinations only).</span></p><p>\r\n<br></p><div align="center"><span style="font-family: verdana, geneva, sans-serif; font-size: 12pt;">&nbsp;<strong><em>b. Internet Volunteering</em></strong></span></div><p>\r\n<br></p><p align="justify"><span style="font-family: verdana, geneva, sans-serif; font-size: 12pt;">Internet,\r\n cyber or virtual volunteering refers to volunteer work entirely done \r\nvia internet. It has the advantage that you don’t have to leave your \r\ncountry or home, but still can offer support to an organization. You \r\njust need a computer and an internet line. In case of the KCBTA and CBT,\r\n internet volunteering can typically involve the following tasks: \r\ntranslation of texts from Kyrgyz, Russian and English into various \r\nlanguages and correction of texts in English or other languages by \r\nnative speakers. Additionally, the KCBTA and CBT can benefit from a \r\nfeedback forum (to be launched at <a>www.cbtkyrgyzstan.kg</a> soon) where you can drop your proposals, new ideas for CBT, suggestions for further improvement and so on.</span></p><p><br></p>', '<p align="justify"><span style="font-family: verdana, geneva, sans-serif; font-size: 12pt;"><em><strong>a. General Information</strong></em></span></p><p>\r\n<br></p><p align="justify"><span style="font-family: verdana, geneva, sans-serif; font-size: 12pt;">–<em>Why volunteer with CBT?</em></span><br>\r\n<span style="font-family: verdana, geneva, sans-serif; font-size: 12pt;">If\r\n you would like to support CBT groups and the KCBTA in reaching their \r\ngoals, such as participation of local stakeholders, contribution to \r\nlocal economic development and promoting and practicing socially and \r\necologically sustainable tourism, why not volunteer with us?</span></p><p>\r\n<br></p><p align="justify"><span style="font-family: verdana, geneva, sans-serif; font-size: 12pt;">CBT\r\n groups in Kyrgyzstan will appreciate your contribution like i.e. \r\nlanguage skills; looking at CBT organizations with a ‘foreign eye’ and \r\nthus possibly having the ability to give further inputs or come up with \r\nnew ideas; working experience in fields relevant for CBT groups \r\nactivities; technical skills and others. In return, you will have the \r\nchance to get a deeper insight into the daily work of CBT groups by \r\nactively participating in a CBT community. Moreover, there will be \r\nenough time to explore local culture, national traditions, study a new \r\nlanguage and learn about the country’s history.</span></p><p>\r\n<br></p><p align="justify"><span style="font-family: verdana, geneva, sans-serif; font-size: 12pt;">If\r\n you don’t have a possibility to come to Kyrgyzstan, there is still \r\nanother option of volunteering with us. You just need a computer, access\r\n to the web and you are ready for internet volunteering. CBT groups and \r\nthe KCBTA will be happy to receive your support by translating or \r\ncorrecting documents or giving feedback on CBT activities.</span></p><p>\r\n<br></p><p align="justify"><span style="font-family: verdana, geneva, sans-serif; font-size: 12pt;">–<em>Remuneration and Supervision</em></span><br>\r\n<span style="font-family: verdana, geneva, sans-serif; font-size: 12pt;">CBT\r\n groups and / or the KCBTA will help you in organizing visa, reaching \r\nyour destination after arrival in Bishkek and provide you with other \r\ninformation needed. During your stay in Kyrgyzstan, the KCBTA main \r\noffice will be an additional supervisor for you – apart from your \r\nsupervisor at CBT group.</span><br>\r\n<span style="font-family: verdana, geneva, sans-serif; font-size: 12pt;">For\r\n volunteering, we cannot provide remuneration or social insurance, but \r\neach CBT group will do their best do offer you some compensation for \r\nyour work – for instance, provide you with accommodation (a private \r\nguesthouse, share with local family, CBT destinations only).</span></p><p>\r\n<br></p><div align="center"><span style="font-family: verdana, geneva, sans-serif; font-size: 12pt;">&nbsp;<strong><em>b. Internet Volunteering</em></strong></span></div><p>\r\n<br></p><p align="justify"><span style="font-family: verdana, geneva, sans-serif; font-size: 12pt;">Internet,\r\n cyber or virtual volunteering refers to volunteer work entirely done \r\nvia internet. It has the advantage that you don’t have to leave your \r\ncountry or home, but still can offer support to an organization. You \r\njust need a computer and an internet line. In case of the KCBTA and CBT,\r\n internet volunteering can typically involve the following tasks: \r\ntranslation of texts from Kyrgyz, Russian and English into various \r\nlanguages and correction of texts in English or other languages by \r\nnative speakers. Additionally, the KCBTA and CBT can benefit from a \r\nfeedback forum (to be launched at <a>www.cbtkyrgyzstan.kg</a> soon) where you can drop your proposals, new ideas for CBT, suggestions for further improvement and so on.</span></p><p><br></p>', '2018-11-24 10:30:33', '2018-11-24 10:30:33', 34, 1, 1),
	(2, 'Kyrgyzstan Winter Tour is a 6-day holiday at popular Kyrgyz resorts and tourity cities.', 'Kyrgyzstan Winter Tour is a 6-day holiday at', '', '', '2018-11-24 11:02:44', '2018-11-24 11:02:44', 40, 1, 1),
	(3, 'Kyrgyzstan Biking Tour', 'Kyrgyzstan Biking Tour', '', '', '2018-11-24 11:37:31', '2018-11-24 11:37:31', 55, 1, 1);
/*!40000 ALTER TABLE `application_offers` ENABLE KEYS */;

-- Дамп структуры для таблица safety.application_partners
CREATE TABLE IF NOT EXISTS `application_partners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_en` varchar(255) DEFAULT NULL,
  `title_ru` varchar(255) NOT NULL,
  `description_ru` text,
  `description_en` text,
  `modified_date` datetime NOT NULL,
  `creation_date` datetime NOT NULL,
  `file_id` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `application_partners_storage_files_id_fk` (`file_id`),
  CONSTRAINT `application_partners_storage_files_id_fk` FOREIGN KEY (`file_id`) REFERENCES `storage_files` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы safety.application_partners: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `application_partners` DISABLE KEYS */;
/*!40000 ALTER TABLE `application_partners` ENABLE KEYS */;

-- Дамп структуры для таблица safety.application_services
CREATE TABLE IF NOT EXISTS `application_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_en` varchar(255) DEFAULT NULL,
  `title_ru` varchar(255) DEFAULT NULL,
  `description_ru` text,
  `description_en` int(11) DEFAULT NULL,
  `creation_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `file_id` int(11) DEFAULT NULL,
  `icon` text NOT NULL,
  `short_description_ru` text,
  `short_description_en` text,
  PRIMARY KEY (`id`),
  KEY `application_services_storage_files_id_fk` (`file_id`),
  CONSTRAINT `application_services_storage_files_id_fk` FOREIGN KEY (`file_id`) REFERENCES `storage_files` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы safety.application_services: ~4 rows (приблизительно)
/*!40000 ALTER TABLE `application_services` DISABLE KEYS */;
INSERT IGNORE INTO `application_services` (`id`, `title_en`, `title_ru`, `description_ru`, `description_en`, `creation_date`, `modified_date`, `file_id`, `icon`, `short_description_ru`, `short_description_en`) VALUES
	(1, NULL, 'Энергоаудит', '<p>Мы являемся партнёрами немецкого энергетического агентства (dena) - \r\nконсультант Правительства РК, один из разработчиков закона “Об \r\nэнергосбережении и повышении энергоэффективности”<br></p>', NULL, '2019-03-22 08:16:42', '2019-03-22 08:16:42', NULL, 'pe-7s-graph1', 'Мы являемся партнёрами немецкого энергетического агентства (dena) - консультант Правительства РК, один из разработчиков закона “Об энергосбережении и повышении энергоэффективности”', NULL),
	(2, NULL, 'Тепловизионное обследование зданий', '<p>Тепловизионное обследование поможет Вам выявить скрытые дефекты \r\nтеплозащиты, обнаружить теплопотери во внутренних помещениях и снаружи \r\nзданий и сооружений.<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp; Проводить тепловизионное обследование зданий целесообразно как по \r\nокончанию строительства и реконструкции, так и в период эксплуатации.<br></p>', NULL, '2019-03-22 08:24:56', '2019-03-22 08:24:56', NULL, 'pe-7s-home', 'Тепловизионное обследование поможет Вам выявить скрытые дефекты теплозащиты, обнаружить теплопотери во внутренних помещениях и снаружи зданий и сооружений.\r\n     Проводить тепловизионное обследование зданий целесообразно как по окончанию строительства и реконструкции, так и в период эксплуатации.', NULL),
	(3, NULL, 'Энергоменеджмент', '<p>Система энергоменеджмента является одним из инструментов общего \r\nменеджмента, обеспечивающая повышение конкурентоспособности и достижение\r\n стратегических целей компании. Мировой опыт демонстрирует нам, что \r\nповышение энергоэффективности осуществляется за счет улучшения \r\nорганизационных моментов.<br></p>', NULL, '2019-03-22 08:51:06', '2019-03-22 08:51:06', NULL, 'pe-7s-cash', 'Система энергоменеджмента является одним из инструментов общего менеджмента, обеспечивающая повышение конкурентоспособности и достижение стратегических целей компании. Мировой опыт демонстрирует нам, что повышение энергоэффективности осуществляется за счет улучшения организационных моментов.', NULL),
	(4, NULL, 'Консалтинг по энергоэффективному строительству', '<p>Строительство энергоэффективных зданий и сооружений - это комплексная \r\nработа, учитывающая многовариантный подход, рациональный выбор \r\nтеплозащиты ограждающих конструкций, выбор инженерного оборудования и \r\nэффективность использования возобновляемых источников энергии.<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp; Энергоэффективные здания характеризуются низким удельным \r\nтеплопотреблением. Это достигается применением современных строительных \r\nтехнологий, качественных строительных материалов и утепления, а также \r\nэффективными системами энергообеспечения и вентиляции. Строительство \r\nэнергоэффективноых зданий становится одним из ключевых, а проблема \r\nрационального использования энергоресурсов приобретает все большее \r\nзначение.<br></p>', NULL, '2019-03-22 08:53:11', '2019-03-22 08:53:11', NULL, 'pe-7s-tools', 'Строительство энергоэффективных зданий и сооружений - это комплексная работа, учитывающая многовариантный подход, рациональный выбор теплозащиты ограждающих конструкций, выбор инженерного оборудования и эффективность использования возобновляемых источников энергии.', NULL);
/*!40000 ALTER TABLE `application_services` ENABLE KEYS */;

-- Дамп структуры для таблица safety.application_settings
CREATE TABLE IF NOT EXISTS `application_settings` (
  `name` varchar(255) NOT NULL,
  `value` text,
  PRIMARY KEY (`name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Дамп данных таблицы safety.application_settings: ~18 rows (приблизительно)
/*!40000 ALTER TABLE `application_settings` DISABLE KEYS */;
INSERT IGNORE INTO `application_settings` (`name`, `value`) VALUES
	('contact.address', 'Kyrgyzstan, Bishkek, Ibraimova st, 113/2'),
	('contact.email', 'cyclekyrgyzstan@gmail.com'),
	('contact.lat', '42.8771927787671'),
	('contact.lng', '74.60367584667972'),
	('contact.mobile', '+996 700 602 206'),
	('contact.phone', '+996 705 700 711'),
	('en.site.description', 'Cycle Kyrgyzstan'),
	('en.site.keywords', 'Cycle Kyrgyzstan'),
	('en.site.title', 'Cycle Kyrgyzstan'),
	('ru.site.description', 'Cycle Kyrgyzstan'),
	('ru.site.keywords', 'Cycle Kyrgyzstan'),
	('ru.site.title', 'Центр энергосбережения'),
	('social.facebook', 'ferfwerf'),
	('social.google-plus', ''),
	('social.instagram', '2435345'),
	('social.twitter', 'werfewr'),
	('social.vk', ''),
	('social.youtube', '');
/*!40000 ALTER TABLE `application_settings` ENABLE KEYS */;

-- Дамп структуры для таблица safety.application_sliders
CREATE TABLE IF NOT EXISTS `application_sliders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_en` varchar(255) DEFAULT NULL,
  `title_ru` varchar(255) DEFAULT NULL,
  `description_en` text,
  `description_ru` text,
  `creation_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `file_id` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `application_sliders_storage_files__fk` (`file_id`) USING BTREE,
  CONSTRAINT `application_sliders_storage_files__fk` FOREIGN KEY (`file_id`) REFERENCES `storage_files` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Дамп данных таблицы safety.application_sliders: ~5 rows (приблизительно)
/*!40000 ALTER TABLE `application_sliders` DISABLE KEYS */;
INSERT IGNORE INTO `application_sliders` (`id`, `title_en`, `title_ru`, `description_en`, `description_ru`, `creation_date`, `modified_date`, `file_id`, `status`, `link`) VALUES
	(4, NULL, 'wrgrtg', NULL, 'erggggg', '2019-03-25 09:03:33', '2019-03-25 09:03:33', 73, 1, '23453452345'),
	(5, NULL, 'erert', NULL, 'retgretg', '2019-03-25 12:07:09', '2019-03-25 12:07:09', 76, 1, ''),
	(6, NULL, 'retgrgt', NULL, '', '2019-03-25 12:07:17', '2019-03-25 12:07:17', 79, 1, ''),
	(7, NULL, 'ergrgrtg', NULL, '', '2019-03-25 12:08:12', '2019-03-25 12:08:12', 82, 1, ''),
	(8, NULL, 'er36', NULL, '', '2019-03-25 12:08:52', '2019-03-25 12:08:52', 85, 1, '');
/*!40000 ALTER TABLE `application_sliders` ENABLE KEYS */;

-- Дамп структуры для таблица safety.application_teams
CREATE TABLE IF NOT EXISTS `application_teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_en` varchar(255) DEFAULT NULL,
  `title_ru` varchar(255) DEFAULT NULL,
  `description_en` text,
  `description_ru` text,
  `creation_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `file_id` int(11) DEFAULT NULL,
  `short_description_en` text,
  `short_description_ru` text,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `application_teams_storage_files__fk` (`file_id`) USING BTREE,
  CONSTRAINT `application_teams_storage_files__fk` FOREIGN KEY (`file_id`) REFERENCES `storage_files` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Дамп данных таблицы safety.application_teams: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `application_teams` DISABLE KEYS */;
INSERT IGNORE INTO `application_teams` (`id`, `title_en`, `title_ru`, `description_en`, `description_ru`, `creation_date`, `modified_date`, `file_id`, `short_description_en`, `short_description_ru`) VALUES
	(1, NULL, 'ewrfwef', NULL, 'werfwefewf', '2019-03-27 11:13:37', '2019-03-27 11:13:37', 91, NULL, 'rfeqrferferferf'),
	(2, NULL, 'regrtg', NULL, 'rfeqrferferferf<br>', '2019-03-27 11:16:35', '2019-03-27 11:16:35', 88, NULL, 'rfeqrferferferf');
/*!40000 ALTER TABLE `application_teams` ENABLE KEYS */;

-- Дамп структуры для таблица safety.application_translates
CREATE TABLE IF NOT EXISTS `application_translates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `locale` varchar(5) NOT NULL,
  `translate` text NOT NULL,
  `translate_key_id` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `application_translates_application_translate_key__fk` (`translate_key_id`) USING BTREE,
  CONSTRAINT `application_translates_application_translate_key__fk` FOREIGN KEY (`translate_key_id`) REFERENCES `application_translate_key` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Дамп данных таблицы safety.application_translates: ~26 rows (приблизительно)
/*!40000 ALTER TABLE `application_translates` DISABLE KEYS */;
INSERT IGNORE INTO `application_translates` (`id`, `locale`, `translate`, `translate_key_id`) VALUES
	(1, 'en_EN', 'Russian', 2),
	(2, 'ru_RU', 'Русский', 2),
	(3, 'en_EN', 'English', 3),
	(4, 'ru_RU', 'Английский', 3),
	(5, 'en_EN', 'Copyright © %s Cyclekyrgyzstan.com. All rights reserved.', 4),
	(6, 'ru_RU', 'Copyright © %s zarde.net. Все права защищены.', 4),
	(7, 'en_EN', 'Support', 5),
	(8, 'ru_RU', 'Служба Поддержки', 5),
	(9, 'en_EN', 'Special offers', 6),
	(10, 'ru_RU', 'Special offers', 6),
	(11, 'en_EN', 'Cycling adventures', 7),
	(12, 'ru_RU', 'Cycling adventures', 7),
	(13, 'ru_RU', 'Контакты', 8),
	(14, 'ru_RU', 'Новости', 9),
	(15, 'ru_RU', 'О нас', 10),
	(16, 'ru_RU', 'Наши услуги', 11),
	(17, 'ru_RU', 'Клиенты', 12),
	(18, 'ru_RU', 'Наша команда', 13),
	(19, 'ru_RU', 'Наши партнеры', 14),
	(20, 'ru_RU', 'История', 15),
	(21, 'ru_RU', 'Главная', 16),
	(22, 'ru_RU', 'Услуги', 17),
	(23, 'ru_RU', 'Новости', 18),
	(24, 'ru_RU', 'Команда', 19),
	(25, 'ru_RU', 'Страницы', 20),
	(26, 'ru_RU', 'Слайды', 21);
/*!40000 ALTER TABLE `application_translates` ENABLE KEYS */;

-- Дамп структуры для таблица safety.application_translate_key
CREATE TABLE IF NOT EXISTS `application_translate_key` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(20) NOT NULL,
  `translate_text` text NOT NULL,
  `js` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Дамп данных таблицы safety.application_translate_key: ~17 rows (приблизительно)
/*!40000 ALTER TABLE `application_translate_key` DISABLE KEYS */;
INSERT IGNORE INTO `application_translate_key` (`id`, `module`, `translate_text`, `js`) VALUES
	(2, 'application', 'ru_RU', 0),
	(3, 'application', 'en_EN', 0),
	(4, 'application', '%s company_copyright', 0),
	(5, 'application', 'Support', 0),
	(6, 'application', 'special-offers', 0),
	(7, 'application', 'cycling-adventures', 0),
	(8, 'application', 'Contacts', 0),
	(9, 'application', 'News', 0),
	(10, 'application', 'About us', 0),
	(11, 'application', 'Our Services', 0),
	(12, 'application', 'Clients', 0),
	(13, 'application', 'Our team', 0),
	(14, 'application', 'Our partners', 0),
	(15, 'application', 'History', 0),
	(16, 'application', 'Home', 0),
	(17, 'application', 'Services', 0),
	(18, 'application', 'Articles', 0),
	(19, 'application', 'Teams', 0),
	(20, 'application', 'Pages', 0),
	(21, 'application', 'Sliders', 0);
/*!40000 ALTER TABLE `application_translate_key` ENABLE KEYS */;

-- Дамп структуры для таблица safety.article_articles
CREATE TABLE IF NOT EXISTS `article_articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_en` varchar(255) DEFAULT NULL,
  `title_ru` varchar(255) NOT NULL,
  `description_en` longtext,
  `description_ru` longtext NOT NULL,
  `creation_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `file_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `article_articles_user_users__fk` (`user_id`) USING BTREE,
  KEY `article_articles_storage_files__fk` (`file_id`) USING BTREE,
  CONSTRAINT `article_articles_storage_files__fk` FOREIGN KEY (`file_id`) REFERENCES `storage_files` (`id`),
  CONSTRAINT `article_articles_user_users__fk` FOREIGN KEY (`user_id`) REFERENCES `user_users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Дамп данных таблицы safety.article_articles: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `article_articles` DISABLE KEYS */;
INSERT IGNORE INTO `article_articles` (`id`, `title_en`, `title_ru`, `description_en`, `description_ru`, `creation_date`, `modified_date`, `file_id`, `user_id`) VALUES
	(1, 'Kyrgyzstan Included in Top 20 Travel Destinations of 2018', '35656 ergergreb erberbrtg', '234 ferf', '234234 retgrwtg wertretg<br>', '2018-11-17 09:58:09', '2018-11-17 09:58:09', 25, 1),
	(2, 'Kyrgyzstan is one of Lonely Planet’s Top 10 Countries to Visit in 2019', 'Kyrgyzstan is one of Lonely Planet’s Top 10 Countries to Visit in 2019', 'A team of experts from Lonely Planet has just announced its Top 10 destinations that will capture tourists’ imaginations in 2019.\r\n\r\nKyrgyzstan ranked fifth on this list: “The time to visit has never been better…Kyrgyzstan is quickly becoming an in-the-know favorite for independent travelers seeking unspoilt natural beauty.”\r\n\r\nSri Lanka heads the list of destinations. The top 10 also includes Germany, Zimbabwe, Panama, Jordan, Indonesia, Belarus, Saõ Tome and Principé, and Belize.\r\nLonely Planet, founded in 1972 and headquartered in Australia, specializes in the production of travel guides.', 'A team of experts from Lonely Planet has just announced its Top 10 destinations that will capture tourists’ imaginations in 2019.\r\n\r\nKyrgyzstan ranked fifth on this list: “The time to visit has never been better…Kyrgyzstan is quickly becoming an in-the-know favorite for independent travelers seeking unspoilt natural beauty.”\r\n\r\nSri Lanka heads the list of destinations. The top 10 also includes Germany, Zimbabwe, Panama, Jordan, Indonesia, Belarus, Saõ Tome and Principé, and Belize.\r\nLonely Planet, founded in 1972 and headquartered in Australia, specializes in the production of travel guides.', '2018-11-24 09:43:01', '2018-11-24 09:43:01', 28, 1),
	(3, NULL, 'werfwerfwerf', NULL, '<p>wefwerfwerfewrf<br></p>', '2019-03-28 13:47:27', '2019-03-28 13:47:27', 94, 1);
/*!40000 ALTER TABLE `article_articles` ENABLE KEYS */;

-- Дамп структуры для таблица safety.article_categories
CREATE TABLE IF NOT EXISTS `article_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_en` varchar(255) NOT NULL,
  `title_ru` varchar(255) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Дамп данных таблицы safety.article_categories: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `article_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `article_categories` ENABLE KEYS */;

-- Дамп структуры для таблица safety.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы safety.migrations: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT IGNORE INTO `migrations` (`version`) VALUES
	('20190317144917'),
	('20190325090108');
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Дамп структуры для таблица safety.page_pages
CREATE TABLE IF NOT EXISTS `page_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `title_ru` varchar(255) DEFAULT NULL,
  `description_en` longtext,
  `description_ru` longtext,
  `creation_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `custom` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `page_pages_name_uindex` (`name`) USING BTREE,
  KEY `page_pages_user_users__fk` (`user_id`) USING BTREE,
  CONSTRAINT `page_pages_user_users__fk` FOREIGN KEY (`user_id`) REFERENCES `user_users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Дамп данных таблицы safety.page_pages: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `page_pages` DISABLE KEYS */;
INSERT IGNORE INTO `page_pages` (`id`, `name`, `title_en`, `title_ru`, `description_en`, `description_ru`, `creation_date`, `modified_date`, `user_id`, `custom`) VALUES
	(1, 'history', 'About Kyrgyzstan', 'История', '<p>Kyrgyzstan – is a country located in Central Asia.\r\n Landlocked and mountainous, Kyrgyzstan is bordered by\r\n Kazakhstan to the north, Uzbekistan to the west, Tajikistan to the\r\n southwest and China to the east. Its capital and largest city is Bishkek.</p><div class="text"><p> The official language, Kyrgyz, is closely related to the other Turkic\r\n languages; however, the country is under a strong cultural influence\r\n from Russia and is rather Russified. The majority of the population (64%)\r\n are nondenominational Muslims.</p><p> Kyrgyzstan is a member of the Commonwealth of Independent States,\r\n the Eurasian Economic Community, the Collective Security\r\n Treaty Organization, the Shanghai Cooperation Organisation, the\r\n Organisation of Islamic Cooperation, the Turkic Council, the TÜRKSOY\r\n community and the United Nations.</p></div>', '<p>История компании<br></p>', '2018-11-17 05:08:46', '2018-11-17 05:08:50', 1, NULL),
	(2, 'about_us', 'About Us', 'О нас', '<p align="center">From our humble beginnings in 2003, Advantour has grown to three \r\noffices across Central Asia and the Caucasus. Even with hundreds of \r\ngroup, private and personalized tours to the best sights in Armenia, \r\nAzerbaijan, Georgia, Kazakhstan, Kyrgyzstan, Tajikistan, \r\nTurkmenistan,&nbsp;&nbsp;Uzbekistan&nbsp;and China, Advantour remains close to its \r\nroots by working with local staff and tour operators to make sure that \r\ntours are full of flavor while also supporting sustainable tourism \r\neverywhere we work.</p><p align="center">We are always searching for new destinations and new experiences for \r\nour guests, from updating and improving group tours to creating tours to\r\n meet specific needs and interests. Whether you want to join one of our \r\nsmall group tours (with no more than 16 people) to some of our favorite \r\ndestinations, or create a personalized private tour to fit your tastes, \r\nwe aim to offer the best value and service to make your trip \r\nunforgettable.</p><p align="center"><br></p>', '', '2018-11-24 06:55:57', '2018-11-24 06:56:00', 1, NULL),
	(3, 'nomads-lodge', 'Nomads Lodge', 'Nomads Lodge', 'Nomads Lodge', 'Nomads Lodge', '2018-11-24 09:24:30', '2018-11-24 09:24:40', 1, NULL);
/*!40000 ALTER TABLE `page_pages` ENABLE KEYS */;

-- Дамп структуры для таблица safety.storage_files
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
  PRIMARY KEY (`id`) USING BTREE,
  KEY `storage_files_storage_services__fk` (`service_id`) USING BTREE,
  CONSTRAINT `storage_files_storage_services__fk` FOREIGN KEY (`service_id`) REFERENCES `storage_services` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Дамп данных таблицы safety.storage_files: ~85 rows (приблизительно)
/*!40000 ALTER TABLE `storage_files` DISABLE KEYS */;
INSERT IGNORE INTO `storage_files` (`id`, `parent_file_id`, `type`, `storage_path`, `parent_type`, `parent_id`, `extension`, `name`, `mime_major`, `mime_minor`, `size`, `hash`, `owner_id`, `owner_type`, `service_id`) VALUES
	(1, NULL, NULL, 'files/article_articles/1/0000_747f.png', 'article_articles', 1, 'png', '66zgg.png', 'image', 'png', 178879, '5103747f404ba35d96cb081b8cfee7e1', 1, 'user_users', 1),
	(2, 1, 'thumb.normal', 'files/article_articles/1/0000_1fbf.png', 'article_articles', 1, 'png', '66zgg.png', 'image', 'png', 22245, '6b5f1fbf89f0d34485f3a2d28f694de3', 1, 'user_users', 1),
	(3, 1, 'thumb.icon', 'files/article_articles/1/0000_808e.png', 'article_articles', 1, 'png', '66zgg.png', 'image', 'png', 12987, '92fb808edffec01e4e37d71d1028faa5', 1, 'user_users', 1),
	(4, NULL, NULL, 'files/article_articles/1/0000_0533.jpeg', 'article_articles', 1, 'jpeg', 'index111.jpeg', 'image', 'jpeg', 41481, '739605339307f17cf6693e61b2a01f30', 1, 'user_users', 1),
	(5, 4, 'thumb.normal', 'files/article_articles/1/0000_037f.jpeg', 'article_articles', 1, 'jpeg', 'index111.jpeg', 'image', 'jpeg', 3194, 'e059037f424f78999850223b07bce92f', 1, 'user_users', 1),
	(6, 4, 'thumb.icon', 'files/article_articles/1/0000_d789.jpeg', 'article_articles', 1, 'jpeg', 'index111.jpeg', 'image', 'jpeg', 2655, '0a43d789be9441bcfcbd9f1b77f9c4ce', 1, 'user_users', 1),
	(7, NULL, NULL, 'files/application_sliders/2/0000_fd2f.jpg', 'application_sliders', 2, 'jpg', 'full_Zjpi7yQ4.jpg', 'image', 'jpeg', 329115, '0068fd2fea30dc3ddbbd531afa6534b5', 1, 'user_users', 1),
	(8, 7, 'thumb.normal', 'files/application_sliders/2/0000_6152.jpg', 'application_sliders', 2, 'jpg', 'full_Zjpi7yQ4.jpg', 'image', 'jpeg', 5231, '84556152dc844c25e76720027e03e0b1', 1, 'user_users', 1),
	(9, 7, 'thumb.icon', 'files/application_sliders/2/0000_9639.jpg', 'application_sliders', 2, 'jpg', 'full_Zjpi7yQ4.jpg', 'image', 'jpeg', 3369, '1f959639306cbc035c8c3326bb82a379', 1, 'user_users', 1),
	(10, NULL, NULL, 'files/tour_tours/1/0000_b8a2.jpeg', 'tour_tours', 1, 'jpeg', 'index1212.jpeg', 'image', 'jpeg', 26162, '330db8a2cb95635c5755c1f5a1b8b1ce', 1, 'user_users', 1),
	(11, 10, 'thumb.normal', 'files/tour_tours/1/0000_e463.jpeg', 'tour_tours', 1, 'jpeg', 'index1212.jpeg', 'image', 'jpeg', 2294, '9be5e46336af985690d69035422662a5', 1, 'user_users', 1),
	(12, 10, 'thumb.icon', 'files/tour_tours/1/0000_26bf.jpeg', 'tour_tours', 1, 'jpeg', 'index1212.jpeg', 'image', 'jpeg', 1869, '7b8026bf407f94d04afd5c22806b5cac', 1, 'user_users', 1),
	(13, NULL, NULL, 'files/tour_tours/1/0000_3e4f.jpg', 'tour_tours', 1, 'jpg', 'shutterstock_81514453.jpg', 'image', 'jpeg', 41932, '67db3e4f1d4b188c69f837c73bacaebd', 1, 'user_users', 1),
	(14, 13, 'thumb.normal', 'files/tour_tours/1/0000_ea54.jpg', 'tour_tours', 1, 'jpg', 'shutterstock_81514453.jpg', 'image', 'jpeg', 4294, '1f1aea54c1e05d22c4261dc2329948de', 1, 'user_users', 1),
	(15, 13, 'thumb.icon', 'files/tour_tours/1/0000_a12e.jpg', 'tour_tours', 1, 'jpg', 'shutterstock_81514453.jpg', 'image', 'jpeg', 3223, '6468a12ed058033606cabacf2c914437', 1, 'user_users', 1),
	(16, NULL, NULL, 'files/tour_tours/1/0000_3e4f.jpg', 'tour_tours', 1, 'jpg', 'shutterstock_81514453.jpg', 'image', 'jpeg', 41932, '67db3e4f1d4b188c69f837c73bacaebd', 1, 'user_users', 1),
	(17, 16, 'thumb.normal', 'files/tour_tours/1/0000_ea54.jpg', 'tour_tours', 1, 'jpg', 'shutterstock_81514453.jpg', 'image', 'jpeg', 4294, '1f1aea54c1e05d22c4261dc2329948de', 1, 'user_users', 1),
	(18, 16, 'thumb.icon', 'files/tour_tours/1/0000_a12e.jpg', 'tour_tours', 1, 'jpg', 'shutterstock_81514453.jpg', 'image', 'jpeg', 3223, '6468a12ed058033606cabacf2c914437', 1, 'user_users', 1),
	(19, NULL, NULL, 'files/tour_tours/2/0000_aa70.jpg', 'tour_tours', 2, 'jpg', 'shutterstock_79771195.jpg', 'image', 'jpeg', 79000, '4ffdaa701bb58c41c3228a2f44d00911', 1, 'user_users', 1),
	(20, 19, 'thumb.normal', 'files/tour_tours/2/0000_4a27.jpg', 'tour_tours', 2, 'jpg', 'shutterstock_79771195.jpg', 'image', 'jpeg', 5586, 'c51f4a27a5709d9fea258a129377cae5', 1, 'user_users', 1),
	(21, 19, 'thumb.icon', 'files/tour_tours/2/0000_8d90.jpg', 'tour_tours', 2, 'jpg', 'shutterstock_79771195.jpg', 'image', 'jpeg', 3722, 'e2738d904f2e240bf9861058d793a88d', 1, 'user_users', 1),
	(22, NULL, NULL, 'files/application_sliders/3/0000_f92c.jpg', 'application_sliders', 3, 'jpg', '01.jpg', 'image', 'jpeg', 105889, '7df7f92c932a99c8594fb30ff7e3ebff', 1, 'user_users', 1),
	(23, 22, 'thumb.normal', 'files/application_sliders/3/0000_5aee.jpg', 'application_sliders', 3, 'jpg', '01.jpg', 'image', 'jpeg', 2952, '034c5aee8c84f99203a7efa20abefe30', 1, 'user_users', 1),
	(24, 22, 'thumb.icon', 'files/application_sliders/3/0000_1e7a.jpg', 'application_sliders', 3, 'jpg', '01.jpg', 'image', 'jpeg', 3008, 'c7a31e7abe29cb28612e9018d29e9e2f', 1, 'user_users', 1),
	(25, NULL, NULL, 'files/article_articles/1/0000_1cec.jpg', 'article_articles', 1, 'jpg', '4-camping-in-mountains-Kyrgyzstan-1.jpg', 'image', 'jpeg', 77911, 'c39c1cec8a6510a375313311acd047d5', 1, 'user_users', 1),
	(26, 25, 'thumb.normal', 'files/article_articles/1/0000_3cde.jpg', 'article_articles', 1, 'jpg', '4-camping-in-mountains-Kyrgyzstan-1.jpg', 'image', 'jpeg', 5111, 'eefa3cde80340d5daa7fe2669a662f93', 1, 'user_users', 1),
	(27, 25, 'thumb.icon', 'files/article_articles/1/0000_3492.jpg', 'article_articles', 1, 'jpg', '4-camping-in-mountains-Kyrgyzstan-1.jpg', 'image', 'jpeg', 3252, '41eb3492e7d90a7434dba128bc448f79', 1, 'user_users', 1),
	(28, NULL, NULL, 'files/article_articles/2/0000_b560.jpg', 'article_articles', 2, 'jpg', '401379_10200282760023148_573897985_n.jpg', 'image', 'jpeg', 40007, 'b8c5b560a9299590b573705cd58d6ff7', 1, 'user_users', 1),
	(29, 28, 'thumb.normal', 'files/article_articles/2/0000_8572.jpg', 'article_articles', 2, 'jpg', '401379_10200282760023148_573897985_n.jpg', 'image', 'jpeg', 4027, '717e8572546a58743ca9c283d93e30b5', 1, 'user_users', 1),
	(30, 28, 'thumb.icon', 'files/article_articles/2/0000_9371.jpg', 'article_articles', 2, 'jpg', '401379_10200282760023148_573897985_n.jpg', 'image', 'jpeg', 2711, 'de1f9371a649c31104919a1cf8eaa71a', 1, 'user_users', 1),
	(31, NULL, NULL, 'files/tour_tours/3/0000_5c61.jpg', 'tour_tours', 3, 'jpg', 'shutterstock_177399293.jpg', 'image', 'jpeg', 43237, 'a8c55c614a390ff47ef8c1066912aa46', 1, 'user_users', 1),
	(32, 31, 'thumb.normal', 'files/tour_tours/3/0000_5f95.jpg', 'tour_tours', 3, 'jpg', 'shutterstock_177399293.jpg', 'image', 'jpeg', 3419, '14955f955f78c7af87251024f4215618', 1, 'user_users', 1),
	(33, 31, 'thumb.icon', 'files/tour_tours/3/0000_3096.jpg', 'tour_tours', 3, 'jpg', 'shutterstock_177399293.jpg', 'image', 'jpeg', 2435, '3458309672f5ecb71976f452620c3a22', 1, 'user_users', 1),
	(34, NULL, NULL, 'files/application_offers/1/0000_2622.jpg', 'application_offers', 1, 'jpg', 'shutterstock_350859866.jpg', 'image', 'jpeg', 47113, '12392622a924006316be969028beb199', 1, 'user_users', 1),
	(35, 34, 'thumb.normal', 'files/application_offers/1/0000_9993.jpg', 'application_offers', 1, 'jpg', 'shutterstock_350859866.jpg', 'image', 'jpeg', 4228, 'be279993afac8dfd8bef0aaff4809469', 1, 'user_users', 1),
	(36, 34, 'thumb.icon', 'files/application_offers/1/0000_191d.jpg', 'application_offers', 1, 'jpg', 'shutterstock_350859866.jpg', 'image', 'jpeg', 3117, '5c55191db681d4843f4250324e115b08', 1, 'user_users', 1),
	(37, NULL, NULL, 'files/tour_tours/4/0000_74c6.jpeg', 'tour_tours', 4, 'jpeg', 'index.jpeg', 'image', 'jpeg', 7763, '998a74c61aeffef7876b207df817427c', 1, 'user_users', 1),
	(38, 37, 'thumb.normal', 'files/tour_tours/4/0000_c0a4.jpeg', 'tour_tours', 4, 'jpeg', 'index.jpeg', 'image', 'jpeg', 3290, '661ec0a4f82ea1a1484825e5c9690013', 1, 'user_users', 1),
	(39, 37, 'thumb.icon', 'files/tour_tours/4/0000_a665.jpeg', 'tour_tours', 4, 'jpeg', 'index.jpeg', 'image', 'jpeg', 2434, '2691a665ea4d9571d1ecb318e9d68d0c', 1, 'user_users', 1),
	(40, NULL, NULL, 'files/application_offers/2/0000_8189.jpg', 'application_offers', 2, 'jpg', 'img1.jpg', 'image', 'jpeg', 76706, 'aa438189f443f37f67f12d48a0351a0e', 1, 'user_users', 1),
	(41, 40, 'thumb.normal', 'files/application_offers/2/0000_27fb.jpg', 'application_offers', 2, 'jpg', 'img1.jpg', 'image', 'jpeg', 5388, 'd24e27fb86cd0bb94e626fd6b6ac0a09', 1, 'user_users', 1),
	(42, 40, 'thumb.icon', 'files/application_offers/2/0000_02f8.jpg', 'application_offers', 2, 'jpg', 'img1.jpg', 'image', 'jpeg', 3511, '330c02f8ef49a2995dc8b3b0afbef448', 1, 'user_users', 1),
	(43, NULL, NULL, 'files/application_sliders/2/0000_01cc.jpg', 'application_sliders', 2, 'jpg', 'slider8.jpg', 'image', 'jpeg', 137104, '409001ccff970a5f10fb2c0b579bfb46', 1, 'user_users', 1),
	(44, 43, 'thumb.normal', 'files/application_sliders/2/0000_950c.jpg', 'application_sliders', 2, 'jpg', 'slider8.jpg', 'image', 'jpeg', 3769, '72c5950cceb850bf3cfee92bbde31bb8', 1, 'user_users', 1),
	(45, 43, 'thumb.icon', 'files/application_sliders/2/0000_8098.jpg', 'application_sliders', 2, 'jpg', 'slider8.jpg', 'image', 'jpeg', 3160, '9a7380984968f489edd119d2531ca16c', 1, 'user_users', 1),
	(46, NULL, NULL, 'files/application_offers/3/0000_2943.jpeg', 'application_offers', 3, 'jpeg', '123123.jpeg', 'image', 'jpeg', 15455, 'def82943e4b17d8ae68b833ea51d690d', 1, 'user_users', 1),
	(47, 46, 'thumb.normal', 'files/application_offers/3/0000_0d1d.jpeg', 'application_offers', 3, 'jpeg', '123123.jpeg', 'image', 'jpeg', 4910, 'f6a40d1d32cf45ded9ea917fb6ee2240', 1, 'user_users', 1),
	(48, 46, 'thumb.icon', 'files/application_offers/3/0000_b0f7.jpeg', 'application_offers', 3, 'jpeg', '123123.jpeg', 'image', 'jpeg', 3482, '104bb0f76ee669aa331abb9ff7e28063', 1, 'user_users', 1),
	(49, NULL, NULL, 'files/application_sliders/3/0000_e3dc.jpeg', 'application_sliders', 3, 'jpeg', '123123.jpeg', 'image', 'jpeg', 98872, '08d9e3dc3e3a0aadd40a9159e0c0f03f', 1, 'user_users', 1),
	(50, 49, 'thumb.normal', 'files/application_sliders/3/0000_e25b.jpeg', 'application_sliders', 3, 'jpeg', '123123.jpeg', 'image', 'jpeg', 3857, 'ab85e25bbbb25ba02883955c9accfdf3', 1, 'user_users', 1),
	(51, 49, 'thumb.icon', 'files/application_sliders/3/0000_1954.jpeg', 'application_sliders', 3, 'jpeg', '123123.jpeg', 'image', 'jpeg', 3027, 'b871195491ee228ceff481ea2c503c0d', 1, 'user_users', 1),
	(52, NULL, NULL, 'files/application_sliders/3/0000_f92c.jpg', 'application_sliders', 3, 'jpg', '01.jpg', 'image', 'jpeg', 105889, '7df7f92c932a99c8594fb30ff7e3ebff', 1, 'user_users', 1),
	(53, 52, 'thumb.normal', 'files/application_sliders/3/0000_5aee.jpg', 'application_sliders', 3, 'jpg', '01.jpg', 'image', 'jpeg', 2952, '034c5aee8c84f99203a7efa20abefe30', 1, 'user_users', 1),
	(54, 52, 'thumb.icon', 'files/application_sliders/3/0000_1e7a.jpg', 'application_sliders', 3, 'jpg', '01.jpg', 'image', 'jpeg', 3008, 'c7a31e7abe29cb28612e9018d29e9e2f', 1, 'user_users', 1),
	(55, NULL, NULL, 'files/application_offers/3/0000_a3fc.jpeg', 'application_offers', 3, 'jpeg', '123123.jpeg', 'image', 'jpeg', 45554, 'fd9aa3fcf4b2d3fa51578e272ddb8c3c', 1, 'user_users', 1),
	(56, 55, 'thumb.normal', 'files/application_offers/3/0000_e25b.jpeg', 'application_offers', 3, 'jpeg', '123123.jpeg', 'image', 'jpeg', 3857, 'ab85e25bbbb25ba02883955c9accfdf3', 1, 'user_users', 1),
	(57, 55, 'thumb.icon', 'files/application_offers/3/0000_1954.jpeg', 'application_offers', 3, 'jpeg', '123123.jpeg', 'image', 'jpeg', 3027, 'b871195491ee228ceff481ea2c503c0d', 1, 'user_users', 1),
	(58, NULL, NULL, 'files/tour_photos/1/0000_3e4f.jpg', 'tour_photos', 1, 'jpg', 'shutterstock_81514453.jpg', 'image', 'jpeg', 41932, '67db3e4f1d4b188c69f837c73bacaebd', 1, 'user_users', 1),
	(59, 58, 'thumb.normal', 'files/tour_photos/1/0000_ea54.jpg', 'tour_photos', 1, 'jpg', 'shutterstock_81514453.jpg', 'image', 'jpeg', 4294, '1f1aea54c1e05d22c4261dc2329948de', 1, 'user_users', 1),
	(60, 58, 'thumb.icon', 'files/tour_photos/1/0000_a12e.jpg', 'tour_photos', 1, 'jpg', 'shutterstock_81514453.jpg', 'image', 'jpeg', 3223, '6468a12ed058033606cabacf2c914437', 1, 'user_users', 1),
	(61, NULL, NULL, 'files/tour_photos/2/0000_6d54.jpg', 'tour_photos', 2, 'jpg', '44-Horse-Riding-in-Apple-Fields-near-Almaty.jpg', 'image', 'jpeg', 114385, 'bc8a6d544c227eaefc921839aa1a28c6', 1, 'user_users', 1),
	(62, 61, 'thumb.normal', 'files/tour_photos/2/0000_55ac.jpg', 'tour_photos', 2, 'jpg', '44-Horse-Riding-in-Apple-Fields-near-Almaty.jpg', 'image', 'jpeg', 6677, '927e55ac4f44cd04f88e5ec9f3d3752a', 1, 'user_users', 1),
	(63, 61, 'thumb.icon', 'files/tour_photos/2/0000_fe91.jpg', 'tour_photos', 2, 'jpg', '44-Horse-Riding-in-Apple-Fields-near-Almaty.jpg', 'image', 'jpeg', 4077, 'bc88fe91b95bea7a1f9c44298bc7f6ff', 1, 'user_users', 1),
	(64, NULL, NULL, 'files/application_sliders/4/0000_80a5.jpg', 'application_sliders', 4, 'jpg', 'shutterstock_81514453.jpg', 'image', 'jpeg', 55003, '95a380a57228a85377e24b1daf68af7c', 1, 'user_users', 1),
	(65, 64, 'thumb.normal', 'files/application_sliders/4/0000_ea54.jpg', 'application_sliders', 4, 'jpg', 'shutterstock_81514453.jpg', 'image', 'jpeg', 4294, '1f1aea54c1e05d22c4261dc2329948de', 1, 'user_users', 1),
	(66, 64, 'thumb.icon', 'files/application_sliders/4/0000_a12e.jpg', 'application_sliders', 4, 'jpg', 'shutterstock_81514453.jpg', 'image', 'jpeg', 3223, '6468a12ed058033606cabacf2c914437', 1, 'user_users', 1),
	(67, NULL, NULL, 'files/application_clients/1/0000_b173.jpg', 'application_clients', 1, 'jpg', 'full_Zjpi7yQ4.jpg', 'image', 'jpeg', 71812, 'f02cb173750826827711f6fb6697d4c6', 1, 'user_users', 1),
	(68, 67, 'thumb.normal', 'files/application_clients/1/0000_6152.jpg', 'application_clients', 1, 'jpg', 'full_Zjpi7yQ4.jpg', 'image', 'jpeg', 5231, '84556152dc844c25e76720027e03e0b1', 1, 'user_users', 1),
	(69, 67, 'thumb.icon', 'files/application_clients/1/0000_9639.jpg', 'application_clients', 1, 'jpg', 'full_Zjpi7yQ4.jpg', 'image', 'jpeg', 3369, '1f959639306cbc035c8c3326bb82a379', 1, 'user_users', 1),
	(70, NULL, NULL, 'files/application_clients/2/0000_8d86.jpeg', 'application_clients', 2, 'jpeg', 'WhatsApp Image 2019-01-16 at 16.07.39.jpeg', 'image', 'jpeg', 33367, '60a18d86a05f98543877aaae1338bb21', 1, 'user_users', 1),
	(71, 70, 'thumb.normal', 'files/application_clients/2/0000_911b.jpeg', 'application_clients', 2, 'jpeg', 'WhatsApp Image 2019-01-16 at 16.07.39.jpeg', 'image', 'jpeg', 2823, '960b911baed28c4c89adbb6a69f0b4a3', 1, 'user_users', 1),
	(72, 70, 'thumb.icon', 'files/application_clients/2/0000_716f.jpeg', 'application_clients', 2, 'jpeg', 'WhatsApp Image 2019-01-16 at 16.07.39.jpeg', 'image', 'jpeg', 1821, '00d5716ffb1558ef636663071c8b86ce', 1, 'user_users', 1),
	(73, NULL, NULL, 'files/application_sliders/4/0000_aed5.jpeg', 'application_sliders', 4, 'jpeg', 'index111.jpeg', 'image', 'jpeg', 95557, 'c203aed51a6296c418dab8e87565a6f0', 1, 'user_users', 1),
	(74, 73, 'thumb.normal', 'files/application_sliders/4/0000_c2a4.jpeg', 'application_sliders', 4, 'jpeg', 'index111.jpeg', 'image', 'jpeg', 8854, '9e06c2a4a45fb72b8dcea458238d0056', 1, 'user_users', 1),
	(75, 73, 'thumb.icon', 'files/application_sliders/4/0000_d789.jpeg', 'application_sliders', 4, 'jpeg', 'index111.jpeg', 'image', 'jpeg', 2655, '0a43d789be9441bcfcbd9f1b77f9c4ce', 1, 'user_users', 1),
	(76, NULL, NULL, 'files/application_sliders/5/0000_4b7a.jpg', 'application_sliders', 5, 'jpg', 'no_avatar.jpg', 'image', 'jpeg', 6339, '9cca4b7acbfa18cd3b6bf02b5535ca8a', 1, 'user_users', 1),
	(77, 76, 'thumb.normal', 'files/application_sliders/5/0000_b34c.jpg', 'application_sliders', 5, 'jpg', 'no_avatar.jpg', 'image', 'jpeg', 2990, 'ef19b34c4a765726a62f1a1a653cbe28', 1, 'user_users', 1),
	(78, 76, 'thumb.icon', 'files/application_sliders/5/0000_9848.jpg', 'application_sliders', 5, 'jpg', 'no_avatar.jpg', 'image', 'jpeg', 1194, '5644984844ba3f71729b03173c15a4c4', 1, 'user_users', 1),
	(79, NULL, NULL, 'files/application_sliders/6/0000_3670.jpg', 'application_sliders', 6, 'jpg', '20180812_113341.jpg', 'image', 'jpeg', 77124, 'b68a3670e3459df9655669a2df8cc22c', 1, 'user_users', 1),
	(80, 79, 'thumb.normal', 'files/application_sliders/6/0000_2a31.jpg', 'application_sliders', 6, 'jpg', '20180812_113341.jpg', 'image', 'jpeg', 11467, '96812a3128693ea107a3f111119a7ca6', 1, 'user_users', 1),
	(81, 79, 'thumb.icon', 'files/application_sliders/6/0000_9527.jpg', 'application_sliders', 6, 'jpg', '20180812_113341.jpg', 'image', 'jpeg', 3034, '917a9527f3d838c3d6eb12810ff82ae0', 1, 'user_users', 1),
	(82, NULL, NULL, 'files/application_sliders/7/0000_fd2f.jpg', 'application_sliders', 7, 'jpg', 'full_Zjpi7yQ4.jpg', 'image', 'jpeg', 329115, '0068fd2fea30dc3ddbbd531afa6534b5', 1, 'user_users', 1),
	(83, 82, 'thumb.normal', 'files/application_sliders/7/0000_1e8b.jpg', 'application_sliders', 7, 'jpg', 'full_Zjpi7yQ4.jpg', 'image', 'jpeg', 15594, 'ab541e8b1831dbb1cc9de93f2a1bc2aa', 1, 'user_users', 1),
	(84, 82, 'thumb.icon', 'files/application_sliders/7/0000_9639.jpg', 'application_sliders', 7, 'jpg', 'full_Zjpi7yQ4.jpg', 'image', 'jpeg', 3369, '1f959639306cbc035c8c3326bb82a379', 1, 'user_users', 1),
	(85, NULL, NULL, 'files/application_sliders/8/0000_747f.png', 'application_sliders', 8, 'png', '66zgg.png', 'image', 'png', 178879, '5103747f404ba35d96cb081b8cfee7e1', 1, 'user_users', 1),
	(86, 85, 'thumb.normal', 'files/application_sliders/8/0000_f2dd.png', 'application_sliders', 8, 'png', '66zgg.png', 'image', 'png', 57125, '99daf2dd7220a3d6a8d0d63bf183f23a', 1, 'user_users', 1),
	(87, 85, 'thumb.icon', 'files/application_sliders/8/0000_808e.png', 'application_sliders', 8, 'png', '66zgg.png', 'image', 'png', 12987, '92fb808edffec01e4e37d71d1028faa5', 1, 'user_users', 1),
	(88, NULL, NULL, 'files/application_teams/2/0000_3ea8.png', 'application_teams', 2, 'png', 'avatar-375-456327.png', 'image', 'png', 18257, '457c3ea8a8696e3481f3ef2f9d45c8a5', 1, 'user_users', 1),
	(89, 88, 'thumb.normal', 'files/application_teams/2/0000_9261.png', 'application_teams', 2, 'png', 'avatar-375-456327.png', 'image', 'png', 17983, 'e6039261cb43727672b3463282a2aca8', 1, 'user_users', 1),
	(90, 88, 'thumb.icon', 'files/application_teams/2/0000_59bb.png', 'application_teams', 2, 'png', 'avatar-375-456327.png', 'image', 'png', 11920, 'b09d59bba2d9f4db448bf05f51613881', 1, 'user_users', 1),
	(91, NULL, NULL, 'files/application_teams/1/0000_747f.png', 'application_teams', 1, 'png', '66zgg.png', 'image', 'png', 178879, '5103747f404ba35d96cb081b8cfee7e1', 1, 'user_users', 1),
	(92, 91, 'thumb.normal', 'files/application_teams/1/0000_1fbf.png', 'application_teams', 1, 'png', '66zgg.png', 'image', 'png', 22245, '6b5f1fbf89f0d34485f3a2d28f694de3', 1, 'user_users', 1),
	(93, 91, 'thumb.icon', 'files/application_teams/1/0000_808e.png', 'application_teams', 1, 'png', '66zgg.png', 'image', 'png', 12987, '92fb808edffec01e4e37d71d1028faa5', 1, 'user_users', 1),
	(94, NULL, NULL, 'files/article_articles/3/0000_3ea8.png', 'article_articles', 3, 'png', 'avatar-375-456327.png', 'image', 'png', 18257, '457c3ea8a8696e3481f3ef2f9d45c8a5', 1, 'user_users', 1),
	(95, 94, 'thumb.normal', 'files/article_articles/3/0000_9261.png', 'article_articles', 3, 'png', 'avatar-375-456327.png', 'image', 'png', 17983, 'e6039261cb43727672b3463282a2aca8', 1, 'user_users', 1),
	(96, 94, 'thumb.icon', 'files/article_articles/3/0000_59bb.png', 'article_articles', 3, 'png', 'avatar-375-456327.png', 'image', 'png', 11920, 'b09d59bba2d9f4db448bf05f51613881', 1, 'user_users', 1);
/*!40000 ALTER TABLE `storage_files` ENABLE KEYS */;

-- Дамп структуры для таблица safety.storage_services
CREATE TABLE IF NOT EXISTS `storage_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) DEFAULT NULL,
  `config` text,
  `enabled` smallint(6) DEFAULT NULL,
  `default` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `storage_services_storage_types__fk` (`type_id`) USING BTREE,
  CONSTRAINT `storage_services_storage_types__fk` FOREIGN KEY (`type_id`) REFERENCES `storage_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Дамп данных таблицы safety.storage_services: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `storage_services` DISABLE KEYS */;
INSERT IGNORE INTO `storage_services` (`id`, `type_id`, `config`, `enabled`, `default`) VALUES
	(1, 1, NULL, 1, 1),
	(2, 2, '{"params": {"host": "10.51.2.206", "path": "/var/www/nrk/public", "password": "Lan2018KeyTgBLan@)!^", "username": "akazakbaev"}, "adapter": "ssh", "baseUrl": "https://tandoo.gov.kg/"}', 1, 0);
/*!40000 ALTER TABLE `storage_services` ENABLE KEYS */;

-- Дамп структуры для таблица safety.storage_types
CREATE TABLE IF NOT EXISTS `storage_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL,
  `plugin` varchar(128) DEFAULT NULL,
  `form` varchar(128) DEFAULT NULL,
  `enabled` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Дамп данных таблицы safety.storage_types: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `storage_types` DISABLE KEYS */;
INSERT IGNORE INTO `storage_types` (`id`, `title`, `plugin`, `form`, `enabled`) VALUES
	(1, 'Local Storage', 'Storage\\Storage\\Local', '', 1),
	(2, 'Virtual File System', 'Storage\\Storage\\Vfs', NULL, NULL);
/*!40000 ALTER TABLE `storage_types` ENABLE KEYS */;

-- Дамп структуры для таблица safety.user_allows
CREATE TABLE IF NOT EXISTS `user_allows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `user_allows_user_levels__fk` (`level_id`) USING BTREE,
  KEY `user_allows_user_permissions__fk` (`permission_id`) USING BTREE,
  CONSTRAINT `user_allows_user_levels__fk` FOREIGN KEY (`level_id`) REFERENCES `user_levels` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_allows_user_permissions__fk` FOREIGN KEY (`permission_id`) REFERENCES `user_permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Дамп данных таблицы safety.user_allows: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `user_allows` DISABLE KEYS */;
INSERT IGNORE INTO `user_allows` (`id`, `level_id`, `permission_id`) VALUES
	(8, 1, 1),
	(9, 1, 2);
/*!40000 ALTER TABLE `user_allows` ENABLE KEYS */;

-- Дамп структуры для таблица safety.user_levels
CREATE TABLE IF NOT EXISTS `user_levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL,
  `description` text,
  `type` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Дамп данных таблицы safety.user_levels: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `user_levels` DISABLE KEYS */;
INSERT IGNORE INTO `user_levels` (`id`, `title`, `description`, `type`) VALUES
	(1, 'admin', 'admin', 'admin');
/*!40000 ALTER TABLE `user_levels` ENABLE KEYS */;

-- Дамп структуры для таблица safety.user_logins
CREATE TABLE IF NOT EXISTS `user_logins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Дамп данных таблицы safety.user_logins: ~34 rows (приблизительно)
/*!40000 ALTER TABLE `user_logins` DISABLE KEYS */;
INSERT IGNORE INTO `user_logins` (`id`, `user_id`, `username`, `status`, `ip`, `creation_date`) VALUES
	(1, 1, 'admin', 1, '127.0.0.1', '2018-10-09 11:56:37'),
	(2, 1, 'admin', 1, '127.0.0.1', '2018-10-09 11:57:45'),
	(3, 1, 'admin', 1, '127.0.0.1', '2018-10-09 12:15:02'),
	(4, 1, 'admin', 1, '127.0.0.1', '2018-10-10 11:09:52'),
	(5, 1, 'admin', 1, '127.0.0.1', '2018-10-10 12:58:21'),
	(6, 1, 'admin', 1, '127.0.0.1', '2018-10-12 11:50:18'),
	(7, 1, 'admin', 1, '127.0.0.1', '2018-10-12 13:40:41'),
	(8, 1, 'admin', 1, '127.0.0.1', '2018-11-17 04:40:31'),
	(9, 1, 'admin', 1, '127.0.0.1', '2018-11-17 06:25:28'),
	(10, 1, 'admin', 1, '127.0.0.1', '2018-11-17 08:59:01'),
	(11, 1, 'admin', 1, '127.0.0.1', '2018-11-17 10:45:24'),
	(12, 1, 'admin', 1, '127.0.0.1', '2018-11-19 03:02:24'),
	(13, 1, 'admin', 1, '127.0.0.1', '2018-11-20 02:40:20'),
	(14, 1, 'admin', 1, '127.0.0.1', '2018-11-20 03:08:16'),
	(15, 1, 'admin', 1, '127.0.0.1', '2018-11-21 02:46:22'),
	(16, 1, 'admin', 1, '127.0.0.1', '2018-11-21 13:26:18'),
	(17, 1, 'admin', 1, '127.0.0.1', '2018-11-22 04:56:18'),
	(18, 1, 'admin', 1, '127.0.0.1', '2018-11-24 05:15:14'),
	(19, 1, 'admin', 1, '127.0.0.1', '2018-11-26 04:33:43'),
	(20, 1, 'admin', 1, '127.0.0.1', '2018-11-27 12:41:48'),
	(21, 1, 'admin', 1, '127.0.0.1', '2018-12-03 12:22:46'),
	(22, 1, 'admin', 1, '127.0.0.1', '2018-12-08 08:20:37'),
	(23, 1, 'admin', 1, '127.0.0.1', '2018-12-09 04:21:17'),
	(24, 1, 'admin', 1, '127.0.0.1', '2018-12-09 08:43:47'),
	(25, 1, 'admin', 1, '127.0.0.1', '2018-12-22 07:52:05'),
	(26, 1, 'admin', 1, '127.0.0.1', '2019-03-03 08:08:09'),
	(27, 1, 'admin', 1, '127.0.0.1', '2019-03-09 08:49:38'),
	(28, 1, 'admin', 1, '127.0.0.1', '2019-03-09 09:39:18'),
	(29, 1, 'admin', 1, '127.0.0.1', '2019-03-09 10:13:09'),
	(30, 1, 'admin', 1, '127.0.0.1', '2019-03-10 08:25:29'),
	(31, 1, 'admin', 1, '127.0.0.1', '2019-03-10 09:47:29'),
	(32, 1, 'admin', 1, '127.0.0.1', '2019-03-16 08:33:48'),
	(33, 1, 'admin', 1, '127.0.0.1', '2019-03-16 09:36:19'),
	(34, 1, 'admin', 1, '127.0.0.1', '2019-03-22 08:06:25'),
	(35, 1, 'admin', 1, '127.0.0.1', '2019-03-22 13:20:45'),
	(36, 1, 'admin', 1, '127.0.0.1', '2019-03-25 02:52:05'),
	(37, 1, 'admin', 1, '127.0.0.1', '2019-03-25 05:53:50'),
	(38, 1, 'admin', 1, '127.0.0.1', '2019-03-25 08:56:17'),
	(39, 1, 'admin', 1, '127.0.0.1', '2019-03-25 12:07:01'),
	(40, 1, 'admin', 1, '127.0.0.1', '2019-03-27 11:13:31'),
	(41, 1, 'admin', 1, '127.0.0.1', '2019-03-28 13:30:30'),
	(42, 1, 'admin', 1, '127.0.0.1', '2019-04-04 03:37:58'),
	(43, 1, 'admin', 1, '127.0.0.1', '2019-11-17 06:23:33'),
	(44, 1, 'admin', 1, '127.0.0.1', '2019-11-17 07:59:48');
/*!40000 ALTER TABLE `user_logins` ENABLE KEYS */;

-- Дамп структуры для таблица safety.user_permissions
CREATE TABLE IF NOT EXISTS `user_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Дамп данных таблицы safety.user_permissions: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `user_permissions` DISABLE KEYS */;
INSERT IGNORE INTO `user_permissions` (`id`, `name`, `description`) VALUES
	(1, 'languages.list', 'Languages List Page'),
	(2, 'settings.permissions', 'Permission Page');
/*!40000 ALTER TABLE `user_permissions` ENABLE KEYS */;

-- Дамп структуры для таблица safety.user_users
CREATE TABLE IF NOT EXISTS `user_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(60) NOT NULL,
  `level_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `user_users_email_uindex` (`email`) USING BTREE,
  UNIQUE KEY `user_users_username_uindex` (`username`) USING BTREE,
  KEY `user_users_user_levels__fk` (`level_id`) USING BTREE,
  CONSTRAINT `user_users_user_levels__fk` FOREIGN KEY (`level_id`) REFERENCES `user_levels` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Дамп данных таблицы safety.user_users: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `user_users` DISABLE KEYS */;
INSERT IGNORE INTO `user_users` (`id`, `email`, `username`, `password`, `level_id`, `status`, `creation_date`) VALUES
	(1, 'kazakbaev-89@mail.ru', 'admin', '$2y$10$FEznmCetodvLsMrr5/raPuupsdZp2WxmXgYcm3TH2ZBrHq.DYGDQG', 1, 1, '2018-10-09 11:55:21');
/*!40000 ALTER TABLE `user_users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
