-- Adminer 4.2.0 MySQL dump

SET NAMES utf8mb4;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `ads_authors`;
CREATE TABLE `ads_authors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `seller_name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ads_container`;
CREATE TABLE `ads_container` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `private` tinyint(1) NOT NULL DEFAULT '0',
  `allow_mails` bit(1) NOT NULL DEFAULT b'0',
  `phone` char(11) NOT NULL,
  `location_id` char(6) NOT NULL,
  `category_id` char(3) NOT NULL,
  `title` varchar(30) NOT NULL,
  `description` varchar(500) NOT NULL,
  `price` int(9) NOT NULL DEFAULT '0',
  `author_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `cat_id` varchar(3) NOT NULL,
  `category` varchar(30) NOT NULL,
  `parent_id` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`cat_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `categories` (`cat_id`, `category`, `parent_id`) VALUES
('11',	'Автомобили с пробегом',	1),
('12',	'Новые автомобили',	1),
('13',	'Мотоциклы и мототехника',	1),
('14',	'Грузовики и спецтехника',	1),
('15',	'Водный транспорт',	1),
('16',	'Запчасти и аксессуары',	1),
('21',	'Квартиры',	2),
('22',	'Комнаты',	2),
('23',	'Дома, дачи, коттеджи',	2),
('24',	'Земельные участки',	2),
('25',	'Гаражи и машиноместа',	2),
('26',	'Коммерческая недвижимость',	2),
('27',	'Недвижимость за рубежом',	2),
('31',	'Вакансии (поиск сотрудников)',	3),
('32',	'Резюме (поиск работы)',	3),
('41',	'Предложения услуг',	4),
('42',	'Запросы на услуги',	4),
('51',	'Одежда, обувь, аксессуары',	5),
('52',	'Детская одежда и обувь',	5),
('53',	'Товары для детей и игрушки',	5),
('54',	'Часы и украшения',	5),
('55',	'Красота и здоровье',	5),
('61',	'Бытовая техника',	6),
('62',	'Мебель и интерьер',	6),
('63',	'Посуда и товары для кухни',	6),
('64',	'Продукты питания',	6),
('65',	'Ремонт и строительство',	6),
('66',	'Растения',	6),
('71',	'Аудио и видео',	7),
('72',	'Игры, приставки и программы',	7),
('73',	'Настольные компьютеры',	7),
('74',	'Ноутбуки',	7),
('75',	'Оргтехника и расходники',	7),
('76',	'Планшеты и электронные книги',	7),
('77',	'Телефоны',	7),
('78',	'Товары для компьютера',	7),
('79',	'Фототехника',	7),
('81',	'Билеты и путешествия',	8),
('82',	'Велосипеды',	8),
('83',	'Книги и журналы',	8),
('84',	'Коллекционирование',	8),
('85',	'Музыкальные инструменты',	8),
('86',	'Охота и рыбалка',	8),
('87',	'Спорт и отдых',	8),
('88',	'Знакомства',	8),
('91',	'Собаки',	9),
('92',	'Кошки',	9),
('93',	'Птицы',	9),
('94',	'Аквариум',	9),
('95',	'Другие животные',	9),
('101',	'Товары для животных',	10),
('102',	'Готовый бизнес',	10),
('103',	'Оборудование для бизнеса',	10),
('1',	'Транспорт',	NULL),
('2',	'Недвижимость',	NULL),
('3',	'Работа',	NULL),
('4',	'Услуги',	NULL),
('5',	'Личные вещи',	NULL),
('6',	'Для дома и дачи',	NULL),
('7',	'Бытовая электроника',	NULL),
('8',	'Хобби и отдых',	NULL),
('9',	'Животные',	NULL),
('10',	'Для бизнеса',	NULL);

DROP TABLE IF EXISTS `cities`;
CREATE TABLE `cities` (
  `city_id` char(6) NOT NULL,
  `city_name` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `cities` (`city_id`, `city_name`) VALUES
('641780',	'Новосибирск'),
('641490',	'Барабинск'),
('641510',	'Бердск'),
('641600',	'Искитим'),
('641630',	'Колывань'),
('641680',	'Краснообск'),
('641710',	'Куйбышев'),
('641760',	'Мошково'),
('641790',	'Обь'),
('641800',	'Ордынское'),
('641970',	'Черепаново');

-- 2015-05-16 17:05:14
