<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Runner;

use Mateusjatenee\SmolTest\Test\ExceptionDetails;
use Mateusjatenee\SmolTest\Test\TestClass;
use Mateusjatenee\SmolTest\Test\TestMethod;

readonly class Failure
{
    public function __construct(
        public TestClass $testClass,
        public TestMethod $testMethod,
        public ExceptionDetails $exceptionDetails,
    ) {
    }
}
