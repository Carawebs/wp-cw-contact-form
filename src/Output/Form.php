<?php
namespace Carawebs\ContactForm\Output;

use Carawebs\ContactForm\Config\BaseFormValues;
use Carawebs\ContactForm\Traits\PartialSelector;
use Carawebs\ContactForm\Config\FileFormFieldsConfig;
/**
*
*/
class Form extends BaseForm
{
    use PartialSelector;

    protected $honeypot_name = 'checker';

    function __construct(BaseFormValues $baseFormValues, FileFormFieldsConfig $formFieldsConfig)
    {
        $this->baseFormValues = $baseFormValues;
        $this->formFields = $formFieldsConfig;
        $this->buildFields();
        $this->add_js();
    }

    public function outputContactForm()
    {
        if (false === $this->allowed) return;
        add_action('carawebs\email-contact-form', function() {
            $budget_options = [
                'name' => 'budget_selector',
                'options' => [
                    'Less than €5000',
                    '€5000 - €10K',
                    '€10K - €25K',
                    '€50K - €100K',
                    'More than €10K',
                ]
            ];
            $redirect_url = get_the_permalink();
            $nonce = $this->baseFormValues->getNonce();
            $honeypot = $this->baseFormValues->getHoneypot();
            ob_start();
            foreach ($this->fieldsMarkupArray as $key => $value) {
                echo "<div class='form-group'>$value</div>";
            }
            include($this->static_partial_selector('partials/forms/contact-form'));
            echo ob_get_clean();
        });
    }
}
