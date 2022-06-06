<?php

declare(strict_types=1);

namespace Abrouter\Client\RemoteEntity\Entities;

class FeatureFlagRan
{
    private bool $isEnabled;

    public function __construct(bool $isEnabled)
    {
        $this->isEnabled = $isEnabled;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->isEnabled;
    }
}
