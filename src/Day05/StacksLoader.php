<?php

declare(strict_types=1);

namespace AdventOfCode\Day05;

use loophp\collection\Collection;

final class StacksLoader
{
    public static function load(iterable $input): Collection
    {
        return Collection::fromIterable($input)
            ->map(static function (string $value): array {
                return Collection::fromString($value)
                    ->chunk(4)
                    ->map(static fn (array $value): string => trim((string) ($value[1] ?? '')))
                    ->map(static fn (string $value): ?string => '' === $value ? null : $value)
                    ->all()
                ;
            })
            ->slice(0, 8)
            ->transpose()
            ->map(static fn (array $value): Collection => Collection::fromIterable($value)->compact()->reverse())
            ->map(static fn (Collection $value): Stack => new Stack($value))
        ;
    }
}
