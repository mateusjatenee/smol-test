<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Test;

use ReflectionMethod;

/** @mixin ReflectionMethod */
class TestMethod
{
    public function __construct(
        public ReflectionMethod $method,
        public array $arguments = []
    ) {
    }

    public function __call(string $name, array $arguments)
    {
        return $this->method->$name(...$arguments);
    }

    public function nameForHumans(): string
    {
        return str($this->method->getName())
            ->replace('test', '')
            ->replace('_', ' ')
            ->trim()
            ->ucfirst()
            ->__toString();
    }
}
