<?php

namespace App\Entity;

use DateTime;


class Post extends AbstractEntity
{

    private $id_post;
    private $id_topic;
    private $id_user;
    private $title;
    private $text;
    private $image;
    private $date_add;
    private $active;
    private $user;

    function __construct()
    {
    }

    /**
     * @return int
     */
    public function getIdPost(): int
    {
        return $this->id_post;
    }

    /**
     * @param int $id_post
     */
    public function setIdPost(int $id_post)
    {
        $this->id_post = $id_post;
    }

    /**
     * @return mixed
     */
    public function getIdTopic(): int
    {
        return $this->id_topic;
    }

    /**
     * @param mixed $id_topic
     */
    public function setIdTopic(int $id_topic): void
    {
        $this->id_topic = $id_topic;
    }

    /**
     * @return int
     */
    public function getIdUser(): int
    {
        return $this->id_user;
    }

    /**
     * @param int $id_user
     */
    public function setIdUser(int $id_user)
    {
        $this->id_user = $id_user;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
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
    public function setText(string $text)
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        if (empty($this->image)){
            $this->image = "icon-folder.png";
        }
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage(string $image)
    {
        $this->image = $image;
    }

    /**
     * @return DateTime
     */
    public function getDateAdd(): DateTime
    {
        if (is_string($this->date_add)) {
            $this->date_add = new DateTime($this->date_add);
        }
        return $this->date_add;
    }

    /**
     * @param DateTime $data_add
     */
    public function setDateAdd(DateTime $date_add)
    {
        $this->date_add = $date_add;
    }

    /**
     * @return bool
     */
    public function getActive():bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    /**
     * @return User
     */
    public function getUser():User
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

}