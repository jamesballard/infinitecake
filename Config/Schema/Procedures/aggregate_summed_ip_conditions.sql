DELIMITER $$

DROP PROCEDURE IF EXISTS `aggregate_summed_ip_conditions`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `aggregate_summed_ip_conditions`(
  IN customer_id INT(11),
  IN idstart INT(11),
  IN idend INT(11),
  IN rule_id_val INT(11)
)
    MODIFIES SQL DATA
BEGIN
  /*
    All 'DECLARE' statements must come first
  */
 
  -- Declare '_val' variables to read in each record from the cursor
  DECLARE time_id_val INT(11);
  DECLARE date_id_val INT(11);
  DECLARE time_val DATETIME;
  DECLARE system_id_val INT(11);
  DECLARE group_id_val INT(11);
  DECLARE user_id_val INT(11);
  DECLARE condition_id_val INT(11);
  DECLARE action_id_val INT(11);
  -- Declare variables used just for cursor and loop control
  DECLARE no_more_rows BOOLEAN;
  DECLARE inside_null BOOLEAN;
  DECLARE loop_cntr INT DEFAULT 0;
  DECLARE num_rows INT DEFAULT 0;
  -- Declare the cursor
  DECLARE actions_cur CURSOR FOR
    SELECT a.time, a.system_id, a.user_id, a.group_id, a.id 
    FROM actions a
    LEFT JOIN systems s ON s.id = a.system_id 
    WHERE s.customer_id = customer_id
      AND a.id > idstart
      AND a.id < idend;
      
  -- Declare 'handlers' for exceptions
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET no_more_rows = TRUE;
  
  /*
    Now the programming logic
  */ 
  -- 'open' the cursor and capture the number of rows returned
  -- (the 'select' gets invoked when the cursor is 'opened')
  OPEN actions_cur;
  SELECT FOUND_ROWS() INTO num_rows;
  the_loop: LOOP   
    FETCH  actions_cur
    INTO   time_val, system_id_val, user_id_val, group_id_val, action_id_val;
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
	  WHERE `date` = DATE_FORMAT(time_val, '%Y-%m-%d');
    
    SET condition_id_val = (SELECT IFNULL((SELECT c1.id
	FROM conditions c1
	LEFT JOIN rule_conditions rc ON rc.condition_id = c1.id
	LEFT JOIN conditions c2 ON c2.value LIKE c1.value AND c2.name = 'IP address'
	LEFT JOIN action_conditions ac ON ac.condition_id = c2.id
	WHERE ac.action_id = action_id_val
	AND rc.rule_id = rule_id_val)
	, 0));
         
    IF condition_id_val IS NOT NULL THEN
        -- Update fact aggregation tables
        INSERT INTO fact_summed_verb_rule_datetime (system_id, group_id, user_id, rule_id, condition_id, dimension_date_id, dimension_time_id, total)
	    VALUES (system_id_val, group_id_val, user_id_val, rule_id_val, condition_id_val, date_id_val, time_id_val, 1)
	    ON DUPLICATE KEY
	    UPDATE total = total+1;
    END IF;
    -- count the number of times looped
    SET loop_cntr = loop_cntr + 1;
    
  END LOOP the_loop;
    -- update the output log so we can see they are the same
  INSERT INTO customer_updates (`type`, `time`, startid, endid, numrows, processedrows, customer_id, rule_id)
	VALUES (5, NOW(), idstart, idend, num_rows, loop_cntr, customer_id, NULL);
  
  -- Update customer record 
  INSERT INTO customer_status (`type`, `time`, startid, endid, customer_id, rule_id) 
	VALUES (5, NOW(), idstart, idend, customer_id, NULL)
	ON DUPLICATE KEY
	UPDATE `time` = NOW(),
	startid = idstart,
	endid = idend;
END$$

DELIMITER ;