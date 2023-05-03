<?php
namespace App\Blog\PHPUnit\Commands;

use PHPUnit\Framework\TestCase;
use App\Blog\Commands\Arguments;
use App\Blog\Commands\CreateUserCommand;
use App\Blog\Exceptions\CommandException;
use App\Blog\Repositories\UsersRepository\DummyUsersRepository;

class CreateUserCommandTest extends TestCase
{

    /**
     * Проверяем, что команда создания пользователя бросает исключение,
     * если пользователь с таким именем уже существует
     */
    public function testItThrowsAnExceptionWhenUserAlreadyExists(): void 
    {
        $command = new CreateUserCommand(new DummyUsersRepository());

        $this->expectException(CommandException::class);

        $this->expectExceptionMessage('Пользователь с таким логином уже существует: Ivan');

        $command->handle(new Arguments(['login' => 'Ivan']));
    }
}