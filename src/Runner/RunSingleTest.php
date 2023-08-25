<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Runner;

use Mateusjatenee\SmolTest\AssertionFailedException;
use Mateusjatenee\SmolTest\Failure;

class RunSingleTest
{
    public function __construct()
    {
    }

    public function handle(string $testClass, \ReflectionMethod $method, Printer $printer): TestRun
    {
        $start = microtime(true);

        try {
            $method->invoke(new $testClass);
        } catch (AssertionFailedException $exception) {
            $failure = new Failure($testClass, $exception->getMessage(), $exception->getFile(),
                $exception->getLine());
        }

        $timeInMiliseconds = number_format(ceil((microtime(true) - $start) * 1000));

        return new TestRun(
            $testClass,
            $method->getName(),
            (int) $timeInMiliseconds,
            $failure ?? null
        );
    }
}
