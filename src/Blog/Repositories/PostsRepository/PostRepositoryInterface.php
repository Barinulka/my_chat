<?php
namespace App\Blog\Repositories\PostsRepository;
use App\Blog\Post;
use App\Blog\UUID;

interface PostRepositoryInterface 
{
    public function save(Post $post): void;

    public function get(UUID $uuid): Post;

    public function delete(UUID $uuid);
}