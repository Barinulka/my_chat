<?php
namespace App\Blog;

use App\Blog\Post;
use App\Person\Person;

class Comments
{
    private int $id;
    private Person $author;
    private Post $post;
    private string $text;

    public function __construct(int $id, Person $author, Post $post, string $text)
    {
        $this->id = $id;
        $this->author = $author;
        $this->post = $post;
        $this->text = $text;
    }

    public function __toString()
    {
        return $this->text . PHP_EOL;
    }

}