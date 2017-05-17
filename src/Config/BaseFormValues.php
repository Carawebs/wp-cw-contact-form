<?php
namespace Carawebs\ContactForm\Config;

/**
* An object that holds form data required by both the form output and the form
* processor: Nonce data and honeypot.
*/
class BaseFormValues
{
    private $nonceName = 'contact_form';

    private $nonceAction = 'ensure_contact_form_safety';

    private $honeypotName = 'main_email';

    private $nonce;

    private $honeypot;

    private $namePrefix;

    function __construct($namePrefix)
    {
        $this->setNonce();
        $this->setHoneypot();
        $this->namePrefix = $namePrefix;
    }

    private function setNonce()
    {
        $this->nonce = wp_nonce_field( $this->nonceAction, $this->nonceName, true, false);
    }

    public function getNonce()
    {
        return $this->nonce;
    }

    public function getNonceName()
    {
        return $this->nonceName;
    }

    public function getNonceAction()
    {
        return $this->nonceAction;
    }

    private function setHoneypot()
    {
        ob_start();
        ?>
        <div class="form-group" style="display:none;">
            <label>Keep this field blank</label>
            <input class="form-control" type="text" name="<?= $this->honeypotName; ?>" id="<?= $this->honeypotName; ?>" />
        </div>
        <?php
        $this->honeypot = ob_get_clean();
    }

    public function getHoneypot()
    {
        return $this->honeypot;
    }

    public function getHoneypotName()
    {
        return $this->honeypotName;
    }

    public function getNamePrefix()
    {
        return $this->namePrefix;
    }
}
