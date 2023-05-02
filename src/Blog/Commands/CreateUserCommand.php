<?php
namespace App\Blog\Commands;
use App\Blog\User;
use App\Blog\UUID;
use App\Person\Name;
use App\Blog\Exceptions\CommandException;
use App\Blog\Exceptions\UserNotFoundException;
use App\Blog\Repositories\UsersRepository\UsersRepositoryInterface;

class CreateUserCommand 
{
    public function __construct(
        private UsersRepositoryInterface $usersRepository
    ) {

    }

    public function handle(Arguments $arguments): void
    {
        $login = $arguments->get('login');

        if ($this->userExists($login)) {
            throw new CommandException("Пользователь с таким логином уже существует: $login");
        }

        $this->usersRepository->save(
            new User(
                UUID::random(),
                new Name($arguments->get('first_name'), $arguments->get('last_name')),
                $login
            )
        );
    }

    private function userExists(string $login): bool
    {
        try {
        // Пытаемся получить пользователя из репозитория
            $this->usersRepository->getByLogin($login);
        } catch (UserNotFoundException) {
            return false;
        }

        return true;
    }
}