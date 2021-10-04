<?php
declare(strict_types=1);

namespace Abrouter\Client\Config;

class Config
{
    /**
     * @var string $token
     */
    private string $token;
    
    /**
     * @var string $host
     */
    private string $host;
    
    public function __construct(string $token, string $host)
    {
        $this->token = $token;
        $this->host = $host;
    }
    
    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }
    
    /**
     * @return string
     */
    public function getToken(): string
    {
        return '';
    }
}
