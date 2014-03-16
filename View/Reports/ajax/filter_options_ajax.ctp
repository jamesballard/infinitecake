<?php
if (!empty($filter_options)) {
    echo '<option value="">' . __('pleaseSelect') . '</option>';
    foreach ($filter_options as $k => $v) {
        echo '<option value="' . $k . '">' . h($v) . '</option>';
    }
} else {
    echo '<option value="0">' . __('No option required') . '</option>';
}
?>