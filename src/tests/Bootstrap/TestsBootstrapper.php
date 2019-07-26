<?php

declare(strict_types = 1);

namespace Tests\Bootstrap;

use AvtoDev\DevTools\Tests\PHPUnit\Traits\CreatesApplicationTrait;
use AvtoDev\DevTools\Tests\Bootstrap\AbstractLaravelTestsBootstrapper;

class TestsBootstrapper extends AbstractLaravelTestsBootstrapper
{
    use CreatesApplicationTrait;

}
