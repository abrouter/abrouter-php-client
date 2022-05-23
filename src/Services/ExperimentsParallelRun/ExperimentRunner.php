<?php

declare(strict_types=1);

namespace Abrouter\Client\Services\ExperimentsParallelRun;

class ExperimentRunner
{
    private $variants;

    public function addSide(string $name, float $percent)
    {
        $this->variants[$name] = $percent;
    }

    public function rollFirst(): string
    {
        $firstKey = array_keys($this->variants)[0];
        return $this->variants[$firstKey];
    }

    public function roll(): string
    {
        $rand = mt_rand(1, 100);

        $start = 0;
        foreach ($this->variants as $variant => $percent) {
            if (($rand > $start) && ($rand <= ($start + $percent))) {
                return $variant;
            } else {
                $start = $start + $percent;
            }
        }

        $keys = array_keys($this->variants);
        $version = end($keys);
        $this->variants = [];

        return $version;
    }
}
