<?php

namespace Mateusjatenee\SmolTest\Runner\Execution;

use Mateusjatenee\SmolTest\Test\TestClass;
use Mateusjatenee\SmolTest\Test\TestMethod;

interface RunsTests
{
    public function handle(TestClass $testClass, TestMethod $testMethod);
}
