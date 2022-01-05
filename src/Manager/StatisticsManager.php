<?php
declare(strict_types = 1);

namespace Abrouter\Client\Manager;

use Abrouter\Client\Builders\Payload\EventSendPayloadBuilder;
use Abrouter\Client\Entities\SendEvent;
use Abrouter\Client\Exceptions\InvalidJsonApiResponseException;
use Abrouter\Client\Exceptions\SendEventRequestException;
use Abrouter\Client\Requests\SendEventRequest;
use Abrouter\Client\Transformers\SendEventRequestTransformer;
use Abrouter\Client\DTO\EventDTO;

class StatisticsManager
{   
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
     * @param EventDTO
     *
     * @return SendEvent
     */
    public function sendEvent(EventDTO $eventDTO)
    {
        $payload = $this->eventSendPayloadBuilder->build($eventDTO);
        $response = $this->sendEventRequest->sendEvent($payload);
        $sendEvent = $this->sendEventRequestTransformer->transform($response);
        
        return $sendEvent;
    }
}
