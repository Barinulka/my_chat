<?php
namespace App\Blog;

class Post
{
    private int $id;
    private User $user;
    private string $title;
    private string $text;

    public function __construct(int $id, User $user, string $title, string $text)
    {
        $this->id = $id;
        $this->user = $user;
        $this->title = $title;
        $this->text = $text;
    }

    public function __toString()
    {
        return $this->user . ' пишет: ' . $this->text . PHP_EOL;
    }

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * @return User
     */
    public function getUser(): User {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getTitle(): string {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getText(): string {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void {
        $this->text = $text;
    }
}