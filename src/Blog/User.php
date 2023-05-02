<?php
namespace App\Blog;

use App\Person\Name;

class User 
{
    private UUID $uuid;
    private Name $username;
    private string $login;

    /**
     * @param UUID $uuid
     * @param Name $username
     * @param string $login
     */
    public function __construct(UUID $uuid, Name $username, string $login)
    {
        $this->uuid = $uuid;
        $this->username = $username;
        $this->login = $login;
    }

    public function __toString()
    {
        return "Пользователь $this->uuid с именем $this->username и логином $this->login" . PHP_EOL;
    }

    /**
     * @return integer
     */
    public function uuid(): UUID
    {
        return $this->uuid;
    }

    /**
     * @return Name
     */
    public function name(): Name
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