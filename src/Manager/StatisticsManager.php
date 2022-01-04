<?php
declare(strict_types = 1);

namespace Abrouter\Client\Manager;

use Abrouter\Client\Builders\Payload\StatisticsPayloadBuilder;
use Abrouter\Client\Entities\Statistics;
use Abrouter\Client\Exceptions\InvalidJsonApiResponseException;
use Abrouter\Client\Exceptions\StatisticsRequestException;
use Abrouter\Client\Requests\StatisticsRequest;
use Abrouter\Client\Transformers\StatisticsRequestTransformer;
use Abrouter\Client\Services\DTO\EventDTO;

class StatisticsManager
{   
    public function __construct(
        StatisticsPayloadBuilder $statisticsPayloadBuilder,
        StatisticsRequest $statisticsRequest
    ) {
        $this->statisticsPayloadBuilder = $statisticsPayloadBuilder;
        $this->statisticsRequest = $statisticsRequest;
        $this->statisticsRequestTransformer = $statisticsRequestTransformer;
    }
    /**
     * @param EventDTO
     *
     * @return Statistics
     */
    public function sendEvent(EventDTO $eventDTO)
    {
        $payload = $this->statisticsPayloadBuilder->build($eventDTO);
        $response = $this->statisticsRequest->sendEvent($payload);
        $statistics = $this->statisticsRequestTransformer->transform($response);
        
        return $statistics;
    }
}
