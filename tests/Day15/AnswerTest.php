<?php

declare(strict_types=1);

namespace AdventOfCode\Tests\Day15;

use AdventOfCode\Tests\ApplicationTest;

final class AnswerTest extends ApplicationTest
{
    public function test_answer_1(): void
    {
        $this->applicationTester->run(['command' => 'day15:1']);

        $this->assertSame(
            'The are 4873353 positions cannot contain a beacon',
            trim($this->applicationTester->getDisplay())
        );
    }

    public function test_answer_2(): void
    {
        $this->applicationTester->run(['command' => 'day15:2']);

        $this->assertSame(
            'The tuning frequency is 11600823139120',
            trim($this->applicationTester->getDisplay())
        );
    }
}
