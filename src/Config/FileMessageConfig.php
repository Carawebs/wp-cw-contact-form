<?php
namespace Carawebs\ContactForm\Config;

use Carawebs\ContactForm\Config\Contracts\MessageConfig;
/**
 *
 */
class FileMessageConfig extends BaseArrayAccess implements MessageConfig
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

    public function getSendToEmailAddress()
    {
        return $this->container['email'];
    }
}
