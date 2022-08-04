<?php

declare(strict_types=1);

namespace App\Infrastructure\Validator\User;

use App\Domain\Entity\User\UserInterface;
use App\Domain\Repository\UserRepositoryInterface;
use App\Infrastructure\Validator\User\Rules\UserDeletedAtRule;
use App\Infrastructure\Validator\User\Rules\UserEmailBlackDomainsRule;
use App\Infrastructure\Validator\User\Rules\UserEmailUniqRule;
use App\Infrastructure\Validator\User\Rules\UserNameBlackWordsRule;
use App\Infrastructure\Validator\User\Rules\UserNameUniqRule;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Factory;
use Respect\Validation\Validator;

class UserValidator
{
    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return Validator
     */
    protected function getValidator(): Validator
    {
        Factory::setDefaultInstance(
            (new Factory())->withRuleNamespace('App\\Infrastructure\\Validator\\User\\Rules')
        );
        $v = Validator::create()
            ->addRule(new UserNameUniqRule($this->userRepository))
            ->addRule(new UserEmailUniqRule($this->userRepository))
            ->addRule(new UserNameBlackWordsRule())
            ->addRule(new UserEmailBlackDomainsRule())
            ->addRule(new UserDeletedAtRule());
        $v::attribute(
            'name',
            $v::stringType()
            ->notEmpty()
            ->min(8)
            ->alnum()
            ->UserNameBlackWordsRule()
            ->UserNameUniqRule($this->userRepository)
        );
        $v::attribute(
            'email',
            $v::email()
            ->UserEmailUniqRule($this->userRepository)
            ->UserEmailBlackDomainsRule()
        );
        $v::attribute('createdAt', $v::dateTime()->notEmpty());
        $v::attribute('deletedAt', $v::dateTime()->UserDeletedAtRule());

        return $v;
    }

    /**
     * @param UserInterface $user
     *
     * @return array
     */
    public function validate(UserInterface $user): array
    {
        $validator = $this->getValidator();
        $errorMessages = [];
        try {
            $validator->assert($user);
        } catch (NestedValidationException $exception) {
            $errorMessages = $exception->getMessages();
        }
        return $errorMessages;
    }
}
