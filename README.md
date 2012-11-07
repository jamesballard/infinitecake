infinitecake
============

This is the initial Cake PHP version setup for the site

##Installation

1. Clone the respository to web root
2. Create a new database on localhost
3. Import the data from /config/schema/lcmoodle2.sql
4. Create database configuration file (config/database.php)

```php
public $default = array(
    'datasource' => 'Database/Mysql',
    'persistent' => false,
    'host' => 'localhost',
    'port' => '',
    'login' => '{user}',
    'password' => '{password}',
    'database' => 'lcmoodle2',
    'schema' => '',
    'prefix' => 'mdl_',
    'encoding' => ''
);
```

## Use

Open the site in a browser - the first load may be slower while cache is created

