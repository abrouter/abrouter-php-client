<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Unit\Transformers;

use Abrouter\Client\Builders\RequestBuilder;
use Abrouter\Client\Entities\Client\Request;
use Abrouter\Client\Tests\Unit\TestCase;

class RequestBuilderTest extends TestCase
{
    /**
     * @var RequestBuilder $requestBuilder
     */
    private RequestBuilder $requestBuilder;

    public function setUp(): void
    {
        $this->requestBuilder = $this->getContainer()->make(RequestBuilder::class);
    }

    public function testRequestBuilder()
    {
        $url = '/';
        $payload = [
            'test' => 1,
        ];
        $headers = [
            'Authorization' => 'Bearer ' . uniqid(),
        ];

        $request = $this->requestBuilder
            ->post()
            ->url($url)
            ->withJsonPayload($payload)
            ->withHeaders($headers)
            ->build();

        $this->assertInstanceOf(Request::class, $request);
        $this->assertEquals($request->getPayload(), $payload);
        $this->assertEquals($request->getMethod(), RequestBuilder::METHOD_POST);
        $this->assertEquals($request->getHeaders(), $headers);
        $this->assertEquals($request->getUrl(), $url);
    }
}
