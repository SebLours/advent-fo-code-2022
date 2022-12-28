<?php

declare(strict_types=1);

namespace AdventOfCode\Day13;

final class Compare
{
    public function __invoke(int|array $left, int|array $right): int
    {
        if (is_int($left) && is_int($right)) {
            return $right <=> $left;
        }

        if (is_array($left) && is_array($right)) {
            return $this->compareTwoArrays($left, $right);
        }

        return $this((array) $left, (array) $right);
    }

    private function compareTwoArrays(array $left, array $right): int
    {
        if ($left !== [] && $right === []) {
            return -1;
        }

        if ($left === [] && $right !== []) {
            return 1;
        }

        if (count($left) < count($right)) {
            $left = array_pad($left, count($right), null);
        }

        if (count($right) < count($left)) {
            $right = array_pad($right, count($left), null);
        }

        foreach ($left as $key => $value) {
            if (null === $value) {
                return 1;
            }

            if (null === $right[$key]) {
                return -1;
            }

            if (($result = $this($value, $right[$key])) !== 0) {
                return $result;
            }
        }

        return 0;
    }
}
