<?php 
namespace App\Http\Actions\Users;
use App\Blog\User;
use App\Blog\UUID;
use App\Person\Name;
use App\Http\Request;
use App\Http\Response;
use App\Http\ErrorResponse;
use App\Http\SuccessfulResponse;
use App\Http\Actions\ActionInterface;
use App\Blog\Exceptions\HttpException;
use App\Blog\Repositories\UsersRepository\UsersRepositoryInterface;

class CreateUser implements ActionInterface
{
    public function __construct(
        private UsersRepositoryInterface $usersRepository
    ){
    }

    public function handle(Request $request): Response 
    {
        try {
            $newUserUuid = UUID::random();

            $user = new User(
                $newUserUuid,
                new Name(
                    $request->jsonBodyField('first_name'),
                    $request->jsonBodyField('last_name')
                ),
                $request->jsonBodyField('login')
            );

        } catch (HttpException $e) {
            return new ErrorResponse($e->getMessage());
        }

        $this->usersRepository->save($user);

        return new SuccessfulResponse([
            'succsess' => 'User ' . $user->login() .' create',
            'uuid' => (string)$newUserUuid,
        ]);
    }
}