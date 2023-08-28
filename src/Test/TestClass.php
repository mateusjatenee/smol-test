<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Test;

use Mateusjatenee\SmolTest\Tagging\Test;
use ReflectionClass;
use ReflectionMethod;

class TestClass
{
    public function __construct(
        public ReflectionClass $reflectionClass
    ) {
    }

    public function newReflectionClass()
    {
        return $this->reflectionClass->newInstance();
    }

    public function methods(): array
    {
        $methods = array_filter(
            $this->reflectionClass->getMethods(),
            static function (ReflectionMethod $method) {
                return count($method->getAttributes(Test::class)) > 0
                    || str_starts_with($method->getName(), 'test');
            });

        return array_map(
            static fn (ReflectionMethod $method) => new TestMethod($method),
            $methods
        );
    }

    public function name(): string
    {
        return $this->reflectionClass->getName();
    }
}
