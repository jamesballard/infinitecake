<?php
    /**
     * CakePHP helper that acts as a wrapper for Drastic Data Tree Maps.
     */
class BootstrapFormHelper extends AppHelper {

    public $helpers = array('Html', 'Form');

    /**
     * Creates a standard form create element with Twitter Bootstrap wrappings.
     *
     * @param string $name
     * @return string HTML Form create output
     */
    public function create($name='BootForm', $options=array()) {
        //Setup the default Twitter Bootstrap options
        $bootstrap = array(
            'class' => 'form-horizontal',
            'inputDefaults' => array(
                'format' => array('before', 'label', 'between', 'input', 'error', 'after'),
                'div' => array('class' => 'control-group'),
                'label' => array('class' => 'control-label'),
                'between' => '<div class="controls">',
                'after' => '</div>',
                'error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline')),
            ));
        $options = array_merge($bootstrap, $options);
        return $this->Form->create("$name", $options);
    }

    /**
     * Creates a standard form end element with Twitter Bootstrap wrappings.
     *
     * @param string $name
     * @return string HTML Form end output
     */
    public function end($label='Submit', $options=array()) {
        //Setup the default Twitter Bootstrap options
        $bootstrap = array(
            'label' => __("$label"),
            'class' => 'btn',
            'div' => array(
                'class' => 'control-group',
            ),
            'before' => '<div class="controls">',
            'after' => '</div>'
        );
        $options = array_merge($bootstrap, $options);
        return $this->Form->end($options);
    }
}