<?php

namespace App\Entity;
use App\Entity\User;
use App\Entity\Forum;
use DateTime;

class Category extends AbstractEntity
{
    private $id_category;
    private $title;
    private $description;
    private $image;
    private $date_add;
    private $id_user;
    private $active;
    private $forums;

    public function __construct()
    {
    }

    /**
     * @return int
     */
    public function getIdCategory(): int
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
    public function getDescription(): string
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
     * @return mixed
     */
    public function getActive():bool
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getForums():array
    {
        return $this->forums;
    }

    /**
     * @param mixed $forums
     */
    public function setForums(array $forums): void
    {
        $this->forums = $forums;
    }


}