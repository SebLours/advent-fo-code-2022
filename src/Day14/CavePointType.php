<?php

declare(strict_types=1);

namespace AdventOfCode\Day14;

enum CavePointType: string
{
    case Air = '.';
    case Goal = 'G';
    case Rock = '#';
    case Sand = 'o';
    case Source = '+';
}
