<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest;

use Mateusjatenee\SmolTest\Test\ExceptionDetails;
use Mateusjatenee\SmolTest\Test\TestClass;

readonly class Failure
{
    public function __construct(
        public TestClass $testClass,
        public ExceptionDetails $exceptionDetails,
    ) {
    }
}
