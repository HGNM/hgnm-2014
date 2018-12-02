<?php
if (!function_exists('colloquium_list')) {
    /**
     * Display a list of colloquia
     * @param  array  $opts Options array
     * @return string HTML string for a <ul> listing colloquia
     */
    function colloquium_list($opts)
    {
        $show_map_link = array_key_exists('show_map_link', $opts) ? $opts['show_map_link'] : false;

        $html = '<ul>';
        foreach ($opts['colloquia'] as $colloquium) {
            $html .= component('colloquium_list_item', $colloquium->ID);
        }
        $html .= '</ul>';
        if ($show_map_link) {
            $html .= component('colloquium_location_link');
        }
        return $html;
    }
}
