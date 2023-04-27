<?php

namespace App\Author;

use App\User\User;
use DateTimeImmutable;

class Author 
{
    public function __construct(
        private User $user,
        private DateTimeImmutable $registeredOn
    )
    {

    }

    public function __toString()
    {
        return $this->user . ' (на сайте с ' . $this->registeredOn->format('Y-m-d') . ')';
    }
}