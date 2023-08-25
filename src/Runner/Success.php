<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Runner;

class Success
{
    public function __construct(
        public string $className,
        public string $methodName,
        public int $duration,
    ) {
    }
}
