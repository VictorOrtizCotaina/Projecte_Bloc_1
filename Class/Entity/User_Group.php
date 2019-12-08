<?php

namespace App\Entity;

use DateTime;


class User_Group extends AbstractEntity
{
    private $id_user_group;
    private $name;
    private $description;
    private $avatar;
    private $data_add;


    public function __construct(int $id_user_group, string $name, string $description, string $avatar, DateTime $data_add)
    {
        $this->id_user_group = $id_user_group;
        $this->name = $name;
        $this->description = $description;
        $this->avatar = $avatar;
        $this->data_add = $data_add;
    }

    /**
     * @return int
     */
    public function getIdUserGroup():int{
        return $this->id_user_group;
    }

    /**
     * @param int $id_user_group
     */
    public function setIdUserGroup(int $id_user_group){
        $this->id_user_group = $id_user_group;
    }

    /**
     * @return string
     */
    public function getName():string{
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name){
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription():string{
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description){
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getAvatar():string{
        return $this->avatar;
    }

    /**
     * @param string $avatar
     */
    public function setAvatar(string $avatar){
        $this->avatar = $avatar;
    }

    /**
     * @return DateTime
     */
    public function getDateAdd():string{
        return $this->data_add;
    }

    /**
     * @param DateTime $data_add
     */
    public function setDateAdd(string $data_add){
        $this->data_add = $data_add;
    }




}