<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Runner\Output;

use Mateusjatenee\SmolTest\Runner\FailedTestsCollection;
use Mateusjatenee\SmolTest\Test\TestClass;
use Mateusjatenee\SmolTest\Test\TestRun;

interface Printer
{
    public function class(TestClass $class);

    public function testRun(TestRun $testRun);

    public function showFailedTests(FailedTestsCollection $failedTests);
}
