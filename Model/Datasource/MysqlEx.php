<?php
/**
 * Extended DBO for MySQLi
 *
 * @package    Datasource
 * @subpackage mysql_ex
 * @copyright  &copy; 2014 Infinite Rooms Ltd  {@link http://www.infiniterooms.co.uk}
 * @author     james.ballard
 * @version    1.0
 */

App::uses('Mysql', 'Model/Datasource/Database');

class MysqlEx extends Mysql {
    var $description = "MySQL DBO Driver - Extended";

    // Extended 'resultSet' to allow alias processing
    // Fields should contain '((something)) AS Model__field'
    function resultSet($results) {
        $this->map = array();
        $numFields = $results->columnCount();
        $index = 0;
        $j = 0;

        while ($j < $numFields) {
            $column = $results->getColumnMeta($index);
            if (!empty($column['table'])) {
                $this->map[$index++] = array($column['table'], $column['name']);
            } else {
                if (strpos($column['name'], '__')) {
                    $parts = explode('__', $column['name']);
                    $this->map[$index++] = array($parts[0], $parts[1]);
                } else {
                    $this->map[$index++] = array(0, $column['name']);
                }
            }
            $j++;
        }

    }
}