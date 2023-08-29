<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Event;

use Mateusjatenee\SmolTest\Test\TestRun;

readonly class TestFinished implements Event
{
    public function __construct(
        public TestRun $testRun
    ) {
    }
}
