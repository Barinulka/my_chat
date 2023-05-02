<?php
namespace App\Blog\Repositories\UsersRepository;

use App\Blog\User;
use App\Blog\Exceptions\UserNotFoundException;

class InMemoryUsersRepository
{
    /**
     * @var User[]
     */
    private array $users = [];

    public function save(User $user): void
    {
        $this->users[] = $user;
    }

    public function get(int $id): User
    {
        foreach ($this->users as $user) {
            if ($user->id() == $id) {
                return $user;
            }
        }

        throw new UserNotFoundException("Пользователь с таким ID: $id не найден!");
    }
}