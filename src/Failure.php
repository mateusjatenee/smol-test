<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest;

readonly class Failure
{
    public function __construct(
        public string $className,
        public string $error,
        public string $file,
        public int $line
    ) {
    }
}
