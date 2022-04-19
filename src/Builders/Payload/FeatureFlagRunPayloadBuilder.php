<?php

declare(strict_types=1);

namespace Abrouter\Client\Builders\Payload;

use Abrouter\Client\Entities\JsonPayload;

class FeatureFlagRunPayloadBuilder
{
    public function build(string $id): JsonPayload
    {
        return new JsonPayload([
            'data' => [
                'type'          => 'feature-toggles-run',
                'attributes'    => [
                    'userSignature' => "",
                ],
                'relationships' => [
                    'feature-toggle' => [
                        'data' => [
                            'id'   => $id,
                            'type' => 'feature-toggles',
                        ],
                    ],
                ]
            ],
        ]);
    }
}
