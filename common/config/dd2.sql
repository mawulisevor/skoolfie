SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
DELIMITER $$
--
-- Procedures
--
-- DELIMITER $$

CREATE PROCEDURE `broadsheet_pivot`(IN cGradgroup VARCHAR(64), IN `cProgid` VARCHAR(15))
BEGIN

SET SESSION group_concat_max_len = 20000;
    SET @sql = NULL;
SELECT
  GROUP_CONCAT(DISTINCT
    CONCAT(
      'SUM(IF(Semester=',Semester,', CR, 0)) AS ', CONCAT('CR',Semester),', ',
      'SUM(IF(Semester=',Semester,', GP, 0)) AS ', CONCAT('GPA',Semester),''
    )
  ) INTO @sql
FROM broadsheet WHERE Gradgroup=cGradgroup AND Progid=cProgid ORDER BY Semester;

DROP TABLE IF EXISTS `tmpbroad`;

SET @sql = CONCAT('CREATE TABLE `tmpbroad` AS SELECT `Index_No` AS `Index_No`,
                    `Name` AS `Name`,`Progid` AS `Progid`,
                    ', @sql, ',
                    SUM(CR) AS TCR, ROUND(SUM(GP)/SUM(CR), 1) AS `FGPA` FROM broadsheet GROUP BY `Index_No` ORDER BY `FGPA` DESC');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
CALL broad_pivot;
-- SELECT * FROM broad;
END$$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE `broad_pivot`()
BEGIN
SET SESSION group_concat_max_len = 20000;
    SET @sql = NULL;
SELECT
  GROUP_CONCAT(DISTINCT
    CONCAT(
		'IF(CR1,CR1,0) AS CR1, 
			IF(GPA1,ROUND(GPA1/CR1,3),0) AS GPA1, 
		IF(CR2,SUM(CR1 + CR2),0) AS CR2, 
			IF(GPA2,ROUND(SUM(GPA1 + GPA2)/SUM(CR1 + CR2),3),0) AS GPA2,
		IF(CR3,SUM(CR1 + CR2 + CR3),0) AS CR3, 
			IF(GPA3,ROUND(SUM(GPA1 + GPA2 + GPA3)/SUM(CR1 + CR2 + CR3),3),0) AS GPA3,
		IF(CR4,SUM(CR1 + CR2 + CR3 + CR4),0) AS CR4, 
			IF(GPA4,ROUND(SUM(GPA1 + GPA2 + GPA3 + GPA4)/SUM(CR1 + CR2 + CR3 + CR4),3),0) AS GPA4,
		IF(CR5,SUM(CR1 + CR2 + CR3 + CR4 + CR5),0) AS CR5, 
			IF(GPA5,ROUND(SUM(GPA1 + GPA2 + GPA3 + GPA4 + GPA5)/SUM(CR1 + CR2 + CR3 + CR4 + CR5),3),0) AS GPA5,
		IF(CR6,SUM(CR1 + CR2 + CR3 + CR4 + CR5 + CR6),0) AS CR6, 
			IF(GPA6,ROUND(SUM(GPA1 + GPA2 + GPA3 + GPA4 + GPA5 + GPA6)/SUM(CR1 + CR2 + CR3 + CR4 + CR5 + CR6),3),0) AS GPA6'
    )
  ) INTO @sql
FROM tmpbroad;

DROP TABLE IF EXISTS `broad`;

SET @sql = CONCAT('CREATE TABLE `broad` AS SELECT `Index_No` AS `Index_No`,
                    `Name` AS `Name`,`Progid` AS `Progid`,
                    ', @sql, ',
                     TCR AS TCR, ROUND(FGPA,1) AS `FGPA` FROM tmpbroad GROUP BY `Index_No` ORDER BY `FGPA` DESC');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
END$$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE `enroll_insert_update`(StudentID varchar(20),CourseID varchar(10))
BEGIN
	DECLARE vUser varchar(20);
	SELECT USER() INTO vUser;
	   INSERT INTO enrollaudit
	   ( studid,
		 courseid,
         updatedby)
	   VALUES
	   ( StudentID,
		 CourseID,
         vUser );
END$$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE `enroll_pivot`()
BEGIN
SET SESSION group_concat_max_len = 20000;   -- just in case
	SET @sql = NULL;
SELECT
  GROUP_CONCAT(DISTINCT
    CONCAT(
      'SUM(IF(courseid="',courseid,'", ca, 0)) AS ','CA, ',
      'SUM(IF(courseid="',courseid,'", exams, 0)) AS ','Exams, ',
      'SUM(IF(courseid="',courseid,'", (ca+exams), 0)) AS "',courseid, '"'
    )
  ) INTO @sql
FROM enroll;

SET @sql = CONCAT('SELECT studid
                    , ', @sql, ' 
                   FROM enroll
                   GROUP BY studid');

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
END$$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE `result_pivot`(
    IN cYear VARCHAR(64),      -- name of column to put across the top
    IN cLevel VARCHAR(64),      -- name of column to SUM up
    IN cSemester VARCHAR(64)   -- empty string or "WHERE ..."
	)
BEGIN
SET SESSION group_concat_max_len = 20000;   -- just in case
	SET @sql = NULL;
 
DROP TABLE IF EXISTS `tmp_ucc`;
CREATE TABLE `tmp_ucc` AS SELECT * from ucc_export where Level=cLevel and Year=cYear and Semester=cSemester;
SELECT
  GROUP_CONCAT(DISTINCT
    CONCAT(
      'SUM(IF(Courseid="',Courseid,'", CA, 0)) AS ','CA, ',
      'SUM(IF(Courseid="',Courseid,'", Exam, 0)) AS ','Exam, ',
      'SUM(IF(Courseid="',Courseid,'", (Total), 0)) AS "',Courseid, '"'
    )
  ) INTO @sql
FROM tmp_ucc;
-- where Year=cYear and Level=cLevel and Semester=cSemester;

SET @sql = CONCAT('SELECT @s:=@s+1 as `ID`,`Index_No`, `Name`
                    , ', @sql, ' 
                   FROM tmp_ucc, (Select @s:=0) as s
				   GROUP BY `Index_No`');

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
END$$

DELIMITER ;

DELIMITER $$

--
-- Functions
--
CREATE FUNCTION `coursecredit_calc`(coursecode varchar(10) ) RETURNS int(11)
    DETERMINISTIC
BEGIN
	Declare course_credit_value int;
   	Select course.coursecredit into course_credit_value from course where course.courseid=coursecode;
	RETURN course_credit_value;
END$$

DELIMITER ;

DELIMITER $$

CREATE FUNCTION `GP_CALC`( ca INT,exams Int, coursecode varchar(10) ) RETURNS float
    DETERMINISTIC
BEGIN
Declare score_total int(3);
   Declare gp float;
	Declare course_credit_value int;
   Set score_total = ca + exams;
	Select course.coursecredit into course_credit_value from course where course.courseid=coursecode;

   IF score_total >= 80 THEN
      SET gp = 4.0*course_credit_value;
   ELSEIF score_total >= 75 AND score_total <= 79 THEN
      SET gp = 3.5*course_credit_value;
   ELSEIF score_total >= 70 AND score_total <= 74 THEN
      SET gp = 3.0*course_credit_value;
   ELSEIF score_total >= 65 AND score_total <= 69 THEN
      SET gp = 2.5*course_credit_value;
   ELSEIF score_total >= 60 AND score_total <= 64 THEN
      SET gp = 2.0*course_credit_value;
   ELSEIF score_total >= 55 AND score_total <= 59 THEN
      SET gp = 1.5*course_credit_value;
   ELSEIF score_total >= 50 AND score_total <= 54 THEN
      SET gp = 1.0*course_credit_value;
   ELSEIF score_total <50 THEN
      SET gp = 0;
   END IF;

   RETURN gp;
END$$

DELIMITER ;

DELIMITER $$

CREATE FUNCTION `GRADE_CALC`( ca INT,exams Int ) RETURNS char(2) CHARSET utf8
    DETERMINISTIC
BEGIN
	 Declare score_total int(3);
   Declare grade char(2);
   Set score_total = ca + exams;
   IF score_total >= 80 THEN
      SET grade = 'A';
   ELSEIF score_total >= 75 AND score_total <= 79 THEN
      SET grade = 'B+';
   ELSEIF score_total >= 70 AND score_total <= 74 THEN
      SET grade = 'B';
   ELSEIF score_total >= 65 AND score_total <= 69 THEN
      SET grade = 'C+';
   ELSEIF score_total >= 60 AND score_total <= 64 THEN
      SET grade = 'C';
   ELSEIF score_total >= 55 AND score_total <= 59 THEN
      SET grade = 'D+';
   ELSEIF score_total >= 50 AND score_total <= 54 THEN
      SET grade = 'D';
   ELSEIF score_total <50 THEN
      SET grade = 'E';

   END IF;

   RETURN grade;
END$$


DELIMITER ;


-- --------------------------------------------------------

--
-- Table structure for table `academicyear`
--
-- Creation: Aug 23, 2015 at 10:43 AM
--

CREATE TABLE IF NOT EXISTS `academicyear` (
  `acyear` varchar(15) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `startdate` date DEFAULT NULL,
  `enddate` date DEFAULT NULL,
  PRIMARY KEY (`acyear`),
  KEY `fk_AcYear_idx` (`acyear`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `acprog`
--
-- Creation: Aug 23, 2015 at 10:43 AM
--

CREATE TABLE IF NOT EXISTS `acprog` (
  `progid` varchar(15) NOT NULL,
  `progname` varchar(100) NOT NULL,
  `awardedby` varchar(100) NOT NULL,
  PRIMARY KEY (`progid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Academic Programs in the school';

-- --------------------------------------------------------

--
-- Table structure for table `admdt`
--
-- Creation: Oct 18, 2015 at 05:48 PM
--

CREATE TABLE IF NOT EXISTS `admdt` (
  `INDEX_NO` varchar(20) NOT NULL COMMENT 'INDEX NO',
  `NAME` varchar(200) NOT NULL COMMENT 'NAME',
  `ENTRANCE_CERT` varchar(45) DEFAULT '-' COMMENT 'ENTRANCE CERT',
  `AWARDING_INSTITUTION` varchar(100) DEFAULT '-' COMMENT 'AWARDING INSTITUTION',
  `CERTIFICATE_NO` varchar(100) DEFAULT '-' COMMENT 'CERTIFICATE NO',
  `QUALIFICATION_INDEX_NO` varchar(100) DEFAULT '-' COMMENT 'QUALIFICATION INDEX NO',
  `CLASS` varchar(100) DEFAULT '-' COMMENT 'CLASS',
  `ENGLISH_LANGUAGE` varchar(10) DEFAULT '-' COMMENT 'ENGLISH LANGUAGE',
  `MATHEMATICS` varchar(10) DEFAULT '-' COMMENT 'MATHEMATICS',
  `INTEGRATED_SCIENCE` varchar(10) DEFAULT '-' COMMENT 'INTEGRATED SCIENCE',
  `SOCIAL_STUDIES` varchar(10) DEFAULT '-' COMMENT 'SOCIAL STUDIES',
  `PHYSICS` varchar(10) DEFAULT '-' COMMENT 'PHYSICS',
  `CHEMISTRY` varchar(10) DEFAULT '-' COMMENT 'CHEMISTRY',
  `BIOLOGY` varchar(10) DEFAULT '-' COMMENT 'BIOLOGY',
  `ELECTIVE_MATHEMATICS` varchar(10) DEFAULT '-' COMMENT 'ELECTIVE MATHEMATICS',
  `GENERAL_AGRICULTURE` varchar(10) DEFAULT '-' COMMENT 'GENERAL AGRICULTURE',
  `CROP_HUSBANDRY` varchar(10) DEFAULT '-' COMMENT 'CROP HUSBANDRY',
  `ANIMAL_HUSBANDRY` varchar(10) DEFAULT '-' COMMENT 'ANIMAL HUSBANDRY',
  PRIMARY KEY (`INDEX_NO`),
  KEY `fk_admrt_studid_idx` (`INDEX_NO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `admdt`:
--   `INDEX_NO`
--       `student` -> `studid`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--
-- Creation: Nov 21, 2015 at 08:18 AM
--

CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(50) NOT NULL,
  `admin_password` varchar(50) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `admresult`
--
-- Creation: Oct 18, 2015 at 03:21 PM
--

CREATE TABLE IF NOT EXISTS `admresult` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `studid` varchar(20) NOT NULL,
  `cert` varchar(45) NOT NULL,
  `institution` varchar(100) NOT NULL,
  `certno` varchar(100) DEFAULT NULL,
  `indexno` varchar(100) DEFAULT NULL,
  `certclass` varchar(100) DEFAULT NULL,
  `subject` varchar(100) NOT NULL,
  `grade` varchar(10) NOT NULL,
  PRIMARY KEY (`pid`),
  KEY `fk_admissionresult_studid_idx` (`studid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- RELATIONS FOR TABLE `admresult`:
--   `studid`
--       `student` -> `studid`
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `admresult_view`
--
CREATE TABLE IF NOT EXISTS `admresult_view` (
`NAME` varchar(242)
,`gradgroup` varchar(15)
,`INDEX_NO` varchar(20)
,`ENTRANCE_CERT` varchar(45)
,`AWARDING_INSTITUTION` varchar(100)
,`CERTIFICATE_NO` varchar(100)
,`QUALIFICATION_INDEX_NO` varchar(100)
,`CLASS` varchar(100)
,`subjects` varchar(100)
,`grades` varchar(10)
);
-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--
-- Creation: Sep 27, 2015 at 06:40 PM
--

CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELATIONS FOR TABLE `auth_assignment`:
--   `item_name`
--       `auth_item` -> `name`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--
-- Creation: Sep 27, 2015 at 06:40 PM
--

CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELATIONS FOR TABLE `auth_item`:
--   `rule_name`
--       `auth_rule` -> `name`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--
-- Creation: Sep 27, 2015 at 06:40 PM
--

CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELATIONS FOR TABLE `auth_item_child`:
--   `parent`
--       `auth_item` -> `name`
--   `child`
--       `auth_item` -> `name`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--
-- Creation: Sep 27, 2015 at 06:40 PM
--

CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `broad`
--
-- Creation: Oct 17, 2015 at 08:09 AM
--

CREATE TABLE IF NOT EXISTS `broad` (
  `Index_No` varchar(20) NOT NULL,
  `Name` varchar(242) DEFAULT NULL,
  `CR1` decimal(32,0) DEFAULT NULL,
  `GPA1` double(20,3) DEFAULT NULL,
  `CR2` decimal(55,0) DEFAULT NULL,
  `GPA2` double(20,3) DEFAULT NULL,
  `CR3` decimal(56,0) DEFAULT NULL,
  `GPA3` double(20,3) DEFAULT NULL,
  `CR4` decimal(57,0) DEFAULT NULL,
  `GPA4` double(20,3) DEFAULT NULL,
  `CR5` decimal(58,0) DEFAULT NULL,
  `GPA5` double(20,3) DEFAULT NULL,
  `CR6` decimal(59,0) DEFAULT NULL,
  `GPA6` double(20,3) DEFAULT NULL,
  `TCR` decimal(32,0) DEFAULT NULL,
  `FGPA` double(18,1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Stand-in structure for view `broadsheet`
--
CREATE TABLE IF NOT EXISTS `broadsheet` (
`Index_No` varchar(20)
,`Name` varchar(242)
,`Progid` varchar(15)
,`Gradgroup` varchar(15)
,`Semester` int(11)
,`CR` int(11)
,`GP` float
);
-- --------------------------------------------------------

--
-- Table structure for table `classroom`
--
-- Creation: Aug 23, 2015 at 10:43 AM
--

CREATE TABLE IF NOT EXISTS `classroom` (
  `roomid` int(11) NOT NULL,
  `roofname` varchar(45) NOT NULL,
  `roomdesc` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`roomid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--
-- Creation: Sep 25, 2015 at 10:27 PM
--

CREATE TABLE IF NOT EXISTS `course` (
  `courseid` varchar(10) NOT NULL,
  `coursename` varchar(100) NOT NULL,
  `coursecredit` int(3) NOT NULL,
  `aclevel` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `deptid` int(11) DEFAULT NULL,
  `progid` varchar(15) NOT NULL,
  PRIMARY KEY (`courseid`),
  KEY `fk_DeptID_idx` (`deptid`),
  KEY `fk_course_progid_idx` (`progid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `course`:
--   `deptid`
--       `department` -> `deptid`
--   `progid`
--       `acprog` -> `progid`
--

-- --------------------------------------------------------

--
-- Table structure for table `department`
--
-- Creation: Aug 23, 2015 at 10:43 AM
--

CREATE TABLE IF NOT EXISTS `department` (
  `deptid` int(11) NOT NULL AUTO_INCREMENT,
  `deptname` varchar(45) NOT NULL,
  `hodid` varchar(45) NOT NULL DEFAULT 'AC/T/0001',
  PRIMARY KEY (`deptid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `enroll`
--
-- Creation: Oct 17, 2015 at 06:42 AM
--

CREATE TABLE IF NOT EXISTS `enroll` (
  `studid` varchar(20) NOT NULL,
  `courseid` varchar(10) NOT NULL,
  `resit` tinyint(2) NOT NULL DEFAULT '0',
  `ca` tinyint(4) DEFAULT '0',
  `exams` tinyint(4) DEFAULT '0',
  `acyear` varchar(15) DEFAULT NULL,
  `classroom` int(11) NOT NULL,
  PRIMARY KEY (`studid`,`courseid`,`resit`),
  KEY `fk_ClassRm_idx` (`classroom`),
  KEY `fk_AcYr_idx` (`acyear`),
  KEY `fk_course_enroll_idx` (`courseid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='When a student registers for a course, it is entered here. Marks awarded students for each course are also entered here';

--
-- RELATIONS FOR TABLE `enroll`:
--   `acyear`
--       `academicyear` -> `acyear`
--   `courseid`
--       `course` -> `courseid`
--   `studid`
--       `student` -> `studid`
--

-- --------------------------------------------------------

--
-- Table structure for table `enrollaudit`
--
-- Creation: Aug 23, 2015 at 10:43 AM
--

CREATE TABLE IF NOT EXISTS `enrollaudit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `studid` varchar(20) NOT NULL,
  `updatedate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `courseid` varchar(10) NOT NULL,
  `updatedby` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `auditlog`
--
-- Creation: Aug 23, 2015 at 10:43 AM
--

CREATE TABLE IF NOT EXISTS `auditlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tableid` varchar(30) NOT NULL,
  `pkey` varchar(50) NOT NULL,
  `actiondate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `actionby` varchar(20) NOT NULL,
  `action` varchar(20) NOT NULL,
  `studid` varchar(20) NULL,
  `courseid` varchar(10) NULL,
  `filename` varchar(10) NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------
--
-- Table structure for table `grade`
--
-- Creation: Aug 23, 2015 at 10:43 AM
--

CREATE TABLE IF NOT EXISTS `grade` (
  `letter` char(2) NOT NULL,
  `lettervalue` decimal(10,1) DEFAULT NULL,
  `minmark` int(11) NOT NULL,
  `maxmark` int(11) NOT NULL,
  PRIMARY KEY (`letter`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Stand-in structure for view `gradebook`
--
CREATE TABLE IF NOT EXISTS `gradebook` (
`Name` varchar(242)
,`Index_No` varchar(20)
,`Year` varchar(20)
,`Ac_Level` int(11)
,`Semester` int(11)
,`Course_Code` varchar(10)
,`Course_Title` varchar(100)
,`CA` tinyint(4)
,`Exam` tinyint(4)
,`Total` int(5)
,`CR` int(11)
,`GR` char(2)
,`GP` float
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `exportbio`
--
CREATE TABLE IF NOT EXISTS `exportbio` (
`INDEX_NO` varchar(20)
,`SURNAME` varchar(70)
,`MIDDLE_NAME` varchar(70)
,`OTHERNAMES` varchar(100)
,`PROGRAMME_CODE` varchar(15)
,`LEVEL` int(11)
,`LEVEL_OF_ADMISSION` int(11)
,`GENDER` char(1)
,`TEL` varchar(15)
,`EMAIL` varchar(255)
,`DATE_OF_ADMISSION` date
,`DATE_OF_BIRTH` date
,`GRADUATION_GROUP` varchar(15)
);
-- --------------------------------------------------------

--
-- Table structure for table `migration`
--
-- Creation: Aug 23, 2015 at 08:42 PM
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Stand-in structure for view `result`
--
CREATE TABLE IF NOT EXISTS `result` (
`Name` varchar(242)
,`Index_No` varchar(20)
,`Title` varchar(100)
,`Courseid` varchar(10)
,`CA` tinyint(4)
,`Exam` tinyint(4)
,`Total` int(5)
,`CR` int(11)
,`GR` char(2)
,`GP` float
,`Level` int(11)
,`Year` varchar(20)
,`Semester` int(11)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `result_slip`
--
CREATE TABLE IF NOT EXISTS `result_slip` (
`Name` varchar(242)
,`Index No.` varchar(20)
,`CourseName` varchar(100)
,`CA/40` tinyint(4)
,`Exams/60` tinyint(4)
,`Total Score` int(5)
,`Grades` char(2)
,`GP` float
);
-- --------------------------------------------------------

--
-- Table structure for table `student`
--
-- Creation: Oct 25, 2015 at 11:16 AM
--

CREATE TABLE IF NOT EXISTS `student` (
  `studid` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `fname` varchar(20) DEFAULT NULL,
  `oname` varchar(45) DEFAULT NULL,
  `progid` varchar(15) DEFAULT NULL,
  `currentlevel` int(11) NOT NULL COMMENT '	',
  `admissionlevel` int(11) NOT NULL,
  `sex` char(1) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `pobox` varchar(300) DEFAULT NULL COMMENT 'P.O. Box',
  `admdate` date NOT NULL,
  `birthdate` date DEFAULT NULL,
  `gradgroup` varchar(15) NOT NULL,
  `semsdone` int(2) DEFAULT '0',
  `totalgp` float DEFAULT '0',
  `totalcredit` int(4) DEFAULT '0',
  `cgpa` float DEFAULT '0',
  `certclass` varchar(20) DEFAULT NULL,
  `picture` varchar(100) DEFAULT 'pictures/default.png',
  PRIMARY KEY (`studid`),
  UNIQUE KEY `sid_UNIQUE` (`studid`),
  KEY `fk_ProgID_idx` (`progid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Student biodata';

--
-- RELATIONS FOR TABLE `student`:
--   `progid`
--       `acprog` -> `progid`
--

-- --------------------------------------------------------

--
-- Table structure for table `teach`
--
-- Creation: Aug 23, 2015 at 10:43 AM
--

CREATE TABLE IF NOT EXISTS `teach` (
  `teachid` varchar(20) NOT NULL,
  `courseid` varchar(10) NOT NULL,
  `roomid` int(11) NOT NULL,
  `acyear` varchar(15) NOT NULL,
  PRIMARY KEY (`teachid`,`courseid`,`roomid`),
  KEY `fk_Subject_idx` (`courseid`),
  KEY `fk_RoomID_idx` (`roomid`),
  KEY `fk_teach_acyear_idx` (`acyear`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `teach`:
--   `teachid`
--       `teacher` -> `teachid`
--   `courseid`
--       `course` -> `courseid`
--   `roomid`
--       `classroom` -> `roomid`
--

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--
-- Creation: Aug 23, 2015 at 10:43 AM
--

CREATE TABLE IF NOT EXISTS `teacher` (
  `teachid` varchar(20) NOT NULL,
  `lname` varchar(70) NOT NULL,
  `fname` varchar(70) NOT NULL,
  `oname` varchar(100) DEFAULT NULL,
  `suffix` varchar(45) DEFAULT NULL,
  `sex` char(1) NOT NULL,
  `deptid` int(11) DEFAULT NULL,
  PRIMARY KEY (`teachid`),
  KEY `fk_Dept_idx` (`deptid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `teacher`:
--   `deptid`
--       `department` -> `deptid`
--

-- --------------------------------------------------------

--
-- Table structure for table `tmpbroad`
--
-- Creation: Oct 17, 2015 at 08:09 AM
--

CREATE TABLE IF NOT EXISTS `tmpbroad` (
  `Index_No` varchar(20) NOT NULL,
  `Name` varchar(242) DEFAULT NULL,
  `CR1` decimal(32,0) DEFAULT NULL,
  `GPA1` double DEFAULT NULL,
  `CR2` decimal(32,0) DEFAULT NULL,
  `GPA2` double DEFAULT NULL,
  `CR6` decimal(32,0) DEFAULT NULL,
  `GPA6` double DEFAULT NULL,
  `CR4` decimal(32,0) DEFAULT NULL,
  `GPA4` double DEFAULT NULL,
  `CR3` decimal(32,0) DEFAULT NULL,
  `GPA3` double DEFAULT NULL,
  `CR5` decimal(32,0) DEFAULT NULL,
  `GPA5` double DEFAULT NULL,
  `TCR` decimal(32,0) DEFAULT NULL,
  `FGPA` double(18,1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_ucc`
--
-- Creation: Oct 18, 2015 at 05:42 PM
--

CREATE TABLE IF NOT EXISTS `tmp_ucc` (
  `Index_No` varchar(20) NOT NULL,
  `Name` varchar(242) DEFAULT NULL,
  `Title` varchar(100) NOT NULL,
  `Courseid` varchar(10) NOT NULL,
  `CA` tinyint(4) DEFAULT NULL,
  `Exam` tinyint(4) DEFAULT NULL,
  `Total` int(5) DEFAULT NULL,
  `Level` int(11) NOT NULL,
  `Year` varchar(20) DEFAULT NULL,
  `Semester` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Stand-in structure for view `ucc_export`
--
CREATE TABLE IF NOT EXISTS `ucc_export` (
`Index_No` varchar(20)
,`Name` varchar(242)
,`Title` varchar(100)
,`Courseid` varchar(10)
,`CA` tinyint(4)
,`Exam` tinyint(4)
,`Total` int(5)
,`Level` int(11)
,`Year` varchar(20)
,`Semester` int(11)
);
-- --------------------------------------------------------

--
-- Table structure for table `user`
--
-- Creation: Oct 22, 2015 at 02:52 PM
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fname` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'First Name',
  `lname` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Last Name',
  `birthdate` date NOT NULL DEFAULT '0000-00-00' COMMENT 'Date of Birth',
  `role` int(11) NOT NULL DEFAULT '10',
  `ugroup` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`),
  KEY `fname` (`fname`,`lname`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
-- --------------------------------------------------------
-- 
-- Table structure for table `institution`
-- Creation: April 18, 2016 at 6:55 AM
--
CREATE TABLE IF NOT EXISTS `institution` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `inst_shortname` varchar(10) NOT NULL COMMENT 'Institution Short Name',
  `inst_name` varchar(250) NOT NULL COMMENT 'Institution Name',
  `inst_location` varchar(250) NOT NULL COMMENT 'Location',
  `inst_post_address` varchar(100) NOT NULL COMMENT 'Postal Address',
  `inst_email` varchar(100) NOT NULL COMMENT 'Email',
  `inst_est_date` date NOT NULL COMMENT 'Date Established',
  `logo` varchar(100) DEFAULT 'pictures/default_logo.png' COMMENT 'Institution Logo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- --------------------------------------------------------
--
-- Table structure for table `graduate`
-- Creation: April 18, 2016 at 6:55 AM
--
CREATE TABLE IF NOT EXISTS `graduate` (
  `studid` varchar(20) NOT NULL COMMENT 'INDEX NO',
  `lname` varchar(50) NOT NULL COMMENT 'LASTNAME',
  `fname` varchar(20) DEFAULT NULL COMMENT 'FIRSTNAME',
  `oname` varchar(45) DEFAULT NULL COMMENT 'OTHER NAMES',
  `progid` varchar(15) DEFAULT NULL COMMENT 'PROGRAM CODE',
  `admdate` date NOT NULL COMMENT 'ADMISSION DATE',
  `birthdate` date DEFAULT NULL COMMENT 'DATE OF BIRTH',
  `sex` char(1) NOT NULL COMMENT 'SEX',
  `picture` varchar(100) DEFAULT 'pictures/default.png',
  PRIMARY KEY (`studid`),
  UNIQUE KEY `grad_studid_UNIQUE` (`studid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT 'GRADUATES';
-- --------------------------------------------------------
--
-- Table structure for table `transcript`
-- Creation: April 18, 2016 at 6:55 AM
--
CREATE TABLE IF NOT EXISTS `transcript` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `studid` varchar(20) NOT NULL COMMENT 'INDEX NO',
  `acyear` varchar(15) NOT NULL COMMENT 'ACADEMIC YEAR',
  `courseid` varchar(10) NOT NULL COMMENT 'COURSE CODE',
  `semester` varchar(100) NOT NULL COMMENT 'SEMESTER',
  `grade` varchar(10) NOT NULL COMMENT 'GRADE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- ====================END UPDATE==============================

-- --------------------------------------------------------
--
-- Structure for view `admresult_view`
--
DROP TABLE IF EXISTS `admresult_view`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `admresult_view` AS select concat(`student`.`lname`,', ',`student`.`fname`,' ',`student`.`oname`) AS `NAME`,`student`.`gradgroup` AS `gradgroup`,`admresult`.`studid` AS `INDEX_NO`,`admresult`.`cert` AS `ENTRANCE_CERT`,`admresult`.`institution` AS `AWARDING_INSTITUTION`,`admresult`.`certno` AS `CERTIFICATE_NO`,`admresult`.`indexno` AS `QUALIFICATION_INDEX_NO`,`admresult`.`certclass` AS `CLASS`,`admresult`.`subject` AS `subjects`,`admresult`.`grade` AS `grades` from (`admresult` join `student` on((`student`.`studid` = `admresult`.`studid`)));

-- --------------------------------------------------------

--
-- Structure for view `broadsheet`
--
DROP TABLE IF EXISTS `broadsheet`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `broadsheet` AS select `enroll`.`studid` AS `Index_No`,concat(`student`.`lname`,', ',`student`.`fname`,' ',`student`.`oname`) AS `Name`,`student`.`gradgroup` AS `Gradgroup`,`course`.`semester` AS `Semester`,`course`.`coursecredit` AS `CR`,`GP_CALC`(`enroll`.`ca`,`enroll`.`exams`,`enroll`.`courseid`) AS `GP` from ((`enroll` join `course` on((`course`.`courseid` = `enroll`.`courseid`))) join `student` on((`student`.`studid` = `enroll`.`studid`))) order by `enroll`.`studid`,`course`.`aclevel`,`course`.`semester`;

-- --------------------------------------------------------

--
-- Structure for view `gradebook`
--
DROP TABLE IF EXISTS `gradebook`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `gradebook` AS select concat(`student`.`lname`,', ',`student`.`fname`,' ',`student`.`oname`) AS `Name`,`enroll`.`studid` AS `Index_No`,`enroll`.`acyear` AS `Year`,`course`.`aclevel` AS `Ac_Level`,`course`.`semester` AS `Semester`,`course`.`courseid` AS `Course_Code`,`course`.`coursename` AS `Course_Title`,`enroll`.`ca` AS `CA`,`enroll`.`exams` AS `Exam`,(`enroll`.`ca` + `enroll`.`exams`) AS `Total`,`course`.`coursecredit` AS `CR`,`GRADE_CALC`(`enroll`.`ca`,`enroll`.`exams`) AS `GR`,`GP_CALC`(`enroll`.`ca`,`enroll`.`exams`,`enroll`.`courseid`) AS `GP` from ((`enroll` join `course` on((`course`.`courseid` = `enroll`.`courseid`))) join `student` on((`student`.`studid` = `enroll`.`studid`))) order by `enroll`.`studid`,`course`.`aclevel`,`course`.`semester`;

-- --------------------------------------------------------

--
-- Structure for view `exportbio`
--
DROP TABLE IF EXISTS `exportbio`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `exportbio` AS select `student`.`studid` AS `INDEX_NO`,`student`.`lname` AS `SURNAME`,`student`.`fname` AS `MIDDLE_NAME`,`student`.`oname` AS `OTHERNAMES`,`student`.`progid` AS `PROGRAMME_CODE`,`student`.`currentlevel` AS `LEVEL`,`student`.`admissionlevel` AS `LEVEL_OF_ADMISSION`,`student`.`sex` AS `GENDER`,`student`.`phone` AS `TEL`,`student`.`email` AS `EMAIL`,`student`.`admdate` AS `DATE_OF_ADMISSION`,`student`.`birthdate` AS `DATE_OF_BIRTH`,`student`.`gradgroup` AS `GRADUATION_GROUP` from `student` order by `student`.`studid`;

-- --------------------------------------------------------

--
-- Structure for view `result`
--
DROP TABLE IF EXISTS `result`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `result` AS select concat(`student`.`lname`,', ',`student`.`fname`,' ',`student`.`oname`) AS `Name`,`enroll`.`studid` AS `Index_No`,`course`.`coursename` AS `Title`,`enroll`.`courseid` AS `Courseid`,`enroll`.`ca` AS `CA`,`enroll`.`exams` AS `Exam`,(`enroll`.`ca` + `enroll`.`exams`) AS `Total`,`course`.`coursecredit` AS `CR`,`GRADE_CALC`(`enroll`.`ca`,`enroll`.`exams`) AS `GR`,`GP_CALC`(`enroll`.`ca`,`enroll`.`exams`,`enroll`.`courseid`) AS `GP`,`course`.`aclevel` AS `Level`,`enroll`.`acyear` AS `Year`,`course`.`semester` AS `Semester` from ((`enroll` join `course` on((`course`.`courseid` = `enroll`.`courseid`))) join `student` on((`student`.`studid` = `enroll`.`studid`))) order by `enroll`.`studid`,`course`.`aclevel`,`course`.`semester`;

-- --------------------------------------------------------

--
-- Structure for view `result_slip`
--
DROP TABLE IF EXISTS `result_slip`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `result_slip` AS select concat(`student`.`lname`,', ',`student`.`fname`,' ',`student`.`oname`) AS `Name`,`enroll`.`studid` AS `Index No.`,`course`.`coursename` AS `CourseName`,`enroll`.`ca` AS `CA/40`,`enroll`.`exams` AS `Exams/60`,(`enroll`.`ca` + `enroll`.`exams`) AS `Total Score`,`GRADE_CALC`(`enroll`.`ca`,`enroll`.`exams`) AS `Grades`,`GP_CALC`(`enroll`.`ca`,`enroll`.`exams`,`enroll`.`courseid`) AS `GP` from ((`enroll` join `course` on((`course`.`courseid` = `enroll`.`courseid`))) join `student` on((`student`.`studid` = `enroll`.`studid`))) order by `enroll`.`studid`,`course`.`aclevel`,`course`.`semester`;

-- --------------------------------------------------------

--
-- Structure for view `ucc_export`
--
DROP TABLE IF EXISTS `ucc_export`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `ucc_export` AS select `enroll`.`studid` AS `Index_No`,concat(`student`.`lname`,', ',`student`.`fname`,' ',`student`.`oname`) AS `Name`,`course`.`coursename` AS `Title`,`enroll`.`courseid` AS `Courseid`,`enroll`.`ca` AS `CA`,`enroll`.`exams` AS `Exam`,(`enroll`.`ca` + `enroll`.`exams`) AS `Total`,`course`.`aclevel` AS `Level`,`enroll`.`acyear` AS `Year`,`course`.`semester` AS `Semester` from ((`enroll` join `course` on((`course`.`courseid` = `enroll`.`courseid`))) join `student` on((`student`.`studid` = `enroll`.`studid`))) where (`student`.`progid` = 'DIGA') order by `enroll`.`studid`,`course`.`aclevel`,`course`.`semester`;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admdt`
--
ALTER TABLE `graduate`
  ADD CONSTRAINT `fk_graduate_progid` FOREIGN KEY (`progid`) REFERENCES `acprog` (`progid`) ON DELETE NO ACTION ON UPDATE NO ACTION;
--
-- Constraints for table `admdt`
--
ALTER TABLE `transcript`
  ADD CONSTRAINT `fk_transcript_studid` FOREIGN KEY (`studid`) REFERENCES `graduate` (`studid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `transcript`
  ADD CONSTRAINT `fk_transcript_courseid` FOREIGN KEY (`courseid`) REFERENCES `course` (`courseid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `transcript`
  ADD CONSTRAINT `fk_transcript_acyear` FOREIGN KEY (`acyear`) REFERENCES `academicyear` (`acyear`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `admdt`
--
ALTER TABLE `admdt`
  ADD CONSTRAINT `fk_admdt_studid` FOREIGN KEY (`INDEX_NO`) REFERENCES `student` (`studid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `admresult`
--
ALTER TABLE `admresult`
  ADD CONSTRAINT `fk_admissionresult_studid` FOREIGN KEY (`studid`) REFERENCES `student` (`studid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `fk_course_dept` FOREIGN KEY (`deptid`) REFERENCES `department` (`deptid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_course_progid` FOREIGN KEY (`progid`) REFERENCES `acprog` (`progid`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `enroll`
--
ALTER TABLE `enroll`
  ADD CONSTRAINT `fk_acyear_enroll` FOREIGN KEY (`acyear`) REFERENCES `academicyear` (`acyear`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_course_enroll` FOREIGN KEY (`courseid`) REFERENCES `course` (`courseid`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_student_enroll` FOREIGN KEY (`studid`) REFERENCES `student` (`studid`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `fk_student_acprog` FOREIGN KEY (`progid`) REFERENCES `acprog` (`progid`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `teach`
--
ALTER TABLE `teach`
  ADD CONSTRAINT `fk_teacher_teach` FOREIGN KEY (`teachid`) REFERENCES `teacher` (`teachid`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_teach_course` FOREIGN KEY (`courseid`) REFERENCES `course` (`courseid`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_teach_room` FOREIGN KEY (`roomid`) REFERENCES `classroom` (`roomid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `fk_teacher_dept` FOREIGN KEY (`deptid`) REFERENCES `department` (`deptid`) ON DELETE NO ACTION ON UPDATE NO ACTION;
--
-- Insert data for table `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('site-admin', 1, 'Manage ARMS', NULL, NULL, NULL, NULL),
('site-clerk', 1, 'Do data entry work on the site', NULL, NULL, NULL, NULL),
('site-viewer', 1, 'Able to view what is in the database', NULL, NULL, NULL, NULL);

--
-- Insert data for table `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('site-admin', 'site-clerk'),
('site-admin', 'site-viewer'),
('site-clerk', 'site-viewer');

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('site-admin', '1', 20151122);
--
-- Insert data for table `institution`
--

INSERT INTO `institution` (`inst_shortname`, `inst_name`, `inst_location`, `inst_post_address`, `inst_email`, `inst_est_date`, `logo`) VALUES
('Bubufy', 'Bubu Institute', 'Kojokofe', 'P.O. Box KJ1, Kojokofe, Volta Region, Ghana','info@example.com','1960-01-30','pictures/default_logo.png');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

