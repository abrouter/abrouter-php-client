<?php
declare(strict_types = 1);

namespace Abrouter\Client\Manager;

use Abrouter\Client\Builders\Payload\SendEventPayloadBuilder;
use Abrouter\Client\Entities\SentEvent;
use Abrouter\Client\Exceptions\InvalidJsonApiResponseException;
use Abrouter\Client\Exceptions\SendEventRequestException;
use Abrouter\Client\Requests\SendEventRequest;
use Abrouter\Client\Transformers\SendEventRequestTransformer;
use Abrouter\Client\DTO\IncrementEventDTO;
use Abrouter\Client\DTO\SummarizeEventDTO;

class StatisticsManager
{
    /**
     * @var SendEventRequest
     */
    private SendEventRequest $sendEventRequest;

    /**
     * @var SendEventPayloadBuilder
     */
    private SendEventPayloadBuilder $sendEventPayloadBuilder;

    /**
     * @var SendEventRequestTransformer
     */
    private SendEventRequestTransformer $sendEventRequestTransformer;

    public function __construct(
        SendEventRequest            $sendEventRequest,
        SendEventPayloadBuilder     $sendEventPayloadBuilder,
        SendEventRequestTransformer $sendEventRequestTransformer
    ) {
        $this->sendEventRequest = $sendEventRequest;
        $this->sendEventPayloadBuilder = $sendEventPayloadBuilder;
        $this->sendEventRequestTransformer = $sendEventRequestTransformer;
    }

    /**
     * @param IncrementEventDTO $incrementEventDTO
     * @return SentEvent
     * @throws InvalidJsonApiResponseException
     * @throws SendEventRequestException
     */
    public function increment(IncrementEventDTO $incrementEventDTO): SentEvent
    {
        $payload = $this->sendEventPayloadBuilder->buildSendIncrementEventRequest($incrementEventDTO);
        $response = $this->sendEventRequest->sendEvent($payload);
        $increment = $this->sendEventRequestTransformer->transform($response);
        
        return $increment;
    }

    /**
     * @param SummarizeEventDTO $summarizeEventDTO
     * @return SentEvent
     * @throws InvalidJsonApiResponseException
     * @throws SendEventRequestException
     */
    public function summarize(SummarizeEventDTO $summarizeEventDTO): SentEvent
    {
        $payload = $this->sendEventPayloadBuilder->buildSendSummarizeEventRequest($summarizeEventDTO);
        $response = $this->sendEventRequest->sendEvent($payload);
        $summarize = $this->sendEventRequestTransformer->transform($response);

        return $summarize;
    }
}
