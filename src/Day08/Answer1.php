<?php

declare(strict_types=1);

namespace AdventOfCode\Day08;

use loophp\collection\Collection;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Answer1 extends Command
{
    protected static $defaultName = 'day08:1';

    protected static $defaultDescription = 'Day 8 - Answer 1';

    public function __construct(
        private readonly FileLocator $dataFileLocator,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $collection = Collection::fromString(file_get_contents($this->dataFileLocator->locate('day08/input.txt')))
            ->explode(\PHP_EOL)
        ;

        $grid = $collection->all();

        $visible = count($grid) * 4 - 4;

        for ($y = 1; $y < count($grid) - 1; ++$y) {
            for ($x = 1; $x < count($grid) - 1; ++$x) {
                if ($this->isTreeVisible($this->getTreeLines($grid, $x, $y), (int) $grid[$y][$x])) {
                    ++$visible;
                }
            }
        }

        $output->writeln(sprintf(
            'The are <options=bold,underscore>%d</> trees visible',
            $visible,
        ));

        return Command::SUCCESS;
    }

    private function getTreeLines(array $grid, int $x, int $y): array
    {
        $up = $down = [];

        for ($i = 0; $i < count($grid); ++$i) {
            if ($i === $y) {
                continue;
            }

            if ($i < $y) {
                $up[] = (int) $grid[$i][$x];
            } else {
                $down[] = (int) $grid[$i][$x];
            }
        }

        $left = $right = [];

        for ($i = 0; $i < count($grid); ++$i) {
            if ($i === $x) {
                continue;
            }

            if ($i < $x) {
                $left[] = (int) $grid[$y][$i];
            } else {
                $right[] = (int) $grid[$y][$i];
            }
        }

        return compact('up', 'down', 'left', 'right');
    }

    private function isTreeVisible(array $lines, int $tree): bool
    {
        return
            $tree > max($lines['up']) ||
            $tree > max($lines['down']) ||
            $tree > max($lines['left']) ||
            $tree > max($lines['right'])
        ;
    }
}
