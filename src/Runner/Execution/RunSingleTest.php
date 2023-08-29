<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Runner\Execution;

use Mateusjatenee\SmolTest\AssertionFailedException;
use Mateusjatenee\SmolTest\Event\Bus;
use Mateusjatenee\SmolTest\Event\TestFailed;
use Mateusjatenee\SmolTest\Event\TestFinished;
use Mateusjatenee\SmolTest\Runner\Failure;
use Mateusjatenee\SmolTest\Test\ExceptionDetails;
use Mateusjatenee\SmolTest\Test\TestClass;
use Mateusjatenee\SmolTest\Test\TestDuration;
use Mateusjatenee\SmolTest\Test\TestMethod;
use Mateusjatenee\SmolTest\Test\TestRun;
use Throwable;

class RunSingleTest implements RunsTests
{
    public function handle(TestClass $testClass, TestMethod $testMethod): TestRun
    {
        $start = microtime(true);

        $instance = $testClass->newReflectionClass();

        if (method_exists($instance, 'beforeEach')) {
            $instance->beforeEach();
        }

        try {
            $testMethod->invoke($instance, ...$testMethod->arguments);
        } catch (AssertionFailedException $exception) {
            $failure = new Failure(
                $testClass, $testMethod, ExceptionDetails::fromException($exception)
            );
            Bus::dispatch(new TestFailed($failure));
        } catch (Throwable $exception) {
            $failure = new Failure(
                $testClass, $testMethod, ExceptionDetails::fromException($exception)
            );

            Bus::dispatch(new TestFailed($failure));
        }

        $duration = TestDuration::sinceStart($start);

        if (method_exists($instance, 'afterEach')) {
            $instance->afterEach();
        }

        $testRun = new TestRun(
            $testClass,
            $testMethod,
            $duration,
            $failure ?? null
        );

        Bus::dispatch(new TestFinished($testRun));

        return $testRun;
    }
}
