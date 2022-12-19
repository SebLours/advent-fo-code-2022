<?php

declare(strict_types=1);

namespace AdventOfCode\Day07;

final class Terminal
{
    private Directory $rootDirectory;

    private Directory $currentDirectory;

    public function __construct(iterable $history)
    {
        $this->rootDirectory = new Directory('/');
        $this->currentDirectory = $this->rootDirectory;

        foreach ($history as $line) {
            if (str_starts_with($line, '$ cd ')) {
                $this->changeDirectory(substr($line, 2));

                continue;
            }

            if (!str_starts_with($line, '$')) {
                $this->handleOutput($line);
            }
        }
    }

    public function getRootDirectory(): Directory
    {
        return $this->rootDirectory;
    }

    public function getCurrentDirectory(): Directory
    {
        return $this->currentDirectory;
    }

    private function changeDirectory(string $command): void
    {
        preg_match('/cd (.*)/', $command, $matches);

        $name = $matches[1];

        if ('/' === $name) {
            $this->currentDirectory = $this->rootDirectory;
        } elseif ('..' === $name) {
            $this->currentDirectory = $this->currentDirectory->getParent();
        } else {
            $this->currentDirectory->addDirectory($directory = new Directory($name));
            $this->currentDirectory = $directory;
        }
    }

    private function handleOutput(string $output): void
    {
        if (!preg_match('/(\d+) ([a-z.]+)/', $output, $matches)) {
            return;
        }

        $this->currentDirectory->addFile(new File($matches[2], (int) $matches[1]));
    }
}
