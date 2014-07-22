<?php
/**
 * Abstract super-model for Facts
 *
 * @package    model
 * @subpackage FactModel
 * @copyright  &copy; 2014 Infinite Rooms Ltd  {@link http://www.infiniterooms.co.uk}
 * @author     james.ballard
 * @version    1.0
 */

class FactModel extends AppModel {

    var $name = 'FactModel';

    // I prefer using findFacts() directly but like this you could quickly make a find type of the whole thing.
    function find($type='all', $options = array()) {
        switch ($type) {
            case 'facts':
                return $this->findFacts($options['fact'],$options);
            default:
                return parent::find($type, $options);
        }
    }

    // this method will always be specific to each fact model.
    function gather( $start_time = null ) {
        debug($this->alias.' must implement gather()');
        return false;
    }

    //-- 'mapped' re-arranges the results in an array-hierarchy according to the group parameter.
    function findFacts($fact, $options) {
        $defaults = array(
            'conditions' =>'',
            'fields' => array(),
            'order' => '',
            'group' => '',
            'joins' => array(),
            'mapped'=>false
        );
        $options = array_merge($defaults, $options);

        $dimensions = $this->getAssociated('belongsTo');

        $extraJoins = array();

        // Get array of dimensions used in query
        $usedDimensions = array();
        foreach ($options['conditions'] as $k => $v) {
            $alias = strtok($k, '.');
            $usedDimensions[] = $alias;
            switch($alias) {
                case 'Course':
                    $usedDimensions[] = 'Group';
                    $extraJoins[] = array(
                        'table' => 'courses',
                        'alias' => 'Course',
                        'type' => 'LEFT',
                        'conditions' => array(
                            'Course.id = Group.course_id'
                        )
                    );
                    break;
                case 'Artefact':
                    $usedDimensions[] = 'Module';
                    $extraJoins[] = array(
                        'table' => 'artefacts',
                        'alias' => 'Artefact',
                        'type' => 'LEFT',
                        'conditions' => array(
                            'Artefact.id = Module.artefact_id'
                        )
                    );
                    break;
                case 'Person':
                    $usedDimensions[] = 'User';
                    $extraJoins[] = array(
                        'table' => 'persons',
                        'alias' => 'Person',
                        'type' => 'LEFT',
                        'conditions' => array(
                            'Person.id = User.person_id'
                        )
                    );
                    break;
                default:
                    break;
            }
        }

        $usedDimensions = array_unique($usedDimensions);

        $this_name = $this->alias;
        foreach ( $dimensions as $k => $dim ) {
            if (in_array($dim, $usedDimensions)) {
                $joinType = $dim == 'Module' ? 'LEFT' : 'INNER'; // The Module dimension can be zero and so doesn't support INNER.
                $fk = $this->belongsTo[$dim]['foreignKey'];
                $joins[] = array(
                    'table' => $this->$dim->useTable,
                    'alias' => $dim,
                    'type' => $joinType,
                    'conditions' => array(
                        "$dim.id = $this_name.$fk"
                    )
                );
            }
        }
        // Join order is important so add the second level joins after.
        $joins = array_merge($joins, $extraJoins);

        $fields = array_merge($options['fields'], array($fact.' AS '.$this->alias.'__fact'));
        if (!empty($options['group'])) {
            $fields[] = $options['group'];
        }
        if (!empty($options['group'])) {
            $fields[] = $options['order'];
        }
        $fields = array_unique($fields);

        $db = ConnectionManager::getDataSource($this->useDbConfig);
        if (!empty($joins)) {
            $count = count($joins);
            for ($i = 0; $i < $count; $i++) {
                if (is_array($joins[$i])) {
                    $joins[$i] = $db->buildJoinStatement($joins[$i]);
                }
            }
        }
        $query = $db->renderStatement('select', array(
            'conditions' => $db->conditions($options['conditions'], true, true, $this),
            'fields' => implode(',', $fields),
            'table' => $this->useTable,
            'alias' => $this->alias,
            'order' => $db->order($options['order']),
            'limit' => '',
            'joins' => implode(' ', $joins),
            'group' => $db->group($options['group'])
        ));
        $raw_facts = $this->query($query);

        if ( $options['mapped'] ) {
            $group_str = str_replace(' ','',$options['group']);
            $groups = explode(',',$group_str);
            $last_group = array_pop($groups);

            $mapped_facts = array();
            foreach ( $raw_facts as $key => $val ) {
                $domain =& $mapped_facts;
                foreach ( $groups as $group ) {
                    $gKey = Set::extract($raw_facts,$key.'.'.$group);
                    if ( !isset($domain[ $gKey ]) ) {
                        $domain[ $gKey ] = array();
                    }
                    $domain =& $domain[ $gKey ];
                }
                $gKey = Set::extract($raw_facts,$key.'.'.$last_group);
                $domain[$gKey] = $val;
            }

            return $mapped_facts;
        } else {
            return $raw_facts;
        }
    }

    function saveFact($fact) {

        $keys = array_keys($fact[$this->alias]);
        $values = array_values($fact[$this->alias]);

        $fields = $this->_getFactFields();
        $update = '';
        foreach ( $fields as $field ) {
            $update .= ' `'.$field.'` = '.$fact[$this->alias][$field].',';
        }

        $query = 'INSERT INTO `'.$this->useTable.'` (`'. implode('`,`', $keys) .'`) VALUES ('. implode(',', $values) .') ON DUPLICATE KEY UPDATE'.substr($update,0,-1);
        $this->query($query);
    }

    function _getFactFields() {
        $fields = array();
        foreach ( $this->_schema as $field => $params ) {
            if ( !isset($params['key']) ) {
                $fields[] = $field;
            }
        }
        return $fields;
    }
}