<?php
namespace Carawebs\ContactForm\Scripts;

use Carawebs\ContactForm\Config\BaseFormValues;

/**
 *
 */
class Footer
{

    function __construct(BaseFormValues $baseFormValues)
    {
        $this->honeypotName = $baseFormValues->getHoneypotName();
    }

    /**
     * Hook this to wp_footer
     * @return void
     */
    public function honeypot($allowed) {
        if (false === $allowed) return;
        ob_start();
        ?>
        <script type="text/javascript">
        function validateMyForm() {
            // The field is empty, submit the form.
            if(!document.getElementById("<?= $this->honeypotName; ?>").value) {
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
    }
}
