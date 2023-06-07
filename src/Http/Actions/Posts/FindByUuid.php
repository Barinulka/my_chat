<?php 
namespace App\Http\Actions\Posts;

use App\Blog\UUID;
use App\Http\Request;
use App\Http\Response;
use App\Http\ErrorResponse;
use App\Http\SuccessfulResponse;
use App\Http\Actions\ActionInterface;
use App\Blog\Exceptions\HttpException;
use App\Blog\Exceptions\PostNotFoundException;
use App\Blog\Repositories\PostsRepository\PostRepositoryInterface;

class FindByUuid implements ActionInterface
{

    public function __construct(
        private PostRepositoryInterface $postRepository
    ) { 
    }

    public function handle(Request $request): Response
    {
        try {
            // Пытаемся получить uuid статьи из запроса
            $uuid = new UUID($request->query('uuid'));
        } catch (HttpException $e) {
            // Если в запросе нет параметра uuid -
            // возвращаем неуспешный ответ
            return new ErrorResponse($e->getMessage());
        }

        try {
            // Пытаемся найти статью в репозитории
            $post = $this->postRepository->get($uuid);
        } catch (PostNotFoundException $e) {
            // Если статья не найдена -
            // возвращаем неуспешный ответ
            return new ErrorResponse($e->getMessage());
        }
       
        // Возвращаем успешный ответ
        return new SuccessfulResponse([
            'post' => (string)$uuid,
            'autor_uuid' => (string)$post->getUser()->uuid(),
            'autor_name' => (string)$post->getUser()->name(),
            'title' => $post->title(),
            'text' => $post->text()
        ]);
    }
    
}