<?php
namespace Carawebs\ContactForm;

use Carawebs\Settings;
use Carawebs\ContactForm\Processors\Form;
use Carawebs\ContactForm\Config\MessageConfig;
use Carawebs\ContactForm\Config\FileMessageConfig;
use Carawebs\ContactForm\Shortcodes\RegisterShortcodes;

if (! defined('ABSPATH')) exit;
/**
* Main plugin class
*/
class Plugin
{
    private $config;

    public function __construct($basePath)
    {
        $this->settingsController = new Settings\SettingsController;
        $this->registerShortcodes = new RegisterShortcodes;
        $this->messageConfig = new FileMessageConfig($basePath . '/config/message.php');
        $this->contactForm = new Form;
        $this->autoloader = new Autoloader;
        $this->basePath = $basePath;
        $this->settingsConfigFilePath = $basePath . '/config/options-page.php';
    }

    public function init()
    {
        add_action('plugins_loaded', function() {
            $this->settingsController->setOptionsPageArgs($this->settingsConfigFilePath)->initOptionsPage();
            $this->contactForm->setMessageConfig($this->messageConfig);
            $this->contactForm->processSubmittedForm();
            $this->contactForm->outputContactForm();
            $this->onActivation();
            $this->onDeactivation();
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
