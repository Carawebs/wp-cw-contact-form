<?php
namespace Carawebs\ContactForm;

use Carawebs\Settings;
use Carawebs\ContactForm\Form\Processor;
use Carawebs\ContactForm\Scripts\Footer;
use Carawebs\ContactForm\Form\FormOutput;
use Carawebs\ContactForm\Config\MessageConfig;
use Carawebs\ContactForm\Config\BaseFormValues;
use Carawebs\ContactForm\Widgets\RegisterWidgets;
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

    public function __construct($basePath, $namePrefix)
    {
        $this->setPaths($basePath);
        $this->namePrefix = $namePrefix;
        $this->initialiseObjects();
    }

    public function setPaths($basePath)
    {
        $this->basePath = $basePath;
        $this->settingsConfigFilePath = $this->basePath . '/config/options-page.php';
        $this->formFieldsConfig = new FileFormFieldsConfig($this->basePath . '/config/form-fields.php');
        $this->messageConfigPath = $this->basePath . '/config/message.php';

        add_action('wp', function() use ($basePath){
            $this->allowedLocationsConfig = new FileAllowedLocationsConfig($this->basePath . '/config/allowed-locations.php');
        });
    }

    /**
     * Initialise Objects
     */
    private function initialiseObjects()
    {
        $this->settingsController = new Settings\SettingsController;

        add_action('wp', function() {
            // new Autoloader;
            // Object to set nonce vals & honeypot name - these passed to form output & processor.
            $baseFormValues = new BaseFormValues($this->namePrefix);
            $this->messageConfig = new FileMessageConfig($this->messageConfigPath);
            $this->formFieldsData = new FieldBuilder($this->formFieldsConfig, $this->namePrefix);
            $this->contactForm = new FormOutput($baseFormValues, $this->formFieldsData);
            $this->formProcessor = new Processor($baseFormValues, $this->formFieldsData);
            $this->autoloader = new Autoloader;
            $this->footerScripts = new Footer($baseFormValues);
        });

        add_action('after_setup_theme', function() {
            new RegisterWidgets;
            new RegisterShortcodes;
        });
    }


    public function init()
    {
        $this->settingsController->setOptionsPageArgs($this->settingsConfigFilePath)->initOptionsPage();
        add_action('wp', function() {
            $allowed = $this->allowedLocationsConfig->allowed();
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
