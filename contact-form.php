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

if ( ! defined( 'ABSPATH' ) ) exit;

$basePath = dirname(__FILE__);
$namePrefix = "carawebs_";
include __DIR__ . '/src/Plugin.php';
$plugin = new Plugin($basePath, $namePrefix);
$plugin->init();
