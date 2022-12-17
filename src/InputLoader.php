<?php

declare(strict_types=1);

namespace AdventOfCode;

use Generator;
use loophp\collection\Collection;
use Symfony\Component\Config\FileLocator;

final class InputLoader
{
    public function __construct(
        private readonly FileLocator $dataFileLocator,
    ) {
    }

    /**
     * @return Collection<int, mixed>
     */
    public function load(string $input): Collection
    {
        /** @var string $inputDataFile */
        $inputDataFile = $this->dataFileLocator->locate($input);

        return Collection::fromGenerator((static function ($stream): Generator {
            while (($line = fgets($stream, 4096)) !== false) {
                yield trim($line);
            }
        })(fopen($inputDataFile, 'r')));
    }
}
