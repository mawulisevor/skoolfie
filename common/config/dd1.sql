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
CREATE PROCEDURE `admresult_pivot`(
    IN cGradgroup VARCHAR(64)     -- name of column to put across the top
	)
BEGIN
SET SESSION group_concat_max_len = 20000;   -- just in case
	SET @sql = NULL;
SELECT
  GROUP_CONCAT(
  DISTINCT
    CONCAT(
      'IF(subjects = `subjects`, grades, NULL) AS ',CONCAT("`",subjects,"`")
    )
  ) INTO @sql
FROM `admresult_view`;
SET @sql = CONCAT('SELECT @b:=@b+1 as `ID`,`INDEX_NO`, `NAME`,`ENTRANCE_CERT`,`AWARDING_INSTITUTION`,`CERTIFICATE_NO`,`CLASS`
                    , ', @sql, ' 
                   FROM admresult_view, (Select @b:=0) as b
				   GROUP BY `Index_No`'); 
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
END$$
