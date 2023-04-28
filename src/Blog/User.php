<?php
namespace App\Blog;

use App\Person\Name;

class User 
{
    private int $id;
    private Name $username;
    private string $login;

    /**
     * @param integer $id
     * @param Name $username
     * @param string $login
     */
    public function __construct(int $id, Name $username, string $login)
    {
        $this->id = $id;
        $this->username = $username;
        $this->login = $login;
    }

    public function __toString()
    {
        return "Пользователь $this->id с именем $this->username и логином $this->login" . PHP_EOL;
    }

    /**
     * @return integer
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * @param integer $id
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param Name $username
     * @return void
     */
    public function setUsername(Name $username) : void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     * @return void
     */
    public function setLogin(string $login): void 
    {
        $this->login = $login;
    }
}