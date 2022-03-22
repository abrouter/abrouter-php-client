<?php
declare(strict_types = 1);

namespace Abrouter\Client\Tests\Unit\Transformers;

use Abrouter\Client\Builders\UrlBuilder;
use Abrouter\Client\Tests\Unit\TestCase;

class UrlBuilderTest extends TestCase
{
    /**
     * @var UrlBuilder $urlBuilder
     */
    private UrlBuilder $urlBuilder;
    
    public function setUp(): void
    {
        $this->bindConfig();
        $this->urlBuilder = $this->getContainer()->make(UrlBuilder::class);
    }
    
    public function testUrlBuilderRunExperimentUri()
    {
        $url = $this->urlBuilder->runExperimentUri()->build();
        $this->assertEquals($url, $this->getConfig()->getHost() . '/' . UrlBuilder::RUN_EXPERIMENT_API_URL);
    }

    public function testUrlBuilderRunFeatureFlagUri()
    {
        $url = $this->urlBuilder->runFeatureFlagUri()->build();
        $this->assertEquals($url, $this->getConfig()->getHost() . '/' . UrlBuilder::RUN_FEATURE_FLAG_API_URL);
    }

    public function testUrlBuilderSendEventUri()
    {
        $url = $this->urlBuilder->sendEventUri()->build();
        $this->assertEquals($url, $this->getConfig()->getHost() . '/' . UrlBuilder::SEND_EVENT_API_URL);
    }
}
