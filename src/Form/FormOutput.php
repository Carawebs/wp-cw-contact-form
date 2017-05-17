<?php
namespace Carawebs\ContactForm\Form;

use Carawebs\ContactForm\Config\BaseFormValues;
use Carawebs\ContactForm\Traits\PartialSelector;
use Carawebs\ContactForm\Form\Fields\FieldBuilder;
use Carawebs\ContactForm\Config\FileFormFieldsConfig;
/**
*
*/
class FormOutput
{
    use PartialSelector;

    function __construct(BaseFormValues $baseFormValues, FieldBuilder $formFields)
    {
        $this->baseFormValues = $baseFormValues;
        $this->formFields = $formFields->getFieldsMarkup();
    }

    public function outputContactForm()
    {
        if (false === $this->allowed) return;
        add_action('carawebs\email-contact-form', function() {
            $nonce = $this->baseFormValues->getNonce();
            $honeypot = $this->baseFormValues->getHoneypot();
            $postToUrl = get_the_permalink();
            ob_start();
            if (!empty($_SESSION['formErrors'])) {
                include($this->static_partial_selector('partials/forms/form-errors'));
            }
            include($this->static_partial_selector('partials/forms/contact-form'));
            echo ob_get_clean();
        });
    }

    public function setAllowed($value)
    {
        $this->allowed = $value;
    }
}
