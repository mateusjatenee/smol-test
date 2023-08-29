<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Runner\Execution;

use Mateusjatenee\SmolTest\Runner\Output\Printer;
use Mateusjatenee\SmolTest\Test\Dataset;

class RunTestFactory
{
    public static function make(Printer $printer, ?Dataset $dataset): RunsTests
    {
        if (! $dataset) {
            return new RunSingleTest($printer);
        }

        return new RunTestWithProviderData($printer, $dataset);
    }
}
