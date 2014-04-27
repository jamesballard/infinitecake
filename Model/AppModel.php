<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
//App::uses('MyModel', 'Tools.Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
    public $actsAs = array('Containable');
    public $recursive = -1;

    /*
     * Takes a conditions array (2-dimensional), flattens it to 1, and implodes to create unique cache reference.
     *
     * @var array $conditions
     * return string
     */
    public function formatCacheConditions($conditions) {
        return implode('.', array_map(function($value) {
            if (is_array($value)) {
                return implode('.', $value);
            } else {
                return $value;
            }
        }, $conditions));
    }
}
