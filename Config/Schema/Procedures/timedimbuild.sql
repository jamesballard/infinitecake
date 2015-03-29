DELIMITER $$

DROP PROCEDURE IF EXISTS `timedimbuild`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `timedimbuild`()
BEGIN
    DECLARE v_full_date DATETIME;
    DELETE FROM dimension_time;
    SET v_full_date = '2009-03-01 00:00:00';

    WHILE v_full_date < '2009-03-02 00:00:00' DO
      INSERT INTO dimension_time (
        fulltime ,
        HOUR ,
        ampm
      ) VALUES (
        TIME(v_full_date),
        HOUR(v_full_date),
        DATE_FORMAT(v_full_date, '%p')
      );
      SET v_full_date = DATE_ADD(v_full_date, INTERVAL 1 HOUR);
    END WHILE;
  END$$

DELIMITER ;