<?php
declare(strict_types=1);

namespace Abrouter\Client\Builders;

use Abrouter\Client\Entities\Client\Request;

class RequestBuilder
{
    public const METHOD_POST = 'post';
    
    /**
     * @var string $method
     */
    private $method;
    
    /**
     * @var string $url
     */
    private $url;
    
    /**
     * @var array
     */
    private $jsonPayload;
    
    /**
     * @var array
     */
    private  $headers;
    
    public function post(): self
    {
        $this->method = self::METHOD_POST;
        return $this;
    }
    
    public function url(string $url): self
    {
        $this->url = $url;
        return $this;
    }
    
    public function withJsonPayload(array $payload): self
    {
        $this->jsonPayload = $payload;
        return $this;
    }
    
    public function withHeaders(array $headers): self
    {
        $this->headers = $headers;
        return $this;
    }
    
    public function build(): Request
    {
        return new Request($this->method, $this->url, $this->jsonPayload, $this->headers);
    }
}
