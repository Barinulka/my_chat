<?php
namespace App\Blog\Repositories\UsersRepository;
use PDO;
use App\Blog\User;
use App\Blog\UUID;
use App\Person\Name;
use App\Blog\Exceptions\UserNotFoundException;
use PDOStatement;

class MysqlUsersRepository implements UsersRepositoryInterface
{
    public function __construct(
        private PDO $connection
    ){
    }

    public function save(User $user): void 
    {
        $statement = $this->connection->prepare(
            'INSERT INTO users (uuid, first_name, last_name, login) VALUES (:uuid, :first_name, :last_name, :login)'
        );

        $statement->execute([
            ':uuid' => (string)$user->uuid(),
            ':first_name' => $user->name()->first(),
            ':last_name'=> $user->name()->last(),
            ':login' => $user->getLogin()
        ]);
    }

    // Также добавим метод для получения
    // пользователя по его UUID
    public function get(UUID $uuid): User
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM users WHERE uuid = :uuid'
        );

        $statement->execute([
            ':uuid' => (string)$uuid,
        ]);

        return $this->getUser($statement, $uuid);
    }

    /**
     * @param string $login
     * @return User
     */
    public function getByLogin(string $login): User
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM users WHERE login = :login'
        );
        $statement->execute([
            ':login' => $login,
        ]);

       return $this->getUser($statement, $login);
    }

    private function getUser(PDOStatement $statement, string $string): User
    {
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result === false) {
            throw new UserNotFoundException(
                "Cannot find user: $string"
            );
        }

        // Создаём объект пользователя с полем username
        return new User(
            new UUID($result['uuid']),
            new Name($result['first_name'], $result['last_name']),
            $result['login'],
        );
    }
}