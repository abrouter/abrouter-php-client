<?php
declare(strict_types = 1);

namespace Abrouter\Client\Manager;

use Abrouter\Client\Builders\Payload\IncrementPayloadBuilder;
use Abrouter\Client\Builders\Payload\SummarizePayloadBuilder;
use Abrouter\Client\Entities\Increment;
use Abrouter\Client\Entities\Summarize;
use Abrouter\Client\Exceptions\InvalidJsonApiResponseException;
use Abrouter\Client\Exceptions\SendEventRequestException;
use Abrouter\Client\Requests\SendEventRequest;
use Abrouter\Client\Transformers\IncrementRequestTransformer;
use Abrouter\Client\Transformers\SummarizeRequestTransformer;
use Abrouter\Client\DTO\IncrementEventDTO;
use Abrouter\Client\DTO\SummarizeEventDTO;

class StatisticsManager
{
    /**
     * @var SendEventRequest
     */
    private SendEventRequest $sendEventRequest;

    /**
     * @var IncrementPayloadBuilder
     */
    private IncrementPayloadBuilder $incrementPayloadBuilder;

    /**
     * @var SummarizePayloadBuilder
     */
    private SummarizePayloadBuilder $summarizePayloadBuilder;

    /**
     * @var IncrementRequestTransformer
     */
    private IncrementRequestTransformer $incrementRequestTransformer;

    /**
     * @var SummarizeRequestTransformer
     */
    private SummarizeRequestTransformer $summarizeRequestTransformer;

    public function __construct(
        SendEventRequest            $sendEventRequest,
        IncrementPayloadBuilder     $incrementPayloadBuilder,
        SummarizePayloadBuilder     $summarizePayloadBuilder,
        IncrementRequestTransformer $incrementRequestTransformer,
        SummarizeRequestTransformer $summarizeRequestTransformer
    ) {
        $this->sendEventRequest = $sendEventRequest;
        $this->incrementPayloadBuilder = $incrementPayloadBuilder;
        $this->summarizePayloadBuilder = $summarizePayloadBuilder;
        $this->incrementRequestTransformer = $incrementRequestTransformer;
        $this->summarizeRequestTransformer = $summarizeRequestTransformer;
    }

    /**
     * @param IncrementEventDTO $incrementEventDTO
     * @return Increment
     * @throws SendEventRequestException
     * @throws InvalidJsonApiResponseException
     */
    public function increment(IncrementEventDTO $incrementEventDTO): Increment
    {
        $payload = $this->incrementPayloadBuilder->build($incrementEventDTO);
        $response = $this->sendEventRequest->sendEvent($payload);
        $increment = $this->incrementRequestTransformer->transform($response);
        
        return $increment;
    }

    /**
     * @param SummarizeEventDTO $summarizeEventDTO
     * @return Summarize
     * @throws InvalidJsonApiResponseException
     * @throws SendEventRequestException
     */
    public function summarize(SummarizeEventDTO $summarizeEventDTO): Summarize
    {
        $payload = $this->summarizePayloadBuilder->build($summarizeEventDTO);
        $response = $this->sendEventRequest->sendEvent($payload);
        $summarize = $this->summarizeRequestTransformer->transform($response);

        return $summarize;
    }
}
