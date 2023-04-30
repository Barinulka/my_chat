<?php
namespace App\Blog;

class Comment
{
    public function __construct(
        private int $id, 
        private User $user, 
        private Post $post, 
        private string $text
    )
    {
    }

    public function __toString()
    {
        return $this->user . " оставил Комментарий >> " . $this->text . PHP_EOL;
    }

    /**
     * @return integer
     */
    public function id (): int
    {
        return $this->id;
    }

    /**
     * @param integer $id
     */
    public function setId(int $id): void 
    {
        $this->id = $id;
    }

    /**
     * @param User $user
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void 
    {
        $this->user = $user;
    }

    /**
     * @return Post
     */
    public function getPost(): Post
    {
        return $this->post;
    }

    /**
     * @param Post $post
     */
    public function setPost(Post $post): void
    {
        $this->post = $post;
    }

    /**
     * @return string
     */
    public function getText(): string 
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }
}