<?php

declare(strict_types=1);

namespace Tests\Unit\User\Rules;

use App\Domain\Entity\User\User;
use App\Infrastructure\Validator\User\Rules\UserDeletedAtRule;
use App\Infrastructure\Validator\User\Rules\UserNameBlackWordsRule;
use DateInterval;
use DateTime;
use Tests\BaseTestCase;

/**
 * @group user
 * @group validator
 */
class UserDeletedAtRuleTest extends BaseTestCase
{
    public function testValidateSuccess1()
    {
        $user = new User(
            'name',
            'name@gmail.com',
            new DateTime(),
            null,
            null,
            1,
        );
        $rule = new UserDeletedAtRule();
        $result = $rule->validate($user);
        $this->assertTrue($result);
    }

    public function testValidateSuccess2()
    {
        $time = new DateTime();
        $user = new User(
            'name',
            'name@gmail.com',
            $time,
            $time,
            null,
            1,
        );
        $rule = new UserDeletedAtRule();
        $result = $rule->validate($user);
        $this->assertTrue($result);
    }

    public function testValidateSuccess3()
    {
        $time = new DateTime();
        $user = new User(
            'name',
            'name@gmail.com',
            $time->sub(new DateInterval('PT1H')),
            $time,
            null,
            1,
        );
        $rule = new UserDeletedAtRule();
        $result = $rule->validate($user);
        $this->assertTrue($result);
    }

    public function testValidateError()
    {
        $time = new DateTime();
        $user = new User(
            'black_word1',
            'name@gmail.com',
            $time,
            $time->sub(new DateInterval('PT1H')),
            null,
            1,
        );
        $rule = new UserNameBlackWordsRule();
        $result = $rule->validate($user);
        $this->assertFalse($result);
    }
}
