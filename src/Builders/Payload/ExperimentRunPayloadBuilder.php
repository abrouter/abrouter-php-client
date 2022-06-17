<?php

declare(strict_types=1);

namespace Abrouter\Client\Builders\Payload;

use Abrouter\Client\Entities\JsonPayload;

class ExperimentRunPayloadBuilder
{
    public function build(string $userSignature, string $experimentId): JsonPayload
    {
        return new JsonPayload([
            'data' => [
                'type'          => 'experiment-run',
                'attributes'    => [
                    'userSignature' => $userSignature,
                ],
                'relationships' => [
                    'experiment' => [
                        'data' => [
                            'id'   => $experimentId,
                            'type' => 'experiments',
                        ],
                    ],
                ]
            ],
        ]);
    }
}
