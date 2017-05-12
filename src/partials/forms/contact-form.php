<?php

?>
<form class="form-horizontal" onsubmit="return validateMyForm();" action="<?= $post_to_url ?? NULL; ?>" method="POST">
    <?= ! empty($nonce) ? $nonce : NULL; ?>
    <?= ! empty($honeypot) ? $honeypot : NULL; ?>
    <fieldset>
        <div class="form-group">
            <input name="first_name" placeholder="First Name (required)" type="text" class="form-control required" required>
        </div>
        <div class="form-group">
            <input name="last_name" placeholder="Last Name (required)" type="text" class="form-control" required>
        </div>
        <div class="form-group">
            <input name="email" placeholder="Your Email (required)" type="email" class="form-control" id="email" required>
        </div>
        <div class="form-group">
            <input name="phone_number" placeholder="Contact Phone Number" type="tel" class="form-control" id="phone">
        </div>
        <div class="form-group">
            <textarea class="form-control" id="textarea" name="message_from_lead" rows="5">Your Message</textarea>
        </div>
        <h3>Budget</h3>
        <?php
        $i = 1;
        foreach ($budget_options['options'] as $option) {

            ?>
            <div class="form-check">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="<?= $budget_options['name']; ?>" id="budget-option-<?= $i; ?>" value="<?= $option; ?>">
                    <?= $option; ?>
                </label>
            </div>

            <?php
            $i ++;
        }

        ?>
        <hr>
        <div class="form-group">
            <input name="submit" value="Submit Form" type="submit" class="btn btn-secondary">
        </div>
        <input name="_gotcha" style="display:none" type="text">
        <input name="campaign" style="display:none" type="hidden" value="facebook_ad_1">
        <input name="redirect_url" style="display:none" type="hidden" value="<?= $redirect_url; ?>">

    </fieldset>
</form>
