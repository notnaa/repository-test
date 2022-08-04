<?php

declare(strict_types=1);

namespace App\Infrastructure\Serializer;

use DateTime;
use App\Domain\Entity\User\User;
use App\Domain\Entity\User\UserInterface;
use App\Domain\Serializer\UserSerializerInterface;

class UserSerializer implements UserSerializerInterface
{
    private const DATETIME_FORMAT = 'Y-m-d H:i:s';

    /**
     * @inheritDoc
     */
    public function serialize(UserInterface $user): array
    {
        $deleted = null !== $user->getDeletedAt() ? $user->getDeletedAt()->format(self::DATETIME_FORMAT) : null;
        return [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'created' => $user->getCreatedAt()->format(self::DATETIME_FORMAT),
            'deleted' => $deleted,
            'notes' => $user->getNotes(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function unserialize(array $data): UserInterface
    {
        $updated = $data['deleted'] ?? null;
        return new User(
            trim($data['name']),
            trim($data['email']),
            new DateTime($data['created']),
            null !== $updated ? new DateTime($updated) : null,
            null !== $data['notes'] ? trim($data['notes']) : null,
            null !== $data['id'] ? intval($data['id']) : null,
        );
    }
}
