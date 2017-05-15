<?php
namespace Carawebs\ContactForm\Config;

use Carawebs\ContactForm\Config\Contracts\AllowedLocationsConfig;
/**
 *
 */
class FileAllowedLocationsConfig extends BaseArrayAccess implements AllowedLocationsConfig
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

    public function allowed()
    {
        static $allowed;
        isset($allowed) || $allowed = in_array(true, $this->container);
        return $allowed;
    }
}
