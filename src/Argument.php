<?php declare(strict_types=1);

namespace Mateusjatenee\SmolTest;

readonly class Argument
{
    public function __construct(
        public string $name,
        public string $value
    )
    {
    }

    /** @return Argument[] */
    public static function create(array $argv): array
    {
        unset($argv[0]);

        return array_map(function ($argument) {
            [$name, $value] = explode('=', $argument);

            return new Argument($name, $value);
        }, $argv);
    }
}