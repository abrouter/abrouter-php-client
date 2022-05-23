<?php

declare(strict_types=1);

namespace Abrouter\Client\RemoteEntity\Entities;

class ExperimentBranch
{
    /**
     * @var string
     */
    private $uid;

    /**
     * @var int
     */
    private $percentage;

    /**
     * @var string
     */
    private $experimentId;

    private string $id;

    private string $experimentAlias;

    public function __construct(string $id, string $uid, int $percentage, string $experimentAlias, string $experimentId)
    {
        $this->id = $id;
        $this->uid = $uid;
        $this->percentage = $percentage;
        $this->experimentId = $experimentId;
        $this->experimentAlias = $experimentAlias;
    }

    /**
     * @return string
     */
    public function getUid(): string
    {
        return $this->uid;
    }

    /**
     * @return int
     */
    public function getPercentage(): int
    {
        return $this->percentage;
    }

    /**
     * @return string
     */
    public function getExperimentId(): string
    {
        return $this->experimentId;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}
