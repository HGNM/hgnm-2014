<?php
if (!function_exists('icon')) {
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

return icon($opts);
