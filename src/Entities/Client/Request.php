<?php
declare(strict_types=1);

namespace Abrouter\Client\Entities\Client;

class Request implements RequestInterface
{
    /**
     * @var string
     */
    private $method;
    
    /**
     * @var array
     */
    private $payload;
    
    /**
     * @var array
     */
    private $headers;
    
    /**
     * @var string
     */
    private $url;
    
    public function __construct(
        string $method,
        string $url,
        array $payload,
        array $headers
    ) {
        $this->method = $method;
        $this->url = $url;
        $this->payload = $payload;
        $this->headers = $headers;
    }
    
    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }
    
    /**
     * @return array
     */
    public function getPayload(): array
    {
        return $this->payload;
    }
    
    public function getHeaders(): array
    {
        return $this->headers;
    }
    
    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }
}
