<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;

class BaseTestCase extends TestCase
{
    /**
     * @return array
     */
    protected function getSettings(): array
    {
        return include ROOT . 'tests/data/settings.php';
    }
}
