<?php

declare(strict_types=1);

namespace Tests\Unit\User\Rules;

use App\Domain\Entity\User\User;
use App\Infrastructure\Validator\User\Rules\UserNameBlackWordsRule;
use DateTime;
use Tests\BaseTestCase;

/**
 * @group user
 * @group validator
 */
class UserNameBlackWordsRuleTest extends BaseTestCase
{
    public function testValidateSuccess()
    {
        $user = new User(
            'name',
            'name@gmail.com',
            new DateTime(),
            null,
            null,
            1,
        );
        $rule = new UserNameBlackWordsRule();
        $result = $rule->validate($user);
        $this->assertTrue($result);
    }

    public function testValidateError()
    {
        $user = new User(
            'black_word1',
            'name@gmail.com',
            new DateTime(),
            null,
            null,
            1,
        );
        $rule = new UserNameBlackWordsRule();
        $result = $rule->validate($user);
        $this->assertFalse($result);
    }
}
