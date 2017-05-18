<?php
namespace Carawebs\ContactForm\Form\Fields;

/**
* Markup for individual fields.
*/
abstract class FieldMarkup
{

    public function text($args)
    {
        $args = $this->fieldArgs($args);
        ob_start();
        ?>
        <?php if(!empty($args['label'])) : ?>
            <label for="<?= $args['name']; ?>"><?= $args['label']; ?></label>
        <?php endif; ?>
        <?php $this->required($args); ?>
        <input name="<?= $args['name']; ?>" id="<?= $args['name']; ?>"<?= $args['placeholder']; ?> class="form-control<?= $args['required']; ?>"<?=$args['required']; ?> type="text">
        <?php
        return ob_get_clean();
    }

    /**
     * [required description]
     * @param [type] $args [description]
     */
    private function required($args)
    {
        if(!empty($args['required'])) {
            ob_start();
            ?>
            <small id="<?= $args['name']; ?>-help" class="text-muted"> (Required)</small>
            <?php
            echo ob_get_clean();
        }
        return;
    }


    public function textarea($args)
    {
        $rows = !empty($args['rows']) ? $args['rows'] : '5';
        $args = $this->fieldArgs($args);

        ob_start();
        ?>
        <?php if(!empty($args['label'])) : ?>
            <label for="<?= $args['name']; ?>"><?= $args['label']; ?></label>
        <?php endif; ?>
        <?php $this->required($args); ?>
        <textarea class="form-control" id="textarea" name="<?= $args['name']; ?>" rows="<?= $rows; ?>"<?= $args['placeholder']; ?>></textarea>
        <?php
        $this->required($args);
        return ob_get_clean();
    }

    public function tel($args)
    {
        $args = $this->fieldArgs($args);
        ob_start();
        ?>
        <?php if(!empty($args['label'])) : ?>
            <label for="<?= $args['name']; ?>"><?= $args['label']; ?></label>
        <?php endif; ?>
        <input name="<?= $args['name']; ?>" id="<?= $args['name']; ?>" class="form-control<?= $args['required']; ?>"<?= $args['required']; ?> type="tel">
        <?php
        $this->required($args);
        return ob_get_clean();
    }

    public function radios($args)
    {
        $args = array_merge($this->fieldArgs($args));
        ob_start();
        $i = 0;
        echo "<fieldset><label>{$args['label']}</label>";
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
        echo "</fieldset>";
        $this->required($args);
        return ob_get_clean();
    }

    public function id($name, $i)
    {
        $str = strtolower(trim($name));
        return str_replace('_', '-', $str) . '-' . $i;
    }

    public function heading($args)
    {
        $label = !empty($args['label']) ? $args['label'] : NULL;
        return "<h3>$label</h3>";
    }

    public function paragraph($args)
    {
        $label = !empty($args['label']) ? $args['label'] : NULL;
        return "<p class='form-control-static'>$label</p>";
    }

    /**
    * Set field arguments
    * @param array $args Raw field arguments
    */
    private function fieldArgs($args)
    {
        $args['placeholder'] = !empty($args['placeholder']) ? ' placeholder="' . $args['placeholder'] . '"' : NULL;
        $args['required'] = !empty($args['required']) ? ' required' : NULL;
        $args['label'] = !empty($args['label']) ? $args['label'] : NULL;
        $args['name'] = $this->namePrefix . $args['name'];
        return $args;
    }
}
