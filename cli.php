<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Blog\Post;
use App\User\User;
use App\Author\Author;

$post = new Post(
    new Author(
        new User(
            'Иван',
            'Иванов'
        ),
        new DateTimeImmutable()
    ),
    'Мой первый пост!'
);

print $post . PHP_EOL;