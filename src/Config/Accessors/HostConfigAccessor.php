<?php
declare(strict_types=1);

namespace Abrouter\Client\Config\Accessors;

use Abrouter\Client\Config\Config;

class HostConfigAccessor
{
    /**
     * @var Config
     */
    private $config;
    
    public function __construct(Config $config)
    {
        $this->config = $config;
    }
    
    public function getHost(): string
    {
        return $this->config->getHost();
    }
}
