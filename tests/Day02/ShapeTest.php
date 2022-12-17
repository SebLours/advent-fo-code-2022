<?php

declare(strict_types=1);

namespace AdventOfCode\Tests\Day02;

use AdventOfCode\Day01\IncreasesMeasurementCalculator;
use AdventOfCode\Day02\RoundResult;
use AdventOfCode\Day02\Shape;
use loophp\collection\Collection;
use PHPUnit\Framework\TestCase;

final class ShapeTest extends TestCase
{
    public function test_fight(): void
    {
        $paper = Shape::Paper;
        $rock = Shape::Rock;
        $scissors = Shape::Scissors;

        $this->assertSame(RoundResult::Draw, $paper->fightWith($paper), 'paper vs paper must be tie');
        $this->assertSame(RoundResult::Draw, $rock->fightWith($rock), 'rock vs rock must be tie');
        $this->assertSame(RoundResult::Draw, $scissors->fightWith($scissors), 'scissors vs scissors must be tie');

        $this->assertSame(RoundResult::Win, $paper->fightWith($rock), 'paper must beat rock');
        $this->assertSame(RoundResult::Win, $rock->fightWith($scissors), 'rock must beat scissors');
        $this->assertSame(RoundResult::Win, $scissors->fightWith($paper), 'scissors must beat paper');

        $this->assertSame(RoundResult::Loose, $paper->fightWith($scissors), 'paper must be beaten by scissors');
        $this->assertSame(RoundResult::Loose, $rock->fightWith($paper), 'rock must be beaten by paper');
        $this->assertSame(RoundResult::Loose, $scissors->fightWith($rock), 'scissors must be beaten by rock');
    }

    public function test_score(): void
    {
        $rock = Shape::Rock;
        $paper = Shape::Paper;
        $scissors = Shape::Scissors;

        $this->assertSame(1, $rock->score(), 'rock must win one point');
        $this->assertSame(2, $paper->score(), 'paper must win two points');
        $this->assertSame(3, $scissors->score(), 'scissors must win three points');
    }

    public function test_opponent(): void
    {
        $rock = Shape::Rock;
        $paper = Shape::Paper;
        $scissors = Shape::Scissors;

        $this->assertSame($rock, $rock->opponent(RoundResult::Draw), 'rock must draw with rock');
        $this->assertSame($paper, $paper->opponent(RoundResult::Draw), 'paper must draw with paper');
        $this->assertSame($scissors, $scissors->opponent(RoundResult::Draw), 'scissors must draw with scissors');

        $this->assertSame($scissors, $rock->opponent(RoundResult::Win), 'rock must win against scissors');
        $this->assertSame($rock, $paper->opponent(RoundResult::Win), 'paper must win against rock');
        $this->assertSame($paper, $scissors->opponent(RoundResult::Win), 'scissors must win against paper');

        $this->assertSame($paper, $rock->opponent(RoundResult::Loose), 'rock must loose against paper');
        $this->assertSame($scissors, $paper->opponent(RoundResult::Loose), 'paper must loose against scissors');
        $this->assertSame($rock, $scissors->opponent(RoundResult::Loose), 'scissors must loose against rock');
    }
}
