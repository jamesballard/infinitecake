infinitecake
============

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

##Installation

1. Clone the repository to web root
2. Update submodules (git submodule update --init)
3. Create temporary folders (tmp/cache/models tmp/cache/persistent tmp/logs)
4. Import the database and data from /Config/Schema/infinitecake.sql
5. Import the following data to create the 'admin' user:
   * /Config/Schema/aros.sql
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
      cake acl grant Membership::Managers controllers/Conditions
      cake acl grant Membership::Managers controllers/Groups
      cake acl grant Membership::Managers controllers/Members
      cake acl grant Membership::Managers controllers/Modules
      cake acl grant Membership::Managers controllers/Pages
      cake acl grant Membership::Managers controllers/People
      cake acl grant Membership::Managers controllers/Rules
      cake acl grant Membership::Managers controllers/Systems
      cake acl grant Membership::Managers controllers/Users
      cake acl grant Membership::Managers controllers/UserProfile
      cake acl grant Membership::Managers controllers/CourseProfile
      cake acl grant Membership::Managers controllers/Stats
      cake acl grant Membership::Managers jsonfeed
      cake acl grant Membership::Users controllers/Pages
      cake acl grant Membership::Users controllers/UserProfile
      cake acl grant Membership::Users controllers/CourseProfile
      cake acl grant Membership::Users controllers/Stats
      cake acl grant Membership::Users jsonfeed
   ```
   
   Where controllers is a parent of all individual controllers, while users are given access to specific page sets

## Upgrade

If database changes are made as part of an upgrade then the following should be used to create a new schema

   ```cli
         cake schema generate infiniterooms
   ```

This will create Config/Schema/infiniterooms.php

1. Get the latest code

   ```git
      git pull
   ```

2. Create new tables

   ```cli
         Console/cake schema create infiniterooms
   ```

   NB: choose 'n' to drop existing tables and 'y' to create new tables - if tables are dropped then all data is lost!

3. Update the database schema

   ```cli
         Console/cake schema update infiniterooms
   ```

4. Update any new ACOs

   ```cli
      Console/cake AclExtras.AclExtras aco_sync
   ```

5. Add any new permissions

   ```cli
      Console/cake acl grant Membership::Managers controllers/Courses
      Console/cake acl grant Membership::Managers controllers/Departments
      Console/cake acl grant Membership::Managers controllers/Guides
      Console/cake acl grant Membership::Managers controllers/CustomerStatuses
      Console/cake acl grant Membership::Users controllers/Guides
   ```

   NB: We need to store/record these somewhere so the upgrade script can find them.
