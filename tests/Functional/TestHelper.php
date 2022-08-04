<?php

declare(strict_types=1);

namespace Tests\Functional;

use Spiral\Database\DatabaseProviderInterface;

class TestHelper
{
    /**
     * @param DatabaseProviderInterface $db
     */
    public static function truncateUserTable(DatabaseProviderInterface $db): void
    {
        $db->database()->execute('TRUNCATE TABLE users;');
    }
}
