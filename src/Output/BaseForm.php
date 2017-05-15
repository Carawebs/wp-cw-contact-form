<?php
namespace Carawebs\ContactForm\Output;

/**
*
*/
abstract class BaseForm {

    protected $nonce_name;

    protected $nonce_action;

    // public function nonce($args)
    // {
    //     $action = $args['action'] ?? NULL;
    //     $name = $args['name'] ?? NULL;
    //     $referer = $args['referer'] ?? true;
    //     return wp_nonce_field( $action, $name, $referer, false);
    // }

    // public function check_nonce($nonce, $nonce_action)
    // {
    //     $result = wp_verify_nonce( $nonce, $nonce_action );
    //     if ( 1 === $result ) {
    //         return true; // Return true if the nonce is less than one day old
    //     } else {
    //         return false;
    //     }
    // }

    public function sanitize($value)
    {
        return sanitize_text_field( $value );
    }

    public function add_js()
    {
        add_action( 'wp_footer', function() {
            if (false === $this->allowed) return;
            ob_start();
            ?>
            <script type="text/javascript">
            function validateMyForm() {
                // The field is empty, submit the form.
                if(!document.getElementById("<?= $this->honeypot_name; ?>").value) {
                    return true;
                }
                // the field has a value it's a spam bot
                else {
                    return false;
                }
            }
            var email = document.getElementById("email");

            email.addEventListener("keyup", function (event) {
                if (email.validity.typeMismatch) {
                    email.setCustomValidity("Please enter a valid email address.");
                } else {
                    email.setCustomValidity("");
                }
            });
            </script>
            <?php
            echo ob_get_clean();
        });
    }

    // public function setMessageConfig($config)
    // {
    //     $this->messageConfig = $config;
    //     //die(var_dump($this->config));
    // }

    public function setAllowed($value)
    {
        $this->allowed = $value;
    }
}
