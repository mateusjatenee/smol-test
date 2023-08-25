<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Runner;

interface Printer
{
    public function class(ClassDetails $class);

    public function testRun(TestRun $testRun);

    public function showFailedTests(FailedTestsCollection $failedTests);
}
