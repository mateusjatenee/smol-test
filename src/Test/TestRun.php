<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Test;

use Mateusjatenee\SmolTest\Failure;

readonly class TestRun
{
    public function __construct(
        public TestClass $class,
        public TestMethod $method,
        public TestDuration $duration,
        public ?Failure $failure = null
    ) {
    }

    public function succeeded(): bool
    {
        return $this->failure === null;
    }

    public function failed(): bool
    {
        return ! $this->succeeded();
    }

    public function readableMethodName(): string
    {
        return $this->method->nameForHumans();
    }
}
