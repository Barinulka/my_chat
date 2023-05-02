<?php
namespace App\Blog\Repositories\CommentsRepository;

use PDO;
use PDOStatement;
use App\Blog\UUID;
use App\Blog\Comment;
use App\Blog\Exceptions\CommentNotFoundException;
use App\Blog\Repositories\PostsRepository\MysqlPostsRepository;
use App\Blog\Repositories\UsersRepository\MysqlUsersRepository;
use App\Blog\Repositories\CommentsRepository\CommentsRepositoryInterface;

class MysqlCommentRepository implements CommentsRepositoryInterface
{
    public function __construct(private PDO $connection){

    }

    public function save(Comment $comment): void 
    {
        $statement = $this->connection->prepare(
            "INSERT INTO comments (uuid, author_uuid, post_uuid, text) 
            VALUES (:uuid, :author_uuid, :post_uuid, :text)"
        );

        $statement->execute([
            ':uuid' => $comment->uuid(),
            ':author_uuid' => $comment->user()->uuid(),
            ':post_uuid' => $comment->post()->uuid(),
            ':text' => $comment->text()
        ]);
    }

    public function get(UUID $uuid): Comment
    {
        $statement = $this->connection->prepare(
            "SELECT * FROM comments WHERE uuid = :uuid"
        );

        $statement->execute([
            ':uuid' => (string)$uuid
        ]);

        return $this->getComment($statement, $uuid);
    }

    private function getComment(PDOStatement $statement, string $string): Comment
    {
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result == false) {
            throw new CommentNotFoundException(
                "Невозможно найти комментарий: $string"
            );
        }

        $postRepository = new MysqlPostsRepository($this->connection);
        $userRepository = new MysqlUsersRepository($this->connection);

        $post = $postRepository->get(new UUID($result['post_uuid']));
        $user = $userRepository->get(new UUID($result['author_uuid']));


        return new Comment(
            new UUID($result['uuid']),
            $user,
            $post,
            $result['text']
        );
    }
}