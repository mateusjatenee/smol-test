<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Runner;

use Mateusjatenee\SmolTest\Failure;
use Mateusjatenee\SmolTest\Test\TestRun;
use function Termwind\render;

class DefaultPrinter implements Printer
{
    public function success(TestRun $testRun): void
    {
        render("
                 <div>
                    <div class=\"px-1 bg-green-600\">Success</div>
                    <em class=\"ml-1\">{$testRun->readableMethodName()}</em>
                    <span class='ml-1'><b>{$testRun->duration->miliseconds()}ms</b></span>
                </div>
        ");
    }

    public function failure(TestRun $testRun, Failure $failure): void
    {
        render("
                 <div>
                    <div class=\"px-1 bg-red-600\">FAILURE</div>
                    <em class=\"ml-1\">{$testRun->readableMethodName()}</em>
                    <span class='ml-1'><b>{$testRun->duration->miliseconds()}ms</b></span>
                </div>
        ");
    }

    public function class(ClassDetails $class)
    {
        // TODO: Implement class() method.
    }

    public function testRun(TestRun $testRun): void
    {
        if ($testRun->succeeded()) {
            $this->success($testRun);

            return;
        }

        $this->failure($testRun, $testRun->failure);
    }

    public function showFailedTests(FailedTestsCollection $failedTests): void
    {
        $failureStrings = [];

        foreach ($failedTests->failures as $failure) {
            $failureStrings[] = "
                    <div>
                        <em class=\"px-1\">{$failure->testClass->name()}::{$failure->exceptionDetails->file}</em>
                        <div>
                            <span class=\"px-1 bg-red-600\">{$failure->exceptionDetails->message}</span>
                        </div>
                    </div>
            ";
        }

        $failureStrings = implode("\n", $failureStrings);

        render("
                 <div>
                    {$failureStrings}
                </div>
        ");
    }
}
