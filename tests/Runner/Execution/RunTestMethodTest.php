<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Tests\Runner\Execution;

use Generator;
use Mateusjatenee\SmolTest\Runner\Execution\RunSingleTest;
use Mateusjatenee\SmolTest\Runner\Execution\RunTestMethod;
use Mateusjatenee\SmolTest\Runner\FailedTestsCollection;
use Mateusjatenee\SmolTest\Runner\Output\DefaultPrinter;
use Mateusjatenee\SmolTest\Tagging\Test;
use Mateusjatenee\SmolTest\Test\DataProvider;
use Mateusjatenee\SmolTest\Test\TestClass;
use Mateusjatenee\SmolTest\Test\TestDuration;
use Mateusjatenee\SmolTest\Test\TestMethod;
use Mateusjatenee\SmolTest\Test\TestRun;
use ReflectionClass;

class RunTestMethodTest
{
    #[Test]
    public function it_uses_data_providers(): void
    {
        $testClass = new TestClass(new ReflectionClass(ClassToBeTested::class));

        /** @var TestMethod $testMethod */
        $testMethod = $testClass->methods()[0];

        $runSingleTest = \Mockery::mock(RunSingleTest::class);
        $runSingleTest->expects('handle')->times(2)->andReturn(new TestRun(
            $testClass,
            $testMethod,
            new TestDuration(0.0),
            null
        ));

        $runTestMethod = new RunTestMethod(
            new DefaultPrinter(),
            new FailedTestsCollection(),
            $runSingleTest
        );

        $runTestMethod->handle($testClass, $testMethod);
    }

    #[Test]
    public function it_uses_generator_based_data_providers(): void
    {
        $testClass = new TestClass(new ReflectionClass(ClassToBeTestedWithGenerators::class));

        /** @var TestMethod $testMethod */
        $testMethod = $testClass->methods()[0];

        $runSingleTest = \Mockery::mock(RunSingleTest::class);
        $runSingleTest->expects('handle')->times(2)->andReturn(new TestRun(
            $testClass,
            $testMethod,
            new TestDuration(0.0),
            null
        ));

        $runTestMethod = new RunTestMethod(
            new DefaultPrinter(),
            new FailedTestsCollection(),
            $runSingleTest
        );

        $runTestMethod->handle($testClass, $testMethod);
    }

    public function afterEach(): void
    {
        \Mockery::close();
    }
}

class ClassToBeTested
{
    #[\Mateusjatenee\SmolTest\Tagging\DataProvider('provider')]
    public function test_something(int $a): void
    {

    }

    public static function provider(): array
    {
        return [
            'test' => [1],
            'another' => [2],
        ];
    }
}

class ClassToBeTestedWithGenerators
{
    #[\Mateusjatenee\SmolTest\Tagging\DataProvider('provider')]
    public function test_something(int $a): void
    {

    }

    public static function provider(): Generator
    {
        yield 'something' => [
            1,
        ];

        yield 'something else' => [
            2,
        ];
    }
}
