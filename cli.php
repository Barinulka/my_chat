<?php
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
// $usersRepository->save(new User(UUID::random(), new Name('Alexey', 'Barinov'), 'admin'));

try {
    echo $usersRepository->get(new UUID('483343ed-e097-4191-b0bc-9c4bfa3c5564'));
} catch (Exception $ex) {
    echo $ex->getMessage() . PHP_EOL;
}
