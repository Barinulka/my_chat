<?php
use App\Blog\Post;
use App\Blog\User;
use App\Person\Name;
use App\Blog\Comments;
use App\Person\Person;

require_once __DIR__ . '/vendor/autoload.php';

$faker = Faker\Factory::create('ru_RU');

$name = new Name($faker->firstName(), $faker->lastName());
$user = new User(
    $faker->randomNumber(5, false),
    $name,
    $faker->word()
);

if (isset($argv[1])) {
    switch ($argv[1]) {
        case 'user' :
            echo $user;
            break;
        case 'post' :
            $post = new Post(
                $faker->randomNumber(5, false),
                $user,
                $faker->sentence(3),
                $faker->paragraph(3),
            );
            echo $post;
            break;
        case 'comment' :
            $post = new Post(
                $faker->randomNumber(5, false),
                $user,
                $faker->sentence(3),
                $faker->paragraph(3),
            );
            $comment = new Comments(
                $faker->randomNumber(5, false),
                $user,
                $post,
                $faker->paragraph(3)
            );
            echo $comment;
            break;
        default :
            echo 'Такой команды не существует!' . PHP_EOL;
            echo "'user' - 'post' - 'comment'" . PHP_EOL;
    }
}
