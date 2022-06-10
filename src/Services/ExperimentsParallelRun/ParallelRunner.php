<?php

declare(strict_types=1);

namespace Abrouter\Client\Services\ExperimentsParallelRun;

use Abrouter\Client\Config\Accessors\ParallelRunConfigAccessor;
use Abrouter\Client\Contracts\TaskManagerContract;
use Abrouter\Client\RemoteEntity\Cache\Cacher;
use Abrouter\Client\RemoteEntity\Entities\ExperimentRanResult;
use Abrouter\Client\RemoteEntity\Repositories\Cached\ExperimentBranchesCacheRepository;

class ParallelRunner
{
    /**
     * @var ExperimentBranchesCacheRepository
     */
    private $experimentBranchesCacheRepository;

    /**
     * @var ExperimentRunner
     */
    private $experimentRunner;

    /**
     * @var ParallelRunConfigAccessor
     */
    private ParallelRunConfigAccessor $parallelRunConfigAccessor;

    /**
     * @var Cacher
     */
    private Cacher $cacher;

    public function __construct(
        ExperimentBranchesCacheRepository $experimentBranchesCacheRepository,
        ExperimentRunner $experimentRunner,
        ParallelRunConfigAccessor $parallelRunConfig,
        Cacher $cacher
    ) {
        $this->experimentBranchesCacheRepository = $experimentBranchesCacheRepository;
        $this->experimentRunner = $experimentRunner;
        $this->parallelRunConfigAccessor = $parallelRunConfig;
        $this->cacher = $cacher;
    }

    public function run(string $userSignature, string $experimentAlias): ExperimentRanResult
    {
        $runFunction = function () use ($experimentAlias, $userSignature) {
            $branches = $this
                ->experimentBranchesCacheRepository
                ->getByExperimentAlias($experimentAlias);

            foreach ($branches->getExperimentBranches() as $branch) {
                $this->experimentRunner->addSide($branch->getUid(), (float)$branch->getPercentage());
            }
            $branch = $this->experimentRunner->roll();

            $task = new AddUserToBranchTask(
                $experimentAlias,
                $branches->getExperimentId(),
                $userSignature,
                $branch,
            );

            $this->parallelRunConfigAccessor->getTaskManager()->queue($task);

            return new ExperimentRanResult(
                $branch,
                $experimentAlias
            );
        };

        /**
         * @var ExperimentRanResult $ran
         */
        $cacheKey = join('', [$experimentAlias, '-', $userSignature]);
        $ran = $this->cacher->fetch($cacheKey, 'experiment_users', 3600 * 24 * 180, $runFunction);

        return $ran;
    }
}
