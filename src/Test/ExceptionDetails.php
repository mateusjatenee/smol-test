<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Test;

use Throwable;

final readonly class ExceptionDetails
{
    public function __construct(
        public string $className,
        public string $message,
        public string $file,
        public int $line,
        public string $trace
    ) {
    }

    public static function fromException(Throwable $exception): self
    {
        return new self(
            get_class($exception),
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine(),
            $exception->getTraceAsString()
        );
    }
}
