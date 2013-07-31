DELIMITER $$

DROP PROCEDURE IF EXISTS `map_groups_to_course`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `map_groups_to_course`(
  IN customer_id INT(11)
)
    MODIFIES SQL DATA
BEGIN
  /*
    All 'DECLARE' statements must come first
  */
  -- Declare '_val' variables to read in each record from the cursor
  DECLARE group_id_val INT(11);  
  DECLARE group_idnumber_val VARCHAR(255);
  DECLARE system_id_val INT(11);
  DECLARE course_id_val INT(11);
  -- Declare variables used just for cursor and loop control
  DECLARE no_more_rows BOOLEAN;
  DECLARE loop_cntr INT DEFAULT 0;
  DECLARE num_rows INT DEFAULT 0;
  -- Declare the cursor
  DECLARE groups_cur CURSOR FOR
    SELECT g.id, g.idnumber, g.system_id, g.course_id 
    FROM groups g
    LEFT JOIN systems s ON s.id = g.system_id
    WHERE s.customer_id = customer_id;
  -- Declare 'handlers' for exceptions
  DECLARE CONTINUE HANDLER FOR NOT FOUND
    SET no_more_rows = TRUE;
  /*
    Now the programming logic
  */
  -- 'open' the cursor and capture the number of rows returned
  -- (the 'select' gets invoked when the cursor is 'opened')
  OPEN groups_cur;
  SELECT FOUND_ROWS() INTO num_rows;
  the_loop: LOOP
    FETCH  groups_cur
    INTO   group_id_val, group_idnumber_val, system_id_val, course_id_val;
    -- break out of the loop if
      -- 1) there were no records, or
      -- 2) we've processed them all
    IF no_more_rows THEN
        CLOSE groups_cur;
        LEAVE the_loop;
    END IF;
    
    -- Update fact aggregation tables
    INSERT INTO courses (idnumber, customer_id, created, modified)
	VALUES (group_idnumber_val, customer_id, NOW(), NOW())
	ON DUPLICATE KEY
	UPDATE id = LAST_INSERT_ID(id);
    
    -- Get dimension ids     
    UPDATE groups 
    SET course_id = LAST_INSERT_ID()
    WHERE id = group_id_val;
    
    -- count the number of times looped
    SET loop_cntr = loop_cntr + 1;
  END LOOP the_loop;
  
  -- update the output log so we can see they are the same
  INSERT INTO customer_updates (`type`, `time`, startid, endid, numrows, processedrows, customer_id, rule_id)
	VALUES (2, NOW(), NULL, NULL, num_rows, loop_cntr, customer_id, NULL);
  
  -- Update customer record 
  INSERT INTO customer_status (`type`, `time`, startid, endid, customer_id, rule_id) 
	VALUES (2, NOW(), NULL, NULL, customer_id, NULL)
	ON DUPLICATE KEY
	UPDATE `time` = NOW();
END$$

DELIMITER ;