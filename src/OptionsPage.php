<?php
namespace Carawebs\ContactForm;

use Carawebs\Settings;
/**
 *
 */
class OptionsPage
{

    function __construct(string $configFilePath, Settings\SettingsController $optionsPage)
    {
        $optionsPage->setOptionsPageArgs($configFilePath)->initOptionsPage();
    }
}
