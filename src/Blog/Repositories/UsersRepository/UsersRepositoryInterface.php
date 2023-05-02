<?php
namespace App\Blog\Repositories\UsersRepository;
use App\Blog\User;
use App\Blog\UUID;

interface UsersRepositoryInterface
{
    public function get(UUID $uuid): void;

    public function save (User $user): User;

    public function getByLogin(string $login): User;
}