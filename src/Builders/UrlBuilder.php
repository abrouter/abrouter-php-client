<?php
declare(strict_types=1);

namespace Abrouter\Client\Builders;

use Abrouter\Client\Config\Accessors\HostConfigAccessor;

class UrlBuilder
{
    public const RUN_EXPERIMENT_API_URL = 'api/v1/experiment/run';
    public const SEND_EVENT_API_URL = 'api/v1/event';
    
    /**
     * @var HostConfigAccessor
     */
    private HostConfigAccessor $hostConfigAccessor;
    
    private string $host;
    
    private string $url;
    
    public function __construct(HostConfigAccessor $hostConfigAccessor)
    {
        $this->hostConfigAccessor = $hostConfigAccessor;
        $this->host = $hostConfigAccessor->getHost();
    }
    
    public function runExperimentUri()
    {
        return $this->setUrl(self::RUN_EXPERIMENT_API_URL);
    }

    public function sendEventUri()
    {
        return $this->setUrl(self::SEND_EVENT_API_URL);
    }
    
    public function build(): string
    {
        return $this->injectHost($this->url);
    }
    
    private function reset()
    {
        $this->url = '';
        return $this;
    }
    
    private function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }
    
    private function injectHost(string $uri): string
    {
        return join('/', [$this->hostConfigAccessor->getHost(), $uri]);
    }
}
