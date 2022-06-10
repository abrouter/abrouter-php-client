<?php

namespace Abrouter\Client\Config\Accessors;

use Abrouter\Client\Config\Config;

abstract class BaseAccessor
{
    /**
     * @var Config
     */
    private $config;

    final public function __construct(Config $config)
    {
        $this->config = $config;
    }

    final protected function getConfig(): Config
    {
        return $this->config;
    }
}
