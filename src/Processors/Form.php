<?php
namespace Carawebs\ContactForm\Processors;

use Carawebs\ContactForm\Traits\PartialSelector;
/**
*
*/
class Form extends BaseForm
{
    use PartialSelector;

    protected $honeypot_name = 'checker';

    function __construct()
    {
        $this->add_js();
        $this->set_nonce_values('contact_form', 'ensure_contact_form_safety');
    }

    public function display()
    {
        static $display;
        isset($display) || $display = in_array(true, [
            // The form will be displayed if ANY of the following return true.
            is_page_template([
                'template-custom.php',
                'page-projects.php',
            ]),
            is_page([
                'contact',
            ]),
            is_single('form-test'),
        ]);
        return $display;
    }

    public function processSubmittedForm()
    {
        add_action('wp', function() {

            if (true != $this->display()) {
                return;
            }

            if (empty($_POST['submit']) or 'Submit Form' != $_POST['submit']) {
                return;
            }

            if (!empty($_POST[$this->honeypot_name])) {
                return;
            }

            if (false === $this->check_nonce($_POST[$this->nonce_name], $this->nonce_action)) {
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
            wp_redirect(home_url('/thank-you') . '?firstname=' . $sane['first_name']);
            exit;
        });
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

    public function outputContactForm()
    {
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
            $nonce = $this->nonce(['name'=>$this->nonce_name, 'action'=>$this->nonce_action]);
            $honeypot = $this->honeypot($this->honeypot_name);
            ob_start();
            include($this->static_partial_selector('partials/forms/contact-form'));
            echo ob_get_clean();
        });
    }
}
