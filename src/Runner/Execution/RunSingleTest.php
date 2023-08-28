<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Runner\Execution;

use Mateusjatenee\SmolTest\AssertionFailedException;
use Mateusjatenee\SmolTest\Runner\Failure;
use Mateusjatenee\SmolTest\Runner\Output\Printer;
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

    public function handle(TestClass $class, TestMethod $method): TestRun
    {
        $start = microtime(true);

        $instance = $class->newReflectionClass();

        if (method_exists($instance, 'beforeEach')) {
            $instance->beforeEach();
        }

        try {
            $method->invoke($instance);
        } catch (AssertionFailedException $exception) {
            $failure = new Failure(
                $class, $method, ExceptionDetails::fromException($exception)
            );
        } catch (Throwable $exception) {
            $failure = new Failure(
                $class, $method, ExceptionDetails::fromException($exception)
            );
        }

        $duration = TestDuration::sinceStart($start);

        if (method_exists($instance, 'afterEach')) {
            $instance->afterEach();
        }

        return new TestRun(
            $class,
            $method,
            $duration,
            $failure ?? null
        );
    }
}
