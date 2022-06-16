<?php

declare(strict_types=1);

namespace Abrouter\Client\Services\Statistics;

use Abrouter\Client\Builders\Payload\SendEventPayloadBuilder;
use Abrouter\Client\DTO\EventDTO;
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
     * @param EventDTO $eventDTO
     * @return SentEvent
     * @throws InvalidJsonApiResponseException
     * @throws SendEventRequestException
     */
    public function sendEvent(EventDTO $eventDTO): SentEvent
    {
        $payload = $this->sendEventPayloadBuilder->build($eventDTO);

        $response = $this->sendEventRequest->sendEvent($payload);
        $sentEvent = $this->sendEventRequestTransformer->transform($response);

        return $sentEvent;
    }
}
