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
CREATE DATABASE IF NOT EXISTS `kkurdziel` /*!40100 DEFAULT CHARACTER SET cp1250 COLLATE cp1250_polish_ci */;
USE `kkurdziel`;

-- Zrzut struktury tabela kkurdziel.absence
CREATE TABLE IF NOT EXISTS `absence` (
  `abs_id` int(11) NOT NULL AUTO_INCREMENT,
  `st_id` int(11) NOT NULL,
  `cour_id` int(11) NOT NULL,
  `absence_date` date NOT NULL,
  `abt_id` int(11) NOT NULL,
  `comment` varchar(400) DEFAULT NULL,
  PRIMARY KEY (`abs_id`),
  KEY `Absence_fk0` (`st_id`),
  KEY `Absence_fk1` (`cour_id`),
  KEY `Absence_fk2` (`abt_id`),
  CONSTRAINT `FK_absence_absence_type` FOREIGN KEY (`abt_id`) REFERENCES `absence_type` (`ab_id`),
  CONSTRAINT `FK_absence_course` FOREIGN KEY (`cour_id`) REFERENCES `course` (`cour_id`),
  CONSTRAINT `FK_absence_student` FOREIGN KEY (`st_id`) REFERENCES `student` (`st_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Zrzucanie danych dla tabeli kkurdziel.absence: ~0 rows (około)
DELETE FROM `absence`;
/*!40000 ALTER TABLE `absence` DISABLE KEYS */;
/*!40000 ALTER TABLE `absence` ENABLE KEYS */;

-- Zrzut struktury tabela kkurdziel.absence_type
CREATE TABLE IF NOT EXISTS `absence_type` (
  `ab_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(100) NOT NULL,
  PRIMARY KEY (`ab_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Zrzucanie danych dla tabeli kkurdziel.absence_type: ~4 rows (około)
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
  `section` varchar(1) NOT NULL,
  `year_started` int(4) NOT NULL,
  `year` int(1) DEFAULT NULL,
  `active` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`class_id`),
  UNIQUE KEY `unique_year_section` (`section`,`year_started`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Zrzucanie danych dla tabeli kkurdziel.class_course: ~6 rows (około)
DELETE FROM `class_course`;
/*!40000 ALTER TABLE `class_course` DISABLE KEYS */;
INSERT INTO `class_course` (`class_course_id`, `class_id`, `course_id`) VALUES
	(2, 20, 1),
	(4, 20, 2),
	(5, 20, 3),
	(6, 20, 4),
	(7, 20, 5),
	(8, 20, 6);
/*!40000 ALTER TABLE `class_course` ENABLE KEYS */;

-- Zrzut struktury tabela kkurdziel.course
CREATE TABLE IF NOT EXISTS `course` (
  `cour_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `year` int(4) NOT NULL,
  PRIMARY KEY (`cour_id`),
  KEY `FK_course_course_type` (`type_id`),
  CONSTRAINT `FK_course_course_type` FOREIGN KEY (`type_id`) REFERENCES `course_type` (`cour_tp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Zrzucanie danych dla tabeli kkurdziel.course: ~6 rows (około)
DELETE FROM `course`;
/*!40000 ALTER TABLE `course` DISABLE KEYS */;
INSERT INTO `course` (`cour_id`, `type_id`, `year`) VALUES
	(1, 17, 2016),
	(2, 14, 2016),
	(3, 19, 2016),
	(4, 16, 2016),
	(5, 20, 2016),
	(6, 15, 2016);
/*!40000 ALTER TABLE `course` ENABLE KEYS */;

-- Zrzut struktury tabela kkurdziel.course_type
CREATE TABLE IF NOT EXISTS `course_type` (
  `cour_tp_id` int(11) NOT NULL AUTO_INCREMENT,
  `course_name` varchar(50) NOT NULL,
  PRIMARY KEY (`cour_tp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=cp1250;

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
  `nazwa` varchar(50) DEFAULT NULL,
  `comment` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`ex_id`),
  KEY `Exam_fk0` (`cour_id`),
  KEY `Exam_fk1` (`ex_type_id`),
  CONSTRAINT `FK_exam_course` FOREIGN KEY (`cour_id`) REFERENCES `course` (`cour_id`),
  CONSTRAINT `FK_exam_exam_type` FOREIGN KEY (`ex_type_id`) REFERENCES `exam_type` (`ext_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Zrzucanie danych dla tabeli kkurdziel.exam: ~2 rows (około)
DELETE FROM `exam`;
/*!40000 ALTER TABLE `exam` DISABLE KEYS */;
INSERT INTO `exam` (`ex_id`, `cour_id`, `ex_type_id`, `nazwa`, `comment`) VALUES
	(1, 5, NULL, 'Sprawdzian 1', 'Pierwszy sprawdzian'),
	(2, 5, NULL, 'Sprawdzian 2', 'Drugi sprawdzian');
/*!40000 ALTER TABLE `exam` ENABLE KEYS */;

-- Zrzut struktury tabela kkurdziel.exam_result
CREATE TABLE IF NOT EXISTS `exam_result` (
  `ex_res` int(11) NOT NULL AUTO_INCREMENT,
  `ex_id` int(11) NOT NULL,
  `t_id` int(11) NOT NULL,
  `st_id` int(11) NOT NULL,
  `mark_id` int(11) NOT NULL,
  `comment` varchar(500) DEFAULT NULL,
  `mark_time` date NOT NULL,
  PRIMARY KEY (`ex_res`),
  KEY `FK_exam_result_exam` (`ex_id`),
  KEY `FK_exam_result_student` (`st_id`),
  KEY `FK_exam_result_mark` (`mark_id`),
  KEY `FK_exam_result_teacher` (`t_id`),
  CONSTRAINT `FK_exam_result_exam` FOREIGN KEY (`ex_id`) REFERENCES `exam` (`ex_id`),
  CONSTRAINT `FK_exam_result_mark` FOREIGN KEY (`mark_id`) REFERENCES `mark` (`mark_id`),
  CONSTRAINT `FK_exam_result_student` FOREIGN KEY (`st_id`) REFERENCES `student` (`st_id`),
  CONSTRAINT `FK_exam_result_teacher` FOREIGN KEY (`t_id`) REFERENCES `teacher` (`t_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Zrzucanie danych dla tabeli kkurdziel.exam_result: ~0 rows (około)
DELETE FROM `exam_result`;
/*!40000 ALTER TABLE `exam_result` DISABLE KEYS */;
INSERT INTO `exam_result` (`ex_res`, `ex_id`, `t_id`, `st_id`, `mark_id`, `comment`, `mark_time`) VALUES
	(1, 1, 40, 38, 11, NULL, '2017-02-04');
/*!40000 ALTER TABLE `exam_result` ENABLE KEYS */;

-- Zrzut struktury tabela kkurdziel.exam_type
CREATE TABLE IF NOT EXISTS `exam_type` (
  `ext_id` int(11) NOT NULL AUTO_INCREMENT,
  `ext_type` varchar(50) NOT NULL,
  PRIMARY KEY (`ext_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Zrzucanie danych dla tabeli kkurdziel.exam_type: ~0 rows (około)
DELETE FROM `exam_type`;
/*!40000 ALTER TABLE `exam_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `exam_type` ENABLE KEYS */;

-- Zrzut struktury tabela kkurdziel.login_history
CREATE TABLE IF NOT EXISTS `login_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL DEFAULT '0',
  `ip` varchar(39) NOT NULL DEFAULT '0',
  `time_of_login` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `failed` int(1) NOT NULL DEFAULT '0',
  `blocked_login` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

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

-- Zrzut struktury tabela kkurdziel.mark
CREATE TABLE IF NOT EXISTS `mark` (
  `mark_id` int(11) NOT NULL AUTO_INCREMENT,
  `mark_value` float NOT NULL,
  `mark` varchar(2) NOT NULL,
  PRIMARY KEY (`mark_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- Zrzucanie danych dla tabeli kkurdziel.mark: ~17 rows (około)
DELETE FROM `mark`;
/*!40000 ALTER TABLE `mark` DISABLE KEYS */;
INSERT INTO `mark` (`mark_id`, `mark_value`, `mark`) VALUES
	(1, 1, '1'),
	(2, 1.5, '1+'),
	(3, 1.75, '2-'),
	(4, 2, '2'),
	(5, 2.5, '2+'),
	(6, 2.75, '3-'),
	(7, 3, '3'),
	(8, 3.5, '3+'),
	(9, 3.75, '4-'),
	(10, 4, '4'),
	(11, 4.5, '4+'),
	(12, 4.75, '5-'),
	(13, 5, '5'),
	(14, 5.5, '5+'),
	(15, 5.75, '6-'),
	(16, 6, '6'),
	(17, 0, '0');
/*!40000 ALTER TABLE `mark` ENABLE KEYS */;

-- Zrzut struktury tabela kkurdziel.parent
CREATE TABLE IF NOT EXISTS `parent` (
  `parent_id` int(11) NOT NULL,
  PRIMARY KEY (`parent_id`),
  CONSTRAINT `FK_parent_person` FOREIGN KEY (`parent_id`) REFERENCES `person` (`pr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Zrzucanie danych dla tabeli kkurdziel.parent: ~0 rows (około)
DELETE FROM `parent`;
/*!40000 ALTER TABLE `parent` DISABLE KEYS */;
INSERT INTO `parent` (`parent_id`) VALUES
	(6),
	(14);
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
  CONSTRAINT `Parent_student_fk0` FOREIGN KEY (`parent_id`) REFERENCES `parent` (`parent_id`),
  CONSTRAINT `Parent_student_fk1` FOREIGN KEY (`student_id`) REFERENCES `student` (`st_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Zrzucanie danych dla tabeli kkurdziel.parent_student: ~2 rows (około)
DELETE FROM `parent_student`;
/*!40000 ALTER TABLE `parent_student` DISABLE KEYS */;
INSERT INTO `parent_student` (`parent_student_id`, `parent_id`, `student_id`) VALUES
	(1, 14, 38),
	(2, 14, 39);
/*!40000 ALTER TABLE `parent_student` ENABLE KEYS */;

-- Zrzut struktury tabela kkurdziel.person
CREATE TABLE IF NOT EXISTS `person` (
  `pr_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE cp1250_polish_ci NOT NULL,
  `surname` varchar(100) COLLATE cp1250_polish_ci NOT NULL,
  `pesel` varchar(11) COLLATE cp1250_polish_ci NOT NULL,
  `mail` varchar(150) COLLATE cp1250_polish_ci NOT NULL,
  `phone_nr` varchar(9) COLLATE cp1250_polish_ci DEFAULT NULL,
  PRIMARY KEY (`pr_id`),
  UNIQUE KEY `pesel` (`pesel`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=cp1250 COLLATE=cp1250_polish_ci;

-- Zrzucanie danych dla tabeli kkurdziel.person: ~16 rows (około)
DELETE FROM `person`;
/*!40000 ALTER TABLE `person` DISABLE KEYS */;
INSERT INTO `person` (`pr_id`, `name`, `surname`, `pesel`, `mail`, `phone_nr`) VALUES
	(1, 'Jan', 'Kowalski', '90101012345', 'asdattt', '111111122'),
	(2, 'Marek', 'Nowak', '99122212343', 'asd', NULL),
	(3, 'Marian', 'Iksiński', '80112211111', 'asd', NULL),
	(4, 'Lucjan', 'Iksiński', '70061222333', 'asd', NULL),
	(5, 'Kordian', 'Kurdziel', '11111111111', 'kordiankurdziel@gmail.com', NULL),
	(6, 'Test', 'Test', '22222222222', 'kordiankurdziel@gmail.com', NULL),
	(12, 'asd', 'zxc', '12222222222', 'asd', '123323232'),
	(13, 'Jan', 'Krasicki', '23232323232', 'asdasd', '232323232'),
	(14, 'Mirosław', 'Gruszka', '23123444444', 'asd', '123445555'),
	(15, 'asdasd', 'zxczxc', '23234242424', 'asdzc', '132342222'),
	(37, 'zxc', 'asd', '32311111111', 'adas', '222222222'),
	(38, 'Arkadiusz', 'Ptak', '10111111111', 'asd', '233333333'),
	(39, 'Jerzy', 'Śliwa', '99121212121', 'test', NULL),
	(40, 'Marek', 'Mickiewicz', '80101011111', 'tete', NULL),
	(41, 'Julian', 'Tuwim', '80090922222', 'asd', NULL),
	(42, 'Maria', 'Curie', '80020233333', 'tet', NULL);
/*!40000 ALTER TABLE `person` ENABLE KEYS */;

-- Zrzut struktury procedura kkurdziel.proc_dodaj_osobe
DELIMITER //
CREATE DEFINER=`kkurdziel`@`localhost` PROCEDURE `proc_dodaj_osobe`(
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
	START TRANSACTION;
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
			signal sqlstate '45001' set message_text = 'Pesel istnieje';
		end if;
	COMMIT;
END//
DELIMITER ;

-- Zrzut struktury tabela kkurdziel.role_type
CREATE TABLE IF NOT EXISTS `role_type` (
  `role_id` int(10) NOT NULL AUTO_INCREMENT,
  `role` varchar(30) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

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
  `id` varchar(64) NOT NULL,
  `los` varchar(39) DEFAULT NULL,
  `ip` varchar(39) DEFAULT NULL,
  `web` varchar(200) DEFAULT NULL,
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`ses_id`),
  KEY `ses_us_id_fk` (`ses_us_id`),
  KEY `FK_session_role_type` (`role_id`),
  CONSTRAINT `FK_session_role_type` FOREIGN KEY (`role_id`) REFERENCES `role_type` (`role_id`),
  CONSTRAINT `ses_us_id_fk` FOREIGN KEY (`ses_us_id`) REFERENCES `user` (`us_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- Zrzucanie danych dla tabeli kkurdziel.session: ~1 rows (około)
DELETE FROM `session`;
/*!40000 ALTER TABLE `session` DISABLE KEYS */;
INSERT INTO `session` (`ses_id`, `ses_us_id`, `id`, `los`, `ip`, `web`, `time`, `role_id`) VALUES
	(12, 11, 'be3bea13b909cb5e09265109288b19a3c650e4832cbae23846a157731698b448', NULL, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:52.0) Gecko/20100101 Firefox/52.0', '2017-02-04 16:55:30', 3);
/*!40000 ALTER TABLE `session` ENABLE KEYS */;

-- Zrzut struktury tabela kkurdziel.student
CREATE TABLE IF NOT EXISTS `student` (
  `st_id` int(11) NOT NULL,
  PRIMARY KEY (`st_id`),
  CONSTRAINT `FK_student_person` FOREIGN KEY (`st_id`) REFERENCES `person` (`pr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Zrzucanie danych dla tabeli kkurdziel.student: ~5 rows (około)
DELETE FROM `student`;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` (`st_id`) VALUES
	(2),
	(6),
	(15),
	(38),
	(39);
/*!40000 ALTER TABLE `student` ENABLE KEYS */;

-- Zrzut struktury tabela kkurdziel.student_class
CREATE TABLE IF NOT EXISTS `student_class` (
  `st_cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `st_id` int(11) NOT NULL,
  `cl_id` int(11) NOT NULL,
  `data_rozp` datetime NOT NULL,
  `data_zak` datetime NOT NULL,
  `is_active` varchar(1) NOT NULL COMMENT 'Trigger przy dodawaniu/usuwaniu',
  PRIMARY KEY (`st_cl_id`),
  KEY `FK_student_class_student` (`st_id`),
  KEY `FK_student_class_class` (`cl_id`),
  CONSTRAINT `FK_student_class_class` FOREIGN KEY (`cl_id`) REFERENCES `class` (`class_id`),
  CONSTRAINT `FK_student_class_student` FOREIGN KEY (`st_id`) REFERENCES `student` (`st_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Zrzucanie danych dla tabeli kkurdziel.student_class: ~2 rows (około)
DELETE FROM `student_class`;
/*!40000 ALTER TABLE `student_class` DISABLE KEYS */;
INSERT INTO `student_class` (`st_cl_id`, `st_id`, `cl_id`, `data_rozp`, `data_zak`, `is_active`) VALUES
	(1, 38, 20, '2016-02-04 16:11:41', '0000-00-00 00:00:00', 'T'),
	(3, 39, 20, '2016-02-04 16:12:09', '0000-00-00 00:00:00', 'T');
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- Zrzucanie danych dla tabeli kkurdziel.student_course: ~12 rows (około)
DELETE FROM `student_course`;
/*!40000 ALTER TABLE `student_course` DISABLE KEYS */;
INSERT INTO `student_course` (`sg_id`, `st_id`, `course_id`) VALUES
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
	(17, 39, 6);
/*!40000 ALTER TABLE `student_course` ENABLE KEYS */;

-- Zrzut struktury tabela kkurdziel.teacher
CREATE TABLE IF NOT EXISTS `teacher` (
  `t_id` int(11) NOT NULL,
  KEY `FK_teacher_person` (`t_id`),
  CONSTRAINT `FK_teacher_person` FOREIGN KEY (`t_id`) REFERENCES `person` (`pr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Zrzucanie danych dla tabeli kkurdziel.teacher: ~6 rows (około)
DELETE FROM `teacher`;
/*!40000 ALTER TABLE `teacher` DISABLE KEYS */;
INSERT INTO `teacher` (`t_id`) VALUES
	(6),
	(13),
	(14),
	(40),
	(41),
	(42);
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Zrzucanie danych dla tabeli kkurdziel.teacher_class: ~1 rows (około)
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Zrzucanie danych dla tabeli kkurdziel.teacher_course: ~6 rows (około)
DELETE FROM `teacher_course`;
/*!40000 ALTER TABLE `teacher_course` DISABLE KEYS */;
INSERT INTO `teacher_course` (`tcour_id`, `t_id`, `cour_id`, `date_from`, `date_to`) VALUES
	(3, 13, 1, '2016-09-01', '2017-08-31'),
	(4, 14, 2, '2016-09-01', '2017-08-31'),
	(5, 40, 3, '2016-09-01', '2017-08-31'),
	(6, 40, 5, '2016-09-01', '2017-08-31'),
	(7, 41, 6, '2016-09-01', '2017-08-31'),
	(8, 42, 4, '2016-09-01', '2017-08-31');
/*!40000 ALTER TABLE `teacher_course` ENABLE KEYS */;

-- Zrzut struktury tabela kkurdziel.user
CREATE TABLE IF NOT EXISTS `user` (
  `us_id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `hashed_pwd` varchar(200) NOT NULL,
  `pr_id` int(11) NOT NULL,
  PRIMARY KEY (`us_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `pr_id` (`pr_id`),
  KEY `FK_user_person` (`pr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- Zrzucanie danych dla tabeli kkurdziel.user: ~5 rows (około)
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`us_id`, `username`, `hashed_pwd`, `pr_id`) VALUES
	(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1),
	(8, 'test', '21232f297a57a5a743894a0e4a801fc3', 2),
	(9, 'ttt', '957783217d6cab74bee659ad1c55612e', 14),
	(10, 'test2', '93215b03c2be210e5250aef0d8d9fbae', 13),
	(11, 'student1', '21232f297a57a5a743894a0e4a801fc3', 38);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

-- Zrzut struktury tabela kkurdziel.user_logs
CREATE TABLE IF NOT EXISTS `user_logs` (
  `ul_id` int(11) NOT NULL AUTO_INCREMENT,
  `time` datetime NOT NULL,
  `ip` varchar(39) DEFAULT NULL,
  `us_username` varchar(100) NOT NULL,
  `type` varchar(40) NOT NULL,
  `value` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`ul_id`,`time`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=latin1
/*!50500 PARTITION BY RANGE  COLUMNS(`time`)
(PARTITION p0 VALUES LESS THAN ('2017-01-01') ENGINE = InnoDB,
 PARTITION p1 VALUES LESS THAN ('2017-02-01') ENGINE = InnoDB,
 PARTITION p2 VALUES LESS THAN ('2017-03-01') ENGINE = InnoDB,
 PARTITION p3 VALUES LESS THAN ('2017-04-01') ENGINE = InnoDB,
 PARTITION p4 VALUES LESS THAN (MAXVALUE) ENGINE = InnoDB) */;

-- Zrzucanie danych dla tabeli kkurdziel.user_logs: ~62 rows (około)
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
	(64, '2017-02-04 16:55:30', '::1', 'student1', 'good_login', NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Zrzucanie danych dla tabeli kkurdziel.user_role: ~7 rows (około)
DELETE FROM `user_role`;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
INSERT INTO `user_role` (`usrole_id`, `us_id`, `role_id`) VALUES
	(1, 1, 1),
	(2, 8, 1),
	(3, 8, 2),
	(4, 9, 2),
	(5, 9, 4),
	(6, 10, 2),
	(7, 11, 3);
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;

-- Zrzut struktury zdarzenie kkurdziel.usun_stare_sesje
DELIMITER //
CREATE DEFINER=`kkurdziel`@`%` EVENT `usun_stare_sesje` ON SCHEDULE EVERY 1 HOUR STARTS '2017-01-30 00:53:12' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
	delete from kkurdziel.session where TIMESTAMPDIFF(MINUTE, time, now()) > 60;
END//
DELIMITER ;

-- Zrzut struktury widok kkurdziel.v_class_course
-- Tworzenie tymczasowej tabeli aby przezwyciężyć błędy z zależnościami w WIDOKU
CREATE TABLE `v_class_course` (
	`class_id` INT(11) NOT NULL,
	`section` VARCHAR(1) NOT NULL COLLATE 'latin1_swedish_ci',
	`year_started` INT(4) NOT NULL,
	`class_y_now` INT(1) NULL,
	`active` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`course_name` VARCHAR(50) NOT NULL COLLATE 'cp1250_general_ci',
	`course_y_started` INT(4) NOT NULL
) ENGINE=MyISAM;

-- Zrzut struktury widok kkurdziel.v_course_mark
-- Tworzenie tymczasowej tabeli aby przezwyciężyć błędy z zależnościami w WIDOKU
CREATE TABLE `v_course_mark` (
	`st_id` INT(11) NOT NULL,
	`cour_id` INT(11) NOT NULL,
	`nazwa` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`mark` VARCHAR(2) NOT NULL COLLATE 'latin1_swedish_ci',
	`mark_value` FLOAT NOT NULL,
	`comment` VARCHAR(500) NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Zrzut struktury widok kkurdziel.v_person_user
-- Tworzenie tymczasowej tabeli aby przezwyciężyć błędy z zależnościami w WIDOKU
CREATE TABLE `v_person_user` (
	`pr_id` INT(11) NOT NULL,
	`name` VARCHAR(100) NOT NULL COLLATE 'cp1250_polish_ci',
	`surname` VARCHAR(100) NOT NULL COLLATE 'cp1250_polish_ci',
	`pesel` VARCHAR(11) NOT NULL COLLATE 'cp1250_polish_ci',
	`mail` VARCHAR(150) NOT NULL COLLATE 'cp1250_polish_ci',
	`us_id` INT(10) NULL,
	`username` VARCHAR(100) NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Zrzut struktury widok kkurdziel.v_student
-- Tworzenie tymczasowej tabeli aby przezwyciężyć błędy z zależnościami w WIDOKU
CREATE TABLE `v_student` (
	`st_id` INT(11) NOT NULL,
	`name` VARCHAR(100) NOT NULL COLLATE 'cp1250_polish_ci',
	`surname` VARCHAR(100) NOT NULL COLLATE 'cp1250_polish_ci',
	`pesel` VARCHAR(11) NOT NULL COLLATE 'cp1250_polish_ci'
) ENGINE=MyISAM;

-- Zrzut struktury widok kkurdziel.v_student_course
-- Tworzenie tymczasowej tabeli aby przezwyciężyć błędy z zależnościami w WIDOKU
CREATE TABLE `v_student_course` (
	`st_id` INT(11) NOT NULL,
	`course_id` INT(11) NOT NULL,
	`course_y` INT(4) NULL,
	`course_name` VARCHAR(50) NOT NULL COLLATE 'cp1250_general_ci'
) ENGINE=MyISAM;

-- Zrzut struktury widok kkurdziel.v_teacher
-- Tworzenie tymczasowej tabeli aby przezwyciężyć błędy z zależnościami w WIDOKU
CREATE TABLE `v_teacher` (
	`st_id` INT(11) NOT NULL,
	`name` VARCHAR(100) NOT NULL COLLATE 'cp1250_polish_ci',
	`surname` VARCHAR(100) NOT NULL COLLATE 'cp1250_polish_ci',
	`pesel` VARCHAR(11) NOT NULL COLLATE 'cp1250_polish_ci'
) ENGINE=MyISAM;

-- Zrzut struktury widok kkurdziel.v_user_role
-- Tworzenie tymczasowej tabeli aby przezwyciężyć błędy z zależnościami w WIDOKU
CREATE TABLE `v_user_role` (
	`us_id` INT(11) NOT NULL,
	`role_id` INT(10) NULL,
	`role` VARCHAR(30) NULL COLLATE 'latin1_swedish_ci'
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

-- Zrzut struktury wyzwalacz kkurdziel.user_logs_before_insert
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `user_logs_before_insert` BEFORE INSERT ON `user_logs` FOR EACH ROW BEGIN
	set new.time = NOW();
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Zrzut struktury widok kkurdziel.v_class_course
-- Usuwanie tabeli tymczasowej i tworzenie ostatecznej struktury WIDOKU
DROP TABLE IF EXISTS `v_class_course`;
CREATE ALGORITHM=UNDEFINED DEFINER=`kkurdziel`@`localhost` VIEW `v_class_course` AS SELECT cl.class_id, cl.section, cl.year_started, cl.year as class_y_now, cl.active, crt.course_name, cr.year as course_y_started 
from class cl left join class_course clc on cl.class_id = clc.class_id
inner join course cr on clc.course_id = cr.cour_id
inner join course_type crt on cr.type_id = crt.cour_tp_id ;

-- Zrzut struktury widok kkurdziel.v_course_mark
-- Usuwanie tabeli tymczasowej i tworzenie ostatecznej struktury WIDOKU
DROP TABLE IF EXISTS `v_course_mark`;
CREATE ALGORITHM=UNDEFINED DEFINER=`kkurdziel`@`localhost` VIEW `v_course_mark` AS SELECT st.st_id, cr.cour_id, ex.nazwa, mrk.mark, mrk.mark_value, exr.comment from
student st left join exam_result exr  on exr.st_id = st.st_id
inner join exam ex on exr.ex_id = ex.ex_id
inner join course cr on ex.cour_id=cr.cour_id
inner join mark mrk on exr.mark_id = mrk.mark_id 
order by exr.mark_time asc ;

-- Zrzut struktury widok kkurdziel.v_person_user
-- Usuwanie tabeli tymczasowej i tworzenie ostatecznej struktury WIDOKU
DROP TABLE IF EXISTS `v_person_user`;
CREATE ALGORITHM=UNDEFINED DEFINER=`kkurdziel`@`localhost` VIEW `v_person_user` AS SELECT person.pr_id, name, surname, pesel, mail, us_id, username from person left join 
user on user.pr_id = person.pr_id ;

-- Zrzut struktury widok kkurdziel.v_student
-- Usuwanie tabeli tymczasowej i tworzenie ostatecznej struktury WIDOKU
DROP TABLE IF EXISTS `v_student`;
CREATE ALGORITHM=UNDEFINED DEFINER=`kkurdziel`@`%` VIEW `v_student` AS select `student`.`st_id` AS `st_id`,`person`.`name` AS `name`,`person`.`surname` AS `surname`,`person`.`pesel` AS `pesel` from (`student` join `person` on((`student`.`st_id` = `person`.`pr_id`))) ;

-- Zrzut struktury widok kkurdziel.v_student_course
-- Usuwanie tabeli tymczasowej i tworzenie ostatecznej struktury WIDOKU
DROP TABLE IF EXISTS `v_student_course`;
CREATE ALGORITHM=UNDEFINED DEFINER=`kkurdziel`@`localhost` VIEW `v_student_course` AS SELECT sc.st_id, sc.course_id, c.year as course_y, ct.course_name from
student_course sc left join course c on c.cour_id = sc.course_id
inner join course_type ct on c.type_id = ct.cour_tp_id ;

-- Zrzut struktury widok kkurdziel.v_teacher
-- Usuwanie tabeli tymczasowej i tworzenie ostatecznej struktury WIDOKU
DROP TABLE IF EXISTS `v_teacher`;
CREATE ALGORITHM=UNDEFINED DEFINER=`kkurdziel`@`%` VIEW `v_teacher` AS select `teacher`.`t_id` AS `st_id`,`person`.`name` AS `name`,`person`.`surname` AS `surname`,`person`.`pesel` AS `pesel` from (`teacher` join `person` on((`teacher`.`t_id` = `person`.`pr_id`))) ;

-- Zrzut struktury widok kkurdziel.v_user_role
-- Usuwanie tabeli tymczasowej i tworzenie ostatecznej struktury WIDOKU
DROP TABLE IF EXISTS `v_user_role`;
CREATE ALGORITHM=UNDEFINED DEFINER=`kkurdziel`@`%` VIEW `v_user_role` AS select `ur`.`us_id` AS `us_id`,`rt`.`role_id` AS `role_id`,`rt`.`role` AS `role` from (`user_role` `ur` left join `role_type` `rt` on((`ur`.`role_id` = `rt`.`role_id`))) ;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
