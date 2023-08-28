<?php declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Tagging;

use Mateusjatenee\SmolTest\Test\TestClass;
use ReflectionClass;

class TestClassFinder
{
    /**
     * @param  array  $classes
     * @return TestClass[]
     * @throws \ReflectionException
     */
    public static function fromArray(array $classes): array
    {
        return array_map(function (string $class) {
            $reflection = new ReflectionClass($class);

            if (
                ! $reflection->implementsInterface(Testable::class) &&
                ! str_ends_with($class, 'Test')
            ) {
                return null;
            }

            return new TestClass($reflection);
        }, $classes);
    }
}