<?php
namespace App\Blog\PHPUnit\Repositories\PostsRepository;

use PDO;
use PDOStatement;
use App\Blog\Post;
use App\Blog\User;
use App\Blog\UUID;
use App\Person\Name;
use PHPUnit\Framework\TestCase;
use App\Blog\Exceptions\PostNotFoundException;
use App\Blog\Repositories\PostsRepository\MysqlPostsRepository;

class MysqlPostsRepositoryTest extends TestCase 
{
    /**
     * Проверяем бросает ли исключение репозиторий
     *
     * @return void
     */
    public function testItThrowsAnExceptionWhenPostNotFound(): void 
    {
        // Создаем мок подключения и стаб запроса
        $connectionMock = $this->createStub(PDO::class);

        $statementStub = $this->createStub(PDOStatement::class);

        // Прокидываем ошибку для пробросли исключения
        $statementStub->method('fetch')->willReturn(false);

        // Создаем запрос
        $connectionMock->method('prepare')->willReturn($statementStub);

        $repository = new MysqlPostsRepository($connectionMock);

        $this->expectException(PostNotFoundException::class);
        $this->expectExceptionMessage("Невозможно найти статью: 0705d895-5c66-4fed-bde2-42aec9472f0c");

        $repository->get(new UUID('0705d895-5c66-4fed-bde2-42aec9472f0c'));
    }

    public function testItGetPostByUuid(): void 
    {
        $connectionStub = $this->createStub(PDO::class);
        
        $statementMock = $this->createMock(PDOStatement::class);

        $statementMock->method('fetch')->willReturn([
            'uuid' => '0705d895-5c66-4fed-bde2-42aec9472f0c',
            'author_uuid' => '1a6a4367-e69d-4382-8fdc-d253733f9f7f',
            'title' => 'Test title',
            'text' => 'Test text',
            'login' => 'Ivan',
            'first_name' => 'Ivan',
            'last_name' => 'Ivan',
        ]);

        $connectionStub->method('prepare')->willReturn($statementMock);

        $postRepository = new MysqlPostsRepository($connectionStub);
        $post = $postRepository->get(new UUID('0705d895-5c66-4fed-bde2-42aec9472f0c'));

        $this->assertSame('0705d895-5c66-4fed-bde2-42aec9472f0c', (string)$post->uuid());
    }

    public function testItSavePostToDatabase(): void 
    {
        $connectionStub = $this->createStub(PDO::class);
        
        $statementMock = $this->createMock(PDOStatement::class);

        $statementMock
            ->expects($this->once())
            ->method('execute')
            ->with([
                ':uuid' => '0705d895-5c66-4fed-bde2-42aec9472f0c',
                ':author_uuid' => '1a6a4367-e69d-4382-8fdc-d253733f9f7f',
                ':title' => 'Test title',
                ':text' => 'Test text'
            ]);

        $connectionStub->method('prepare')->willReturn($statementMock);

        $repository = new MysqlPostsRepository($connectionStub);

        $user = new User(
            new UUID('1a6a4367-e69d-4382-8fdc-d253733f9f7f'),
            new Name('Ivan', 'Ivan'),
            'Ivan'
        );

        $post = new Post(
            new UUID('0705d895-5c66-4fed-bde2-42aec9472f0c'),
            $user,
            'Test title',
            'Test text'
        );

        $repository->save($post);
    }
}