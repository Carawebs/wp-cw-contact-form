<?php
/*
Plugin Name:       Carawebs Email Contact Form
Plugin URI:        http://carawebs.com
Description:       Simple email contact form.
Version:           1.0.0
Author:            David Egan
Author URI:        http://dev-notes.eu
License:           GPL-2.0+
License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
Text Domain:       contact
Domain Path:       /languages
*/
namespace Carawebs\ContactForm;

use Carawebs\Settings;
use Carawebs\ContactForm\Shortcodes\RegisterShortcodes;
use Carawebs\ContactForm\Processors\Form;

include __DIR__.'/Base.php';

if ( ! defined( 'ABSPATH' ) ) exit;
/**
* Singleton class to start the plugin.
*/
class ContactForm extends Base
{
    private $config;

    /**
     * Refers to a single instance of this class
     * @var Object|NULL
     */
    private static $instance = NULL;

    /**
     * Plugin instantiation by singleton method.
     * @return Object Object instantiated from this class
     */
    public static function getInstance()
    {
        if ( NULL == self::$instance ) {
            self::$instance = new self;
        }
         return self::$instance;
    }

    public function bootstrap(Settings\SettingsController $optionsPage, RegisterShortcodes $shortcodes = NULL, Form $contactForm)
    {
        $this->autoload();
        $this->setPaths();
        $optionsPage->setOptionsPageArgs($this->optionsConfig)->initOptionsPage();
        //$dataFilters->addFilters();
    }

    /**
     * Define the paths to the config files for CPTs and custom taxonomies.
     */
    private function setPaths()
    {
        $path = dirname(__FILE__) . '/config/';
        $this->optionsConfig = $path . '/options-page.php';
        $this->formConfig = $path . '/form-fields.php';
    }

    private function onActivation()
    {
        register_activation_hook( __FILE__, function() {
            $this->autoload();
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

$plugin = ContactForm::getInstance();
$plugin->bootstrap(
    new Settings\SettingsController,
    new RegisterShortcodes,
    new Form
);
