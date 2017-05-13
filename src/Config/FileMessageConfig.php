<?php
namespace Carawebs\ContactForm\Config;

/**
 *
 */
class FileMessageConfig extends Base implements MessageConfig
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

    public function getSentToEmailAddress()
    {
        return $this->config['email'];
    }
}
