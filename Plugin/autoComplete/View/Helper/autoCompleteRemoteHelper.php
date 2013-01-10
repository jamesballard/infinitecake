<?php
    /**
     * CakePHP helper that acts as a wrapper for Drastic Data Tree Maps.
     */
class autoCompleteRemoteHelper extends AppHelper {

    public $helpers = array('Html');

    /**
     * Creates javascript for the auto-complete form.
     *
     * @param string $name - the input id to act on
     * @param string $data - url of remote data source in JSON format
     * @return string Div tag output
     */
    public function init($name,$data) {
        $o = '<script>
				  $(function() {			 
				    $( "#'.$name.'" ).autocomplete({
				      source: "'.$data.'",
				      minLength: 3,
				      select: function(event, ui) {
				        $("#'.$name.'").val(ui.item.label);
				        $("#'.$name.'id").val(ui.item.value);
				        return false; // Prevent the widget from inserting the value.
				      },
				      focus: function(event, ui) {
				        $("#'.$name.'").val(ui.item.label);
				        return false; // Prevent the widget from inserting the value.
				      }
				     })		
				  });
				</script>';

        return $o;
    }
}