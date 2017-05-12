<?php
namespace Carawebs\ContactForm\Shortcodes;

interface Shortcode {
    public function handler( $atts, $content );
}
