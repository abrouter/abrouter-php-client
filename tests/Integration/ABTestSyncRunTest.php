<?php

declare(strict_types=1);

namespace Abrouter\Client\Tests\Integration;

use Abrouter\Client\Client;
use Abrouter\Client\RemoteEntity\Repositories\ExperimentUserBranchesRepository;
use Abrouter\Client\Services\ExperimentsParallelRun\ParallelRunSwitch;
use Abrouter\Client\Worker;

class ABTestSyncRunTest extends IntegrationTestCase
{
    public function testABTestRun()
    {
        $this->bindConfig(
            'https://abrouter.com',
            'default'
        );

        $client = $this->getContainer()->make(Client::class);
        $userSignature = 'test-run-f:' . uniqid();
        $run = $client->experiments()->run($userSignature, 'example_experiment');

        $switch = $this->getContainer()->make(ParallelRunSwitch::class);
        $this->assertFalse($switch->isEnabled());

        $this->assertTrue(in_array($run->getBranchId(), ['first_branch', 'second_branch']));

        $this->assertTrue($run->getExperimentId() === 'example_experiment');

        $experimentUserBranchesRepository = $this->getContainer()->make(ExperimentUserBranchesRepository::class);
        $experimentUserBranches = $experimentUserBranchesRepository->getBranchesByUser($userSignature);
        $experimentUserBranch = $experimentUserBranches->getAll()[0];

        $this->assertTrue(in_array($experimentUserBranch->getBranchUid(), ['first_branch', 'second_branch'], true));
    }
}
