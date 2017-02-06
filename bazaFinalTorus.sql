-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Wersja serwera:               10.1.19-MariaDB - mariadb.org binary distribution
-- Serwer OS:                    Win32
-- HeidiSQL Wersja:              9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Zrzut struktury bazy danych kkurdziel
CREATE DATABASE IF NOT EXISTS `kkurdziel` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `kkurdziel`;

-- Zrzut struktury tabela kkurdziel.absence
CREATE TABLE IF NOT EXISTS `absence` (
  `abs_id` int(11) NOT NULL AUTO_INCREMENT,
  `st_id` int(11) NOT NULL,
  `cour_id` int(11) NOT NULL,
  `absence_date` date NOT NULL,
  `abt_id` int(11) NOT NULL,
  `comment` varchar(400) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`abs_id`),
  KEY `Absence_fk0` (`st_id`),
  KEY `Absence_fk1` (`cour_id`),
  KEY `Absence_fk2` (`abt_id`),
  CONSTRAINT `FK_absence_absence_type` FOREIGN KEY (`abt_id`) REFERENCES `absence_type` (`ab_id`),
  CONSTRAINT `FK_absence_course` FOREIGN KEY (`cour_id`) REFERENCES `course` (`cour_id`),
  CONSTRAINT `FK_absence_student` FOREIGN KEY (`st_id`) REFERENCES `student` (`st_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Zrzucanie danych dla tabeli kkurdziel.absence: ~6 rows (około)
DELETE FROM `absence`;
/*!40000 ALTER TABLE `absence` DISABLE KEYS */;
INSERT INTO `absence` (`abs_id`, `st_id`, `cour_id`, `absence_date`, `abt_id`, `comment`) VALUES
	(5, 38, 3, '2017-02-02', 2, ''),
	(6, 39, 5, '2017-02-03', 2, 'Nieobecny cały dzień'),
	(7, 38, 5, '2017-01-18', 3, 'Chory'),
	(8, 38, 5, '2017-01-04', 3, 'Sprawdzian w tym dniu - do napisania'),
	(9, 38, 5, '2017-02-04', 4, 'Ucieczka z zajęć'),
	(10, 38, 3, '2017-01-04', 1, '');
/*!40000 ALTER TABLE `absence` ENABLE KEYS */;

-- Zrzut struktury tabela kkurdziel.absence_type
CREATE TABLE IF NOT EXISTS `absence_type` (
  `ab_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ab_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Zrzucanie danych dla tabeli kkurdziel.absence_type: ~5 rows (około)
DELETE FROM `absence_type`;
/*!40000 ALTER TABLE `absence_type` DISABLE KEYS */;
INSERT INTO `absence_type` (`ab_id`, `type`) VALUES
	(1, 'Usprawiedliwiona'),
	(2, 'Nieusprawiedliwiona'),
	(3, 'Zwolnienie lekarskie'),
	(4, 'Wagary');
/*!40000 ALTER TABLE `absence_type` ENABLE KEYS */;

-- Zrzut struktury tabela kkurdziel.class
CREATE TABLE IF NOT EXISTS `class` (
  `class_id` int(11) NOT NULL AUTO_INCREMENT,
  `section` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `year_started` int(4) NOT NULL,
  `year` int(1) DEFAULT NULL,
  `active` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`class_id`),
  UNIQUE KEY `unique_year_section` (`section`,`year_started`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Zrzucanie danych dla tabeli kkurdziel.class: ~16 rows (około)
DELETE FROM `class`;
/*!40000 ALTER TABLE `class` DISABLE KEYS */;
INSERT INTO `class` (`class_id`, `section`, `year_started`, `year`, `active`) VALUES
	(6, 'A', 2009, 6, 'N'),
	(7, 'B', 2009, 6, 'N'),
	(8, 'A', 2010, 6, 'N'),
	(9, 'B', 2010, 6, 'N'),
	(10, 'A', 2011, 6, 'T'),
	(11, 'B', 2011, 6, 'T'),
	(12, 'A', 2012, 5, 'T'),
	(13, 'B', 2012, 5, 'T'),
	(14, 'A', 2013, 4, 'T'),
	(15, 'B', 2013, 4, 'T'),
	(16, 'A', 2014, 3, 'T'),
	(17, 'B', 2014, 3, 'T'),
	(18, 'A', 2015, 2, 'T'),
	(19, 'B', 2015, 2, 'T'),
	(20, 'A', 2016, 1, 'T'),
	(21, 'B', 2016, 1, 'T');
/*!40000 ALTER TABLE `class` ENABLE KEYS */;

-- Zrzut struktury tabela kkurdziel.class_course
CREATE TABLE IF NOT EXISTS `class_course` (
  `class_course_id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  PRIMARY KEY (`class_course_id`),
  UNIQUE KEY `class_id` (`class_id`,`course_id`),
  KEY `Class_Course_fk0` (`class_id`),
  KEY `Class_Course_fk1` (`course_id`),
  CONSTRAINT `Class_Course_fk0` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`),
  CONSTRAINT `FK_class_course_course` FOREIGN KEY (`course_id`) REFERENCES `course` (`cour_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Zrzucanie danych dla tabeli kkurdziel.class_course: ~12 rows (około)
DELETE FROM `class_course`;
/*!40000 ALTER TABLE `class_course` DISABLE KEYS */;
INSERT INTO `class_course` (`class_course_id`, `class_id`, `course_id`) VALUES
	(2, 20, 1),
	(4, 20, 2),
	(5, 20, 3),
	(6, 20, 4),
	(7, 20, 5),
	(8, 20, 6),
	(10, 21, 7),
	(11, 21, 8),
	(12, 21, 9),
	(13, 21, 10),
	(14, 21, 11),
	(16, 21, 12);
/*!40000 ALTER TABLE `class_course` ENABLE KEYS */;

-- Zrzut struktury tabela kkurdziel.course
CREATE TABLE IF NOT EXISTS `course` (
  `cour_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `year` int(4) NOT NULL,
  PRIMARY KEY (`cour_id`),
  KEY `FK_course_course_type` (`type_id`),
  CONSTRAINT `FK_course_course_type` FOREIGN KEY (`type_id`) REFERENCES `course_type` (`cour_tp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Zrzucanie danych dla tabeli kkurdziel.course: ~12 rows (około)
DELETE FROM `course`;
/*!40000 ALTER TABLE `course` DISABLE KEYS */;
INSERT INTO `course` (`cour_id`, `type_id`, `year`) VALUES
	(1, 17, 2016),
	(2, 14, 2016),
	(3, 19, 2016),
	(4, 16, 2016),
	(5, 20, 2016),
	(6, 15, 2016),
	(7, 17, 2016),
	(8, 14, 2016),
	(9, 19, 2016),
	(10, 16, 2016),
	(11, 20, 2016),
	(12, 15, 2016);
/*!40000 ALTER TABLE `course` ENABLE KEYS */;

-- Zrzut struktury tabela kkurdziel.course_type
CREATE TABLE IF NOT EXISTS `course_type` (
  `cour_tp_id` int(11) NOT NULL AUTO_INCREMENT,
  `course_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`cour_tp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Zrzucanie danych dla tabeli kkurdziel.course_type: ~22 rows (około)
DELETE FROM `course_type`;
/*!40000 ALTER TABLE `course_type` DISABLE KEYS */;
INSERT INTO `course_type` (`cour_tp_id`, `course_name`) VALUES
	(1, 'Język polski'),
	(2, 'Język angielski'),
	(3, 'Język niemiecki'),
	(4, 'Język rosyjski'),
	(5, 'Matematyka'),
	(6, 'Muzyka'),
	(7, 'Plastyka'),
	(8, 'Historia i Społeczeństwo'),
	(9, 'Przyroda'),
	(10, 'Zajęcia komputerowe'),
	(11, 'Zajęcia techniczne'),
	(12, 'Wychowanie Fizyczne'),
	(13, 'Zajęcia z wychowawcą'),
	(14, 'Edukacja polonistyczna'),
	(15, 'Edukacja społeczna'),
	(16, 'Edukacja przyrodnicza'),
	(17, 'Edukacja matematyczna'),
	(18, 'Zajęcia techniczne'),
	(19, 'Edukacja muzyczna'),
	(20, 'Edukacja plastyczna'),
	(21, 'Religia'),
	(22, 'Etyka');
/*!40000 ALTER TABLE `course_type` ENABLE KEYS */;

-- Zrzut struktury tabela kkurdziel.exam
CREATE TABLE IF NOT EXISTS `exam` (
  `ex_id` int(11) NOT NULL AUTO_INCREMENT,
  `cour_id` int(11) NOT NULL,
  `ex_type_id` int(11) DEFAULT NULL,
  `nazwa` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `comment` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ex_id`),
  KEY `Exam_fk0` (`cour_id`),
  KEY `Exam_fk1` (`ex_type_id`),
  CONSTRAINT `FK_exam_course` FOREIGN KEY (`cour_id`) REFERENCES `course` (`cour_id`),
  CONSTRAINT `FK_exam_exam_type` FOREIGN KEY (`ex_type_id`) REFERENCES `exam_type` (`ext_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Zrzucanie danych dla tabeli kkurdziel.exam: ~15 rows (około)
DELETE FROM `exam`;
/*!40000 ALTER TABLE `exam` DISABLE KEYS */;
INSERT INTO `exam` (`ex_id`, `cour_id`, `ex_type_id`, `nazwa`, `comment`) VALUES
	(1, 5, NULL, 'Sprawdzian 1', 'Pierwszy sprawdzian'),
	(2, 5, NULL, 'Sprawdzian 2', 'Drugi sprawdzian'),
	(3, 5, NULL, 'asd', NULL),
	(6, 5, NULL, 'aw', NULL),
	(7, 3, NULL, 'asd3', NULL),
	(8, 3, NULL, 'mk', NULL),
	(14, 5, NULL, 'tewadas', 'kom'),
	(15, 5, NULL, 'sss', 'sss23'),
	(16, 3, NULL, 'egz', 'asd'),
	(17, 3, NULL, 'asd', ' w'),
	(20, 2, NULL, 'Test 1', 'Test 1'),
	(22, 3, NULL, 'Test', ' test ogólny'),
	(23, 3, NULL, 'Test2', NULL),
	(24, 3, NULL, 'Test', NULL),
	(25, 9, NULL, 'Odpowiedź ustna', 'Pierwsza odpowiedź'),
	(26, 8, NULL, 'Test 1', 'Test');
/*!40000 ALTER TABLE `exam` ENABLE KEYS */;

-- Zrzut struktury tabela kkurdziel.exam_result
CREATE TABLE IF NOT EXISTS `exam_result` (
  `ex_res` int(11) NOT NULL AUTO_INCREMENT,
  `ex_id` int(11) NOT NULL,
  `t_id` int(11) NOT NULL,
  `st_id` int(11) NOT NULL,
  `mark` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `comment` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mark_time` date NOT NULL,
  PRIMARY KEY (`ex_res`),
  KEY `FK_exam_result_exam` (`ex_id`),
  KEY `FK_exam_result_student` (`st_id`),
  KEY `FK_exam_result_mark` (`mark`),
  KEY `FK_exam_result_teacher` (`t_id`),
  CONSTRAINT `FK_exam_result_exam` FOREIGN KEY (`ex_id`) REFERENCES `exam` (`ex_id`),
  CONSTRAINT `FK_exam_result_student` FOREIGN KEY (`st_id`) REFERENCES `student` (`st_id`),
  CONSTRAINT `FK_exam_result_teacher` FOREIGN KEY (`t_id`) REFERENCES `teacher` (`t_id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Zrzucanie danych dla tabeli kkurdziel.exam_result: ~26 rows (około)
DELETE FROM `exam_result`;
/*!40000 ALTER TABLE `exam_result` DISABLE KEYS */;
INSERT INTO `exam_result` (`ex_res`, `ex_id`, `t_id`, `st_id`, `mark`, `comment`, `mark_time`) VALUES
	(1, 1, 40, 38, '4+', NULL, '2017-02-04'),
	(3, 2, 40, 39, '0', NULL, '2017-02-04'),
	(4, 1, 40, 39, '4-', NULL, '2017-02-04'),
	(5, 2, 40, 38, '4', NULL, '2017-02-04'),
	(6, 3, 40, 39, '4', NULL, '2017-02-04'),
	(8, 6, 40, 39, '2', NULL, '2017-02-05'),
	(9, 7, 40, 38, '3', 'test3', '2017-02-05'),
	(10, 7, 40, 39, '2+', 'test4', '2017-02-05'),
	(11, 6, 40, 38, '3', NULL, '2017-02-05'),
	(12, 8, 40, 38, '3', NULL, '2017-02-05'),
	(13, 8, 40, 39, '4+', NULL, '2017-02-05'),
	(19, 3, 40, 38, '1', NULL, '2017-02-05'),
	(22, 14, 40, 38, '2-', NULL, '2017-02-05'),
	(25, 15, 40, 39, '2-', NULL, '2017-02-05'),
	(27, 16, 40, 39, '2+', 'test4', '2017-02-06'),
	(28, 17, 40, 38, '1', 'Słabo', '2017-02-06'),
	(29, 17, 40, 39, '2', 'Słabo2', '2017-02-06'),
	(31, 16, 40, 38, '1', 'test', '2017-02-06'),
	(32, 20, 14, 38, '2', 'Słąbo', '2017-02-06'),
	(35, 22, 40, 38, '2', '', '2017-02-06'),
	(36, 22, 40, 39, '3', 'Słabo', '2017-02-06'),
	(37, 23, 40, 39, '2', ' www', '2017-02-06'),
	(38, 24, 40, 38, '1+', '', '2017-02-06'),
	(39, 7, 40, 43, '3-', '', '2017-02-06'),
	(40, 25, 40, 82, '4', '', '2017-02-06'),
	(41, 25, 40, 79, '6', 'Brawo', '2017-02-06'),
	(42, 26, 14, 82, '3-', 'Ok', '2017-02-06'),
	(43, 26, 14, 79, '3', 'Ok', '2017-02-06'),
	(44, 26, 14, 66, '0', 'Nieobecny', '2017-02-06'),
	(45, 26, 14, 44, '6-', 'Brawo', '2017-02-06');
/*!40000 ALTER TABLE `exam_result` ENABLE KEYS */;

-- Zrzut struktury tabela kkurdziel.exam_type
CREATE TABLE IF NOT EXISTS `exam_type` (
  `ext_id` int(11) NOT NULL AUTO_INCREMENT,
  `ext_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ext_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Zrzucanie danych dla tabeli kkurdziel.exam_type: ~0 rows (około)
DELETE FROM `exam_type`;
/*!40000 ALTER TABLE `exam_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `exam_type` ENABLE KEYS */;

-- Zrzut struktury tabela kkurdziel.login_history
CREATE TABLE IF NOT EXISTS `login_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `ip` varchar(39) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `time_of_login` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `failed` int(1) NOT NULL DEFAULT '0',
  `blocked_login` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Zrzucanie danych dla tabeli kkurdziel.login_history: ~5 rows (około)
DELETE FROM `login_history`;
/*!40000 ALTER TABLE `login_history` DISABLE KEYS */;
INSERT INTO `login_history` (`id`, `login`, `ip`, `time_of_login`, `failed`, `blocked_login`) VALUES
	(25, 'admin', '149.156.136.191', '2016-12-08 10:34:04', 1, 0),
	(26, 'admin', '149.156.136.191', '2016-12-08 10:37:49', 1, 1),
	(27, 'admin', '89.64.47.92', '2016-12-08 23:28:31', 0, 0),
	(28, 'asdad', '78.11.192.98', '2017-01-07 22:05:49', 1, 1),
	(29, 'admin', '78.11.192.98', '2017-01-07 22:05:54', 0, 0);
/*!40000 ALTER TABLE `login_history` ENABLE KEYS */;

-- Zrzut struktury tabela kkurdziel.parent
CREATE TABLE IF NOT EXISTS `parent` (
  `parent_id` int(11) NOT NULL,
  PRIMARY KEY (`parent_id`),
  CONSTRAINT `FK_parent_person` FOREIGN KEY (`parent_id`) REFERENCES `person` (`pr_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Zrzucanie danych dla tabeli kkurdziel.parent: ~8 rows (około)
DELETE FROM `parent`;
/*!40000 ALTER TABLE `parent` DISABLE KEYS */;
INSERT INTO `parent` (`parent_id`) VALUES
	(14),
	(44),
	(45),
	(46),
	(47),
	(67),
	(82),
	(84);
/*!40000 ALTER TABLE `parent` ENABLE KEYS */;

-- Zrzut struktury tabela kkurdziel.parent_student
CREATE TABLE IF NOT EXISTS `parent_student` (
  `parent_student_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  PRIMARY KEY (`parent_student_id`),
  UNIQUE KEY `student_id` (`student_id`,`parent_id`),
  KEY `Parent_student_fk0` (`parent_id`),
  KEY `Parent_student_fk1` (`student_id`),
  CONSTRAINT `Parent_student_fk0` FOREIGN KEY (`parent_id`) REFERENCES `parent` (`parent_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Parent_student_fk1` FOREIGN KEY (`student_id`) REFERENCES `student` (`st_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Zrzucanie danych dla tabeli kkurdziel.parent_student: ~8 rows (około)
DELETE FROM `parent_student`;
/*!40000 ALTER TABLE `parent_student` DISABLE KEYS */;
INSERT INTO `parent_student` (`parent_student_id`, `parent_id`, `student_id`) VALUES
	(1, 14, 38),
	(4, 44, 38),
	(2, 14, 39),
	(8, 67, 39),
	(10, 47, 43),
	(11, 67, 43),
	(13, 84, 72),
	(12, 14, 75);
/*!40000 ALTER TABLE `parent_student` ENABLE KEYS */;

-- Zrzut struktury tabela kkurdziel.person
CREATE TABLE IF NOT EXISTS `person` (
  `pr_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `pesel` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `mail` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `phone_nr` varchar(9) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`pr_id`),
  UNIQUE KEY `pesel` (`pesel`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Zrzucanie danych dla tabeli kkurdziel.person: ~33 rows (około)
DELETE FROM `person`;
/*!40000 ALTER TABLE `person` DISABLE KEYS */;
INSERT INTO `person` (`pr_id`, `name`, `surname`, `pesel`, `mail`, `phone_nr`) VALUES
	(1, 'Jan', 'Kowalski', '90101012345', 't@asd', '131231223'),
	(2, 'Marek', 'Nowak', '99122212343', 'asd', NULL),
	(4, 'Lucjan', 'Iksiński', '70061222333', 'asd', NULL),
	(5, 'Kordian', 'Kurdziel', '11111111111', 'kordiankurdziel@gmail.com', NULL),
	(13, 'Jan', 'Krasicki', '23232323232', 'asdasd', '232323232'),
	(14, 'Mirosław', 'Gruszka', '23123444444', 'asd', '123445555'),
	(38, 'Arkadiusz', 'Ptak', '10111111111', 'asd', '233333333'),
	(39, 'Jerzy', 'Śliwa', '99121212121', 'test', NULL),
	(40, 'Marek', 'Mickiewicz', '80101011111', 'tete', NULL),
	(41, 'Julian', 'Tuwim', '80090922222', 'asd', NULL),
	(42, 'Maria', 'Curie', '80020233333', 'tet', NULL),
	(43, 'Wanda', 'Oleszko', '12312322222', 'asd', '111111122'),
	(44, 'Anna', 'Gruszka', '13213452424', 'sdad', '123422332'),
	(45, 'Paulina', 'Sobczak', '12312312313', 'zcxzczx', '111111111'),
	(46, 'Henryk', 'Bąk', '21222222222', 'asdasd', '333333333'),
	(47, 'Kazimierz', 'Chmielewski', '12312315555', 'asd', '111111111'),
	(66, 'Ewa', 'Duda', '12323232323', 'a', '131231313'),
	(67, 'Maria', 'Kot', '21312451241', 'adas@asdads', '123131231'),
	(68, 'Jakub', 'Malinowski', '21314444444', 'asd@a', ''),
	(69, 'Czesław', 'Wróbel', '12133333333', 'asd@aab', '231123123'),
	(70, 'Maciej', 'Szczepański', '12354412315', 'a@a', ''),
	(72, 'Dorota', 'Tomaszewska', '13555555555', 'a@a', ''),
	(73, 'Anna', 'Krajewska', '76666666666', 'ads@a', ''),
	(74, 'Jerzy', 'Wróblewski', '65656533333', 'a2@w', ''),
	(75, 'Bożena', 'Baranowska', '55555544444', 'aw@wa2', ''),
	(76, 'Jerzy', 'Wróblewski', '23232354232', 'ww@ww', ''),
	(77, 'Magdalena', 'Adamczyk', '32422222222', 'ww@ww', ''),
	(78, 'Marek', 'Wiśniewski', '13242444444', 'ww@ww', ''),
	(79, 'Agata', 'Kubiak', '23444445555', 'ww@ww', ''),
	(80, 'Piotr', 'Szymański', '12314444444', 'aw@wa', ''),
	(81, 'Marcin', 'Mazurek', '33332222222', 'www@aaa', ''),
	(82, 'Maria', 'Wilska', '51312312312', 'mail@mail', '123456789'),
	(84, 'Bill', 'Mc\'Cain', '62377778888', 'test@asd', '');
/*!40000 ALTER TABLE `person` ENABLE KEYS */;

-- Zrzut struktury procedura kkurdziel.proc_dodaj_osobe
DELIMITER //
CREATE DEFINER=`kkurdziel`@`%` PROCEDURE `proc_dodaj_osobe`(
	IN `in_name` VARCHAR(100),
	IN `in_surname` VARCHAR(100),
	IN `in_pesel` VARCHAR(11),
	IN `in_mail` VARCHAR(150),
	IN `in_phone_nr` VARCHAR(9),
	IN `in_is_teacher` VARCHAR(1),
	IN `in_is_student` VARCHAR(1),
	IN `in_is_parent` VARCHAR(1),
	OUT `out_pr_id` INT





)
BEGIN
		set @cnt = (select COUNT(*) FROM person WHERE pesel like in_pesel); 
		if @cnt = 0 then
			insert into person(name, surname, pesel, mail, phone_nr) values (
				in_name, in_surname, in_pesel, in_mail, in_phone_nr);
			select LAST_INSERT_ID() into out_pr_id;
			if in_is_teacher = 't' then 
				insert into teacher(t_id) values(out_pr_id);
			end if;
			if in_is_student = 't' then 
				insert into student(st_id) values(out_pr_id);
			end if;
			if in_is_parent = 't' then 
				insert into parent(parent_id) values(out_pr_id);
			end if;
		else
			signal sqlstate '45001' set message_text = 'PeselExists';
		end if;
END//
DELIMITER ;

-- Zrzut struktury tabela kkurdziel.role_type
CREATE TABLE IF NOT EXISTS `role_type` (
  `role_id` int(10) NOT NULL AUTO_INCREMENT,
  `role` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Zrzucanie danych dla tabeli kkurdziel.role_type: ~4 rows (około)
DELETE FROM `role_type`;
/*!40000 ALTER TABLE `role_type` DISABLE KEYS */;
INSERT INTO `role_type` (`role_id`, `role`) VALUES
	(1, 'admin'),
	(2, 'teacher'),
	(3, 'student'),
	(4, 'parent');
/*!40000 ALTER TABLE `role_type` ENABLE KEYS */;

-- Zrzut struktury tabela kkurdziel.session
CREATE TABLE IF NOT EXISTS `session` (
  `ses_id` int(10) NOT NULL AUTO_INCREMENT,
  `ses_us_id` int(10) NOT NULL,
  `id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `los` varchar(39) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip` varchar(39) COLLATE utf8_unicode_ci DEFAULT NULL,
  `web` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`ses_id`),
  KEY `ses_us_id_fk` (`ses_us_id`),
  KEY `FK_session_role_type` (`role_id`),
  CONSTRAINT `FK_session_role_type` FOREIGN KEY (`role_id`) REFERENCES `role_type` (`role_id`),
  CONSTRAINT `ses_us_id_fk` FOREIGN KEY (`ses_us_id`) REFERENCES `user` (`us_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Zrzucanie danych dla tabeli kkurdziel.session: ~1 rows (około)
DELETE FROM `session`;
/*!40000 ALTER TABLE `session` DISABLE KEYS */;
/*!40000 ALTER TABLE `session` ENABLE KEYS */;

-- Zrzut struktury tabela kkurdziel.student
CREATE TABLE IF NOT EXISTS `student` (
  `st_id` int(11) NOT NULL,
  PRIMARY KEY (`st_id`),
  CONSTRAINT `FK_student_person` FOREIGN KEY (`st_id`) REFERENCES `person` (`pr_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Zrzucanie danych dla tabeli kkurdziel.student: ~13 rows (około)
DELETE FROM `student`;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` (`st_id`) VALUES
	(2),
	(38),
	(39),
	(43),
	(44),
	(47),
	(66),
	(68),
	(72),
	(73),
	(75),
	(79),
	(82);
/*!40000 ALTER TABLE `student` ENABLE KEYS */;

-- Zrzut struktury tabela kkurdziel.student_class
CREATE TABLE IF NOT EXISTS `student_class` (
  `st_cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `st_id` int(11) NOT NULL,
  `cl_id` int(11) NOT NULL,
  `data_rozp` datetime NOT NULL,
  `data_zak` datetime NOT NULL,
  `is_active` varchar(1) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Trigger przy dodawaniu/usuwaniu',
  PRIMARY KEY (`st_cl_id`),
  KEY `FK_student_class_student` (`st_id`),
  KEY `FK_student_class_class` (`cl_id`),
  CONSTRAINT `FK_student_class_class` FOREIGN KEY (`cl_id`) REFERENCES `class` (`class_id`),
  CONSTRAINT `FK_student_class_student` FOREIGN KEY (`st_id`) REFERENCES `student` (`st_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Zrzucanie danych dla tabeli kkurdziel.student_class: ~10 rows (około)
DELETE FROM `student_class`;
/*!40000 ALTER TABLE `student_class` DISABLE KEYS */;
INSERT INTO `student_class` (`st_cl_id`, `st_id`, `cl_id`, `data_rozp`, `data_zak`, `is_active`) VALUES
	(1, 38, 20, '2016-02-04 16:11:41', '0000-00-00 00:00:00', 'T'),
	(3, 39, 20, '2016-02-04 16:12:09', '0000-00-00 00:00:00', 'T'),
	(4, 43, 20, '2016-02-04 16:11:41', '0000-00-00 00:00:00', 'T'),
	(5, 47, 20, '2016-02-04 16:11:41', '0000-00-00 00:00:00', 'T'),
	(6, 82, 21, '2016-02-04 16:11:41', '0000-00-00 00:00:00', 'T'),
	(7, 2, 20, '2016-02-04 16:11:41', '0000-00-00 00:00:00', 'T'),
	(8, 75, 20, '2016-02-04 16:11:41', '0000-00-00 00:00:00', 'T'),
	(9, 79, 21, '2016-02-04 16:11:41', '0000-00-00 00:00:00', 'T'),
	(10, 66, 21, '2016-02-04 16:11:41', '0000-00-00 00:00:00', 'T'),
	(11, 44, 21, '2016-02-04 16:11:41', '0000-00-00 00:00:00', 'T');
/*!40000 ALTER TABLE `student_class` ENABLE KEYS */;

-- Zrzut struktury tabela kkurdziel.student_course
CREATE TABLE IF NOT EXISTS `student_course` (
  `sg_id` int(11) NOT NULL AUTO_INCREMENT,
  `st_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  PRIMARY KEY (`sg_id`),
  UNIQUE KEY `st_id` (`st_id`,`course_id`),
  KEY `Student_Course_fk1` (`course_id`),
  KEY `FK_student_course_student` (`st_id`),
  CONSTRAINT `FK_student_course_course` FOREIGN KEY (`course_id`) REFERENCES `course` (`cour_id`),
  CONSTRAINT `FK_student_course_student` FOREIGN KEY (`st_id`) REFERENCES `student` (`st_id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Zrzucanie danych dla tabeli kkurdziel.student_course: ~60 rows (około)
DELETE FROM `student_course`;
/*!40000 ALTER TABLE `student_course` DISABLE KEYS */;
INSERT INTO `student_course` (`sg_id`, `st_id`, `course_id`) VALUES
	(31, 2, 1),
	(32, 2, 2),
	(33, 2, 3),
	(34, 2, 4),
	(35, 2, 5),
	(36, 2, 6),
	(1, 38, 1),
	(3, 38, 2),
	(5, 38, 3),
	(7, 38, 4),
	(8, 38, 5),
	(9, 38, 6),
	(10, 39, 1),
	(12, 39, 2),
	(13, 39, 3),
	(14, 39, 4),
	(16, 39, 5),
	(17, 39, 6),
	(19, 43, 1),
	(20, 43, 2),
	(21, 43, 3),
	(22, 43, 4),
	(23, 43, 5),
	(24, 43, 6),
	(61, 44, 7),
	(62, 44, 8),
	(63, 44, 9),
	(64, 44, 10),
	(65, 44, 11),
	(66, 44, 12),
	(25, 47, 1),
	(26, 47, 2),
	(27, 47, 3),
	(28, 47, 4),
	(29, 47, 5),
	(30, 47, 6),
	(55, 66, 7),
	(56, 66, 8),
	(57, 66, 9),
	(58, 66, 10),
	(59, 66, 11),
	(60, 66, 12),
	(37, 75, 1),
	(38, 75, 2),
	(39, 75, 3),
	(40, 75, 4),
	(41, 75, 5),
	(42, 75, 6),
	(49, 79, 7),
	(50, 79, 8),
	(51, 79, 9),
	(52, 79, 10),
	(53, 79, 11),
	(54, 79, 12),
	(43, 82, 7),
	(44, 82, 8),
	(45, 82, 9),
	(46, 82, 10),
	(47, 82, 11),
	(48, 82, 12);
/*!40000 ALTER TABLE `student_course` ENABLE KEYS */;

-- Zrzut struktury tabela kkurdziel.teacher
CREATE TABLE IF NOT EXISTS `teacher` (
  `t_id` int(11) NOT NULL,
  KEY `FK_teacher_person` (`t_id`),
  CONSTRAINT `FK_teacher_person` FOREIGN KEY (`t_id`) REFERENCES `person` (`pr_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Zrzucanie danych dla tabeli kkurdziel.teacher: ~6 rows (około)
DELETE FROM `teacher`;
/*!40000 ALTER TABLE `teacher` DISABLE KEYS */;
INSERT INTO `teacher` (`t_id`) VALUES
	(13),
	(14),
	(40),
	(41),
	(42),
	(67);
/*!40000 ALTER TABLE `teacher` ENABLE KEYS */;

-- Zrzut struktury tabela kkurdziel.teacher_class
CREATE TABLE IF NOT EXISTS `teacher_class` (
  `tclass_id` int(11) NOT NULL AUTO_INCREMENT,
  `t_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  PRIMARY KEY (`tclass_id`),
  KEY `Teacher_Class_fk0` (`t_id`),
  KEY `Teacher_Class_fk1` (`class_id`),
  CONSTRAINT `Teacher_Class_fk0` FOREIGN KEY (`t_id`) REFERENCES `teacher` (`t_id`),
  CONSTRAINT `Teacher_Class_fk1` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Zrzucanie danych dla tabeli kkurdziel.teacher_class: ~0 rows (około)
DELETE FROM `teacher_class`;
/*!40000 ALTER TABLE `teacher_class` DISABLE KEYS */;
INSERT INTO `teacher_class` (`tclass_id`, `t_id`, `class_id`, `date_from`, `date_to`) VALUES
	(1, 40, 20, '2016-09-01', '2019-08-31');
/*!40000 ALTER TABLE `teacher_class` ENABLE KEYS */;

-- Zrzut struktury tabela kkurdziel.teacher_course
CREATE TABLE IF NOT EXISTS `teacher_course` (
  `tcour_id` int(11) NOT NULL AUTO_INCREMENT,
  `t_id` int(11) NOT NULL,
  `cour_id` int(11) NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  PRIMARY KEY (`tcour_id`),
  KEY `Teacher_Course_fk0` (`t_id`),
  KEY `Teacher_Course_fk1` (`cour_id`),
  CONSTRAINT `FK_teacher_course_course` FOREIGN KEY (`cour_id`) REFERENCES `course` (`cour_id`),
  CONSTRAINT `Teacher_Course_fk0` FOREIGN KEY (`t_id`) REFERENCES `teacher` (`t_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Zrzucanie danych dla tabeli kkurdziel.teacher_course: ~12 rows (około)
DELETE FROM `teacher_course`;
/*!40000 ALTER TABLE `teacher_course` DISABLE KEYS */;
INSERT INTO `teacher_course` (`tcour_id`, `t_id`, `cour_id`, `date_from`, `date_to`) VALUES
	(3, 13, 1, '2016-09-01', '2017-08-31'),
	(4, 14, 2, '2016-09-01', '2017-08-31'),
	(5, 40, 3, '2016-09-01', '2017-08-31'),
	(6, 40, 5, '2016-09-01', '2017-08-31'),
	(7, 41, 6, '2016-09-01', '2017-08-31'),
	(8, 42, 4, '2016-09-01', '2017-08-31'),
	(9, 13, 7, '2016-09-01', '2017-08-31'),
	(10, 40, 9, '2016-09-01', '2017-08-31'),
	(11, 14, 8, '2016-09-01', '2017-08-31'),
	(12, 67, 10, '2016-09-01', '2017-08-31'),
	(13, 41, 12, '2016-09-01', '2017-08-31'),
	(14, 42, 11, '2016-09-01', '2017-08-31');
/*!40000 ALTER TABLE `teacher_course` ENABLE KEYS */;

-- Zrzut struktury tabela kkurdziel.user
CREATE TABLE IF NOT EXISTS `user` (
  `us_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `hashed_pwd` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `pr_id` int(11) NOT NULL,
  PRIMARY KEY (`us_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `pr_id` (`pr_id`),
  KEY `FK_user_person` (`pr_id`),
  CONSTRAINT `FK_user_person` FOREIGN KEY (`pr_id`) REFERENCES `person` (`pr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Zrzucanie danych dla tabeli kkurdziel.user: ~22 rows (około)
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`us_id`, `username`, `hashed_pwd`, `pr_id`) VALUES
	(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1),
	(8, 'test', '21232f297a57a5a743894a0e4a801fc3', 2),
	(9, 'parent1', '21232f297a57a5a743894a0e4a801fc3', 14),
	(11, 'student1', '21232f297a57a5a743894a0e4a801fc3', 38),
	(12, 'micmac', '21232f297a57a5a743894a0e4a801fc3', 40),
	(14, 'parent2', '21232f297a57a5a743894a0e4a801fc3', 44),
	(17, 'def2', '21232f297a57a5a743894a0e4a801fc3', 69),
	(18, 'kordian', '21232f297a57a5a743894a0e4a801fc3', 5),
	(20, 'Mc\'Cain', '21232f297a57a5a743894a0e4a801fc3', 84),
	(21, 'sliwaj', '21232f297a57a5a743894a0e4a801fc3', 39),
	(22, 'iksinluc', '21232f297a57a5a743894a0e4a801fc3', 4),
	(23, 'oleszwan', '21232f297a57a5a743894a0e4a801fc3', 43),
	(24, 'tuwimjul', '21232f297a57a5a743894a0e4a801fc3', 41),
	(25, 'bakhenr', '21232f297a57a5a743894a0e4a801fc3', 46),
	(26, 'dudaewa', '21232f297a57a5a743894a0e4a801fc3', 66),
	(27, 'sobczakp', '21232f297a57a5a743894a0e4a801fc3', 45),
	(28, 'chmielk', '21232f297a57a5a743894a0e4a801fc3', 47),
	(29, 'kotm', '21232f297a57a5a743894a0e4a801fc3', 67),
	(30, 'malinj', '21232f297a57a5a743894a0e4a801fc3', 68),
	(31, 'kubiakag', '21232f297a57a5a743894a0e4a801fc3', 79),
	(32, 'krasjan', '21232f297a57a5a743894a0e4a801fc3', 13),
	(33, 'curiema', '21232f297a57a5a743894a0e4a801fc3', 42),
	(34, 'wilskm', '21232f297a57a5a743894a0e4a801fc3', 82),
	(35, 'tomdor', '21232f297a57a5a743894a0e4a801fc3', 72),
	(36, 'barboz', '21232f297a57a5a743894a0e4a801fc3', 75),
	(37, 'krąjann', '21232f297a57a5a743894a0e4a801fc3', 73);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

-- Zrzut struktury tabela kkurdziel.user_logs
CREATE TABLE IF NOT EXISTS `user_logs` (
  `ul_id` int(11) NOT NULL AUTO_INCREMENT,
  `time` datetime NOT NULL,
  `ip` varchar(39) COLLATE utf8_unicode_ci DEFAULT NULL,
  `us_username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ul_id`,`time`)
) ENGINE=InnoDB AUTO_INCREMENT=166 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
/*!50500 PARTITION BY RANGE  COLUMNS(`time`)
(PARTITION p0 VALUES LESS THAN ('2017-01-01') ENGINE = InnoDB,
 PARTITION p1 VALUES LESS THAN ('2017-02-01') ENGINE = InnoDB,
 PARTITION p2 VALUES LESS THAN ('2017-03-01') ENGINE = InnoDB,
 PARTITION p3 VALUES LESS THAN ('2017-04-01') ENGINE = InnoDB,
 PARTITION p4 VALUES LESS THAN (MAXVALUE) ENGINE = InnoDB) */;

-- Zrzucanie danych dla tabeli kkurdziel.user_logs: ~160 rows (około)
DELETE FROM `user_logs`;
/*!40000 ALTER TABLE `user_logs` DISABLE KEYS */;
INSERT INTO `user_logs` (`ul_id`, `time`, `ip`, `us_username`, `type`, `value`) VALUES
	(9, '2017-01-01 21:17:38', '::1', 'admin', 'good_login', NULL),
	(1, '2017-02-01 20:42:23', '::1', 'admin', 'bad_login', NULL),
	(2, '2017-02-01 20:44:28', '::1', 'admin', 'good_login', NULL),
	(3, '2017-02-01 20:51:48', '::1', 'admin', 'good_login', NULL),
	(10, '2017-02-01 21:18:06', '::1', 'admin', 'bad_login_u', NULL),
	(11, '2017-02-01 21:18:12', '::1', 'admin', 'good_login', NULL),
	(12, '2017-02-01 21:19:06', '::1', 'admin', 'good_login', NULL),
	(13, '2017-02-01 21:19:38', '::1', 'admin', 'good_login', NULL),
	(14, '2017-02-01 21:20:04', '::1', 'admin', 'good_login', NULL),
	(15, '2017-02-01 21:21:33', '::1', 'admin', 'good_login', NULL),
	(16, '2017-02-01 21:31:34', '::1', 'admin', 'good_login', NULL),
	(17, '2017-02-01 21:44:45', '::1', 'test', 'good_login', NULL),
	(18, '2017-02-01 21:49:00', '::1', 'admin', 'good_login', NULL),
	(19, '2017-02-01 21:50:53', '::1', 'admin', 'good_login', NULL),
	(20, '2017-02-01 22:23:07', '::1', 'admin', 'good_login', NULL),
	(21, '2017-02-01 22:25:09', '::1', 'admin', 'good_login', NULL),
	(22, '2017-02-01 22:26:21', '::1', 'admin', 'good_login', NULL),
	(23, '2017-02-01 22:52:20', '127.0.0.1', 'admin', 'good_login', NULL),
	(24, '2017-02-01 23:05:19', '::1', 'admin', 'good_login', NULL),
	(25, '2017-02-01 23:06:17', '::1', 'admin', 'good_login', NULL),
	(26, '2017-02-01 23:06:33', '::1', 'test', 'good_login', NULL),
	(27, '2017-02-01 23:37:36', '::1', 'test', 'good_login', NULL),
	(28, '2017-02-01 23:39:39', '::1', 'test', 'good_login', NULL),
	(29, '2017-02-01 23:40:25', '::1', 'test', 'good_login', NULL),
	(30, '2017-02-01 23:42:21', '::1', 'admin', 'good_login', NULL),
	(31, '2017-02-01 23:42:29', '::1', 'test', 'good_login', NULL),
	(32, '2017-02-01 23:43:14', '::1', 'test', 'good_login', NULL),
	(33, '2017-02-01 23:44:08', '::1', 'test', 'good_login', NULL),
	(34, '2017-02-01 23:45:03', '::1', 'admin', 'good_login', NULL),
	(35, '2017-02-01 23:45:10', '::1', 'test', 'good_login', NULL),
	(36, '2017-02-01 23:46:00', '::1', 'admin', 'good_login', NULL),
	(37, '2017-02-01 23:46:33', '::1', 'admin', 'good_login', NULL),
	(38, '2017-02-01 23:46:53', '::1', 'admin', 'good_login', NULL),
	(39, '2017-02-01 23:48:17', '::1', 'admin', 'good_login', NULL),
	(40, '2017-02-01 23:49:15', '::1', 'test', 'good_login', NULL),
	(41, '2017-02-01 23:57:24', '::1', 'admin', 'good_login', NULL),
	(42, '2017-02-02 00:03:28', '::1', 'admin', 'good_login', NULL),
	(43, '2017-02-02 00:09:06', '::1', 'admin', 'good_login', NULL),
	(44, '2017-02-02 00:15:33', '::1', 'admin', 'good_login', NULL),
	(45, '2017-02-02 00:16:23', '::1', 'test', 'good_login', NULL),
	(46, '2017-02-02 00:20:08', '::1', 'admin', 'good_login', NULL),
	(47, '2017-02-02 00:21:24', '::1', 'test', 'good_login', NULL),
	(48, '2017-02-02 20:08:55', '::1', 'test', 'good_login', NULL),
	(49, '2017-02-02 20:18:36', '::1', 'admin', 'good_login', NULL),
	(50, '2017-02-02 21:02:14', '::1', 'admin', 'good_login', NULL),
	(51, '2017-02-02 23:36:49', '::1', 'admin', 'good_login', NULL),
	(52, '2017-02-02 23:40:49', '::1', 'admin', 'good_login', NULL),
	(53, '2017-02-04 00:38:35', '::1', 'admin', 'good_login', NULL),
	(54, '2017-02-04 00:47:42', '::1', 'admin', 'good_login', NULL),
	(55, '2017-02-04 12:45:58', '::1', 'admin', 'bad_login_u', NULL),
	(56, '2017-02-04 12:46:03', '::1', 'admin', 'good_login', NULL),
	(57, '2017-02-04 13:50:41', '::1', 'test', 'good_login', NULL),
	(58, '2017-02-04 13:51:09', '::1', 'test', 'bad_login_u', NULL),
	(59, '2017-02-04 13:51:15', '::1', 'test', 'good_login', NULL),
	(60, '2017-02-04 13:52:39', '::1', 'admin', 'good_login', NULL),
	(61, '2017-02-04 13:53:51', '::1', 'test3', 'bad_login_u', NULL),
	(62, '2017-02-04 13:54:01', '::1', 'test3', 'good_login', NULL),
	(63, '2017-02-04 15:28:18', '::1', 'admin', 'good_login', NULL),
	(64, '2017-02-04 16:55:30', '::1', 'student1', 'good_login', NULL),
	(65, '2017-02-04 19:07:33', '::1', 'admin', 'good_login', NULL),
	(66, '2017-02-04 20:58:01', '::1', 'micmac', 'good_login', NULL),
	(67, '2017-02-04 23:40:00', '::1', 'student3', 'bad_login', NULL),
	(68, '2017-02-04 23:40:37', '::1', 'student1', 'good_login', NULL),
	(69, '2017-02-04 23:50:54', '::1', 'micmac', 'good_login', NULL),
	(70, '2017-02-05 11:12:06', '::1', 'test', 'bad_login_u', NULL),
	(71, '2017-02-05 11:12:10', '::1', 'test', 'good_login', NULL),
	(72, '2017-02-05 11:12:32', '::1', 'micmac', 'good_login', NULL),
	(73, '2017-02-05 11:54:37', '::1', 'student1', 'good_login', NULL),
	(74, '2017-02-05 14:10:03', '::1', 'admin', 'good_login', NULL),
	(75, '2017-02-05 14:14:18', '::1', 'noscript', 'good_login', NULL),
	(76, '2017-02-05 14:15:16', '::1', 'admin', 'good_login', NULL),
	(77, '2017-02-05 14:18:48', '::1', 'noscript', 'good_login', NULL),
	(78, '2017-02-05 14:21:17', '::1', 'noscript', 'good_login', NULL),
	(79, '2017-02-05 14:24:41', '::1', 'admin', 'bad_login_u', NULL),
	(80, '2017-02-05 14:24:49', '::1', '<noscript>', 'bad_login', NULL),
	(81, '2017-02-05 14:24:55', '::1', 'admin', 'good_login', NULL),
	(82, '2017-02-05 14:29:20', '::1', 'student1', 'good_login', NULL),
	(83, '2017-02-05 15:01:29', '::1', 'micmac', 'good_login', NULL),
	(84, '2017-02-05 16:32:31', '::1', 'student1', 'good_login', NULL),
	(85, '2017-02-05 16:33:23', '::1', 'student1', 'good_login', NULL),
	(86, '2017-02-05 17:10:29', '::1', 'parent1', 'good_login', NULL),
	(87, '2017-02-05 17:56:01', '::1', 'admin', 'good_login', NULL),
	(88, '2017-02-05 17:56:42', '::1', 'parent2', 'good_login', NULL),
	(89, '2017-02-05 18:20:44', '::1', 'parent1', 'good_login', NULL),
	(90, '2017-02-05 19:01:54', '::1', 'parent2', 'good_login', NULL),
	(91, '2017-02-05 19:39:21', '::1', 'admin', 'good_login', NULL),
	(92, '2017-02-05 20:21:41', '::1', 'parent4', 'good_login', NULL),
	(93, '2017-02-05 20:28:05', '::1', 'admin', 'good_login', NULL),
	(94, '2017-02-05 22:09:15', '::1', 'asdzxca', 'bad_login', NULL),
	(95, '2017-02-05 22:13:11', '::1', 'admin', 'good_login', NULL),
	(96, '2017-02-05 23:13:37', '::1', 'test', 'bad_login_u', NULL),
	(97, '2017-02-05 23:13:41', '::1', 'test', 'good_login', NULL),
	(98, '2017-02-05 23:38:23', '::1', 'micmac', 'good_login', NULL),
	(99, '2017-02-05 23:44:18', '::1', 'admin', 'good_login', NULL),
	(100, '2017-02-06 00:46:20', '::1', 'admin', 'good_login', NULL),
	(101, '2017-02-06 03:15:15', '::1', 'parent1', 'good_login', NULL),
	(102, '2017-02-06 03:22:37', '::1', 'admin', 'good_login', NULL),
	(103, '2017-02-06 10:42:58', '::1', 'parent1', 'bad_login_u', NULL),
	(104, '2017-02-06 10:43:06', '::1', 'parent1', 'good_login', NULL),
	(105, '2017-02-06 11:43:16', '::1', 'student1', 'bad_login_u', NULL),
	(106, '2017-02-06 11:43:22', '::1', 'student1', 'bad_login_u', NULL),
	(107, '2017-02-06 11:44:15', '::1', 'student1', 'good_login', NULL),
	(108, '2017-02-06 12:30:19', '::1', 'parent1', 'good_login', NULL),
	(109, '2017-02-06 12:42:02', '::1', 'admin', 'good_login', NULL),
	(110, '2017-02-06 12:46:52', '::1', 'test', 'good_login', NULL),
	(111, '2017-02-06 12:48:05', '::1', 'micmac', 'good_login', NULL),
	(112, '2017-02-06 12:52:08', '::1', 'admin', 'good_login', NULL),
	(113, '2017-02-06 12:54:33', '::1', 'def2', 'bad_login_u', NULL),
	(114, '2017-02-06 12:54:50', '::1', 'def2', 'good_login', NULL),
	(115, '2017-02-06 12:59:22', '::1', 'micmac', 'good_login', NULL),
	(116, '2017-02-06 13:44:44', '::1', 'micmac', 'good_login', NULL),
	(117, '2017-02-06 13:49:02', '::1', 'micmac', 'good_login', NULL),
	(118, '2017-02-06 14:23:16', '::1', 'parent2', 'good_login', NULL),
	(119, '2017-02-06 14:23:44', '::1', 'parent1', 'good_login', NULL),
	(120, '2017-02-06 14:33:37', '::1', 'micmac', 'good_login', NULL),
	(121, '2017-02-06 15:05:35', '::1', 'student1', 'good_login', NULL),
	(122, '2017-02-06 15:07:47', '::1', 'micmac', 'good_login', NULL),
	(123, '2017-02-06 15:17:47', '::1', 'parent1', 'good_login', NULL),
	(124, '2017-02-06 15:34:47', '::1', 'parent1', 'good_login', NULL),
	(125, '2017-02-06 15:35:40', '::1', 'parent2', 'good_login', NULL),
	(126, '2017-02-06 15:59:22', '::1', 'micmac', 'good_login', NULL),
	(127, '2017-02-06 16:44:18', '::1', 'admin', 'good_login', NULL),
	(128, '2017-02-06 17:15:49', '::1', 'admin', 'bad_login_u', NULL),
	(129, '2017-02-06 17:19:56', '::1', 'admin', 'good_login', NULL),
	(130, '2017-02-06 17:26:08', '::1', 'asd', 'bad_login', NULL),
	(131, '2017-02-06 17:29:41', '::1', 'asd', 'bad_login', NULL),
	(132, '2017-02-06 17:30:56', '::1', 'asd', 'bad_login', NULL),
	(133, '2017-02-06 17:33:15', '::1', 'asd', 'bad_login', NULL),
	(134, '2017-02-06 17:33:35', '::1', 'ad', 'bad_login', NULL),
	(135, '2017-02-06 17:34:11', '::1', 'asd', 'bad_login', NULL),
	(136, '2017-02-06 17:34:50', '::1', 'asd', 'bad_login', NULL),
	(137, '2017-02-06 17:34:59', '::1', 'asd', 'bad_login', NULL),
	(138, '2017-02-06 17:35:12', '::1', 'asd', 'bad_login', NULL),
	(139, '2017-02-06 17:35:52', '::1', 'admin', 'bad_login_u', NULL),
	(140, '2017-02-06 17:36:47', '::1', 'admin', 'good_login', NULL),
	(141, '2017-02-06 17:48:46', '::1', 'admin', 'good_login', NULL),
	(142, '2017-02-06 18:39:25', '::1', 'micmac', 'good_login', NULL),
	(143, '2017-02-06 18:53:44', '::1', 'admin', 'good_login', NULL),
	(144, '2017-02-06 18:54:24', '::1', 'admin', 'good_login', NULL),
	(145, '2017-02-06 19:19:43', '::1', 'micmac', 'good_login', NULL),
	(146, '2017-02-06 19:55:10', '::1', 'admin', 'good_login', NULL),
	(147, '2017-02-06 20:12:42', '::1', '', 'password_change', 'c84258e9c39059a89ab77d846ddab909'),
	(148, '2017-02-06 20:13:39', '::1', 'admin', 'password_change', 'c84258e9c39059a89ab77d846ddab909'),
	(149, '2017-02-06 20:13:57', '::1', 'admin', 'password_change', 'c84258e9c39059a89ab77d846ddab909'),
	(150, '2017-02-06 20:28:34', '::1', 'kordian', 'bad_login_u', NULL),
	(151, '2017-02-06 20:28:47', '::1', 'kordian', 'bad_login_u', NULL),
	(152, '2017-02-06 20:28:59', '::1', 'kordian', 'bad_login_u', NULL),
	(153, '2017-02-06 20:29:20', '::1', 'kordian', 'good_login', NULL),
	(154, '2017-02-06 20:35:04', '::1', 'admin', 'good_login', NULL),
	(155, '2017-02-06 21:08:50', '::1', 'asdasd', 'account_remove', NULL),
	(156, '2017-02-06 21:32:19', '::1', 'Mc\'Cain', 'good_login', NULL),
	(157, '2017-02-06 22:09:02', '::1', 'micmac', 'good_login', NULL),
	(158, '2017-02-06 22:14:37', '::1', 'admin', 'good_login', NULL),
	(159, '2017-02-06 22:34:30', '::1', 'test2', 'account_remove', NULL),
	(160, '2017-02-06 22:35:06', '::1', 'def1', 'account_remove', NULL),
	(161, '2017-02-06 22:35:47', '::1', 'micmac', 'good_login', NULL),
	(162, '2017-02-06 22:38:25', '::1', 'oleszwan', 'good_login', NULL),
	(163, '2017-02-06 22:50:42', '::1', 'kordian', 'good_login', NULL),
	(164, '2017-02-06 22:55:11', '::1', 'parent1', 'good_login', NULL),
	(165, '2017-02-06 22:56:24', '::1', 'parent2', 'good_login', NULL);
/*!40000 ALTER TABLE `user_logs` ENABLE KEYS */;

-- Zrzut struktury tabela kkurdziel.user_role
CREATE TABLE IF NOT EXISTS `user_role` (
  `usrole_id` int(10) NOT NULL AUTO_INCREMENT,
  `us_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`usrole_id`),
  KEY `User_Role_fk0` (`us_id`),
  KEY `User_Role_fk1` (`role_id`),
  CONSTRAINT `User_Role_fk0` FOREIGN KEY (`us_id`) REFERENCES `user` (`us_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `User_Role_fk1` FOREIGN KEY (`role_id`) REFERENCES `role_type` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Zrzucanie danych dla tabeli kkurdziel.user_role: ~21 rows (około)
DELETE FROM `user_role`;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
INSERT INTO `user_role` (`usrole_id`, `us_id`, `role_id`) VALUES
	(1, 1, 1),
	(2, 8, 1),
	(3, 8, 2),
	(4, 9, 2),
	(5, 9, 4),
	(7, 11, 3),
	(8, 12, 2),
	(10, 14, 4),
	(13, 20, 4),
	(14, 21, 3),
	(15, 23, 3),
	(16, 24, 2),
	(17, 25, 4),
	(18, 27, 4),
	(19, 28, 4),
	(20, 29, 2),
	(21, 29, 4),
	(22, 32, 2),
	(23, 33, 2),
	(24, 18, 1),
	(25, 32, 2),
	(26, 34, 3),
	(27, 34, 4),
	(28, 35, 3),
	(29, 36, 3),
	(30, 37, 3),
	(31, 14, 3);
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;

-- Zrzut struktury zdarzenie kkurdziel.usun_stare_sesje
DELIMITER //
CREATE DEFINER=`kkurdziel`@`%` EVENT `usun_stare_sesje` ON SCHEDULE EVERY 1 HOUR STARTS '2017-01-30 00:53:12' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
	delete from kkurdziel.session where TIMESTAMPDIFF(MINUTE, time, now()) > 60;
END//
DELIMITER ;

-- Zrzut struktury widok kkurdziel.v_absence
-- Tworzenie tymczasowej tabeli aby przezwyciężyć błędy z zależnościami w WIDOKU
CREATE TABLE `v_absence` (
	`st_id` INT(11) NOT NULL,
	`name` VARCHAR(100) NOT NULL COLLATE 'utf8_unicode_ci',
	`surname` VARCHAR(100) NOT NULL COLLATE 'utf8_unicode_ci',
	`pesel` VARCHAR(11) NOT NULL COLLATE 'utf8_unicode_ci',
	`cour_id` INT(11) NOT NULL,
	`course_name` VARCHAR(50) NOT NULL COLLATE 'utf8_unicode_ci',
	`type` VARCHAR(100) NOT NULL COLLATE 'utf8_unicode_ci',
	`absence_date` DATE NOT NULL,
	`comment` VARCHAR(400) NULL COLLATE 'utf8_unicode_ci'
) ENGINE=MyISAM;

-- Zrzut struktury widok kkurdziel.v_class_course
-- Tworzenie tymczasowej tabeli aby przezwyciężyć błędy z zależnościami w WIDOKU
CREATE TABLE `v_class_course` (
	`class_id` INT(11) NOT NULL,
	`section` VARCHAR(1) NOT NULL COLLATE 'utf8_unicode_ci',
	`year_started` INT(4) NOT NULL,
	`class_y_now` INT(1) NULL,
	`active` VARCHAR(1) NULL COLLATE 'utf8_unicode_ci',
	`course_name` VARCHAR(50) NOT NULL COLLATE 'utf8_unicode_ci',
	`course_y_started` INT(4) NOT NULL
) ENGINE=MyISAM;

-- Zrzut struktury widok kkurdziel.v_course
-- Tworzenie tymczasowej tabeli aby przezwyciężyć błędy z zależnościami w WIDOKU
CREATE TABLE `v_course` (
	`cour_id` INT(11) NOT NULL,
	`year` INT(4) NOT NULL,
	`course_name` VARCHAR(50) NOT NULL COLLATE 'utf8_unicode_ci'
) ENGINE=MyISAM;

-- Zrzut struktury widok kkurdziel.v_course_mark
-- Tworzenie tymczasowej tabeli aby przezwyciężyć błędy z zależnościami w WIDOKU
CREATE TABLE `v_course_mark` (
	`st_id` INT(11) NOT NULL,
	`cour_id` INT(11) NOT NULL,
	`nazwa` VARCHAR(50) NOT NULL COLLATE 'utf8_unicode_ci',
	`mark` VARCHAR(3) NULL COLLATE 'utf8_unicode_ci',
	`comment` VARCHAR(500) NULL COLLATE 'utf8_unicode_ci'
) ENGINE=MyISAM;

-- Zrzut struktury widok kkurdziel.v_parent
-- Tworzenie tymczasowej tabeli aby przezwyciężyć błędy z zależnościami w WIDOKU
CREATE TABLE `v_parent` (
	`parent_id` INT(11) NOT NULL,
	`name` VARCHAR(100) NOT NULL COLLATE 'utf8_unicode_ci',
	`surname` VARCHAR(100) NOT NULL COLLATE 'utf8_unicode_ci',
	`pesel` VARCHAR(11) NOT NULL COLLATE 'utf8_unicode_ci'
) ENGINE=MyISAM;

-- Zrzut struktury widok kkurdziel.v_parent_student
-- Tworzenie tymczasowej tabeli aby przezwyciężyć błędy z zależnościami w WIDOKU
CREATE TABLE `v_parent_student` (
	`parent_id` INT(11) NOT NULL,
	`par_name` VARCHAR(100) NOT NULL COLLATE 'utf8_unicode_ci',
	`par_surname` VARCHAR(100) NOT NULL COLLATE 'utf8_unicode_ci',
	`st_id` INT(11) NOT NULL,
	`st_name` VARCHAR(100) NOT NULL COLLATE 'utf8_unicode_ci',
	`st_surname` VARCHAR(100) NOT NULL COLLATE 'utf8_unicode_ci'
) ENGINE=MyISAM;

-- Zrzut struktury widok kkurdziel.v_person_user
-- Tworzenie tymczasowej tabeli aby przezwyciężyć błędy z zależnościami w WIDOKU
CREATE TABLE `v_person_user` (
	`pr_id` INT(11) NOT NULL,
	`name` VARCHAR(100) NOT NULL COLLATE 'utf8_unicode_ci',
	`surname` VARCHAR(100) NOT NULL COLLATE 'utf8_unicode_ci',
	`pesel` VARCHAR(11) NOT NULL COLLATE 'utf8_unicode_ci',
	`mail` VARCHAR(150) NOT NULL COLLATE 'utf8_unicode_ci',
	`us_id` INT(11) NULL,
	`username` VARCHAR(100) NULL COLLATE 'utf8_unicode_ci'
) ENGINE=MyISAM;

-- Zrzut struktury widok kkurdziel.v_student
-- Tworzenie tymczasowej tabeli aby przezwyciężyć błędy z zależnościami w WIDOKU
CREATE TABLE `v_student` (
	`st_id` INT(11) NOT NULL,
	`name` VARCHAR(100) NOT NULL COLLATE 'utf8_unicode_ci',
	`surname` VARCHAR(100) NOT NULL COLLATE 'utf8_unicode_ci',
	`pesel` VARCHAR(11) NOT NULL COLLATE 'utf8_unicode_ci'
) ENGINE=MyISAM;

-- Zrzut struktury widok kkurdziel.v_student_course
-- Tworzenie tymczasowej tabeli aby przezwyciężyć błędy z zależnościami w WIDOKU
CREATE TABLE `v_student_course` (
	`name` VARCHAR(100) NOT NULL COLLATE 'utf8_unicode_ci',
	`surname` VARCHAR(100) NOT NULL COLLATE 'utf8_unicode_ci',
	`pesel` VARCHAR(11) NOT NULL COLLATE 'utf8_unicode_ci',
	`st_id` INT(11) NULL,
	`course_id` INT(11) NULL,
	`course_y` INT(4) NOT NULL,
	`course_name` VARCHAR(50) NOT NULL COLLATE 'utf8_unicode_ci'
) ENGINE=MyISAM;

-- Zrzut struktury widok kkurdziel.v_teacher
-- Tworzenie tymczasowej tabeli aby przezwyciężyć błędy z zależnościami w WIDOKU
CREATE TABLE `v_teacher` (
	`t_id` INT(11) NOT NULL,
	`name` VARCHAR(100) NOT NULL COLLATE 'utf8_unicode_ci',
	`surname` VARCHAR(100) NOT NULL COLLATE 'utf8_unicode_ci',
	`pesel` VARCHAR(11) NOT NULL COLLATE 'utf8_unicode_ci'
) ENGINE=MyISAM;

-- Zrzut struktury widok kkurdziel.v_teacher_course
-- Tworzenie tymczasowej tabeli aby przezwyciężyć błędy z zależnościami w WIDOKU
CREATE TABLE `v_teacher_course` (
	`t_id` INT(11) NOT NULL,
	`cour_id` INT(11) NOT NULL,
	`course_name` VARCHAR(50) NOT NULL COLLATE 'utf8_unicode_ci',
	`c_year` INT(4) NULL,
	`classes` TEXT NULL COLLATE 'utf8_unicode_ci'
) ENGINE=MyISAM;

-- Zrzut struktury widok kkurdziel.v_user_role
-- Tworzenie tymczasowej tabeli aby przezwyciężyć błędy z zależnościami w WIDOKU
CREATE TABLE `v_user_role` (
	`us_id` INT(11) NOT NULL,
	`username` VARCHAR(100) NOT NULL COLLATE 'utf8_unicode_ci',
	`role_id` INT(10) NULL,
	`role` VARCHAR(30) NULL COLLATE 'utf8_unicode_ci'
) ENGINE=MyISAM;

-- Zrzut struktury wyzwalacz kkurdziel.class_before_insert
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='';
DELIMITER //
CREATE TRIGGER `class_before_insert` BEFORE INSERT ON `class` FOR EACH ROW BEGIN


DECLARE v_year integer(1);
DECLARE v_cur_month integer(1);
DECLARE v_cur_year integer(4);
select extract(month from sysdate()) from dual into v_cur_month;
select extract(year from sysdate()) from dual into v_cur_year;

 if v_cur_month > 8 then
	select v_cur_year  - new.year_started + 1 into v_year;
 else
	select v_cur_year - new.year_started into v_year;
 end if;

if v_year > 6 then
	select 6 into v_year;
	set new.active = 'N';
else
	set new.active = 'T';
end if;

set new.year = v_year;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Zrzut struktury wyzwalacz kkurdziel.exam_result_before_insert
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `exam_result_before_insert` BEFORE INSERT ON `exam_result` FOR EACH ROW BEGIN
	set new.mark_time = NOW();
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Zrzut struktury wyzwalacz kkurdziel.exam_result_before_update
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `exam_result_before_update` BEFORE UPDATE ON `exam_result` FOR EACH ROW BEGIN
	set new.mark_time = NOW();
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Zrzut struktury wyzwalacz kkurdziel.user_logs_before_insert
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `user_logs_before_insert` BEFORE INSERT ON `user_logs` FOR EACH ROW BEGIN
	set new.time = NOW();
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Zrzut struktury widok kkurdziel.v_absence
-- Usuwanie tabeli tymczasowej i tworzenie ostatecznej struktury WIDOKU
DROP TABLE IF EXISTS `v_absence`;
CREATE ALGORITHM=UNDEFINED DEFINER=`kkurdziel`@`%` VIEW `v_absence` AS SELECT st.st_id, p.name, p.surname, p.pesel, c.cour_id, ct.course_name, 
abt.type, ab.absence_date, ab.comment
from absence ab inner join student st on ab.st_id = st.st_id
inner join person p on st.st_id = p.pr_id
inner join course c on ab.cour_id = c.cour_id
inner join course_type ct on ct.cour_tp_id = c.type_id
inner join absence_type abt on abt.ab_id = ab.abt_id
order by ab.absence_date desc ;

-- Zrzut struktury widok kkurdziel.v_class_course
-- Usuwanie tabeli tymczasowej i tworzenie ostatecznej struktury WIDOKU
DROP TABLE IF EXISTS `v_class_course`;
CREATE ALGORITHM=UNDEFINED DEFINER=`kkurdziel`@`%` VIEW `v_class_course` AS SELECT cl.class_id, cl.section, cl.year_started, cl.year as class_y_now, cl.active, crt.course_name, cr.year as course_y_started 
from class cl left join class_course clc on cl.class_id = clc.class_id
inner join course cr on clc.course_id = cr.cour_id
inner join course_type crt on cr.type_id = crt.cour_tp_id ;

-- Zrzut struktury widok kkurdziel.v_course
-- Usuwanie tabeli tymczasowej i tworzenie ostatecznej struktury WIDOKU
DROP TABLE IF EXISTS `v_course`;
CREATE ALGORITHM=UNDEFINED DEFINER=`kkurdziel`@`%` VIEW `v_course` AS SELECT c.cour_id, c.year, ct.course_name
from course c inner join course_type ct on c.type_id = ct.cour_tp_id ;

-- Zrzut struktury widok kkurdziel.v_course_mark
-- Usuwanie tabeli tymczasowej i tworzenie ostatecznej struktury WIDOKU
DROP TABLE IF EXISTS `v_course_mark`;
CREATE ALGORITHM=UNDEFINED DEFINER=`kkurdziel`@`%` VIEW `v_course_mark` AS SELECT st.st_id, cr.cour_id, ex.nazwa, exr.mark as mark, exr.comment from
student st left join exam_result exr  on exr.st_id = st.st_id
inner join exam ex on exr.ex_id = ex.ex_id
inner join course cr on ex.cour_id=cr.cour_id
order by exr.mark_time asc ;

-- Zrzut struktury widok kkurdziel.v_parent
-- Usuwanie tabeli tymczasowej i tworzenie ostatecznej struktury WIDOKU
DROP TABLE IF EXISTS `v_parent`;
CREATE ALGORITHM=UNDEFINED DEFINER=`kkurdziel`@`%` VIEW `v_parent` AS select `parent`.`parent_id` AS `parent_id`,`person`.`name` AS `name`,`person`.`surname` AS `surname`,`person`.`pesel` AS `pesel` from (`parent` join `person` on((`parent`.`parent_id` = `person`.`pr_id`))) ;

-- Zrzut struktury widok kkurdziel.v_parent_student
-- Usuwanie tabeli tymczasowej i tworzenie ostatecznej struktury WIDOKU
DROP TABLE IF EXISTS `v_parent_student`;
CREATE ALGORITHM=UNDEFINED DEFINER=`kkurdziel`@`%` VIEW `v_parent_student` AS SELECT par.parent_id, p_par.name as par_name, p_par.surname as par_surname,
 st.st_id, p_st.name as st_name, p_st.surname as st_surname from
parent par inner join person p_par on p_par.pr_id = par.parent_id
inner join parent_student ps on ps.parent_id = par.parent_id
inner join student st on ps.student_id = st.st_id
inner join person p_st on st.st_id = p_st.pr_id ;

-- Zrzut struktury widok kkurdziel.v_person_user
-- Usuwanie tabeli tymczasowej i tworzenie ostatecznej struktury WIDOKU
DROP TABLE IF EXISTS `v_person_user`;
CREATE ALGORITHM=UNDEFINED DEFINER=`kkurdziel`@`%` VIEW `v_person_user` AS SELECT person.pr_id, name, surname, pesel, mail, us_id, username from person left join 
user on user.pr_id = person.pr_id ;

-- Zrzut struktury widok kkurdziel.v_student
-- Usuwanie tabeli tymczasowej i tworzenie ostatecznej struktury WIDOKU
DROP TABLE IF EXISTS `v_student`;
CREATE ALGORITHM=UNDEFINED DEFINER=`kkurdziel`@`%` VIEW `v_student` AS select `student`.`st_id` AS `st_id`,`person`.`name` AS `name`,`person`.`surname` AS `surname`,`person`.`pesel` AS `pesel` from (`student` join `person` on((`student`.`st_id` = `person`.`pr_id`))) ;

-- Zrzut struktury widok kkurdziel.v_student_course
-- Usuwanie tabeli tymczasowej i tworzenie ostatecznej struktury WIDOKU
DROP TABLE IF EXISTS `v_student_course`;
CREATE ALGORITHM=UNDEFINED DEFINER=`kkurdziel`@`%` VIEW `v_student_course` AS SELECT p.name, p.surname, p.pesel, sc.st_id, sc.course_id, c.year as course_y, ct.course_name from
student st left join student_course sc on sc.st_id = st.st_id
inner join person p on p.pr_id = st.st_id
inner join course c on c.cour_id = sc.course_id
inner join course_type ct on c.type_id = ct.cour_tp_id ;

-- Zrzut struktury widok kkurdziel.v_teacher
-- Usuwanie tabeli tymczasowej i tworzenie ostatecznej struktury WIDOKU
DROP TABLE IF EXISTS `v_teacher`;
CREATE ALGORITHM=UNDEFINED DEFINER=`kkurdziel`@`%` VIEW `v_teacher` AS select `teacher`.`t_id` AS `t_id`,`person`.`name` AS `name`,`person`.`surname` AS `surname`,`person`.`pesel` AS `pesel` from (`teacher` join `person` on((`teacher`.`t_id` = `person`.`pr_id`))) ;

-- Zrzut struktury widok kkurdziel.v_teacher_course
-- Usuwanie tabeli tymczasowej i tworzenie ostatecznej struktury WIDOKU
DROP TABLE IF EXISTS `v_teacher_course`;
CREATE ALGORITHM=UNDEFINED DEFINER=`kkurdziel`@`%` VIEW `v_teacher_course` AS SELECT tc.t_id, tc.cour_id, ct.course_name, c.year as c_year,
		(select group_concat(year, section separator ', ') as test from class_course clc2
		inner join class cl2 on cl2.class_id = clc2.class_id
		where course_id = c.cour_id) as classes
from
teacher_course tc left join course c on tc.cour_id = c.cour_id
inner join course_type ct on c.type_id = ct.cour_tp_id ;

-- Zrzut struktury widok kkurdziel.v_user_role
-- Usuwanie tabeli tymczasowej i tworzenie ostatecznej struktury WIDOKU
DROP TABLE IF EXISTS `v_user_role`;
CREATE ALGORITHM=UNDEFINED DEFINER=`kkurdziel`@`%` VIEW `v_user_role` AS select `us`.`us_id`, us.username,`rt`.`role_id` AS `role_id`,`rt`.`role` 
AS `role` from (
user `us` left join user_role `ur` on `ur`.`us_id` = `us`.`us_id`
left join `role_type` `rt` on((`ur`.`role_id` = `rt`.`role_id`))
) ;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
