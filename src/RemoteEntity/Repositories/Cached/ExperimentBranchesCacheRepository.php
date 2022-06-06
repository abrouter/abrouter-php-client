<?php

declare(strict_types=1);

namespace Abrouter\Client\RemoteEntity\Repositories\Cached;

use Abrouter\Client\RemoteEntity\Cache\Cacher;
use Abrouter\Client\RemoteEntity\Collections\ExperimentBranchesCollection;
use Abrouter\Client\RemoteEntity\Repositories\ExperimentBranchesRepository;

class ExperimentBranchesCacheRepository
{
    private const ENTITY_TYPE_EXPERIMENT_BRANCHES = 'experiment-branches';
    private const EXPIRES_IN_EXPERIMENT_BRANCHES = 3600 * 24;

    /**
     * @var ExperimentBranchesRepository
     */
    private $experimentBranchesRepository;

    /**
     * @var Cacher
     */
    private $cacher;

    public function __construct(
        ExperimentBranchesRepository $experimentBranchesRepository,
        Cacher $cacher
    ) {
        $this->experimentBranchesRepository = $experimentBranchesRepository;
        $this->cacher = $cacher;
    }

    public function getByExperimentAlias(string $experimentAlias): ExperimentBranchesCollection
    {

        /**
         * @var ExperimentBranchesCollection $experimentBranches
         */
        $experimentBranches = $this->cacher->fetch(
            $experimentAlias,
            self::ENTITY_TYPE_EXPERIMENT_BRANCHES,
            self::EXPIRES_IN_EXPERIMENT_BRANCHES,
            function () use ($experimentAlias) {
                return $this->experimentBranchesRepository->getByExperimentAlias($experimentAlias);
            }
        );

        return $experimentBranches;
    }

    public function getBranchIdByUid(string $experimentAlias, string $branchUid): ?string
    {
        $branches = $this->getByExperimentAlias($experimentAlias);

        $branchId = null;
        foreach ($branches->getExperimentBranches() as $branch) {
            if ($branch->getUid() === $branchUid) {
                $branchId = $branch->getId();
            }
        }
        if (empty($branchId)) {
            //todo replace with custom exception
            throw new \RuntimeException('Branch not found');
        }

        return $branchId;
    }
}
