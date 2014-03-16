<?php
if (!empty($options)) {
    echo '<option value="">' . __('pleaseSelect') . '</option>';
    foreach ($options as $k => $v) {
        echo '<option value="' . $k . '">' . h($v) . '</option>';
    }
} else {
    echo '<option value="0">' . __('No option required') . '</option>';
}
?>