<?php
    /**
     * CakePHP helper that acts as a wrapper for Drastic Data Tree Maps.
     */
class infinityHelper extends AppHelper {

    public $helpers = array('Html');

    /**
     * Creates javascript for the auto-complete form.
     *
     * @param string $name - the input id to act on
     * @param string $data - url of remote data source in JSON format
     * @return string Div tag output
     */
    public function init($list, $listitem) {
        $o = '<script>
				  var $el = $("#'.$list.'");
				  var listView = new infinity.ListView($el);
				 
				  // ... When adding new content:
				 
				  var $newContent = $("<p>Hello World</p>");
				  listView.append($newContent);
				 
				  // ... To remove items from a list:
				 
				  var listItems = listView.find(".'.$listitem.'");
				  for(var index = 0, length = listItems.length; index < length; index++) {
				    listItems[index].remove();
				  }
				</script>';

        return $o;
    }
}