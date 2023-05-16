<?php 
namespace App\Http\Actions\Users;
use App\Http\Request;
use App\Http\Response;
use App\Http\ErrorResponse;
use App\Http\SuccessfulResponse;
use App\Http\Actions\ActionInterface;
use App\Blog\Exceptions\HttpException;
use App\Blog\Exceptions\UserNotFoundException;
use App\Blog\Repositories\UsersRepository\UsersRepositoryInterface;

class FindByLogin implements ActionInterface
{

    // Внедряем интервейс пользователей в каестве зависимости репозитория пользователей
    public function __construct(
        private UsersRepositoryInterface $usersRepository
    ){
    }

    public function handle(Request $request): Response 
    {
        try {
            // Пытаемся получить искомое имя пользователя из запроса
            $login = $request->query('login');
        } catch (HttpException $e) {
            // Если в запросе нет параметра username -
            // возвращаем неуспешный ответ,
            // сообщение об ошибке берём из описания исключения
            return new ErrorResponse($e->getMessage());
        }

        try {
            // Пытаемся найти пользователя в репозитории
            $user = $this->usersRepository->getByLogin($login);
        } catch (UserNotFoundException $e) {
            // Если пользователь не найден -
            // возвращаем неуспешный ответ
            return new ErrorResponse($e->getMessage());
        }
        
        // Возвращаем успешный ответ
        return new SuccessfulResponse([
            'login' => $user->login(),
            'name' => $user->name()->first() . ' ' . $user->name()->last(),
        ]);
    }
}