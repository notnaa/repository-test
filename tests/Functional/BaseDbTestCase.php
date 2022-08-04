<?php

declare(strict_types=1);

namespace Tests\Functional;

use Spiral\Database\Config\DatabaseConfig;
use Spiral\Database\DatabaseManager;
use Spiral\Database\DatabaseProviderInterface;
use Spiral\Database\Driver\MySQL\MySQLDriver;
use Tests\BaseTestCase;

class BaseDbTestCase extends BaseTestCase
{
    /**
     * @var DatabaseProviderInterface
     */
    protected DatabaseProviderInterface $db;

    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->db = $this->getDb();
    }

    /**
     * @return DatabaseProviderInterface
     */
    private function getDb(): DatabaseProviderInterface
    {
        $settings = $this->getSettings();
        return new DatabaseManager(
            new DatabaseConfig([
                'default' => 'wise',
                'databases' => [
                    'wise' => ['connection' => 'mysql'],
                ],
                'connections' => [
                    'mysql' => [
                        'driver'  => MySQLDriver::class,
                        'connection' => sprintf(
                            'mysql:host=%s;port=%s;dbname=%s',
                            $settings['db_host'],
                            $settings['db_port'],
                            $settings['db_name'],
                        ),
                        'username' => $settings['db_username'],
                        'password' => $settings['db_password'],
                        'reconnect' => false,
                        'profiling' => false,
                    ]
                ],
            ])
        );
    }
}
