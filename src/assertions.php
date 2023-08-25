<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest;

function eq(mixed $actual, mixed $expected): void
{
    if ($actual !== $expected) {
        throw new AssertionFailedException("Received value [{$actual}] is not equal to expected value [{$expected}]");
    }
}
