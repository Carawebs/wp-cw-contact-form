<?php
namespace Carawebs\ContactForm\Form\Fields;

/**
 * Markup for individual fields.
 */
abstract class FieldMarkup
{

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
}
