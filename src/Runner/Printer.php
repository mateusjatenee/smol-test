<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Runner;

use Mateusjatenee\SmolTest\Test\TestRun;

interface Printer
{
    public function class(ClassDetails $class);

    public function testRun(TestRun $testRun);

    public function showFailedTests(FailedTestsCollection $failedTests);
}
