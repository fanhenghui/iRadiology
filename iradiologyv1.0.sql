-- ----------------------------------------------------------------------------
-- MySQL Workbench Migration
-- Migrated Schemata: iradiology
-- Source Schemata: iradiology
-- Created: Tue Sep 24 17:18:20 2013
-- ----------------------------------------------------------------------------

SET FOREIGN_KEY_CHECKS = 0;;

-- ----------------------------------------------------------------------------
-- Schema iradiology
-- ----------------------------------------------------------------------------
DROP SCHEMA IF EXISTS `iradiology` ;
CREATE SCHEMA IF NOT EXISTS `iradiology` ;

-- ----------------------------------------------------------------------------
-- Table iradiology.clinic
-- ----------------------------------------------------------------------------
CREATE  TABLE IF NOT EXISTS `iradiology`.`clinic` (
  `clinic_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `clinic` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`clinic_id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = latin1;

-- ----------------------------------------------------------------------------
-- Table iradiology.department
-- ----------------------------------------------------------------------------
CREATE  TABLE IF NOT EXISTS `iradiology`.`department` (
  `department_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `department` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`department_id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = latin1
COMMENT = '	';

-- ----------------------------------------------------------------------------
-- Table iradiology.occupation
-- ----------------------------------------------------------------------------
CREATE  TABLE IF NOT EXISTS `iradiology`.`occupation` (
  `occupation_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `occupation` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`occupation_id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = latin1
COMMENT = '-- Contains information regarding students information--';

-- ----------------------------------------------------------------------------
-- Table iradiology.patient
-- ----------------------------------------------------------------------------
CREATE  TABLE IF NOT EXISTS `iradiology`.`patient` (
  `patient_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `surname` VARCHAR(70) NULL DEFAULT NULL ,
  `other_names` VARCHAR(100) NULL DEFAULT NULL ,
  `age` INT(11) NULL DEFAULT NULL ,
  `sex_id` INT(11) NULL DEFAULT NULL ,
  `occupation_id` INT(11) NULL DEFAULT NULL ,
  `hospital_no` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`patient_id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 23
DEFAULT CHARACTER SET = latin1
COMMENT = '-- contains infromation about all the patients visiting the hospital --';

-- ----------------------------------------------------------------------------
-- Table iradiology.result
-- ----------------------------------------------------------------------------
CREATE  TABLE IF NOT EXISTS `iradiology`.`result` (
  `result_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `primary_diagnosis` VARCHAR(500) NULL DEFAULT NULL ,
  `clinical_notes` VARCHAR(700) NULL DEFAULT NULL ,
  `consultant_i_c` VARCHAR(45) NULL DEFAULT NULL ,
  `result` TEXT NULL DEFAULT NULL ,
  `amount_to_pay` FLOAT NULL DEFAULT NULL ,
  `l_m_p` DATE NULL DEFAULT NULL ,
  `conclusion` VARCHAR(400) NULL DEFAULT NULL ,
  `patient_id` INT(11) NULL DEFAULT NULL ,
  `date` DATETIME NULL DEFAULT NULL ,
  `department_id` INT(11) NULL DEFAULT NULL COMMENT '-- dept where the test was conducted --' ,
  `sup_dept_id` INT(11) NULL DEFAULT NULL COMMENT '-- sub department of the test --' ,
  `user_id` INT(11) NULL DEFAULT NULL COMMENT '-- contain information on the doctor the performed the test --' ,
  `clinic_id` INT(11) NULL DEFAULT NULL ,
  `appointment_date` DATE NULL DEFAULT NULL ,
  `appointment_time` TIME NULL DEFAULT NULL ,
  `status_id` INT(11) NULL DEFAULT NULL ,
  `statistical_conclusion_id` INT(11) NULL DEFAULT NULL ,
  PRIMARY KEY (`result_id`) ,
  INDEX `result_patient_fk_idx` (`patient_id` ASC) ,
  INDEX `result__idx` (`department_id` ASC) ,
  INDEX `result__idx1` (`sup_dept_id` ASC) ,
  INDEX `result_user_id_idx` (`user_id` ASC) ,
  INDEX `result__idx2` (`clinic_id` ASC) ,
  INDEX `result_status_idx` (`status_id` ASC) ,
  INDEX `result_statisticalConclusion_fk_idx` (`statistical_conclusion_id` ASC) ,
  INDEX `result_subDept_fk_idx` (`sup_dept_id` ASC) ,
  CONSTRAINT `result_clinic_fk`
    FOREIGN KEY (`clinic_id` )
    REFERENCES `iradiology`.`clinic` (`clinic_id` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `result_department_fk`
    FOREIGN KEY (`department_id` )
    REFERENCES `iradiology`.`department` (`department_id` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `result_patient_fk`
    FOREIGN KEY (`patient_id` )
    REFERENCES `iradiology`.`patient` (`patient_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `result_statisticalConclusion_fk`
    FOREIGN KEY (`statistical_conclusion_id` )
    REFERENCES `iradiology`.`statistical_conclusion` (`statistical_conclusion_id` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `result_status`
    FOREIGN KEY (`status_id` )
    REFERENCES `iradiology`.`status` (`status_id` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `result_subDept_fk`
    FOREIGN KEY (`sup_dept_id` )
    REFERENCES `iradiology`.`sub_dept` (`sub_dept_id` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `result_users_fk`
    FOREIGN KEY (`user_id` )
    REFERENCES `iradiology`.`users` (`user_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 28
DEFAULT CHARACTER SET = latin1
COMMENT = '-- contains information on patients test result --';

-- ----------------------------------------------------------------------------
-- Table iradiology.statistical_conclusion
-- ----------------------------------------------------------------------------
CREATE  TABLE IF NOT EXISTS `iradiology`.`statistical_conclusion` (
  `statistical_conclusion_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `statistical_conclusion` VARCHAR(250) NULL DEFAULT NULL ,
  PRIMARY KEY (`statistical_conclusion_id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = latin1
COMMENT = '-- Conclusion that can de measured with some sense of \'definiticy\' if that is even a word! --';

-- ----------------------------------------------------------------------------
-- Table iradiology.status
-- ----------------------------------------------------------------------------
CREATE  TABLE IF NOT EXISTS `iradiology`.`status` (
  `status_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `status` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`status_id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = latin1
COMMENT = '-- Contain information on progress of result information --';

-- ----------------------------------------------------------------------------
-- Table iradiology.sub_dept
-- ----------------------------------------------------------------------------
CREATE  TABLE IF NOT EXISTS `iradiology`.`sub_dept` (
  `sub_dept_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `sub_dept` VARCHAR(45) NULL DEFAULT NULL ,
  `department_id` INT(11) NULL DEFAULT NULL ,
  PRIMARY KEY (`sub_dept_id`) ,
  INDEX `sub_dept_department_fk_idx` (`department_id` ASC) ,
  CONSTRAINT `sub_dept_department_fk`
    FOREIGN KEY (`department_id` )
    REFERENCES `iradiology`.`department` (`department_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = latin1;

-- ----------------------------------------------------------------------------
-- Table iradiology.users
-- ----------------------------------------------------------------------------
CREATE  TABLE IF NOT EXISTS `iradiology`.`users` (
  `user_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `user_login` VARCHAR(70) NULL DEFAULT NULL ,
  `user_password` VARCHAR(70) NULL DEFAULT NULL ,
  `first_name` VARCHAR(45) NULL DEFAULT NULL ,
  `last_name` VARCHAR(45) NULL DEFAULT NULL ,
  `middle_name` VARCHAR(45) NULL DEFAULT NULL ,
  `title_id` INT(11) NULL DEFAULT NULL ,
  `group_id` INT(11) NULL DEFAULT NULL ,
  `department_id` INT(11) NULL DEFAULT NULL ,
  PRIMARY KEY (`user_id`) ,
  INDEX `department_id_idx` (`department_id` ASC) ,
  INDEX `user_group_fk_idx` (`group_id` ASC) ,
  INDEX `user_title_fk_idx` (`title_id` ASC) ,
  CONSTRAINT `users_department_fk`
    FOREIGN KEY (`department_id` )
    REFERENCES `iradiology`.`department` (`department_id` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `users_group_fk`
    FOREIGN KEY (`group_id` )
    REFERENCES `iradiology`.`user_group` (`group_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `users_title_fk`
    FOREIGN KEY (`title_id` )
    REFERENCES `iradiology`.`title` (`title_id` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 13
DEFAULT CHARACTER SET = latin1
COMMENT = '-- Contains information of users from the various user groups in the system --';

-- ----------------------------------------------------------------------------
-- Table iradiology.sex
-- ----------------------------------------------------------------------------
CREATE  TABLE IF NOT EXISTS `iradiology`.`sex` (
  `sex_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `sex` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`sex_id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = latin1;

-- ----------------------------------------------------------------------------
-- Table iradiology.title
-- ----------------------------------------------------------------------------
CREATE  TABLE IF NOT EXISTS `iradiology`.`title` (
  `title_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`title_id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 9
DEFAULT CHARACTER SET = latin1
COMMENT = 'user titles';

-- ----------------------------------------------------------------------------
-- Table iradiology.user_group
-- ----------------------------------------------------------------------------
CREATE  TABLE IF NOT EXISTS `iradiology`.`user_group` (
  `group_id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key of user group tbl' ,
  `group` VARCHAR(45) NULL DEFAULT NULL COMMENT 'the various authorized user groups on the system' ,
  PRIMARY KEY (`group_id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8;

-- ----------------------------------------------------------------------------
-- Routine iradiology.appointment
-- ----------------------------------------------------------------------------
DELIMITER $$

DELIMITER $$
USE `iradiology`$$
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
END$$

DELIMITER ;
SET FOREIGN_KEY_CHECKS = 1;;
