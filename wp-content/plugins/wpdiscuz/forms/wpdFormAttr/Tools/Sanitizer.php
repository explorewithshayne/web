<?php

namespace wpdFormAttr\Tools;

class Sanitizer {

    public static function sanitize($action, $variable_name, $filter, $default = "") {
        if ($filter === "FILTER_SANITIZE_STRING" || $filter === "FILTER_SANITIZE_TEXTAREA") {
            $glob = INPUT_POST === $action ? $_POST : $_GET;
            if (key_exists($variable_name, $glob)) {
                if ($filter === "FILTER_SANITIZE_TEXTAREA") {
                    return sanitize_textarea_field($glob[$variable_name]);
                } else {
                    return sanitize_text_field($glob[$variable_name]);
                }
            } else {
                return $default;
            }
        }
        $variable = isset($variable_name) ? filter_input($action, $variable_name, $filter) : '';
        return $variable ? $variable : $default;
    }

}
