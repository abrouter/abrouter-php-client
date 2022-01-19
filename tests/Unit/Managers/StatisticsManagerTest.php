<?php
namespace Abrouter\Client\Tests\Unit\Managers;

use Abrouter\Client\Builders\Payload\EventSendPayloadBuilder;
use Abrouter\Client\Entities\Client\Response;
use Abrouter\Client\Entities\Client\ResponseInterface;
use Abrouter\Client\Entities\JsonPayload;
use Abrouter\Client\Manager\StatisticsManager;
use Abrouter\Client\Tests\Unit\TestCase;
use \Abrouter\Client\Requests\SendEventRequest;
use Abrouter\Client\Transformers\SendEventRequestTransformer;
use Abrouter\Client\DTO\EventDTO;

class StatisticsManagerTest extends TestCase
{
    public function testSendEvent()
    {
        $eventDTO = new EventDTO(
            'owner_12345',
            'temporary_user_12345',
            'user_12345',
            'new_event',
            'new_tag',
            'abrouter',
            [],
            '255.255.255.255'
        );
        
        $sendEventRequest = new class () extends SendEventRequest {
            public function __construct()
            {
            }
    
            public function sendEvent(JsonPayload $jsonPayload): ResponseInterface
            {
                return new Response([
                    'data' => [
                        'id' => uniqid(),
                        'type' => 'events',
                        'attributes' => [
                            'user_id' => 'user_12345',
                            'event' => 'new_event',
                            'tag' => 'new_tag',
                            'referrer' => 'abrouter',
                            'ip' => '255.255.255.255',
                            'meta' => []
                        ],
                    ]
                ]);
            }
        };
        
        
        $statisticsManager = new StatisticsManager(
            $sendEventRequest,
            $this->getContainer()->make(EventSendPayloadBuilder::class),
            $this->getContainer()->make(SendEventRequestTransformer::class),
        );
        
        $sendEventEntity = $statisticsManager->sendEvent($eventDTO);
    
        $this->assertEquals($sendEventEntity->isSuccessful(), true);
    }
}
