<?php
if (!function_exists('button_link')) {
  function button_link($opts)
  {
    $href = $opts['href'];
    $inner = $opts['html'];
    $class_arr = array_key_exists('classes', $opts) ? $opts['classes'] : array();
    array_push($class_arr, 'button-link');
    $classes = implode(' ', $class_arr);

    $html = '<a class="' . $classes . '" href="' . $href . '">' .
               $inner .
            '</a>';
    return $html;
  }
}

return button_link($opts);
