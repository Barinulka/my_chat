<?php
namespace App\Blog\Repositories\UsersRepository;
use App\Blog\User;
use App\Blog\UUID;

interface UsersRepositoryInterface
{
    public function get(UUID $uuid): User;

    public function save (User $user): void;

    public function getByLogin(string $login): User;
}