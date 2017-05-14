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
use DI\ContainerBuilder;
use Carawebs\ContactForm\Processors\Form;
use Carawebs\ContactForm\Config\FileMessageConfig;
use Carawebs\ContactForm\Shortcodes\RegisterShortcodes;

if ( ! defined( 'ABSPATH' ) ) exit;

$basePath = dirname(__FILE__);
$settingsController = new Settings\SettingsController;
$registerShortcodes = new RegisterShortcodes;
$messageConfig = new FileMessageConfig($basePath . '/config/message.php');
$form = new Form;

include __DIR__ . '/src/Plugin.php';

$plugin = Plugin::getInstance();
$plugin->autoload();
$plugin->setPaths($basePath);
$plugin->bootstrap($settingsController, $registerShortcodes, $messageConfig, $form);
