<?php

declare(strict_types=1);

namespace Abrouter\Client\Transformers;

use Abrouter\Client\RemoteEntity\Collections\ExperimentBranchesCollection;
use Abrouter\Client\Entities\Client\Response;
use Abrouter\Client\RemoteEntity\Entities\ExperimentBranch;
use Abrouter\Client\Exceptions\InvalidJsonApiResponseException;
use Throwable;

/**
 * Todo: rename all classes in this dir to *ResponseTransformer
 */
class BranchesRequestTransformer
{
    /**
     * @throws InvalidJsonApiResponseException
     */
    public function transform(Response $response): ExperimentBranchesCollection
    {
        $json = $response->getResponseJson();

        if (empty($json['data'])) {
            return new ExperimentBranchesCollection();
        }

        try {
            $branchesIds = array_reduce(
                $json['data'][0]['relationships']['branches']['data'],
                function (array $acc, array $identifier) {
                    $acc[] = $identifier['id'];
                    return $acc;
                },
                []
            );

            $experimentId = $json['data'][0]['id'];
            $experimentAlias = $json['data'][0]['attributes']['uid'];

            $included = $json['included'] ?? [];
            return new ExperimentBranchesCollection(
                $experimentId,
                ...array_reduce(
                    $included,
                    function (array $acc, array $include) use ($branchesIds, $experimentId, $experimentAlias) {
                        if (!in_array($include['id'], $branchesIds, true)) {
                            return $acc;
                        }

                        $acc[] = new ExperimentBranch(
                            $include['id'],
                            $include['attributes']['uid'],
                            $include['attributes']['percent'],
                            $experimentAlias,
                            $experimentId,
                        );

                        return $acc;
                    },
                    []
                )
            );
        } catch (Throwable $e) {
            throw new InvalidJsonApiResponseException($e->getMessage());
        }
    }
}
