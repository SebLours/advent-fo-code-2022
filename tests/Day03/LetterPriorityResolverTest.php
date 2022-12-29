<?php

declare(strict_types=1);

namespace AdventOfCode\Tests\Day03;

use AdventOfCode\Day03\LetterPriorityResolver;
use PHPUnit\Framework\TestCase;

final class LetterPriorityResolverTest extends TestCase
{
    public function test_priority(): void
    {
        $resolver = new LetterPriorityResolver();

        $this->assertSame(16, $resolver->priority('p'));
        $this->assertSame(38, $resolver->priority('L'));
        $this->assertSame(42, $resolver->priority('P'));
        $this->assertSame(22, $resolver->priority('v'));
        $this->assertSame(20, $resolver->priority('t'));
        $this->assertSame(19, $resolver->priority('s'));
    }
}
