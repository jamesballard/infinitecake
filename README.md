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

##Set up Access Control

1. The following is set to allow non-authenticated access to MembersController.php and MembersshipsController.php:

```php
	public function beforeFilter() {
    		parent::beforeFilter();
    		$this->Auth->allow('*');
	}
```

2. Create a Membership group via http://{localsite}/memberships/add (e.g. 'Administrators' and 'Users')
3. Create a Member of the group via http://{localsite}/members/add 
4. To create ACOs for each controller use cake bake 
   http://book.cakephp.org/2.0/en/console-and-shells/code-generation-with-bake.html

   ```cake acl create aco root controllers```
   
5. Use the ACLExtras plugin to sync the ACOs
   
   ```cake AclExtras.AclExtras aco_sync```

6. Using aliases (may need to be added manually to tables aros and acos) you can then grant access permissions through CLI

   ```cake acl grant admin controllers```
   
   Where controllers is a parent of all individual controllers

## Use - Current State

Refer to Google Docs for further details.

