<?php

declare(strict_types=1);

namespace Tests\Unit\User;

use App\Domain\Entity\User\User;
use App\Infrastructure\Serializer\UserSerializer;
use DateTime;
use Tests\BaseTestCase;

class UserSerializerTest extends BaseTestCase
{
    private const DATETIME_FORMAT = 'Y-m-d H:i:s';

    public function testSerialize()
    {
        $user = new User(
            'name',
            'name@gmail.com',
            new DateTime(),
            null,
            null,
            1,
        );
        $deleted = null !== $user->getDeletedAt() ? $user->getDeletedAt()->format(self::DATETIME_FORMAT) : null;
        $expected = [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'created' => $user->getCreatedAt()->format(self::DATETIME_FORMAT),
            'deleted' => $deleted,
            'notes' => $user->getNotes(),
        ];
        $serializer = new UserSerializer();
        $result = $serializer->serialize($user);
        $this->assertEquals($expected, $result);
    }

    public function testUnserialize()
    {
        $expected = new User(
            'name',
            'name@gmail.com',
            new DateTime(),
            null,
            null,
            1,
        );
        $deleted = null !== $expected->getDeletedAt() ? $expected->getDeletedAt()->format(self::DATETIME_FORMAT) : null;
        $actual = [
            'id' => $expected->getId(),
            'name' => $expected->getName(),
            'email' => $expected->getEmail(),
            'created' => $expected->getCreatedAt()->format(self::DATETIME_FORMAT),
            'deleted' => $deleted,
            'notes' => $expected->getNotes(),
        ];
        $serializer = new UserSerializer();
        $result = $serializer->unserialize($actual);
        $this->assertEquals($expected->getId(), $result->getId());
        $this->assertEquals($expected->getName(), $result->getName());
        $this->assertEquals($expected->getEmail(), $result->getEmail());
        $this->assertEquals($expected->getCreatedAt()->getTimestamp(), $result->getCreatedAt()->getTimestamp());
        $this->assertEquals(
            null !== $expected->getDeletedAt() ? $expected->getDeletedAt()->getTimestamp() : null,
            null !== $result->getDeletedAt() ? $result->getDeletedAt()->getTimestamp() : null,
        );
        $this->assertEquals($expected->getNotes(), $result->getNotes());
    }
}
