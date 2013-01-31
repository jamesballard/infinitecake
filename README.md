infinitecake
============

This is the initial Cake PHP version setup for the site

## CakePHP

http://cakephp.org/

## Git ignore global ##

```
# CakePHP files #
#######################
tmp/*
[Cc]onfig/core.php
[Cc]onfig/database.php
app/tmp/*
app/[Cc]onfig/core.php
app/[Cc]onfig/database.php
!empty
```

## Branching Strategy

Git Flow: http://nvie.com/posts/a-successful-git-branching-model/

##Installation

1. Clone the repository to web root
2. Update submodules (git submodule update --init)
3. Create temporary folders (tmp/cache/models tmp/cache/persistent tmp/logs)
4. Import the database and data from /Config/Schema/infinitecake.sql
5. Import the following data to create the 'admin' user:
   * /Config/Schema/memberships.sql
   * /Config/Schema/members.sql
6. Create database configuration file (config/database.php)

```php
    public $default = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => '{host}',
		'login' => '{user}',
		'password' => '{password}',
		'database' => 'infinitecake',
		'prefix' => '',
		//'encoding' => 'utf8',
	);
```

##Data Configuration

1. Set up numbers

   ```mysql
      INSERT INTO numbers_small VALUES (0),(1),(2),(3),(4),(5),(6),(7),(8),(9);
      
      INSERT INTO numbers
      SELECT thousands.number * 1000 + hundreds.number * 100 + tens.number * 10 + ones.number
      FROM numbers_small thousands, numbers_small hundreds, numbers_small tens, numbers_small ones
      LIMIT 1000000;
   ```

2. Insert date dimension days
   
   ```mysql
      INSERT INTO dimension_date (id, date)
      SELECT number, DATE_ADD( '2008-01-01', INTERVAL number DAY )
      FROM numbers
      WHERE DATE_ADD( '2008-01-01', INTERVAL number DAY ) BETWEEN '2008-01-01' AND '2020-01-01'
      ORDER BY number;
   ```

3. Update date dimension fields

   ```mysql
      UPDATE dimension_date SET
      timestamp =   UNIX_TIMESTAMP(date),
      day_of_week = DATE_FORMAT( date, "%w" ), 
      day_of_week_name = DATE_FORMAT( date, "%W" ),
      day_of_month = DATE_FORMAT( date, "%d" ),
      day_of_year = DATE_FORMAT( date, "%j" ),
      weekend =     IF( DATE_FORMAT( date, "%W" ) IN ('Saturday','Sunday'), 1, 0),
      month =       DATE_FORMAT( date, "%m" ),
      month_name =  DATE_FORMAT( date, "%M" ),
      year =        DATE_FORMAT( date, "%Y" ),
      week_starting_monday = DATE_FORMAT( date,"%v" ),
      week_starting_sunday = DATE_FORMAT( date,"%V" ),
      month_day =   DATE_FORMAT( date, "%d" );
   ```
   
4. Insert time dimension fields

   ```mysql
      CALL `infinitecake`.`timedimbuild`();
   ```

##Set up Access Control Permissions

Use the cakePHP command line interface from docroot home

1. To create ACOs for root controller 

   ```cli
      cake acl create aco root controllers
   ```
   
2. Use the ACLExtras plugin to sync the ACOs
   
   ```cli
      cake AclExtras.AclExtras aco_sync
   ```

3. Using aliases you can then grant access permissions through CLI

   ```cli
      cake acl grant Membership::Administrators controllers
      cake acl grant Membership::Managers Conditions
      cake acl grant Membership::Managers Groups
      cake acl grant Membership::Managers Members
      cake acl grant Membership::Managers Modules
      cake acl grant Membership::Managers Pages
      cake acl grant Membership::Managers People
      cake acl grant Membership::Managers Rules
      cake acl grant Membership::Managers Systems
      cake acl grant Membership::Managers Users
      cake acl grant Membership::Managers UserProfile
      cake acl grant Membership::Managers CourseProfile
      cake acl grant Membership::Managers Stats
      cake acl grant Membership::Managers jsonfeed
      cake acl grant Membership::Users Pages
      cake acl grant Membership::Users UserProfile
      cake acl grant Membership::Users CourseProfile
      cake acl grant Membership::Users Stats
      cake acl grant Membership::Users jsonfeed
   ```
   
   Where controllers is a parent of all individual controllers, while users are given access to specific page sets

## Use - new customer

1. Set up customer via GUI
   * http://{url}/customers
   * http://{url}/members
   * http://{url}/systems
2. Import data via mooncake (temp) or with plug-in installation
3. Combine users into persons 
   
   ```mysql
      CALL `infinitecake`.`map_users_to_person`({customer_id});
   ```

4. Aggregate standard data facts
   ```mysql
      CALL `infinitecake`.`aggregate_summed_actions`({customer_id},{startdate},{enddate});
   ```
5. Create rules/conditions via GUI
   * http://{url}/rules
   * http://{url}/conditions
6. Aggregate rule/condition facts
   ```mysql
      CALL `infinitecake`.`aggregrate_summed_rule_conditions`({customer_id},{startdate},{enddate},{rule_id});
   ```
7. Aggregate IP facts (currently processed as exception case)
   ```mysql
      CALL `infinitecake`.`aggregrate_summed_ip_conditions`({customer_id},{startdate},{enddate},{rule_id});
   ```

## Admin Maintenance

1. Keep verbs list up to date via language file.

2. Keep artefact types up to date via GUI: http://{url}/artefacts

3. Update aggregations as new data is add (e.g. new action imnport or new rule creation) via CLI
