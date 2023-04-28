<?php
use App\Blog\Post;
use App\Blog\User;
use App\Person\Name;
use App\Blog\Comments;
use App\Person\Person;
use App\Blog\Exceptions\UserNotFoundException;
use App\Blog\Repositories\UserRepository\InMemoryUsersRepository;

require_once __DIR__ . '/vendor/autoload.php';

$faker = Faker\Factory::create('ru_RU');


$name = new Name($faker->firstName(), $faker->lastName());

if (isset($argv[1])) {
    switch ($argv[1]) {
        case 'user' :
            $user = new User($faker->randomNumber(5, false), $name, $faker->word());
            echo $user . PHP_EOL;
            break;
        case 'post' :
            $post = new Post(
                $faker->randomNumber(5, false),
                new Person($name, new DateTimeImmutable()),
                $faker->sentence(3),
                $faker->paragraph(3),
            );
            echo $post . PHP_EOL;
            break;
        case 'comment' :
            
            $comment = new Comments(
                $faker->randomNumber(5, false),
                new Person($name, new DateTimeImmutable()),
                new Post(
                    $faker->randomNumber(5, false),
                    new Person($name, new DateTimeImmutable()),
                    $faker->sentence(3),
                    $faker->paragraph(3),
                ),
                $faker->paragraph(3)
            );
            echo $comment . PHP_EOL;
            break;
        default :
            echo 'Такой команды не существует!' . PHP_EOL;
            echo "'user' - 'post' - 'comment'" . PHP_EOL;
    }
}
