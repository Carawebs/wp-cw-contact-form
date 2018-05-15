<?php

namespace Carawebs\ContactForm\Traits;

/**
*
*/
trait PartialSelector {

    public function partial_selector($partial)
    {
        if (file_exists(get_template_directory() .'/'. $partial . '.php')) {
            return (get_template_directory() .'/'. $partial . '.php');
        } else {
            return (dirname(__DIR__) . '/partials/' . $partial . '.php');
        }
    }

    public static function static_partial_selector($partial) {
        $override = get_template_directory() . '/templates/' . $partial . '.php';

        if (file_exists($override)) {
            return ($override);
        } else {
            return (dirname(__DIR__) . '/' . $partial . '.php');
        }
    }
}
