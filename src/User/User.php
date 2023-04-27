<?php

namespace App\User;

class User
{
    public function __construct(
        private string $firstname,
        private string $lastname
    )
    {

    }

    public function __toString()
    {
        return $this->firstname . ' ' . $this->lastname;
    }
}