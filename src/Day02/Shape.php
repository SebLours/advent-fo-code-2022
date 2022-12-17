<?php

declare(strict_types=1);

namespace AdventOfCode\Day02;

enum Shape
{
    case Rock;
    case Paper;
    case Scissors;

    public function fightWith(self $opponent): RoundResult
    {
        return match ($this) {
            self::Rock => match ($opponent) {
                self::Rock => RoundResult::Draw,
                self::Paper => RoundResult::Loose,
                self::Scissors => RoundResult::Win,
            },
            self::Paper => match ($opponent) {
                self::Rock => RoundResult::Win,
                self::Paper => RoundResult::Draw,
                self::Scissors => RoundResult::Loose,
            },
            self::Scissors => match ($opponent) {
                self::Rock => RoundResult::Loose,
                self::Paper => RoundResult::Win,
                self::Scissors => RoundResult::Draw,
            },
        };
    }

    public function opponent(RoundResult $result): self
    {
        return match ($this) {
            self::Rock => match ($result) {
                RoundResult::Draw => self::Rock,
                RoundResult::Win => self::Scissors,
                RoundResult::Loose => self::Paper,
            },
            self::Paper => match ($result) {
                RoundResult::Draw => self::Paper,
                RoundResult::Win => self::Rock,
                RoundResult::Loose => self::Scissors,
            },
            self::Scissors => match ($result) {
                RoundResult::Draw => self::Scissors,
                RoundResult::Win => self::Paper,
                RoundResult::Loose => self::Rock,
            },
        };
    }

    public function score(): int
    {
        return match ($this) {
            self::Rock => 1,
            self::Paper => 2,
            self::Scissors => 3,
        };
    }
}
