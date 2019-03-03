<?php
if (!function_exists('icon')) {
    /**
     * Insert a content-less span that will be styled with an icon font
     * @param  array  $opts Options array
     * @return string       HTML string for the styled span
     */
    function icon($opts)
    {
        $classes = array(
            'icon',
            'icon--' . $opts['type']
        );
        $options = array('size', 'color');
        foreach ($options as $opt) {
            if (array_key_exists($opt, $opts)) {
                array_push($classes, "icon--$opt-" . $opts[$opt]);
            }
        }
        $class_string = implode(' ', $classes);
        $html = '<span class="' . $class_string . '" aria-hidden="true"></span>';
        return $html;
    }
}
