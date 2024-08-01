<?php

declare(strict_types=1);

namespace Abrouter\Client\Services\ExperimentsParallelRun;

use Abrouter\Client\Config\Accessors\ParallelRunConfigAccessor;
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
     * @var ParallelRunConfigAccessor
     */
    private ParallelRunConfigAccessor $parallelRunConfigAccessor;

    /**
     * @var Cacher
     */
    private Cacher $cacher;

    private RelatedUserBranchDetector $relatedUsersBranchDetector;

    public function __construct(
        ExperimentBranchesCacheRepository $experimentBranchesCacheRepository,
        ParallelRunConfigAccessor $parallelRunConfig,
        Cacher $cacher,
        RelatedUserBranchDetector $relatedUserBranchDetector
    ) {
        $this->experimentBranchesCacheRepository = $experimentBranchesCacheRepository;
        $this->parallelRunConfigAccessor = $parallelRunConfig;
        $this->cacher = $cacher;
        $this->relatedUsersBranchDetector = $relatedUserBranchDetector;
    }

    public function run(string $userSignature, string $experimentAlias): ExperimentRanResult
    {
        $experimentRunResult = $this->relatedUsersBranchDetector->getBranch($userSignature, $experimentAlias);
        if ($experimentRunResult !== null) {
            return $experimentRunResult;
        }

        $experimentRunner = new ExperimentRunner();
        $runFunction = function () use ($experimentAlias, $userSignature, $experimentRunner) {
            $branches = $this
                ->experimentBranchesCacheRepository
                ->getByExperimentAlias($experimentAlias);

            foreach ($branches->getExperimentBranches() as $branch) {
                $experimentRunner->addSide($branch->getUid(), (float)$branch->getPercentage());
            }
            $branch = $experimentRunner->roll();

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
