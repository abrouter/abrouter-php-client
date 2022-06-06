<?php

declare(strict_types=1);

namespace Abrouter\Client\Transformers;

use Abrouter\Client\Entities\Client\Response;
use Abrouter\Client\RemoteEntity\Collections\ExperimentUserBranchesCollection;
use Abrouter\Client\Exceptions\InvalidJsonApiResponseException;
use Abrouter\Client\RemoteEntity\Entities\ExperimentUserBranch;

/**
 * Todo: rename all classes in this dir to *ResponseTransformer
 */
class ExperimentUsersRequestTransformer
{
    /**
     * @throws InvalidJsonApiResponseException
     */
    public function transform(Response $response): ExperimentUserBranchesCollection
    {
        $json = $response->getResponseJson();

        if (empty($json['data'])) {
            return new ExperimentUserBranchesCollection();
        }

        return new ExperimentUserBranchesCollection(...array_reduce(
            $json['data'],
            function (array $acc, array $item) {
                $acc[] = new ExperimentUserBranch(
                    $item['attributes']['branch-uid'],
                    $item['attributes']['experiment-uid']
                );
                return $acc;
            },
            []
        ));
    }
}
