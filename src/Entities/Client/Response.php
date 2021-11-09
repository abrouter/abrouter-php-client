<?php
declare(strict_types=1);

namespace Abrouter\Client\Entities\Client;

class Response implements ResponseInterface
{
    /**
     * @var array
     */
    private $responseJson;
    
    public function __construct(array $responseJson)
    {
        $this->responseJson = $responseJson;
    }
    
    public function getResponseJson(): array
    {
        return $this->responseJson;
    }
}
