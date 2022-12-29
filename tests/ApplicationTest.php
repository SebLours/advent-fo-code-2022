<?php

declare(strict_types=1);

namespace AdventOfCode\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\ApplicationTester;

class ApplicationTest extends TestCase
{
    protected ApplicationTester $applicationTester;

    protected function setUp(): void
    {
        $container = require dirname(__DIR__) . '/config/bootstrap.php';

        /** @var Application $application */
        $application = $container->get('application');
        $application->setAutoExit(false);

        $this->applicationTester = new ApplicationTester($application);
    }
}
