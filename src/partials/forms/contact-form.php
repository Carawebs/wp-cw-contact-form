<?php
// onsubmit="return validateMyForm();"
?>
<form class="form-horizontal" action="<?= $postToUrl ?? NULL; ?>" method="POST">
    <?= !empty($nonce) ? $nonce : NULL; ?>
    <?= !empty($honeypot) ? $honeypot : NULL; ?>
    <fieldset>
        <?php
        foreach ($this->formFields as $key => $value) {
            echo "<div class='form-group'>$value</div>";
        }
        ?>
        <hr>
        <div class="form-group">
            <input name="submit" value="Submit Form" type="submit" class="btn btn-secondary">
        </div>
        <input name="campaign" style="display:none" type="hidden" value="facebook_ad_1">
    </fieldset>
</form>
