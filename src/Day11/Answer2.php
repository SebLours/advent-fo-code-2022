<?php

declare(strict_types=1);

namespace AdventOfCode\Day11;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Answer2 extends Command
{
    protected static $defaultName = 'day11:2';

    protected static $defaultDescription = 'Day 11 - Answer 2';

    public function __construct(
        private readonly MonkeySquadPart2Loader $monkeySquadLoader,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $monkeySquad = $this->monkeySquadLoader->load();

        for ($i = 0; $i < 10000; ++$i) {
            $monkeySquad->handleRound(false);
        }

        $output->writeln(sprintf(
            'After 20 rounds, the monkey business level is <options=bold,underscore>%d</>',
            $monkeySquad->getBusinessLevel(),
        ));

        return Command::SUCCESS;
    }
}
