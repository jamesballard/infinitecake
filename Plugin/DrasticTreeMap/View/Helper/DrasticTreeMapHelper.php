<?php
    /**
     * CakePHP helper that acts as a wrapper for Drastic Data Tree Maps.
     */
class DrasticTreeMapHelper extends AppHelper {

    public $helpers = array('Html', 'Flash.Flash');

    /**
     * Creates a div tag meant to be filled with the Google visualization.
     *
     * @param string $name
     * @return string Script tag output
     */
    public function start($name='treemap',$datafile='/files/DrasticTreemap.xml',$width=1024,$height=768) {
        $this->Flash->init();

        echo $this->Flash->renderSwf(
            'swf/DrasticTreemap.swf',
            $width,
            $height,
            $name,
            array(
                'flashvars' => array(
                    'configFile' => $datafile
                    ),
                'params' => array(),
                'version' => '10.0.0'
            )
        );
    }

    /**
     * Creates a div tag meant to be filled with the Treemap visualization.
     *
     * @param string $name
     * @param array $options
     * @return string Div tag output
     */
    public function visualize($name='treemap') {
        $this->Html->script('swfobject');

        $o = '<div>';
        $o .= '<div id="'.$name.'">';
        $o .= '<a href="http://www.adobe.com/go/getflashplayer">';
        $o .= '<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a>';
        $o .= '</div>';
        $o .= '</div>';

        return $o;
    }






}