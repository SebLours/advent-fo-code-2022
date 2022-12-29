<?php

declare(strict_types=1);

namespace AdventOfCode\Tests\Day14;

use AdventOfCode\Tests\ApplicationTest;

final class AnswerTest extends ApplicationTest
{
    public function test_answer_1(): void
    {
        $this->applicationTester->run(['command' => 'day14:1']);

        $this->assertSame(
            'The are 828 units of sand come to rest before sand starts flowing into the abyss',
            trim($this->applicationTester->getDisplay())
        );
    }

    public function test_answer_2(): void
    {
        $this->applicationTester->run(['command' => 'day14:2']);

        $this->assertSame(
            'The are 25500 units of sand come to rest before the source of the sand becomes blocked',
            trim($this->applicationTester->getDisplay())
        );
    }
}
