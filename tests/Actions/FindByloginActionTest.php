<?php 

namespace App\Http\PHPUnit\Actions;
use App\Blog\User;
use App\Blog\UUID;
use App\Http\Actions\Users\FindByLogin;
use App\Http\ErrorResponse;
use App\Http\Request;
use PHPUnit\Framework\TestCase;
use App\Blog\Exceptions\UserNotFoundException;
use App\Blog\Repositories\UsersRepository\UsersRepositoryInterface;

class FindByLoginActionTest extends TestCase
{

    // Тест, проверяющий, что будет возвращён неудачный ответ,
    // если в запросе нет параметра username
    // Запускаем тест в отдельном процессе
    /**
    * @runInSeparateProcess
    * @preserveGlobalState disabled
    */
    public function testItReturnsErrorResponseIfNoLoginProvided(): void 
    {
        // Создаём объект запроса
        // Вместо суперглобальных переменных
        // передаём простые массивы
        $request = new Request([], []);

        // Создаём стаб репозитория пользователей
        $usersRepository = $this->usersRepository([]);

        $action = new FindByLogin($usersRepository);
        $response = $action->handle($request);

        $this->assertInstanceOf(ErrorResponse::class, $response);
        $this->expectOutputString('{"success":false, "reason":"No such query param in the request: login"}');
        $response->send();
    }

    // Функция, создающая стаб репозитория пользователей,
    // принимает массив "существующих" пользователей
    private function usersRepository(array $users): UsersRepositoryInterface
    {
        // В конструктор анонимного класса передаём массив пользователей
        return new class($users) implements UsersRepositoryInterface {

            public function __construct(
                private array $users
            ) {
            }

            public function save(User $user): void
            {
            }

            public function get(UUID $uuid): User
            {
                throw new UserNotFoundException("Not found");
            }

            public function getByLogin(string $login): User
            {
                foreach ($this->users as $user) {
                    if ($user instanceof User && $login === $user->login()){
                        return $user;
                    }
                }

                throw new UserNotFoundException("Not found");
            }
        };
    }
}