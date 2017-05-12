<?php
namespace Carawebs\ContactForm\Shortcodes;

use Carawebs\ContactForm\Traits\PartialSelector;
/**
* Handler for Share This button shortcode
*/
class EmailContactForm implements Shortcode
{
    use PartialSelector;
    public function handler ( $atts, $content = NULL ) {
        extract( shortcode_atts([
            'heading' => NULL,
            'display' => 'normal'
        ], $atts ));
        $args = [
            'heading' => $heading
        ];

        ob_start();

        ?>
        <div class="carawebs-contact-form">
            <h2>Form goes here</h2>
            <?php
            do_action('carawebs\email-contact-form');
            //include $this->partial_selector( 'share-this');
            ?>
        </div>
        <?php
        return ob_get_clean();
    }
}
