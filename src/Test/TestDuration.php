<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Test;

class TestDuration
{
    public function __construct(
        protected float $microseconds
    ) {
    }

    public static function sinceStart($start): self
    {
        return new static(microtime(true) - $start);
    }

    public function miliseconds(): int
    {
        return (int) ceil($this->microseconds * 1000);
    }
}
