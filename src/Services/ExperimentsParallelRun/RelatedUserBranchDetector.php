<?php

declare(strict_types=1);

namespace Abrouter\Client\Services\ExperimentsParallelRun;

use Abrouter\Client\DB\RelatedUsersStore;
use Abrouter\Client\RemoteEntity\Cache\Cacher;
use Abrouter\Client\RemoteEntity\Entities\ExperimentRanResult;

class RelatedUserBranchDetector
{
    private RelatedUsersStore $relatedUsersStore;

    private Cacher $cacher;

    public function __construct(
        RelatedUsersStore $relatedUsersStore,
        Cacher $cacher
    ) {
        $this->relatedUsersStore = $relatedUsersStore;
        $this->cacher = $cacher;
    }

    public function getBranch(string $userSignature, string $experimentAlias): ?ExperimentRanResult
    {
        $userIds = $this->relatedUsersStore->get()->getByUserId($userSignature);

        if ($userIds === null) {
            return null;
        }

        foreach ($userIds as $userSignatureItem) {
            $cacheKey = join('', [$experimentAlias, '-', $userSignatureItem]);
            $experimentRunResult = $this->cacher->get($cacheKey, 'experiment_users');
            if (!is_object($experimentRunResult)) {
                continue;
            }

            if (!$experimentRunResult instanceof ExperimentRanResult) {
                continue;
            }

            return $experimentRunResult;
        }

        return null;
    }
}
