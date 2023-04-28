<?php
namespace App\Blog;

use App\Person\Person;

class Post
{
    private int $id;
    private Person $author;
    private int $author_id;
    private string $title;
    private string $text;

    public function __construct(int $id, Person $author, string $title, string $text)
    {
        $this->id = $id;
        $this->author = $author;
        $this->title = $title;
        $this->text = $text;
    }

    public function __toString()
    {
        return $this->author . ' пишет: ' . $this->text . PHP_EOL;
    }
}