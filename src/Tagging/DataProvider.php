<?php declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Tagging;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class DataProvider
{
    public function __construct(
        public string $methodName
    )
    {
    }
}