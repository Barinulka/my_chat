<?php
namespace App\Blog\Repositories\UsersRepository;

use App\Blog\User;
use App\Blog\UUID;
use App\Person\Name;
use App\Blog\Exceptions\UserNotFoundException;
use App\Blog\Repositories\UsersRepository\UsersRepositoryInterface;

class DummyUsersRepository implements UsersRepositoryInterface 
{
    public function save(User $user): void 
    {

    }

    public function get(UUID $uuid): User 
    {
        throw new UserNotFoundException("not found");
    }

    public function getByLogin(string $login):  User 
    {
        // Для теста не важно, что это будет за пользователь,
        // поэтому возвращаем совершенно произвольного
        return new User(UUID::random(), new Name('first', 'last'), 'Ivan');
    }
}