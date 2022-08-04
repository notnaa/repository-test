<?php

declare(strict_types=1);

namespace App\Domain\Serializer;

use App\Domain\Entity\User\UserInterface;

interface UserSerializerInterface
{
    /**
     * @param UserInterface $user
     *
     * @return array
     */
    public function serialize(UserInterface $user): array;

    /**
     * @param array $data
     *
     * @return UserInterface
     */
    public function unserialize(array $data): UserInterface;
}
