<?php
namespace App\Blog\PHPUnit\Repositories\UsersRepository;
use PDO;
use PDOStatement;
use App\Blog\User;
use App\Blog\UUID;
use App\Person\Name;
use PHPUnit\Framework\TestCase;
use App\Blog\Exceptions\UserNotFoundException;
use App\Blog\Repositories\UsersRepository\MysqlUsersRepository;

class MysqlUsersRepositoryTest extends TestCase 
{
    /**
     * Тест, проверяющий, что MysqlUser-репозиторий бросает исключение, 
     * когда запрашиваемый пользователь не найден
     * use phpunit test
     */
    public function testItThrowsAnExceptionWhenUserNotFound(): void 
    {
        // Мок подключения
        $connectionMock = $this->createStub(PDO::class);

        // Стаб запроса
        $statementStub = $this->createStub(PDOStatement::class);

        // Стаб запроса будет возвращать false
        // при вызове метода fetch
        $statementStub->method('fetch')->willReturn(false);

        // 3. Стаб подключения будет возвращать другой стаб -
        // стаб запроса - при вызове метода prepare
        $connectionMock->method('prepare')->willReturn($statementStub);

        $repository = new MysqlUsersRepository($connectionMock);

        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage('Cannot find user: Ivan');

        $repository->getByLogin('Ivan');
    }

    /**
     *  Тест, проверяющий, что репозиторий сохраняет данные в БД
     */
    public function testItSavesUserToDatabase(): void 
    {
        // Создаём стаб подключения
        $connectionStub = $this->createStub(PDO::class);

        // Создаём мок запроса, возвращаемый стабом подключения
        $statementMock = $this->createMock(PDOStatement::class);

        // Описываем ожидаемое взаимодействие
        // нашего репозитория с моком запроса
        $statementMock
            ->expects($this->once()) // Ожидаем, что будет вызван один раз
            ->method('execute') // метод execute
            ->with([ // с единственным аргументом - массивом
                ':uuid' => '123e4567-e89b-12d3-a456-426614174000',
                ':login' => 'ivan123',
                ':first_name' => 'Ivan',
                ':last_name' => 'Nikitin',
            ]);

        // При вызове метода prepare стаб подключения
        // возвращает мок запроса
        $connectionStub->method('prepare')->willReturn($statementMock);

        // 1. Передаём в репозиторий стаб подключения
        $repository = new MysqlUsersRepository($connectionStub);

        // Вызываем метод сохранения пользователя
        $repository->save(
            new User( // Свойства пользователя точно такие,
                // как и в описании мока
                new UUID('123e4567-e89b-12d3-a456-426614174000'),
                new Name('Ivan', 'Nikitin'),
                'ivan123'
            )
        );
    }
}