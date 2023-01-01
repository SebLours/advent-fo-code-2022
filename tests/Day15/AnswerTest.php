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
}
