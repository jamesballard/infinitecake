DELIMITER $$

DROP PROCEDURE IF EXISTS `aggregate_summed_rule_conditions`$$

CREATE DEFINER=`admin`@`%` PROCEDURE `aggregate_summed_rule_conditions`(
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
  DECLARE action_id_val INT(11);  
  DECLARE time_id_val INT(11);
  DECLARE date_id_val INT(11);
  DECLARE time_val DATETIME;
  DECLARE system_id_val INT(11);
  DECLARE artefact_id_val INT(11);
  DECLARE module_id_val INT(11);
  DECLARE group_id_val INT(11);
  DECLARE course_id_val INT(11);
  DECLARE user_id_val INT(11);
  DECLARE condition_id_val INT(11);
  DECLARE rule_type_val INT(2);
  DECLARE dimension_verb_id_val INT(11);
  -- Declare variables used just for cursor and loop control
  DECLARE no_more_rows BOOLEAN;
  DECLARE inside_null BOOLEAN;
  DECLARE loop_cntr INT DEFAULT 0;
  DECLARE num_rows INT DEFAULT 0;
  -- Declare the cursor
  DECLARE actions_cur CURSOR FOR
    SELECT a.id, a.time, a.system_id, a.user_id, a.group_id, a.module_id, a.dimension_verb_id 
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
    INTO   action_id_val, time_val, system_id_val, user_id_val, group_id_val, module_id_val, dimension_verb_id_val;
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
    
    SELECT `type` INTO rule_type_val
          FROM rules
          WHERE id = rule_id_val;
    
    SELECT artefact_id INTO artefact_id_val
          FROM modules
          WHERE id = module_id_val;
    
    CASE rule_type_val
    WHEN '1' THEN 
	SET condition_id_val = (SELECT c.id  
          FROM conditions c
          LEFT JOIN action_conditions ac ON ac.condition_id = c.id
          LEFT JOIN rule_conditions rc ON rc.condition_id = c.id
	  WHERE ac.action_id = action_id_val
	  AND rc.rule_id = rule_id_val
	);
    WHEN '2' THEN 
	SET condition_id_val = (SELECT c.id  
          FROM conditions c
          LEFT JOIN dimension_verb_conditions vc ON vc.condition_id = c.id
          LEFT JOIN rule_conditions rc ON rc.condition_id = c.id
	  WHERE vc.dimension_verb_id = dimension_verb_id_val
	  AND rc.rule_id = rule_id_val
	);
    WHEN '3' THEN 
	SET condition_id_val = (SELECT c.id  
          FROM conditions c
          LEFT JOIN module_conditions mc ON mc.condition_id = c.id
          LEFT JOIN rule_conditions rc ON rc.condition_id = c.id
	  WHERE mc.module_id = module_id_val
	  AND rc.rule_id = rule_id_val
	);
    WHEN '4' THEN 
	SET condition_id_val = (SELECT c.id  
          FROM conditions c
          LEFT JOIN artefact_conditions ac ON ac.condition_id = c.id
          LEFT JOIN rule_conditions rc ON rc.condition_id = c.id
	  WHERE ac.artefact_id = artefact_id_val
	  AND rc.rule_id = rule_id_val
	);
    WHEN '5' THEN 
	SET condition_id_val = (SELECT c.id  
          FROM conditions c
          LEFT JOIN course_conditions cc ON cc.condition_id = c.id
          LEFT JOIN rule_conditions rc ON rc.condition_id = c.id
	  WHERE cc.course_id = course_id_val
	  AND rc.rule_id = rule_id_val
	);
    END CASE;    
      
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
	VALUES (4, NOW(), idstart, idend, num_rows, loop_cntr, customer_id, rule_id_val);
  
  -- Update customer record
  IF EXISTS (SELECT * FROM customer_status WHERE `type` = 4 AND `customer_id` = customer_id AND `rule_id` = rule_id) 
  THEN 
   UPDATE customer_status SET `time` = NOW(), `startid` = idstart, `endid` = idend WHERE `type` = 4 AND `customer_id` = customer_id AND `rule_id` = rule_id;
  ELSE
    INSERT INTO customer_status (`type`, `time`, startid, endid, customer_id, rule_id) 
	VALUES (4, NOW(), idstart, idend, customer_id, rule_id);
  END IF;
  
END$$

DELIMITER ;