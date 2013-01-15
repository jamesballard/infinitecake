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
5. Import the following data:
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

1. Insert date dimension days
   
   ```mysql
      INSERT INTO dimension_date (id, date)
      SELECT number, DATE_ADD( '2008-01-01', INTERVAL number DAY )
      FROM numbers
      WHERE DATE_ADD( '2008-01-01', INTERVAL number DAY ) BETWEEN '2008-01-01' AND '2020-01-01'
      ORDER BY number;
   ```

2. Update date dimension fields

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
   
3. Insert time dimension fields

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
      cake acl grant Membership::Users UserProfile
      cake acl grant Membership::Users CourseProfile
      cake acl grant Membership::Users Stats
   ```
   
   Where controllers is a parent of all individual controllers, while users are given access to specific page sets

## Use

Refer to Google Docs for further details.

1. Import data
2. Aggregate standard data facts
3. Create rules/conditions
4. Aggregate rule/condition facts

