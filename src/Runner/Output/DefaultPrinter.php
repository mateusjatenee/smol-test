<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Runner\Output;

use Mateusjatenee\SmolTest\Runner\FailedTestsCollection;
use Mateusjatenee\SmolTest\Runner\Failure;
use Mateusjatenee\SmolTest\Test\TestClass;
use Mateusjatenee\SmolTest\Test\TestRun;
use function Termwind\render;

class DefaultPrinter implements Printer
{
    public function success(TestRun $testRun): void
    {
        render("
                 <div>
                    <div class=\"px-1 text-green-600\">✓</div>
                    <span class=\"ml-1\">{$testRun->readableMethodName()}</span>
                    <span class='ml-1'><b>{$testRun->duration->miliseconds()}ms</b></span>
                </div>
        ");
    }

    public function failure(TestRun $testRun, Failure $failure): void
    {
        render("
                 <div>
                    <div class=\"px-1 text-red-600\">⨯</div>
                    <em class=\"ml-1\">{$testRun->readableMethodName()}</em>
                    <span class='ml-1'><b>{$testRun->duration->miliseconds()}ms</b></span>
                </div>
        ");
    }

    public function class(TestClass $class)
    {
        render("
            <div class='mt-1'>
                <div class='bg-teal-600 px-1'>Test</div>
                <b class='ml-1'>{$class->name()}</b>
            </div>
        ");
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
            $trace = str($failure->exceptionDetails->trace)
                ->replace("\n", '<br>')
                ->toString();

            $failureStrings[] = "
                    <hr class='text-red-500'>
                    <div>
                        <div class='bg-red-500 px-1'>FAILED</div>
                        <b class='px-1'>{$failure->testClass->name()}</b>
                        <span class='px-1'>></span>
                        <span>{$failure->testMethod->nameForHumans()}</span>
                        <div>
                            <span class=\"px-1 bg-red-700\">{$failure->exceptionDetails->className} {$failure->exceptionDetails->message}</span>
                        </div>
                        <div>
                            {$trace}
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
