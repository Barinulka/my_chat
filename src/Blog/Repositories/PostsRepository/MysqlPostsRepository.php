<?php 
namespace App\Blog\Repositories\PostsRepository;

use PDO;
use PDOStatement;
use App\Blog\Post;
use App\Blog\UUID;
use App\Http\ErrorResponse;
use App\Blog\Exceptions\PostNotFoundException;
use App\Blog\Repositories\UsersRepository\MysqlUsersRepository;
use App\Blog\Repositories\PostsRepository\PostRepositoryInterface;

class MysqlPostsRepository implements PostRepositoryInterface
{

    public function __construct(private PDO $connection){
    }

    public function save(Post $post): void 
    {
        $statement = $this->connection->prepare(
            "INSERT INTO posts (uuid, author_uuid, title, text) 
            VALUES (:uuid, :author_uuid, :title, :text)"
        );

        $statement->execute([
            ':uuid' => $post->uuid(),
            ':author_uuid' => $post->getUser()->uuid(),
            ':title' => $post->title(),
            ':text' => $post->text()
        ]);
    }

    public function get(UUID $uuid): Post 
    {
        $statement = $this->connection->prepare(
            "SELECT * FROM posts WHERE uuid = :uuid"
        );

        $statement->execute([
            ':uuid' => (string)$uuid
        ]);

        return $this->getPost($statement, $uuid);
    }

    public function delete(UUID $uuid) 
    {
        $statement = $this->connection->prepare(
            "DELETE FROM posts WHERE uuid = :uuid"
        );

        $statement->execute([
            ':uuid' => (string)$uuid
        ]);

    }

    private function getPost(PDOStatement $statemant, string $string): Post 
    {
        $result = $statemant->fetch(PDO::FETCH_ASSOC);

        if ($result == false) {
            throw new PostNotFoundException(
                "Невозможно найти статью: $string"
            );
        }

        $userRepository = new MysqlUsersRepository($this->connection);
        $user = $userRepository->get(new UUID($result['author_uuid']));

        return new Post(
            new UUID($result['uuid']),
            $user,
            $result['title'],
            $result['text']
        );
    }

}