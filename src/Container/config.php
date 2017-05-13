<?php

use function DI\object;
use Carawebs\ContactForm\Plugin;
use Carawebs\ContactForm\Config\MessageConfig;
use Carawebs\ContactForm\Config\FileMessageConfig;

return [
    // Bind an interface to an implementation
    MessageConfig::class => object(FileMessageConfig::class),
    // Plugin->bootstrap() => object(FileMessageConfig::class),

];
