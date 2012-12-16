DELIMITER $$

USE `infinitecake`$$

DROP TRIGGER /*!50032 IF EXISTS */ `aggregrate_user_actions`$$

CREATE
    /*!50017 DEFINER = 'root'@'localhost' */
    TRIGGER `aggregrate_user_actions` BEFORE INSERT ON `actions` 
    FOR EACH ROW BEGIN
        DECLARE time_id INTEGER;
	DECLARE date_id INTEGER;
	DECLARE verb_id INTEGER;
	
	SELECT id INTO time_id
	  FROM dimension_time
	  WHERE fulltime = FROM_UNIXTIME(new.time, '%H:%i:%s');
	
	SELECT id INTO date_id
	  FROM dimension_date
	  WHERE DATE = FROM_UNIXTIME(new.time, '%Y-%m-%d');
	  
        IF NOT EXISTS (SELECT id FROM dimension_verb WHERE sysname=new.name)
	THEN 
	  INSERT INTO dimension_verb (sysname)
	  VALUES (new.name);
	END IF;
	   
	SELECT id INTO verb_id
	  FROM dimension_verb
	  WHERE sysname = new.name;
	
	INSERT INTO fact_user_actions_date (user_id, module_id, verb_id, dimension_date_id, total, production, consumption, distribution, exchange, operation)
	    VALUES (new.user_id, new.module_id, verb_id, dimension_date_id, 1, 0, 0, 0, 0, 0)
	    ON DUPLICATE KEY
	    UPDATE total = total+1;
	
	INSERT INTO fact_user_actions_time (user_id, dimension_time_id, total)
	    VALUES (new.user_id, dimension_time_id, 1)
	    ON DUPLICATE KEY
	    UPDATE total = total+1;
	
	IF new.type = 1 THEN 
	      UPDATE fact_user_actions_date SET production = production+1
	      WHERE user_id = new.user_id
	        AND module_id = new.module_id
	        AND verb_id = verb_id
	        AND date_id = date_id
	        AND time_id = time_id; 	 
	END IF;     
	IF new.type = 2 THEN UPDATE fact_user_actions_date SET consumption = consumption+1
	      WHERE user_id = new.user_id
	        AND module_id = new.module_id
	        AND verb_id = verb_id
	        AND date_id = date_id
	        AND time_id = time_id;
	END IF; 
	IF new.type = 3 THEN UPDATE fact_user_actions_date SET distibution = distibution+1
	      WHERE user_id = new.user_id
	        AND module_id = new.module_id
	        AND verb_id = verb_id
	        AND date_id = date_id
	        AND time_id = time_id;
	END IF; 
	IF new.type = 4 THEN UPDATE fact_user_actions_date SET exchange = exchange+1
	      WHERE user_id = new.user_id
	        AND module_id = new.module_id
	        AND verb_id = verb_id
	        AND date_id = date_id
	        AND time_id = time_id;
	END IF; 
	IF new.type = 5 THEN UPDATE fact_user_actions_date SET operation = operation+1
	      WHERE user_id = new.user_id
	        AND module_id = new.module_id
	        AND verb_id = verb_id
	        AND date_id = date_id
	        AND time_id = time_id;
	END IF; 
	
    END;
$$

DELIMITER ;