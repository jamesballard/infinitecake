DELIMITER $$

DROP PROCEDURE IF EXISTS `map_users_to_person`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `map_users_to_person`(
  IN customer_id INT(11)
)
    MODIFIES SQL DATA
BEGIN
  /*
    All 'DECLARE' statements must come first
  */
  -- Declare '_val' variables to read in each record from the cursor
  DECLARE user_id_val INT(11);  
  DECLARE user_idnumber_val VARCHAR(255);
  DECLARE system_id_val INT(11);
  DECLARE person_id_val INT(11);
  -- Declare variables used just for cursor and loop control
  DECLARE no_more_rows BOOLEAN;
  DECLARE loop_cntr INT DEFAULT 0;
  DECLARE num_rows INT DEFAULT 0;
  -- Declare the cursor
  DECLARE users_cur CURSOR FOR
    SELECT u.id, u.idnumber, u.system_id, u.person_id 
    FROM users u
    LEFT JOIN systems s ON s.id = u.system_id
    WHERE s.customer_id = customer_id;
  -- Declare 'handlers' for exceptions
  DECLARE CONTINUE HANDLER FOR NOT FOUND
    SET no_more_rows = TRUE;
  /*
    Now the programming logic
  */
  -- 'open' the cursor and capture the number of rows returned
  -- (the 'select' gets invoked when the cursor is 'opened')
  OPEN users_cur;
  SELECT FOUND_ROWS() INTO num_rows;
  the_loop: LOOP
    FETCH  users_cur
    INTO   user_id_val, user_idnumber_val, system_id_val, person_id_val;
    -- break out of the loop if
      -- 1) there were no records, or
      -- 2) we've processed them all
    IF no_more_rows THEN
        CLOSE users_cur;
        LEAVE the_loop;
    END IF;
    
    -- Update fact aggregation tables
    INSERT INTO persons (idnumber, customer_id, created, modified)
	VALUES (user_idnumber_val, customer_id, NOW(), NOW())
	ON DUPLICATE KEY
	UPDATE id = LAST_INSERT_ID(id);
    
    -- Get dimension ids     
    UPDATE users 
    SET person_id = LAST_INSERT_ID()
    WHERE id = user_id_val;
    
    -- count the number of times looped
    SET loop_cntr = loop_cntr + 1;
  END LOOP the_loop;
  
  -- update the output log so we can see they are the same
  INSERT INTO customer_updates (`type`, `time`, startid, endid, numrows, processedrows, customer_id, rule_id)
	VALUES (1, NOW(), NULL, NULL, num_rows, loop_cntr, customer_id, NULL);
  
  -- Update customer record 
  INSERT INTO customer_status (`type`, `time`, startid, endid, customer_id, rule_id) 
	VALUES (1, NOW(), NULL, NULL, customer_id, NULL)
	ON DUPLICATE KEY
	UPDATE `time` = NOW();
  
END$$

DELIMITER ;