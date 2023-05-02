<?php
use App\Blog\Post;
use App\Blog\User;
use App\Blog\UUID;
use App\Person\Name;
use App\Blog\Comment;
use App\Blog\Repositories\PostsRepository\MysqlPostsRepository;
use App\Blog\Repositories\UsersRepository\MysqlUsersRepository;
use App\Blog\Repositories\CommentsRepository\MysqlCommentRepository;

require_once __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/DB/db_connect.php';

$faker = Faker\Factory::create('ru_RU');

$usersRepository = new MysqlUsersRepository($connection);
$postRepository = new MysqlPostsRepository($connection);
$commentRepository = new MysqlCommentRepository($connection);

$user_uuid = UUID::random();
$post_uuid = UUID::random();
$comment_uuid = UUID::random();
$user_login = $faker->word();

$usersRepository->save(
    new User(
        $user_uuid, 
        new Name($faker->firstName('female'), $faker->lastName('female')), 
        $user_login
    )
);

try {
    $user = $usersRepository->getByLogin($user_login);

    $newPost = new Post(
        $post_uuid,
        $user,
        $faker->sentence(3),
        $faker->paragraph(3),
    );

    $postRepository->save($newPost);

    $post = $postRepository->get(new UUID("aff55332-44dc-4634-ad48-738763642860"));

    $newComment = new Comment(
        $comment_uuid,
        $user,
        $post,
        $faker->paragraph(3),
    );

    $commentRepository->save($newComment);

    $comment = $commentRepository->get(new UUID("98bd6437-1586-47b1-a5d6-fc9694a62776"));

    echo $comment;

} catch (Exception $ex) {
    echo $ex->getMessage() . PHP_EOL;
}
