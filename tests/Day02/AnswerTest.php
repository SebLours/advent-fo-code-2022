<?php

declare(strict_types=1);

namespace AdventOfCode\Tests\Day02;

use AdventOfCode\Tests\ApplicationTest;

final class AnswerTest extends ApplicationTest
{
    public function test_answer_1(): void
    {
        $this->applicationTester->run(['command' => 'day02:1']);

        $this->assertSame(
            'The total score is 13005',
            trim($this->applicationTester->getDisplay())
        );
    }

    public function test_answer_2(): void
    {
        $this->applicationTester->run(['command' => 'day02:2']);

        $this->assertSame(
            'The total score is 11373',
            trim($this->applicationTester->getDisplay())
        );
    }
}
