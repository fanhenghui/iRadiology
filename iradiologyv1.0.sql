-- MySQL dump 10.13  Distrib 5.7.9, for Win64 (x86_64)
--
-- Host: localhost    Database: iradiology
-- ------------------------------------------------------
-- Server version	5.6.17

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `clinic`
--

DROP TABLE IF EXISTS `clinic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clinic` (
  `clinic_id` int(11) NOT NULL AUTO_INCREMENT,
  `clinic` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`clinic_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clinic`
--

LOCK TABLES `clinic` WRITE;
/*!40000 ALTER TABLE `clinic` DISABLE KEYS */;
INSERT INTO `clinic` VALUES (1,'GOPD'),(2,'Orthopaedic'),(3,'A&E'),(4,'Anatomy'),(5,'Ophthalmology');
/*!40000 ALTER TABLE `clinic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `department` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT,
  `department` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COMMENT='	';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department`
--

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` VALUES (1,'UltraSound'),(2,'X-Ray/Mammography'),(3,'MRI'),(4,'Fluroscopy'),(5,'CT-Scan');
/*!40000 ALTER TABLE `department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `occupation`
--

DROP TABLE IF EXISTS `occupation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `occupation` (
  `occupation_id` int(11) NOT NULL AUTO_INCREMENT,
  `occupation` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`occupation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COMMENT='-- Contains information regarding students information--';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `occupation`
--

LOCK TABLES `occupation` WRITE;
/*!40000 ALTER TABLE `occupation` DISABLE KEYS */;
INSERT INTO `occupation` VALUES (1,'Student'),(2,'Civil Servant'),(3,'Entrepreneur'),(4,'Freelance'),(5,'Farmer'),(6,'Doctor');
/*!40000 ALTER TABLE `occupation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patient`
--

DROP TABLE IF EXISTS `patient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `patient` (
  `patient_id` int(11) NOT NULL AUTO_INCREMENT,
  `surname` varchar(70) DEFAULT NULL,
  `other_names` varchar(100) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `sex_id` int(11) DEFAULT NULL,
  `occupation_id` int(11) DEFAULT NULL,
  `hospital_no` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`patient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='-- contains infromation about all the patients visiting the hospital --';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patient`
--

LOCK TABLES `patient` WRITE;
/*!40000 ALTER TABLE `patient` DISABLE KEYS */;
INSERT INTO `patient` VALUES (1,'Okwori','Simon',28,2,4,'4354353');
/*!40000 ALTER TABLE `patient` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `result`
--

DROP TABLE IF EXISTS `result`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `result` (
  `result_id` int(11) NOT NULL AUTO_INCREMENT,
  `primary_diagnosis` varchar(500) DEFAULT NULL,
  `clinical_notes` varchar(700) DEFAULT NULL,
  `consultant_i_c` varchar(45) DEFAULT NULL,
  `result` text,
  `amount_to_pay` float DEFAULT NULL,
  `l_m_p` date DEFAULT NULL,
  `conclusion` varchar(400) DEFAULT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL COMMENT '-- dept where the test was conducted --',
  `sup_dept_id` int(11) DEFAULT NULL COMMENT '-- sub department of the test --',
  `user_id` int(11) DEFAULT NULL COMMENT '-- contain information on the doctor the performed the test --',
  `clinic_id` int(11) DEFAULT NULL,
  `appointment_date` date DEFAULT NULL,
  `appointment_time` time DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `statistical_conclusion_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`result_id`),
  KEY `result_patient_fk_idx` (`patient_id`),
  KEY `result__idx` (`department_id`),
  KEY `result__idx1` (`sup_dept_id`),
  KEY `result_user_id_idx` (`user_id`),
  KEY `result__idx2` (`clinic_id`),
  KEY `result_status_idx` (`status_id`),
  KEY `result_statisticalConclusion_fk_idx` (`statistical_conclusion_id`),
  KEY `result_subDept_fk_idx` (`sup_dept_id`),
  CONSTRAINT `result_clinic_fk` FOREIGN KEY (`clinic_id`) REFERENCES `clinic` (`clinic_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `result_department_fk` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `result_patient_fk` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `result_statisticalConclusion_fk` FOREIGN KEY (`statistical_conclusion_id`) REFERENCES `statistical_conclusion` (`statistical_conclusion_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `result_status` FOREIGN KEY (`status_id`) REFERENCES `status` (`status_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `result_subDept_fk` FOREIGN KEY (`sup_dept_id`) REFERENCES `sub_dept` (`sub_dept_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `result_users_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='-- contains information on patients test result --';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `result`
--

LOCK TABLES `result` WRITE;
/*!40000 ALTER TABLE `result` DISABLE KEYS */;
INSERT INTO `result` VALUES (1,'Head injury','He was very stupid to do a shit like this!!','Dr Madaki',NULL,56789,'2016-11-25',NULL,1,'2016-11-24 00:00:00',1,1,NULL,1,'2016-11-24','22:00:00',1,NULL);
/*!40000 ALTER TABLE `result` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sex`
--

DROP TABLE IF EXISTS `sex`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sex` (
  `sex_id` int(11) NOT NULL AUTO_INCREMENT,
  `sex` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`sex_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sex`
--

LOCK TABLES `sex` WRITE;
/*!40000 ALTER TABLE `sex` DISABLE KEYS */;
INSERT INTO `sex` VALUES (1,'Female'),(2,'Male');
/*!40000 ALTER TABLE `sex` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `statistical_conclusion`
--

DROP TABLE IF EXISTS `statistical_conclusion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `statistical_conclusion` (
  `statistical_conclusion_id` int(11) NOT NULL AUTO_INCREMENT,
  `statistical_conclusion` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`statistical_conclusion_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='-- Conclusion that can de measured with some sense of ''definiticy'' if that is even a word! --';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statistical_conclusion`
--

LOCK TABLES `statistical_conclusion` WRITE;
/*!40000 ALTER TABLE `statistical_conclusion` DISABLE KEYS */;
INSERT INTO `statistical_conclusion` VALUES (1,'Normal Lungs Position'),(2,'Has Breast Cancer'),(3,'Bone Facture ');
/*!40000 ALTER TABLE `statistical_conclusion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COMMENT='-- Contain information on progress of result information --';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status`
--

LOCK TABLES `status` WRITE;
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` VALUES (1,'Active'),(2,'Inactive'),(3,'Pending'),(4,'Exists');
/*!40000 ALTER TABLE `status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sub_dept`
--

DROP TABLE IF EXISTS `sub_dept`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sub_dept` (
  `sub_dept_id` int(11) NOT NULL AUTO_INCREMENT,
  `sub_dept` varchar(45) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`sub_dept_id`),
  KEY `sub_dept_department_fk_idx` (`department_id`),
  CONSTRAINT `sub_dept_department_fk` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sub_dept`
--

LOCK TABLES `sub_dept` WRITE;
/*!40000 ALTER TABLE `sub_dept` DISABLE KEYS */;
INSERT INTO `sub_dept` VALUES (1,'Head',2),(2,'Thyriod',3),(3,'Pregnancy',5),(4,'Ankle',2),(5,'knee',3),(6,'Abdomen ',1);
/*!40000 ALTER TABLE `sub_dept` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `title`
--

DROP TABLE IF EXISTS `title`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `title` (
  `title_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`title_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COMMENT='user titles';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `title`
--

LOCK TABLES `title` WRITE;
/*!40000 ALTER TABLE `title` DISABLE KEYS */;
INSERT INTO `title` VALUES (1,'Mr'),(2,'Mrs'),(3,'Miss'),(4,'Dr'),(5,'Chief'),(6,'Alhaji'),(7,'Prof'),(8,'Engr'),(9,'Master'),(10,'Bar.');
/*!40000 ALTER TABLE `title` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_group`
--

DROP TABLE IF EXISTS `user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key of user group tbl',
  `group` varchar(45) DEFAULT NULL COMMENT 'the various authorized user groups on the system',
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_group`
--

LOCK TABLES `user_group` WRITE;
/*!40000 ALTER TABLE `user_group` DISABLE KEYS */;
INSERT INTO `user_group` VALUES (1,'Receptionists'),(2,'Doctors'),(3,'Typists'),(4,'Admin');
/*!40000 ALTER TABLE `user_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_status`
--

DROP TABLE IF EXISTS `user_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_status` (
  `user_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`user_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_status`
--

LOCK TABLES `user_status` WRITE;
/*!40000 ALTER TABLE `user_status` DISABLE KEYS */;
INSERT INTO `user_status` VALUES (1,'Pending'),(2,'Active'),(3,'Deactivated');
/*!40000 ALTER TABLE `user_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_login` varchar(70) DEFAULT NULL,
  `user_password` varchar(70) DEFAULT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `middle_name` varchar(45) DEFAULT NULL,
  `title_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `user_status_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `department_id_idx` (`department_id`),
  KEY `user_group_fk_idx` (`group_id`),
  KEY `user_title_fk_idx` (`title_id`),
  CONSTRAINT `users_department_fk` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `users_group_fk` FOREIGN KEY (`group_id`) REFERENCES `user_group` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `users_title_fk` FOREIGN KEY (`title_id`) REFERENCES `title` (`title_id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='-- Contains information of users from the various user groups in the system --';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'sim','sim','Simon','Okwori','Ayegba Marcellinus',1,4,1,2),(2,NULL,NULL,'Simon','Okwori','Ayegba Marcellinus',1,1,1,1),(3,'marcel24','ayegba24','Simon','Okwori','Ayegba Marcellinus',1,1,1,2);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'iradiology'
--

--
-- Dumping routines for database 'iradiology'
--
/*!50003 DROP PROCEDURE IF EXISTS `appointment` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `appointment`(IN thisDay date)
BEGIN
	declare i, q, r, s, was, t int; declare tin, dept text;
	set i = (select count(distinct department) from department);
	while (i>0) Do
		set q = (select count(result.appointment_date) from result where result.department_id =i and result.appointment_date=thisDay);
		set dept = (select department as dept from department where department.department_id=i);
		set r = (select min(users.user_id) from users inner join result on users.user_id=result.user_id where result.department_id=i and result.appointment_date=thisDay);
		set s = (select max(users.user_id) from users inner join result on users.user_id=result.user_id where result.department_id=i and result.appointment_date=thisDay);
		while (s>=r) Do
				set was = (select count(result.appointment_date) from result inner join users on result.user_id=users.user_id where result.department_id=i and result.appointment_date=thisDay and result.user_id=s);
				set tin = (select users.first_name from result inner join users on result.user_id=users.user_id where result.department_id=i and result.appointment_date=thisDay and result.user_id=s);
				select group_concat(dept,q,tin,was separator ' ');
				set s = s - 1;
				if (s>=r) then
					set t = (select max(users.user_id) from users inner join result on users.user_id=result.user_id where result.department_id=i and result.appointment_date=thisDay and users.user_id<=s);
					set s = t;
				END if;		
		END while;
	-- select group_concat(department, q separator ',') from department where department.department_id=i;
	set i = i - 1;
	END while;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-11-24 18:26:46
