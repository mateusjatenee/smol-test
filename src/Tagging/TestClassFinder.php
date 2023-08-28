<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Tagging;

use Mateusjatenee\SmolTest\Test\TestClass;
use ReflectionClass;

class TestClassFinder
{
    /**
     * @return TestClass[]
     *
     * @throws \ReflectionException
     */
    public static function fromArray(array $classes): array
    {
        $testClasses = [];

        foreach ($classes as $class) {
            $reflection = new ReflectionClass($class);

            if (
                ! $reflection->implementsInterface(Testable::class) &&
                ! str_ends_with($class, 'Test')
            ) {
                continue;
            }

            $testClasses[] = new TestClass($reflection);
        }

        return $testClasses;
    }
}
