<?php
if (!function_exists('component')) {
    /**
     * Load a template component
     * @param  string $name The name of a component file to load
     * @param  any    $opts Options to pass to component function
     */
    function component($name, $opts = array())
    {
        $template_path = "components/$name.php";
        $template = locate_template($template_path, false, false);
        if (empty($template)) {
            throw new Exception("Template not found at $template_path");
        }
        include_once($template);
        if (!is_callable($name)) {
            throw new Exception("$template_path does not declare a function (or function is not named '$name')");
        }
        return $name($opts);
    }
}
