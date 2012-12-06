infinitecake
============

This is the initial Cake PHP version setup for the site

## CakePHP

http://cakephp.org/

## Branching Strategy

Git Flow: http://nvie.com/posts/a-successful-git-branching-model/

##Installation

1. Clone the repository to web root
2. Update submodules (git submodule update --init)
3. Create temporary folders (tmp/cache/models tmp/cache/persistent tmp/logs)
4. Import the database and data from /Config/Schema/infinitecake.sql
5. Create database configuration file (config/database.php)

```php
    public $default = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => '{user}',
		'password' => '{password}',
		'database' => 'infinitecake',
		'prefix' => '',
		//'encoding' => 'utf8',
	);
```

## Use - Current State

Refer to Google Docs for further details.

Interface 1: Activity Statistics (Involvement)

```
Access via the 'Involvement' link: /stats
View/Stats/index.ctp
Controller/StatsController.php
Model/MdlLog
```

Interface 2: Module Treemap (Interaction) 

```
Accessed via the 'Interaction' link: /designs
View/Designs/index.ctp
View/Designs/createfile.ctp *
Controller/DesignsController.php
Model/MdlLog
Model/MdlCourse
Model/MdlCourseCategories
```

NB:  This view requires a TSV file to be created which is not efficient (takes a long while and times out).

## Plugins

* Drastic Treemap: http://www.drasticdata.nl/DDHome.php?m=drastictreemap
* Google Visualisations: https://developers.google.com/chart/interactive/docs/gallery
* SWF Object: http://code.google.com/p/swfobject/
