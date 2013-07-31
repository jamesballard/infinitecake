DELIMITER $$

DROP PROCEDURE IF EXISTS `aggregate_summed_actions`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `aggregate_summed_actions`(
  IN customer_id INT(11),
  IN idstart INT(11),
  IN idend INT(11)
)
    MODIFIES SQL DATA
BEGIN
  /*
    All 'DECLARE' statements must come first
  */
  -- Declare '_val' variables to read in each record from the cursor
  DECLARE time_id_val INT(11);
  DECLARE date_id_val INT(11);
  DECLARE system_id_val INT(11);
  DECLARE group_id_val INT(11);
  DECLARE artefact_id_val INT(11);
  DECLARE time_val DATETIME;
  DECLARE user_id_val INT(11);
  DECLARE module_id_val INT(11);
  -- Declare variables used just for cursor and loop control
  DECLARE no_more_rows BOOLEAN;
  DECLARE loop_cntr INT DEFAULT 0;
  DECLARE num_rows INT DEFAULT 0;
  -- Declare the cursor
  DECLARE actions_cur CURSOR FOR
    SELECT a.time, a.user_id, a.group_id, a.module_id 
    FROM actions a
    LEFT JOIN systems s ON s.id = a.system_id 
    WHERE s.customer_id = customer_id
      AND a.id > idstart
      AND a.id <= idend;
  -- Declare 'handlers' for exceptions
  DECLARE CONTINUE HANDLER FOR NOT FOUND
    SET no_more_rows = TRUE;
  /*
    Now the programming logic
  */
  -- 'open' the cursor and capture the number of rows returned
  -- (the 'select' gets invoked when the cursor is 'opened')
  OPEN actions_cur;
  SELECT FOUND_ROWS() INTO num_rows;
  the_loop: LOOP
    FETCH  actions_cur
    INTO   time_val, user_id_val, group_id_val, module_id_val;
    -- break out of the loop if
      -- 1) there were no records, or
      -- 2) we've processed them all
    IF no_more_rows THEN
        CLOSE actions_cur;
        LEAVE the_loop;
    END IF;
    
    -- Get dimension ids     
    SELECT id INTO time_id_val
	  FROM dimension_time
	  WHERE fulltime = DATE_FORMAT(time_val, '%H:00:00');
	
    SELECT id INTO date_id_val
	  FROM dimension_date
	  WHERE DATE = DATE_FORMAT(time_val, '%Y-%m-%d');
	  
    SELECT artefact_id INTO artefact_id_val
          FROM modules
          WHERE id = module_id_val;
    
    SELECT system_id INTO system_id_val
          FROM users
          WHERE id = user_id_val;
          
    -- Update fact aggregation tables
    INSERT INTO fact_summed_actions_datetime (system_id, group_id, user_id, artefact_id, dimension_date_id, dimension_time_id, total)
	    VALUES (system_id_val, group_id_val, user_id_val, artefact_id_val, date_id_val, time_id_val, 1)
	    ON DUPLICATE KEY
	    UPDATE total = total+1;
    -- count the number of times looped
    SET loop_cntr = loop_cntr + 1;
  END LOOP the_loop;
  
  -- update the output log so we can see they are the same
  INSERT INTO customer_updates (`type`, `time`, startid, endid, numrows, processedrows, customer_id, rule_id)
	VALUES (3, NOW(), idstart, idend, num_rows, loop_cntr, customer_id, NULL);
  
  -- Update customer record 
  INSERT INTO customer_status (`type`, `time`, startid, endid, customer_id, rule_id) 
	VALUES (3, NOW(), idstart, idend, customer_id, NULL)
	ON DUPLICATE KEY
	UPDATE `time` = NOW(),
	startid = idstart,
	endid = idend;
END$$

DELIMITER ;