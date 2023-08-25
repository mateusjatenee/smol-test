<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Runner;

use Mateusjatenee\SmolTest\Failure;

readonly class TestRun
{
    public function __construct(
        public string $className,
        public string $methodName,
        public int $duration,
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
        return str($this->methodName)
            ->replace('test', '')
            ->replace('_', ' ')
            ->trim()
            ->ucfirst()
            ->__toString();
    }
}
