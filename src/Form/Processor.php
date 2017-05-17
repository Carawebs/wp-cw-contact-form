<?php
namespace Carawebs\ContactForm\Form;

use Carawebs\ContactForm\Config\BaseFormValues;
use Carawebs\ContactForm\Form\Fields\FieldBuilder;

/**
*
*/
class Processor extends Validator
{
    public function __construct(BaseFormValues $baseFormValues, FieldBuilder $formFields)
    {
        $this->honeypotName = $baseFormValues->getHoneypotName();
        $this->nonceName = $baseFormValues->getNonceName();
        $this->nonceAction = $baseFormValues->getNonceAction();
        $this->formFields = $formFields->getFieldsData()->container;
        $this->logger('NEW');
    }

    public function processSubmittedForm($allowed)
    {
        $this->logger('PROCESSOR');
        if (false === $allowed) {
            $status = (false === $allowed) ? "FALSE" : "TRUE";
            $this->logger("ALLOWED: " . $status);
            return;
        }
        if (empty($_POST['submit']) or 'Submit Form' != $_POST['submit']) {
            $this->logger('NOT SUBMITTED');
            return;
        }
        $this->logger('After submit');
        if (!empty($_POST[$this->honeypotName])) {
            $_SESSION['formErrors'][] = 'Problem with honeypot';
            $this->logger('honeypot');
            return;
        }
        if (false === $this->checkNonce($_POST[$this->nonceName], $this->nonceAction)) {
            $_SESSION['formErrors'][] = 'Problem with nonce';
            $this->logger('nonce');
            return;
        }
        $this->logger('processing');

        // Check for our fields
        //
        // Check for validity of each field, build error report
        //
        // If validity check fails, send back to the form with notification

        // $sane = $this->sanitize($_POST);
        // $IP = $_SERVER['REMOTE_ADDR'];
        // $to = $this->messageConfig['email'];
        // $subject = $this->messageConfig['subject'];
        // $body = "Hello"; //$this->message($sane, $IP);
        // $headers = ['Content-Type: text/html; charset=UTF-8'];
        // $headers[] = 'From: ' . $this->messageConfig['header-from'] . ' <'. $this->messageConfig['email'] . '>';
        // $log = [];
        // $log['sanitized_data'] = $sane;
        // $log['headers'] = $headers;
        // $log['body'] = $body;
        // file_put_contents(dirname(__FILE__, 3). '/maillog', json_encode($log, JSON_PRETTY_PRINT));
        // wp_mail($to, $subject, $body, $headers);
        // wp_redirect(home_url('/thank-you') . '?firstname=' . $sane['first_name']);
        die(var_dump($_POST));
        exit;
    }

    public function logger($value)
    {
        $file = dirname(__FILE__, 3) . '/log';
        $current = file_get_contents($file);
        $current .= date("H:i:s") . ": " . json_encode($value, JSON_PRETTY_PRINT) . "\n";
        file_put_contents($file, $current);
    }

    public function sanitize($post_array)
    {
        $sane = [];
        $text_fields = ['first_name', 'last_name', 'budget_selector'];
        $post_fields = ['message_from_lead'];

        foreach ($post_array as $key => $value) {
            if (in_array($key, $text_fields)) {
                $sane[$key] = sanitize_text_field($value);
            } elseif (in_array($key, $post_fields)) {
                $sane[$key] = wp_filter_post_kses($value);
            } elseif ('email' === $key) {
                $sane[$key] = sanitize_email($value);
            } elseif ('phone_number' === $key) {
                $sane[$key] = preg_replace('/[^0-9]/', '', $value);
            }
        }
        return $sane;
    }
    public function message($sane, $IP = NULL)
    {
        ob_start();
        ?>
        <h1>Form Submission from <?= esc_html(home_url('/')); ?></h1>
        <p>Message from <?= $sane['first_name']; ?> <?= $sane['last_name']; ?>.</p>
        <p>Email: <a href="mailto:<?= $sane['email']?>"><?= $sane['email']?></a></p>
        <p>IP Address: <?= $IP; ?></p>
        <p>Phone: <?= $sane['phone_number'] ?? "Not supplied."?></p>
        <p>Budget: <?= $sane['budget_selector'] ?? "Not supplied."?></p>
        <h2>Message from Lead</h2>
        <p><?= $sane['message_from_lead'] ?? "No message entered."?></p>
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
