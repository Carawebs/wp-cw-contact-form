<?php
namespace Carawebs\ContactForm\Form;

use Carawebs\ContactForm\Config\BaseFormValues;
use Carawebs\ContactForm\Form\Fields\FieldBuilder;

/**
* Process form submissions.
*/
class Processor extends Validator
{
    public function __construct(BaseFormValues $baseFormValues, FieldBuilder $formFields)
    {
        $this->honeypotName = $baseFormValues->getHoneypotName();
        $this->nonceName = $baseFormValues->getNonceName();
        $this->nonceAction = $baseFormValues->getNonceAction();
        $this->formFields = $formFields->getFieldsData()->container;
        $this->namePrefix = $baseFormValues->getNamePrefix();
        //$this->logger($this->formFields);
    }

    public function processSubmittedForm($allowed)
    {
        if (false === $allowed) {
            return;
        }
        if (empty($_POST['submit']) or 'Submit Form' != $_POST['submit']) {
            return;
        }
        if (!empty($_POST[$this->honeypotName])) {
            $_SESSION['formErrors'][] = 'Problem with honeypot';
            //$this->logger('honeypot');
            return;
        }
        if (false === $this->checkNonce($_POST[$this->nonceName], $this->nonceAction)) {
            return;
        }

        $errors = $this->validator($_POST);
        if (!empty($errors)) {
            $_SESSION['formErrors'] = $errors;
            return;
        }

        $sane = $this->sanitize($_POST);

        $IP = $_SERVER['REMOTE_ADDR'];
        $to = $this->messageConfig['email'];
        $subject = $this->messageConfig['subject'];
        $body = $this->message($sane, $IP);
        $headers = ['Content-Type: text/html; charset=UTF-8'];
        $headers[] = 'From: ' . $this->messageConfig['header-from'] . ' <'. $this->messageConfig['email'] . '>';
        $log = [];
        $log['sanitized_data'] = $sane;
        $log['headers'] = $headers;
        $log['body'] = $body;
        file_put_contents(dirname(__FILE__, 3). '/maillog', json_encode($log, JSON_PRETTY_PRINT));
        wp_mail($to, $subject, $body, $headers);
        // wp_redirect(home_url('/thank-you') . '?firstname=' . $sane['first_name']);
        wp_redirect(home_url('/thank-you'));
        exit;
    }

    public function logger($value)
    {
        $file = dirname(__FILE__, 3) . '/log';
        $current = file_get_contents($file);
        $current .= date("H:i:s") . ": " . json_encode($value, JSON_PRETTY_PRINT) . "\n";
        file_put_contents($file, $current);
    }

    public function message($formData, $IP = NULL)
    {
        $result = "<ul>";
        foreach ($formData as $name => $value) {
            $value = 'email' === $name ? "<a href='mailto:$value'>$value</a>" : $value;
            $result .= '<li>' . $name . ': ' . $value . '</li>';
        }
        $result .= "<li>IP Address of this person: $IP</li>";
        $result .= "</ul>";
        ob_start();
        ?>
        <h1>Form Submission</h1>
        <p>from <?= esc_html(home_url('/')); ?></p>
        <?= $result; ?>
        <?php
        return ob_get_clean();
    }

    public function setMessageConfig($config)
    {
        $this->messageConfig = $config;
    }

    public function checkNonce($nonce, $nonce_action)
    {
        $result = wp_verify_nonce( $nonce, $nonce_action );
        if ( 1 === $result ) {
            return true; // Return true if the nonce is less than one day old
        } else {
            return false;
        }
    }
}
