<?php

declare(strict_types=1);

namespace Abrouter\Client\Services\Statistics;

use Abrouter\Client\Builders\Payload\EventSendPayloadBuilder;
use Abrouter\Client\DTO\EventDTO;
use Abrouter\Client\Entities\SentEvent;
use Abrouter\Client\Exceptions\InvalidJsonApiResponseException;
use Abrouter\Client\Exceptions\SendEventRequestException;
use Abrouter\Client\Requests\SendEventRequest;
use Abrouter\Client\Transformers\SendEventRequestTransformer;

class SendEventService
{
    private SendEventRequest $sendEventRequest;

    private EventSendPayloadBuilder $eventSendPayloadBuilder;

    private SendEventRequestTransformer $sendEventRequestTransformer;

    public function __construct(
        SendEventRequest $sendEventRequest,
        EventSendPayloadBuilder $eventSendPayloadBuilder,
        SendEventRequestTransformer $sendEventRequestTransformer
    ) {
        $this->sendEventRequest = $sendEventRequest;
        $this->eventSendPayloadBuilder = $eventSendPayloadBuilder;
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
        $payload = $this->eventSendPayloadBuilder->build($eventDTO);

        $response = $this->sendEventRequest->sendEvent($payload);
        $sentEvent = $this->sendEventRequestTransformer->transform($response);

        return $sentEvent;
    }
}
