<?php

declare(strict_types=1);

namespace Abrouter\Client\Services\Statistics;

use Abrouter\Client\Builders\Payload\SendEventPayloadBuilder;
use Abrouter\Client\DTO\IncrementEventDTO;
use Abrouter\Client\DTO\SummarizeEventDTO;
use Abrouter\Client\Entities\SentEvent;
use Abrouter\Client\Exceptions\InvalidJsonApiResponseException;
use Abrouter\Client\Exceptions\SendEventRequestException;
use Abrouter\Client\Requests\SendEventRequest;
use Abrouter\Client\Transformers\SendEventRequestTransformer;

class SendEventService
{
    private SendEventRequest $sendEventRequest;

    private SendEventPayloadBuilder $sendEventPayloadBuilder;

    private SendEventRequestTransformer $sendEventRequestTransformer;

    public function __construct(
        SendEventRequest $sendEventRequest,
        SendEventPayloadBuilder $sendEventPayloadBuilder,
        SendEventRequestTransformer $sendEventRequestTransformer
    ) {
        $this->sendEventRequest = $sendEventRequest;
        $this->sendEventPayloadBuilder = $sendEventPayloadBuilder;
        $this->sendEventRequestTransformer = $sendEventRequestTransformer;
    }

    /**
     * @deprecated
     * @param IncrementEventDTO $eventDTO
     * @return SentEvent
     * @throws InvalidJsonApiResponseException
     * @throws SendEventRequestException
     */
    public function sendEvent(IncrementEventDTO $eventDTO): SentEvent
    {
        $payload = $this->sendEventPayloadBuilder->buildSendIncrementEventRequest($eventDTO);

        $response = $this->sendEventRequest->sendEvent($payload);
        $sentEvent = $this->sendEventRequestTransformer->transform($response);

        return $sentEvent;
    }

    /**
     * @param IncrementEventDTO $eventDTO
     * @return SentEvent
     * @throws InvalidJsonApiResponseException
     * @throws SendEventRequestException
     */
    public function sendIncrementEvent(IncrementEventDTO $eventDTO): SentEvent
    {
        $payload = $this->sendEventPayloadBuilder->buildSendIncrementEventRequest($eventDTO);

        $response = $this->sendEventRequest->sendEvent($payload);
        $sentEvent = $this->sendEventRequestTransformer->transform($response);

        return $sentEvent;
    }

    /**
     * @param SummarizeEventDTO $eventDTO
     * @return SentEvent
     * @throws InvalidJsonApiResponseException
     * @throws SendEventRequestException
     */
    public function sendSummarizableEvent(SummarizeEventDTO $eventDTO): SentEvent
    {
        $payload = $this->sendEventPayloadBuilder->buildSendSummarizeEventRequest($eventDTO);

        $response = $this->sendEventRequest->sendEvent($payload);
        $sentEvent = $this->sendEventRequestTransformer->transform($response);

        return $sentEvent;
    }
}
