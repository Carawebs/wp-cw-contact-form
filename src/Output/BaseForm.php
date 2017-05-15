<?php
namespace Carawebs\ContactForm\Output;

/**
*
*/
abstract class BaseForm {

    public function buildFields()
    {
        $this->fieldsMarkupArray = [];
        foreach ($this->formFields->container as $key => $args) {
            switch ($args['type']) {
                case 'text':
                $this->fieldsMarkupArray[] = $this->text($args);
                break;
                case 'textarea':
                $this->fieldsMarkupArray[] = $this->textarea($args);
                break;
                case 'radio':
                $this->fieldsMarkupArray[] = $this->radios($args);
                break;
                default:
                # code...
                break;
            }
        }
    }

    public function text($args)
    {
        $placeholder = !empty($args['placeholder']) ? ' placeholder="' . $args['placeholder'] . '"' : NULL;
        $required = !empty($args['required']) ? ' required' : NULL;
        ob_start();
        ?>
        <input name="<?= $args['name']; ?>"<?= $placeholder; ?>" class="form-control<?= $required; ?>"<?=$required; ?> type="text">
        <?php
        return ob_get_clean();
    }

    public function textarea($args)
    {
        $rows = !empty($args['rows']) ? $args['rows'] : '5';
        $placeholder = !empty($args['placeholder']) ? $args['placeholder'] : NULL;

        ob_start();
        ?>
        <textarea class="form-control" id="textarea" name="<?= $args['name']; ?>" rows="<?= $rows; ?>"><?= $placeholder; ?></textarea>
        <?php
        return ob_get_clean();
    }

    public function radios($args)
    {

        ob_start();
        $i = 0;
        foreach ($args['options'] as $value => $displayValue) {
            ?>
            <div class="form-check">
                <label class="form-check-label">
                    <input class="form-check-input" name="<?= $args['name']; ?>" id="<?= $this->id($args['name'], $i); ?>" value="<?= $value; ?>" type="radio">
                    <?= $displayValue; ?>
                </label>
            </div>
            <?php
            $i++;
        }
        return ob_get_clean();
    }

    public function id($name, $i)
    {
        $str = strtolower(trim($name));
        return str_replace('_', '-', $str) . '-' . $i;
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

    public function setAllowed($value)
    {
        $this->allowed = $value;
    }
}
