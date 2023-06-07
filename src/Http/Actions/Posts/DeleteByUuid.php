<?php
namespace App\Http\Actions\Posts;

use App\Blog\Exceptions\HttpException;
use App\Blog\Exceptions\PostNotFoundException;
use App\Blog\Repositories\PostsRepository\MysqlPostsRepository;
use App\Blog\UUID;
use App\Http\Actions\ActionInterface;
use App\Http\ErrorResponse;
use App\Http\Request;
use App\Http\Response;
use App\Http\SuccessfulResponse;

class DeleteByUuid implements ActionInterface
{
    public function __construct(
        private MysqlPostsRepository $postRepository
    )
    {
        
    }

    public function handle(Request $request): Response
    {

        try {
            // Получаем uuid статьи из запроса
            $uuid = $request->query('uuid');
            $this->postRepository->get(new UUID($uuid));
        } catch (PostNotFoundException $e) {
            return new ErrorResponse($e->getMessage());
        }

       $this->postRepository->delete(new UUID($uuid));

        return new SuccessfulResponse([
            'uuid' => $uuid,
            'message' => "Статья $uuid удалена"
        ]);
    }
}