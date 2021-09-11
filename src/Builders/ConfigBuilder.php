<?php
declare(strict_types=1);

namespace Abrouter\Client\Builders;

use Abrouter\Client\Config\Config;

class ConfigBuilder
{
    private const DEFAULT_HOST = 'https://abrouter.com';
    
    /**
     * @var string $host
     */
    private string $host;
    
    /**
     * @var string $token
     */
    private string $token;
    
    /**
     * @param string $host
     *
     * @return ConfigBuilder
     */
    public function setHost(string $host): self
    {
        $this->host = $host;
        return $this;
    }
    
    /**
     * @param string $token
     *
     * @return ConfigBuilder
     */
    public function setToken(string $token): self
    {
        $this->token = $token;
        return $this;
    }
    
    public function build(): Config
    {
        return new Config(
            $this->token,
            $this->host ?? self::DEFAULT_HOST
        );
    }
}
