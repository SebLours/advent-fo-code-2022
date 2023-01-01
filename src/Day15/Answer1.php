<?php

declare(strict_types=1);

namespace AdventOfCode\Day15;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Answer1 extends Command
{
    protected static $defaultName = 'day15:1';

    protected static $defaultDescription = 'Day 15 - Answer 1';

    public function __construct(
        private readonly SensorBeaconPackLoader $sensorBeaconPackLoader,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $sensorBeaconPacks = $this->sensorBeaconPackLoader->load();

        $y = 2000000;

        $result = $sensorBeaconPacks
            ->reduce(static function (array $line, SensorBeaconPack $sensorBeaconPack) use ($y): array {
                $yRange = abs($sensorBeaconPack->sensor->y - $y);
                $xMin = $sensorBeaconPack->sensor->x - ($sensorBeaconPack->distance - $yRange);
                $xMax = $sensorBeaconPack->sensor->x + ($sensorBeaconPack->distance - $yRange);

                for ($x = $xMin; $x <= $xMax; ++$x) {
                    $line['explored'][$x] = true;

                    if ($sensorBeaconPack->beacon->x === $x && $sensorBeaconPack->beacon->y === $y) {
                        $line['beacon'][$x] = true;
                    }
                }

                return $line;
            }, [])
        ;

        $output->writeln(sprintf(
            'The are <options=bold,underscore>%d</> positions cannot contain a beacon',
            count($result['explored']) - count($result['beacon']),
        ));

        return Command::SUCCESS;
    }
}
