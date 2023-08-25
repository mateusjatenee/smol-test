<?php declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Runner;

use IteratorAggregate;
use Mateusjatenee\SmolTest\Failure;
use Traversable;

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
}