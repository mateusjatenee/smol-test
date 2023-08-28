<?php declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Tests\Tagging;

use Mateusjatenee\SmolTest\Tagging\Test;
use Mateusjatenee\SmolTest\Tagging\Testable;
use Mateusjatenee\SmolTest\Tagging\TestClassFinder;
use Mateusjatenee\SmolTest\Test\TestClass;
use function Mateusjatenee\SmolTest\eq;

class TestClassFinderTest
{
    #[Test]
    public function it_finds_classes_that_implement_testable(): void
    {
        $class = new class implements Testable {
        };

        $foundClasses = TestClassFinder::fromArray([
            get_class($class),
        ]);

        eq(1, count($foundClasses));
        eq(true, $foundClasses[0] instanceof TestClass);
    }

    #[Test]
    public function it_finds_classes_that_have_the_test_suffix(): void
    {
        $foundClasses = TestClassFinder::fromArray([EndsInTest::class]);

        eq(1, count($foundClasses));
        eq(true, $foundClasses[0] instanceof TestClass);
    }

    #[Test]
    public function it_does_not_find_classes_that_do_not_end_in_test(): void
    {
        $foundClasses = TestClassFinder::fromArray([WrongName::class]);

        eq(0, count($foundClasses));
    }
}

class EndsInTest
{}

class WrongName
{}