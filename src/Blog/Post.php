<?php

namespace App\Blog;

use App\Author\Author;


class Post 
{
    public function __construct(
        private Author $author,
        private string $text
    )
    {

    }

    public function __toString()
    {
        return $this->author . ' пишет: ' . $this->text;
    }
}