<?php

declare(strict_types=1);

namespace AdventOfCode\Day13;

use loophp\collection\Contract\Operation\Sortable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Answer2 extends Command
{
    protected static $defaultName = 'day13:2';

    protected static $defaultDescription = 'Day 13 - Answer 2';

    public function __construct(
        private readonly InputLoader $inputLoader,
        private readonly Compare $compare,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $decoderKey = $this->inputLoader->load()
            ->flatten(1)
            ->merge([[[2]], [[6]]])
            ->sort(Sortable::BY_VALUES, fn (int|array $left, int|array $right): int => -($this->compare)($left, $right))
            ->normalize()
            ->filter(static fn (array $input): bool => [[2]] === $input || [[6]] === $input)
            ->reduce(static fn (int $carry, array $item, int $key): int => $carry * ($key + 1), 1)
        ;

        $output->writeln(sprintf(
            'The decoder key is <options=bold,underscore>%d</>',
            $decoderKey,
        ));

        return Command::SUCCESS;
    }
}
