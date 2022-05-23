<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Unit\Http;

use Abrouter\Client\Builders\RequestBuilder;
use Abrouter\Client\Entities\Client\Request;
use Abrouter\Client\Http\RequestExecutor;
use Abrouter\Client\Tests\Unit\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use Abrouter\Client\Entities\Client\ResponseInterface as AbrResponseInterface;

class RequestExecutorTest extends TestCase
{
    public function testRequestExecutor()
    {
        $client = new class () extends Client {
            /**
             * @var string
             */
            private string $method;

            /**
             * @var string
             */
            private string $url;

            /**
             * @var array
             */
            private array $options;

            /**
             * @var array
             */
            private array $returnData;

            /**
             * @return string
             */
            public function getMethod(): string
            {
                return $this->method;
            }

            /**
             * @return string
             */
            public function getUrl(): string
            {
                return $this->url;
            }

            /**
             * @return array
             */
            public function getOptions(): array
            {
                return $this->options;
            }

            /**
             * @return array
             */
            public function getReturnData(): array
            {
                return $this->returnData;
            }

            /**
             * @param array $returnData
             */
            public function setReturnData(array $returnData): void
            {
                $this->returnData = $returnData;
            }

            public function request($method, $uri = '', array $options = []): ResponseInterface
            {
                $this->method = $method;
                $this->url = $uri;
                $this->options = $options;

                return new Response(200, [], json_encode($this->returnData));
            }
        };

        $client->setReturnData([
            'data' => [
                'type' => 'response-type',
                'attributes' => [
                    'experiment_name' => uniqid(),
                ]
            ]
        ]);
        $requestExecutorMock = new RequestExecutor($client);

        $request = new Request(
            RequestBuilder::METHOD_POST,
            '/',
            [
                'data' => [
                    'type' => 'request-type',
                    'attributes' => [
                        'experiment_name' => uniqid(),
                    ]
                ]
            ],
            [
                'Authorization' => 'Bearer ' . uniqid(),
            ]
        );

        $response = $requestExecutorMock->execute($request);
        $this->assertInstanceOf(AbrResponseInterface::class, $response);
        $this->assertEquals($response->getResponseJson(), $client->getReturnData());
        $this->assertEquals($request->getHeaders(), $client->getOptions()[RequestOptions::HEADERS]);
        $this->assertEquals($request->getPayload(), $client->getOptions()[RequestOptions::JSON]);
        $this->assertEquals($request->getMethod(), $client->getMethod());
        $this->assertEquals($request->getUrl(), $client->getUrl());
    }
}
