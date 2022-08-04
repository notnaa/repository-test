<?php

declare(strict_types=1);

namespace App\Application\User;

class ChangelogOperation
{
    private const ADD = "Add user";
    private const UPDATE = "Update user";

    /**
     * @var string
     */
    private string $operation;

    /**
     * @param string $operation
     */
    private function __construct(string $operation)
    {
        $this->operation = $operation;
    }

    /**
     * @return self
     */
    public static function add(): self
    {
        return new self(self::ADD);
    }

    /**
     * @return self
     */
    public static function update(): self
    {
        return new self(self::UPDATE);
    }

    /**
     * @return string
     */
    public function getOperation(): string
    {
        return $this->operation;
    }
}
