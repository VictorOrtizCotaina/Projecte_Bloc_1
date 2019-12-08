<?php

namespace App\Entity;

use DateTime;


class Forum extends AbstractEntity
{
    private $id_forum;
    private $title;
    private $description;
    private $image;
    private $date_add;
    private $active;
    private $id_category;
    private $id_user;
    private $topics;


    public function __construct(){}


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
     * @return mixed
     */
    public function getDescription():string
    {
        return $this->description;
    }

    /**
     * @param mixed $description
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
    public function getDateAdd():DateTime
    {
        if (is_string($this->date_add)){
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
    public function getIdCategory():int
    {
        return $this->id_category;
    }

    /**
     * @param int $id_category
     */
    public function setIdCategory(int $id_category)
    {
        $this->id_category = $id_category;
    }

    /**
     * @return int
     */
    public function getIdUser():int {
        return $this->id_user;
    }

    /**
     * @param int $id_user
     */
    public function setIdUser(int $id_user) {
        $this->id_user = $id_user;
    }

    /**
     * @return array
     */
    public function getTopics():array
    {
        return $this->topics;
    }

    /**
     * @param array $topics
     */
    public function setTopics(array $topics): void
    {
        $this->topics = $topics;
    }


}