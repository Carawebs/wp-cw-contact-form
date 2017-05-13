<?php
namespace Carawebs\ContactForm\Processors;

/**
*
*/
abstract class BaseForm {

    protected $nonce_name;

    protected $nonce_action;

    public function nonce($args)
    {
        $action = $args['action'] ?? NULL;
        $name = $args['name'] ?? NULL;
        $referer = $args['referer'] ?? true;
        return wp_nonce_field( $action, $name, $referer, false);
    }

    public function honeypot($value = 'checker')
    {
        ob_start();
        ?>
        <div class="form-group" style="display:none;">
            <label>Keep this field blank</label>
            <input class="form-control" type="text" name="<?= $value; ?>" id="<?= $value; ?>" />
        </div>
        <?php
        return ob_get_clean();
    }

    public function set_nonce_values($nonce_name, $nonce_action)
    {
        $this->nonce_name = $nonce_name;
        $this->nonce_action = $nonce_action;
    }

    public function check_nonce($nonce, $nonce_action)
    {
        $result = wp_verify_nonce( $nonce, $nonce_action );
        if ( 1 === $result ) {
            return true; // Return true if the nonce is less than one day old
        } else {
            return false;
        }
    }

    public function sanitize($value)
    {
        return sanitize_text_field( $value );
    }

    public function add_js()
    {
        add_action( 'wp_footer', function() {
            if ( true != $this->display() ) {
                return;
            }
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

    public function setMessageConfig($config)
    {
        $this->messageConfig = $config;
        //die(var_dump($this->config));
    }
}
