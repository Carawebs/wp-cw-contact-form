<?php
namespace Carawebs\ContactForm\Form;

/**
*
*/
abstract class BaseForm {

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

    // public function setAllowed($value)
    // {
    //     $this->allowed = $value;
    // }
}
