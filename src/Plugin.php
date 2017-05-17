<?php
namespace Carawebs\ContactForm;

use Carawebs\Settings;
use Carawebs\ContactForm\Form\Processor;
use Carawebs\ContactForm\Scripts\Footer;
use Carawebs\ContactForm\Form\FormOutput;
use Carawebs\ContactForm\Config\MessageConfig;
use Carawebs\ContactForm\Config\BaseFormValues;
use Carawebs\ContactForm\Form\Fields\FieldBuilder;
use Carawebs\ContactForm\Config\FileMessageConfig;
use Carawebs\ContactForm\Config\FileFormFieldsConfig;
use Carawebs\ContactForm\Shortcodes\RegisterShortcodes;
use Carawebs\ContactForm\Config\FileAllowedLocationsConfig;

if (!defined('ABSPATH')) exit;
/**
* Main plugin class
*/
class Plugin
{
    private $config;

    public function __construct($basePath)
    {
        $this->basePath = $basePath;
        $this->initialiseObjects();
    }

    /**
     * [initialiseObjects description]
     * @param [type] $basePath [description]
     */
    private function initialiseObjects()
    {
        add_action('wp', function() {
            // Object to set nonce vals & honeypot name - these passed to form output & processor.
            $baseFormValues = new BaseFormValues;
            $this->settingsController = new Settings\SettingsController;
            $this->registerShortcodes = new RegisterShortcodes;
            $this->messageConfig = new FileMessageConfig($this->basePath . '/config/message.php');
            $this->allowedLocationsConfig = new FileAllowedLocationsConfig($this->basePath . '/config/allowed-locations.php');
            $this->formFieldsConfig = new FileFormFieldsConfig($this->basePath . '/config/form-fields.php');
            // An array of field data
            $this->formFieldsData = new FieldBuilder($this->formFieldsConfig);
            $this->contactForm = new FormOutput($baseFormValues, $this->formFieldsData);
            $this->formProcessor = new Processor($baseFormValues, $this->formFieldsData);
            $this->autoloader = new Autoloader;
            $this->settingsConfigFilePath = $this->basePath . '/config/options-page.php';
            $this->footerScripts = new Footer($baseFormValues);
        });
    }


    public function init()
    {
        add_action('wp', function() {
            $allowed = $this->allowedLocationsConfig->allowed();
            $this->settingsController->setOptionsPageArgs($this->settingsConfigFilePath)->initOptionsPage();
            $this->formProcessor->setMessageConfig($this->messageConfig);
            $this->formProcessor->processSubmittedForm($allowed);
            $this->contactForm->setAllowed($allowed);
            $this->contactForm->outputContactForm();
            $this->onActivation();
            $this->onDeactivation();
        });
        add_action('wp_footer', function() {
            $this->footerScripts->honeypot($this->allowedLocationsConfig->allowed());
        });
    }

    private function onActivation()
    {
        register_activation_hook( __FILE__, function() {
            flush_rewrite_rules();
        });
    }

    private function onDeactivation()
    {
        register_deactivation_hook( __FILE__, function(){
            flush_rewrite_rules();
        });
    }
}
