<?php
namespace App\Blog\PHPUnit\Commands;

use App\Blog\Exceptions\ArgumentsException;
use App\Blog\Exceptions\UserNotFoundException;
use App\Blog\User;
use App\Blog\UUID;
use PHPUnit\Framework\TestCase;
use App\Blog\Commands\Arguments;
use App\Blog\Commands\CreateUserCommand;
use App\Blog\Exceptions\CommandException;
use App\Blog\Repositories\UsersRepository\DummyUsersRepository;
use App\Blog\Repositories\UsersRepository\UsersRepositoryInterface;

class CreateUserCommandTest extends TestCase
{

    /**
     * Проверяем, что команда создания пользователя бросает исключение,
     * если пользователь с таким именем уже существует
     * use stub
     */
    public function testItThrowsAnExceptionWhenUserAlreadyExists(): void 
    {
        $command = new CreateUserCommand(new DummyUsersRepository());

        $this->expectException(CommandException::class);

        $this->expectExceptionMessage('Пользователь с таким логином уже существует: Ivan');

        $command->handle(new Arguments(['login' => 'Ivan']));
    }


    /**
     * Проверяем, что команда действительно требует имя пользователя
     * use stub
     */
    public function testItRequiresFirstName(): void 
    {
        $command = new CreateUserCommand($this->makeUsersRepository());

        $this->expectException(ArgumentsException::class);
        $this->expectExceptionMessage("Нет такого аргумента: first_name");
        
        $command->handle(new Arguments(['login' => 'Ivan']));

    }

    /**
     * Проверяем, что команда действительно требует фамилию пользователя
     */
    public function testItRequiresLastName(): void 
    {
        $command = new CreateUserCommand($this->makeUsersRepository());

        $this->expectException(ArgumentsException::class);
        $this->expectExceptionMessage("Нет такого аргумента: last_name");
        
        $command->handle(new Arguments(['login' => 'Ivan', 'first_name' => 'Ivan']));

    }

    /**
     * Создание анонимного класса зависящего от UsersRepositoryInterface
     * @return UsersRepositoryInterface
     */
    private function makeUsersRepository(): UsersRepositoryInterface
    {
       return new class implements UsersRepositoryInterface {
            public function save(User $user): void {
                // TODO
            }
            public function get(UUID $uuid): User 
            {
                throw new UserNotFoundException("Not Found");
            }

            public function getByLogin(string $login): User 
            {
                throw new UserNotFoundException("Not Found");
            }
        };
    }

    /**
     * Тест, проверяющий, что команда сохраняет пользователя в репозитории
     * use mock
     */
    public function testItSavesUserToRepository(): void 
    {
        $usersRepository = new class implements UsersRepositoryInterface {
            private bool $called = false;

            public function save(User $user): void 
            {
                $this->called = true;
            }

            public function get(UUID $uuid): User
            {
                throw new UserNotFoundException("Not Found");
            }

            public function getByLogin(string $login): User 
            {
                throw new UserNotFoundException("Not Found");
            }

            public function wasCalled(): bool
            {
                return $this->called;
            }
        };

        $command = new CreateUserCommand($usersRepository);

        $command->handle(new Arguments([
            'login' => 'Ivan',
            'first_name' => 'Ivan',
            'last_name' => 'Ivan',
        ]));

        $this->assertTrue($usersRepository->wasCalled());
    }
}