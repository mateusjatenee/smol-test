<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Runner;

class TestSuite
{
    public function __construct(
        public string $path,
        public ?Bootstrapper $bootstrapper = null
    ) {
    }

    public static function path(string $path): static
    {
        return new static($path);
    }

    public function bootstrapper(Bootstrapper $bootstrapper): self
    {
        $this->bootstrapper = $bootstrapper;

        return $this;
    }
}
