<?php
namespace Carawebs\ContactForm\Config;

use Carawebs\ContactForm\Config\Contracts\FormFieldsConfig;
/**
 *
 */
class FileFormFieldsConfig extends BaseArrayAccess implements FormFieldsConfig
{
    /**
     * Path to the config file.
     * @var string
     */
    private $config;

    /**
     * @param string $configFile Path to config file.
     */
    function __construct($configFile)
    {
        $this->container = include($configFile);
    }

    public function setFormFields()
    {
        //return $this->config['email'];
    }

    public function getFormFields()
    {
        return $this->container;
    }
}
