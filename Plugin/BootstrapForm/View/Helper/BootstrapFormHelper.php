<?php
App::uses('FormHelper', 'View/Helper');

class BootstrapFormHelper extends FormHelper {

    public $helpers = array('Html', 'Form');

    /**
     * Default input values with bootstrap classes
     * Changed order of error and after to be able to display validation error messages inline
     */
    protected $_inputDefaults = array(
        'format' => array('before', 'label', 'between', 'input', 'error', 'after'),
        'div' => array('class' => 'form-group'),
        'label' => array('class' => 'col-sm-2 control-label'),
        'between' => '<div class="col-sm-10">',
        'after' => '</div>',
        'class' => 'form-control',
        'error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline'))
    );

    /**
     * Added an array_merge_recursive for labels to combine $_inputDefaults with specific view markup for labels like custom text.
     * Also removed null array for options existing in $_inputDefaults.
     */
    protected function _parseOptions($options) {
        if(!empty($options['label'])) {
            //manage case 'label' => 'your label' as well as 'label' => array('text' => 'your label') before array_merge()
            if(!is_array($options['label'])) {
                $options['label'] = array('text' => $options['label']);
            }
            $options['label'] = array_merge_recursive($options['label'], $this->_inputDefaults['label']);
        }
        $options = array_merge(
            array('before' => null),
            $this->_inputDefaults,
            $options
        );
        return parent::_parseOptions($options);
    }

    /**
     * Creates a standard form create element with Twitter Bootstrap wrappings.
     *
     * @param string $name
     * @return string HTML Form create output
     */
    public function create($model = null, $options = array()) {
        $class = array(
            'class' => 'form-horizontal',
            'role' => 'form'
        );
        $options = array_merge($class, $options);
        return parent::create($model, $options);
    }

    /**
     * Creates a standard form end element with Twitter Bootstrap wrappings.
     *
     * @param string $name
     * @return string HTML Form end output
     */
    public function end($options = array(), $secureAttributes = Array()) {
        $style = isset($options['style']) ? $options['style'] : null;
        $size = isset($options['size']) ? $options['size'] : null;
        $class = $this->generateStyle($style, $size);
        //Setup the default Twitter Bootstrap options
        $class = array(
            'class' => $class,
            'div' => array(
                'class' => 'form-group',
            ),
            'before' => '<div class="col-sm-offset-2 col-sm-10">',
            'after' => '</div>'
        );
        $options = array_merge($class, $options);
        return parent::end($options);
    }

    /**
     * Creates a standard form end element with Twitter Bootstrap wrappings.
     *
     * @param string $name
     * @return string HTML Form end output
     */
    public function button($label='Submit', $options=array(), $style=null, $size = null) {
        $class = $this->generateStyle($style, $size);
        //Setup the default Twitter Bootstrap options
        $bootstrap = array(
            'class' => $class,
            'div' => array(
                'class' => 'form-group',
            ),
            'before' => '<div class="col-sm-offset-2 col-sm-10">',
            'after' => '</div>'
        );
        $options = array_merge($bootstrap, $options);
        return $this->Form->submit($label, $options);
    }

    private function generateStyle($style=null, $size=null) {
        $class = 'btn';
        if($size) {
            $class .= ' btn-'.$size;
        }
        if($style) {
            $class .= ' btn-'.$style;
        }
        return $class;
    }

    /**
     * modified the first condition with a more general empty() otherwise if $default is an empty array
     * !is_null() returns true and $this->_inputDefaults is erased
     */
    public function inputDefaults($defaults = null, $merge = false) {
        if (!empty($defaults)) {
            if ($merge) {
                $this->_inputDefaults = array_merge($this->_inputDefaults, (array)$defaults);
            } else {
                $this->_inputDefaults = (array)$defaults;
            }
        }
        return $this->_inputDefaults;
    }
}