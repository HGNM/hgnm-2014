<?php
if (!function_exists('colloquium_location_link')) {
    /**
     * Display a link to the colloquium location on Google Maps
     * @param  array  $opts Options array with optional key location_only
     * @return string HTML string for the component
     */
    function colloquium_location_link(array $opts)
    {
        $location_only = array_key_exists('location_only', $opts) ? $opts['location_only'] : false;

        $classes = $location_only ? 'location map-popup' : 'map-popup';

        $html = '<p class="' . $classes . '">';
        if ($location_only) {
            $html .= get_field('colloquium_location_short', 'option');
        } else {
            $html .= get_field('colloquium_location_long', 'option');
        }
        $html .= ', <a href="https://www.google.com/maps/place/Music+Bldg,+Harvard+University,+Cambridge,+MA+02138/@42.3769058,-71.1170215,15z/data=!4m2!3m1!1s0x89e3774164253f4d:0x4139366065ac28ee">' .
          'Harvard University Music Building' .
          component('icon', array('type' => 'location')) .
        '</a>';
        $html .= '</p>';
        return $html;
    }
}
