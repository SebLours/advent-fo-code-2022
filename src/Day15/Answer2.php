<?php

declare(strict_types=1);

namespace AdventOfCode\Day15;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Answer2 extends Command
{
    protected static $defaultName = 'day15:2';

    protected static $defaultDescription = 'Day 15 - Answer 2';

    public function __construct(
        private readonly SensorBeaconPackLoader $sensorBeaconPackLoader,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var SensorBeaconPack[] $sensorBeaconPacks */
        $sensorBeaconPacks = $this->sensorBeaconPackLoader->load()->all();

        $maxCoordinate = 4000000;

        for ($y = 0; $y <= $maxCoordinate; ++$y) {
            $xRanges = [];
            foreach ($sensorBeaconPacks as $sensorBeaconPack) {
                $yRange = abs($sensorBeaconPack->sensor->y - $y);

                if ($yRange > $sensorBeaconPack->distance) {
                    continue;
                }

                $xRange = $sensorBeaconPack->distance - $yRange;
                $xMin = max(0, $sensorBeaconPack->sensor->x - $xRange);
                $xMax = min($maxCoordinate, $sensorBeaconPack->sensor->x + $xRange);

                $xRanges[] = [
                    'x-min' => $xMin,
                    'x-max' => $xMax,
                ];
            }

            usort($xRanges, static fn (array $xRangeA, array $xRangeB): int => $xRangeA['x-min'] <=> $xRangeB['x-min']);

            for ($i = 1; $i < count($xRanges); ++$i) {
                if ($xRanges[$i - 1]['x-max'] >= $xRanges[$i]['x-min']) {
                    $xRanges[$i - 1]['x-min'] = min($xRanges[$i - 1]['x-min'], $xRanges[$i]['x-min']);
                    $xRanges[$i - 1]['x-max'] = max($xRanges[$i - 1]['x-max'], $xRanges[$i]['x-max']);
                    array_splice($xRanges, $i, 1);
                    --$i;
                }
            }

            if (count($xRanges) > 1) {
                $output->writeln(sprintf(
                    'The tuning frequency is <options=bold,underscore>%d</>',
                    ($xRanges[0]['x-max'] + 1) * 4000000 + $y,
                ));

                return Command::SUCCESS;
            }
        }

        return Command::FAILURE;
    }
}
