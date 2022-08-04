<?php

declare(strict_types=1);

namespace Tests\Unit\User;

use App\Domain\Entity\User\User;
use App\Domain\Entity\User\UserInterface;
use App\Domain\Repository\UserRepositoryInterface;
use App\Infrastructure\Validator\User\UserValidator;
use DateInterval;
use DateTime;
use Tests\BaseTestCase;

class UserValidatorTest extends BaseTestCase
{
    /**
     * @dataProvider validateDataProvider
     *
     * @param UserInterface $user
     * @param bool $userByName
     * @param bool $userByEmail
     * @param array $expectedResult
     */
    public function testValidate(
        UserInterface $user,
        bool $userByName,
        bool $userByEmail,
        array $expectedResult
    ) {
        $repository = $this->createMock(UserRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getByName')
            ->with($user->getName())
            ->willReturn($userByName ? $user : null);
        $repository->expects($this->once())
            ->method('getByEmail')
            ->with($user->getEmail())
            ->willReturn($userByEmail ? $user : null);
        $validator = new UserValidator($repository);
        $result = $validator->validate($user);
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return array[]
     */
    public function validateDataProvider(): array
    {
        return [
            [
                new User(
                    'name',
                    'name@gmail.com',
                    new DateTime(),
                    null,
                    null,
                    1,
                ),
                false,
                false,
                [],
            ],
            [
                new User(
                    'black_word1',
                    'name@gmail.com',
                    new DateTime(),
                    null,
                    null,
                    1,
                ),
                false,
                false,
                ['UserNameBlackWordsRule' => 'UserNameBlackWordsRule must be valid'],
            ],
            [
                new User(
                    'name',
                    'name@fake-email.com',
                    new DateTime(),
                    null,
                    null,
                    1,
                ),
                false,
                false,
                ['UserEmailBlackDomainsRule' => 'UserEmailBlackDomainsRule must be valid'],
            ],
            [
                new User(
                    'name',
                    'name@gmail.com',
                    new DateTime(),
                    (new DateTime())->sub(new DateInterval('PT1H')),
                    null,
                    1,
                ),
                false,
                false,
                ['UserDeletedAtRule' => 'UserDeletedAtRule must be valid'],
            ],
            [
                new User(
                    'name',
                    'name@gmail.com',
                    new DateTime(),
                    null,
                    null,
                    1,
                ),
                true,
                false,
                ['UserNameUniqRule' => 'UserNameUniqRule must be valid'],
            ],
            [
                new User(
                    'name',
                    'name@gmail.com',
                    new DateTime(),
                    null,
                    null,
                    1,
                ),
                false,
                true,
                ['UserEmailUniqRule' => 'UserEmailUniqRule must be valid'],
            ],
            [
                new User(
                    'name',
                    'name@gmail.com',
                    new DateTime(),
                    null,
                    null,
                    1,
                ),
                true,
                true,
                [
                    'UserNameUniqRule' => 'UserNameUniqRule must be valid',
                    'UserEmailUniqRule' => 'UserEmailUniqRule must be valid',
                ],
            ],
        ];
    }
}
