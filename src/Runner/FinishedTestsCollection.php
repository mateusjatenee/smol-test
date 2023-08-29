<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Runner;

use Mateusjatenee\SmolTest\Test\TestRun;

class FinishedTestsCollection
{
    public function __construct(
        public array $tests = []
    ) {
    }

    public function push(TestRun $testRun): void
    {
        $this->tests[] = $testRun;
    }
}
