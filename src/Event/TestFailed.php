<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Event;

use Mateusjatenee\SmolTest\Runner\Failure;

readonly class TestFailed implements Event
{
    public function __construct(
        public Failure $failure
    ) {
    }
}
