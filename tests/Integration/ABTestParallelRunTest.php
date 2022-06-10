<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Integration;

use Abrouter\Client\Client;
use Abrouter\Client\RemoteEntity\Repositories\ExperimentUserBranchesRepository;
use Abrouter\Client\Services\ExperimentsParallelRun\ParallelRunSwitch;
use Abrouter\Client\Worker;

class ABTestParallelRunTest extends IntegrationTestCase
{
    public function testABTestRun()
    {
        $this->configureParallelRun('add73bda37106bbddf2e6b3f61c6ed197c2250e99df9474ad01b9afb2035af33cf66c292fdf6a6e8');
        $this->clearRedis();

        $client = $this->getContainer()->make(Client::class);
        $userSignature = 'test-run-f:' . uniqid();
        $run = $client->experiments()->run($userSignature, 'example_experiment');

        $switch = $this->getContainer()->make(ParallelRunSwitch::class);
        $this->assertTrue($switch->isEnabled());

        $this->assertTrue(in_array($run->getBranchId(), ['first_branch', 'second_branch']));

        $this->assertTrue($run->getExperimentId() === 'example_experiment');


        $experimentUserBranchesRepository = $this->getContainer()->make(ExperimentUserBranchesRepository::class);
        $experimentUserBranches = $experimentUserBranchesRepository->getBranchesByUser($userSignature);
        $this->assertEquals(sizeof($experimentUserBranches->getAll()), 0);

        $worker = $this->getContainer()->make(Worker::class);
        $worker->work(100);

        $experimentUserBranches = $experimentUserBranchesRepository->getBranchesByUser($userSignature);
        $experimentUserBranch = $experimentUserBranches->getAll()[0];

        $this->assertTrue(in_array($experimentUserBranch->getBranchUid(), ['first_branch', 'second_branch'], true));
    }
}
