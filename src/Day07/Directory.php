<?php

declare(strict_types=1);

namespace AdventOfCode\Day07;

use SplObjectStorage;

final class Directory
{
    private ?self $parent = null;

    private SplObjectStorage $directories;

    private SplObjectStorage $files;

    public function __construct(
        public readonly string $name,
    ) {
        $this->directories = new SplObjectStorage();
        $this->files = new SplObjectStorage();
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): void
    {
        $this->parent = $parent;
    }

    public function getDirectories(): SplObjectStorage
    {
        return $this->directories;
    }

    public function getFiles(): SplObjectStorage
    {
        return $this->files;
    }

    public function addFile(File $file): void
    {
        if (!$this->files->contains($file)) {
            $this->files->attach($file);
        }
    }

    public function addDirectory(self $directory): void
    {
        if (!$this->directories->contains($directory)) {
            $directory->setParent($this);
            $this->directories->attach($directory);
        }
    }

    public function getSize(): int
    {
        $size = array_reduce(iterator_to_array($this->files), fn (int $size, File $file): int => $size + $file->size, 0);

        return array_reduce(iterator_to_array($this->directories), fn (int $size, Directory $directory): int => $size + $directory->getSize(), $size);
    }

    public function getDirectoriesTotalSizeWithAtMost(int $limit): int
    {
        $directories = array_filter(
            iterator_to_array($this->directories),
            fn (Directory $directory): bool => $directory->getSize() < $limit,
        );

        $size = array_reduce(
            $directories,
            fn (int $size, Directory $directory): int => $size + $directory->getSize(),
            0,
        );

        foreach ($this->directories as $directory) {
            $size += $directory->getDirectoriesTotalSizeWithAtMost($limit);
        }

        return $size;
    }

    public function getAllDirectories(): array
    {
        $directories = iterator_to_array($this->directories);

        foreach ($this->directories as $directory) {
            $directories = array_merge($directories, $directory->getAllDirectories());
        }

        return $directories;
    }
}
