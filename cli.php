<?php
use App\Blog\Commands\Arguments;
use App\Blog\Commands\CreateUserCommand;
use App\Blog\Post;
use App\Blog\User;
use App\Blog\UUID;
use App\Person\Name;
use App\Blog\Comment;
use App\Blog\Exceptions\UserNotFoundException;
use App\Blog\Repositories\UsersRepository\MysqlUsersRepository;
// use App\Blog\Repositories\UsersRepository\SqliteUsersRepository;
// use App\Blog\Repositories\UserRepository\InMemoryUsersRepository;

require_once __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/DB/db_connect.php';

// $connection = new PDO('sqlite:'. __DIR__ . '/blog.sqlite');
// $connection = new PDO("mysql:host=localhost;dbname=blog_mysql",'root','root');

$usersRepository = new MysqlUsersRepository($connection);
// $usersRepository->save(new User(UUID::random(), new Name('Super', 'Admin'), 'admin'));
$command = new CreateUserCommand($usersRepository);

// command: php cli.php login=some_login first_name=some_name last_name=some_last_name

try {
    // echo $usersRepository->getByLogin('admin');
    $command->handle(Arguments::fromArgv($argv));
} catch (Exception $ex) {
    echo $ex->getMessage() . PHP_EOL;
}
