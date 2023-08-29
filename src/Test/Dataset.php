<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Test;

use Generator;

class Dataset
{
    public function __construct(
        public array|Generator $dataset
    ) {
    }

    public function asArray(): array
    {
        if ($this->dataset instanceof Generator) {
            return iterator_to_array($this->dataset);
        }

        return $this->dataset;
    }
}
