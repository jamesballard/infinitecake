<?php
/**
 * Created by JetBrains PhpStorm.
 * User: James Ballard
 * Date: 09/08/13
 * Time: 17:26
 * To change this template use File | Settings | File Templates.
 */

class dynamicFormsHelper extends AppHelper {

    public $helpers = array('Html', 'Js');

    /**
     * Creates javascript for the auto-complete form.
     *
     * @param string $name - the input id to act on
     * @param string $data - url of remote data source in JSON format
     * @return string script tag output
     */
    public function autoComplete($name, $data) {
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

    /**
     * Appends HTML elements to a container - designed to add form elements for multi-record forms.
     *
     * @param string $link - the id of the link to act on click
     * @param string $container - the id of the container to add content to
     * @param string $html - the html content you would like to add
     * @return string script tag output
     */
    public function appendHtmlElement($link, $container, $html) {
        $o = '<script type="text/javascript">
                $("#'.$link.'").click(function () {
                    $("#'.$container.'").append(\''.$html.'\');
                    });
            </script>';
        return $o;
    }

    /**
     * Appends HTML elements to a container - designed to add form elements for multi-record forms.
     * Works with HarvestHQ plug-in
     *
     * @param string $link - the id of the link to act on click
     * @param string $container - the id of the container to add content to
     * @param string $html - the html content you would like to add
     * @return string script tag output
     */

    public function addremoveHtmlElement($addlink, $container, $element, $html, $count) {
        //Replace capitalised i and quotation marks from cake form auto-generation.
        $html = str_replace('+I+', '+ i +', $html);
        $html = str_replace('&#039;', '\'', $html);
        //Make sure there are no line endings in html that break js
        $html = $this->cleanLines($html);
        $o = '<script type="text/javascript">
                $(function() {
                    var scntDiv = $("#'.$container.'");
                    var i = '.($count).';

                    $("#'.$addlink.'").on("click", function() {
                        $(\'<'.$element.'>'.$html.'</'.$element.'>\').appendTo(scntDiv);
                        i++;
                        $(".chzn-select").chosen();
                        $(".chzn-select-deselect").chosen({
                            allow_single_deselect:true
                        });
                        return false;
                    });

                    $(".remScnt").on("click", function() {
                        $(this).closest("'.$element.'").remove();
                        return false;
                    });
                });
            </script>';
        return $o;
    }

    protected function cleanLines($html) {
        $output = str_replace(array("\r\n", "\r"), "\n", $html);
        $lines = explode("\n", $output);
        $new_lines = array();

        foreach ($lines as $i => $line) {
            if(!empty($line))
                $new_lines[] = trim($line);
        }
        return implode($new_lines);
    }

    /**
     * Create select option dependents within a form.
     *
     * @param string $master - the id of the select menu that will trigger update on change
     * @param string $dependent - the id of the dependent select to change content
     * @return string script tag output
     */
    public function addSelectionDependency($master, $dependent) {
        $o = '<script type="text/javascript">
                $(function() {
                    $("#'.$master.'").change(function() {
                        var selectedValue = $(this).val();
                        var targeturl = $(this).attr("rel") + "?id=" + selectedValue;
                        $.ajax({
                            type: "get",
                            url: targeturl,
                            beforeSend: function(xhr) {
                            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        },
                            success: function(response) {
                            if (response.content) {
                                $("#'.$dependent.'").html(response.content);
                            }
                        },
                            error: function(e) {
                            alert("An error occurred: " + e.responseText.message);
                            console.log(e);
                        }
                        });
                    });
                });
            </script>';
        return $o;
    }
}