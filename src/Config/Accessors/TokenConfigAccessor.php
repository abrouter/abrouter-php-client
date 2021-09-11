<?php
declare(strict_types=1);

namespace Abrouter\Client\Config\Accessors;

use Abrouter\Client\Config\Config;

class TokenConfigAccessor
{
    /**
     * @var Config
     */
    private Config $config;
    
    public function __construct(Config $config)
    {
        $this->config = $config;
    }
    
    public function getToken(): string
    {
        return $this->config->getToken();
    }
}
