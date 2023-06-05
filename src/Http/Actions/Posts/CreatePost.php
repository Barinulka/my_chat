<?php
namespace App\Http\Actions\Posts;

use App\Blog\Post;
use App\Blog\UUID;
use App\Http\ErrorResponse;
use App\Http\Request;
use App\Http\Response;
use App\Http\Actions\ActionInterface;
use App\Blog\Exceptions\HttpException;
use App\Blog\Exceptions\UserNotFoundException;
use App\Blog\Exceptions\InvalidArgumentException;
use App\Blog\Repositories\PostsRepository\PostRepositoryInterface;
use App\Blog\Repositories\UsersRepository\UsersRepositoryInterface;
use App\Http\SuccessfulResponse;

class CreatePost implements ActionInterface
{

    public function __construct(
        private PostRepositoryInterface $postsRepository,
        private UsersRepositoryInterface $usersRepository,
    ) {
    }

    public function handle(Request $request): Response 
    {
        // Создаем пользователя из данных запроса
        try {
            $authorUuid = new UUID($request->jsonBodyField('author_uuid'));
        } catch (HttpException | InvalidArgumentException $e) {
            return new ErrorResponse($e->getMessage());
        }

        // Ищем пользователя в репозитории
        try {
            $this->usersRepository->get($authorUuid);
        } catch (UserNotFoundException $e) {
            return new ErrorResponse($e->getMessage());
        }

        // Генерируем UUID для новой статьи
        $newPostUuid = UUID::random();

        try {
            // Создаем статью из данных запроса
            $post = new Post(
                $newPostUuid,
                $this->usersRepository->get($authorUuid),
                $request->jsonBodyField('title'),
                $request->jsonBodyField('text')
            );
        } catch (HttpException $e) {
            return new ErrorResponse($e->getMessage());
        }

        // Сохраняем новую стаью
        $this->postsRepository->save($post);

        return new SuccessfulResponse([
            'uuid' => (string)$newPostUuid,
            'message' => 'Post created'
        ]);
    }

}

