<?php
if (!function_exists('colloquium_list')) {
    function colloquium_list($opts)
    {
        $show_map_link = array_key_exists('show_map_link', $opts) ? $opts['show_map_link'] : false;

        echo '<ul>';
        foreach ($opts['colloquia'] as $colloquium) {
            echo component('colloquium_list_item', $colloquium->ID);
        }
        echo '</ul>';
        if ($show_map_link) {
            echo component('colloquium_location_link');
        }
    }
}

colloquium_list($opts);
