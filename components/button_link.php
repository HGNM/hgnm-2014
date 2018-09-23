<?php
if (!function_exists('button_link')) {
    function button_link($opts)
    {
        $inner = $opts['html'];

        $class_arr = array('button-link');
        if (array_key_exists('classes', $opts)) {
            $class_arr = array_merge($class_arr, $opts['classes']);
        }
        $class_string = implode(' ', $class_arr);

        $attributes = array();
        $attributes['class'] = $class_string;
        $attributes['href'] = $opts['href'];
        if (array_key_exists('attrs', $opts)) {
            $attributes = array_merge($attributes, $opts['attrs']);
        }

        $attribute_arr = array();
        foreach ($attributes as $name => $value) {
            array_push($attribute_arr, $name . '="' . $value . '"');
        }
        $attribute_string = implode(' ', $attribute_arr);

        return "<a $attribute_string>$inner</a>";
    }
}

return button_link($opts);
