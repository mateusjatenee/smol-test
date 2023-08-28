<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Runner;

use Mateusjatenee\SmolTest\AssertionFailedException;
use Mateusjatenee\SmolTest\Failure;
use Mateusjatenee\SmolTest\Test\ExceptionDetails;
use Mateusjatenee\SmolTest\Test\TestClass;
use Mateusjatenee\SmolTest\Test\TestDuration;
use Mateusjatenee\SmolTest\Test\TestMethod;
use Mateusjatenee\SmolTest\Test\TestRun;
use Throwable;

class RunSingleTest
{
    public function __construct()
    {
    }

    public function handle(TestClass $class, TestMethod $method, Printer $printer): TestRun
    {
        $start = microtime(true);

        try {
            $method->invoke($class->newReflectionClass());
        } catch (AssertionFailedException $exception) {
            $failure = new Failure(
                $class, $method, ExceptionDetails::fromException($exception)
            );
        } catch (Throwable $exception) {
            $failure = new Failure(
                $class, $method, ExceptionDetails::fromException($exception)
            );
        }

        $duration = TestDuration::fromStart($start);

        return new TestRun(
            $class,
            $method,
            $duration,
            $failure ?? null
        );
    }
}
