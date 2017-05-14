<?php
namespace Carawebs\ContactForm;

use Carawebs\Settings;
use Carawebs\ContactForm\Processors\Form;
use Carawebs\ContactForm\Config\MessageConfig;
use Carawebs\ContactForm\Config\FileMessageConfig;
use Carawebs\ContactForm\Shortcodes\RegisterShortcodes;

if ( ! defined( 'ABSPATH' ) ) exit;
/**
* Singleton class that starts the plugin.
*/
class Plugin
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

    public function bootstrap(
        /*Settings\SettingsController $optionsPage,*/
        /*RegisterShortcodes $shortcodes,*/
        MessageConfig $messageConfig,
        Form $contactForm
        )
    {
        //$optionsPage->setOptionsPageArgs($this->optionsConfig)->initOptionsPage();
        $contactForm->setMessageConfig($messageConfig);
        $contactForm->processSubmittedForm();
        $contactForm->outputContactForm();
    }

    /**
     * Define the paths to the config files for CPTs and custom taxonomies.
     */
    public function setPaths($basePath)
    {
        $path = $basePath . '/config/';
        $this->optionsConfig = $path . 'options-page.php';
        $this->formConfig = $path . 'form-fields.php';
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
    // /**
    // * Load Composer autoload if available, otherwise register a simple autoload callback.
    // *
    // * @return void
    // */
    // public function autoload()
    // {
    //     static $done;
    //     // Go ahead if $done == NULL or the class doesn't exist
    //     if ( !$done && !class_exists( 'Carawebs\CustomContent\Config\Fields', true ) ) {
    //         $done = true;
    //         file_exists( __DIR__.'/vendor/autoload.php' )
    //         ? require_once __DIR__.'/vendor/autoload.php'
    //         : spl_autoload_register( function ( $class ) {
    //             if (strpos($class, __NAMESPACE__) === 0) {
    //                 $name = str_replace('\\', '/', substr($class, strlen(__NAMESPACE__)));
    //                 require_once __DIR__."/src{$name}.php";
    //             }
    //         });
    //     }
    // }
}
