<?php

namespace App\Entity;

use DateTime;


class Topic extends AbstractEntity
{
    private $id_topic;
    private $title;
    private $description;
    private $image;
    private $date_add;
    private $views;
    private $active;
    private $id_user;
    private $id_forum;
    private $posts;
    private $user;


    public function __construct(){}

    /**
     * @return int
     */
    public function getIdTopic():int
    {
        return $this->id_topic;
    }

    /**
     * @param int $id_topic
     */
    public function setIdTopic(int $id_topic)
    {
        $this->id_topic = $id_topic;
    }

    /**
     * @return string
     */
    public function getTitle():string
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
    public function getDescription():string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getImage():string
    {
        if (empty($this->image)){
            $this->image = "file-text.png";
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
    public function getDateAdd():DateTime
    {
        if (is_string($this->date_add)){
            $this->date_add = new DateTime($this->date_add);
        }
        return $this->date_add;
    }

    /**
     * @param DateTime $date_add
     */
    public function setDateAdd(DateTime $date_add)
    {
        $this->date_add = $date_add;
    }

    /**
     * @return int
     */
    public function getViews():int
    {
        return $this->views;
    }

    /**
     * @param int $views
     */
    public function setViews(int $views)
    {
        $this->views = $views;
    }

    /**
     * @return boolean
     */
    public function getActive():bool
    {
        return $this->active;
    }

    /**
     * @param boolean $active
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    /**
     * @return int
     */
    public function getIdUser():int
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
     * @return int
     */
    public function getIdForum():int
    {
        return $this->id_forum;
    }

    /**
     * @param int $id_forum
     */
    public function setIdForum(int $id_forum)
    {
        $this->id_forum = $id_forum;
    }

    /**
     * @return mixed
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * @param mixed $posts
     */
    public function setPosts($posts): void
    {
        $this->posts = $posts;
    }



    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }


}