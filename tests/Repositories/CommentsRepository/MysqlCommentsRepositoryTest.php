<?php
namespace App\Blog\PHPUnit\Repositories\CommentsRepository;

use App\Blog\Comment;
use PDO;
use PDOStatement;
use App\Blog\Post;
use App\Blog\User;
use App\Blog\UUID;
use App\Person\Name;
use PHPUnit\Framework\TestCase;
use App\Blog\Exceptions\CommentNotFoundException;
use App\Blog\Repositories\PostsRepository\MysqlPostsRepository;
use App\Blog\Repositories\CommentsRepository\MysqlCommentRepository;

class MysqlCommentsRepositoryTest extends TestCase 
{
    public function testItThrowsAnExceptionWhenCommentNotFound(): void 
    {
        // Создаем мок подключения и стаб запроса
        $connectionMock = $this->createStub(PDO::class);

        $statementStub = $this->createStub(PDOStatement::class);

        // Прокидываем ошибку для пробросли исключения
        $statementStub->method('fetch')->willReturn(false);

        // Создаем запрос
        $connectionMock->method('prepare')->willReturn($statementStub);

        $repository = new MysqlCommentRepository($connectionMock);

        $this->expectException(CommentNotFoundException::class);
        $this->expectExceptionMessage("Невозможно найти комментарий: 0705d895-5c66-4fed-bde2-42aec9472f0c");

        $repository->get(new UUID('0705d895-5c66-4fed-bde2-42aec9472f0c'));
    }

    public function testItGetCommentByUuid(): void 
    {
        $connectionMock = $this->createStub(PDO::class);
       
        $statementMock = $this->createMock(PDOStatement::class);

        $statementMock->method('fetch')->willReturn([
            'uuid' => '149d87eb-c0b0-4eb9-ad19-26745cfbd9ed',
            'author_uuid' => '6f98e7cc-f297-4d54-8f1c-65c66b26447f',
            'post_uuid' => '6f98e7cc-f297-4d54-8f1c-65c66b26447f',
            'title' => 'Test title',
            'text' => 'Test text',
            'login' => 'Ivan',
            'first_name' => 'Ivan',
            'last_name' => 'Ivan',
        ]);


        $connectionMock->method('prepare')->willReturn($statementMock);

        $commnentRepository = new MysqlCommentRepository($connectionMock);
        $comment = $commnentRepository->get(new UUID('149d87eb-c0b0-4eb9-ad19-26745cfbd9ed'));

        $this->assertSame('149d87eb-c0b0-4eb9-ad19-26745cfbd9ed', (string)$comment->uuid());
    }

    public function testItSaveCommentToDatabase(): void 
    {
        $connectionStub = $this->createStub(PDO::class);
        
        $statementMock = $this->createMock(PDOStatement::class);

        $statementMock
            ->expects($this->once())
            ->method('execute')
            ->with([
                ':uuid' => '149d87eb-c0b0-4eb9-ad19-26745cfbd9ed',
                ':author_uuid' => '6f98e7cc-f297-4d54-8f1c-65c66b26447f',
                ':post_uuid' => '6f98e7cc-f297-4d54-8f1c-65c66b26447f',
                ':text' => 'Test text'
            ]);

        $connectionStub->method('prepare')->willReturn($statementMock);

        $repository = new MysqlCommentRepository($connectionStub);

        $user = new User(
            new UUID('6f98e7cc-f297-4d54-8f1c-65c66b26447f'),
            new Name('Ivan', 'Ivan'),
            'Ivan'
        );

        $post = new Post(
            new UUID('6f98e7cc-f297-4d54-8f1c-65c66b26447f'),
            $user,
            'Test title',
            'Test text'
        );

        $comment = new Comment(
            new UUID('149d87eb-c0b0-4eb9-ad19-26745cfbd9ed'),
            $user,
            $post,
            'Test text'
        );

        $repository->save($comment);
    }
}