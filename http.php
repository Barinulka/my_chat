<?php 

use App\Http\Request;
use App\Http\ErrorResponse;
use App\Http\SuccessfulResponse;
use App\Blog\Exceptions\AppException;
use App\Blog\Exceptions\HttpException;
use App\Http\Actions\Posts\CreatePost;
use App\Http\Actions\Users\CreateUser;
use App\Http\Actions\Users\FindByLogin;
use App\Blog\Repositories\PostsRepository\MysqlPostsRepository;
use App\Blog\Repositories\UsersRepository\MysqlUsersRepository;

require_once __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/DB/db_connect.php';

// Содаем объект запроса из суперглобальных переменных
$request = new Request($_GET, $_SERVER, file_get_contents('php://input'));


$routes = [
    'GET' => [
        '/users/show' => new FindByLogin(new MysqlUsersRepository($connection)),
    ], 
    'POST' => [
        '/users/create' => new CreateUser(new MysqlUsersRepository($connection)),
        '/posts/create' => new CreatePost(new MysqlPostsRepository($connection), new MysqlUsersRepository($connection))
    ]
];

// Пытаемся получить путь
try {
    $path = $request->path();
} catch (HttpException) {
    // Отправляем неудачный ответ если не можем получить путь и выходим
    (new ErrorResponse)->send();
    return;
}

try {
    // Пытаемся получить HTTP-метод запроса
    $method = $request->method();
} catch (HttpException) {
    // Возвращаем неудачный ответ,
    // если по какой-то причине
    // не можем получить метод
    (new ErrorResponse)->send();

    return;
}

// Если у нас нет маршрутов для метода запроса -
// возвращаем неуспешный ответ
if (!array_key_exists($method, $routes)) {
    (new ErrorResponse('Not found'))->send();
    return;
}

// Ищем маршрут среди маршрутов для этого метода
if (!array_key_exists($path, $routes[$method])) {
    (new ErrorResponse('Not found'))->send();
    return;
}

// Выбираем действие по методу и пути
$action = $routes[$method][$path];

try {
    $response = $action->handle($request);
    $response->send();
} catch (Exception $e) {
    (new ErrorResponse($e->getMessage()))->send();
}



