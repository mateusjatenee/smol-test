<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Runner;

class FailedTestsCollection
{
    /**
     * @param  Failure[]  $failures
     */
    public function __construct(
        public array $failures = []
    ) {
    }

    public function push(Failure $failure): void
    {
        $this->failures[] = $failure;
    }

    public function count(): int
    {
        return count($this->failures);
    }
}
