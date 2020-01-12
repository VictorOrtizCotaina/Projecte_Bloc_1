<?php

namespace App\Entity;

use DateTime;


class User extends AbstractEntity {

    private $id_user;
    private $username;
    private $password;
    private $email;
    private $name;
    private $surnames;
    private $province;
    private $lang;
    private $avatar;
    private $id_user_group;
    private $date_add;

    function __construct(){}

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
     * @return string
     */
    public function getUsername():string {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username) {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword():string {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password) {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getEmail():string {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email) {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getName():string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name): string
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSurnames():string
    {
        return $this->surnames;
    }

    /**
     * @param string $surnames
     */
    public function setSurnames($surnames): string
    {
        $this->surnames = $surnames;
    }

    /**
     * @return string
     */
    public function getProvince():string
    {
        return $this->province;
    }

    /**
     * @param string $province
     */
    public function setProvince($province): string
    {
        $this->province = $province;
    }

    /**
     * @return string
     */
    public function getLang():string {
        return $this->lang;
    }

    /**
     * @param string $lang
     */
    public function setLang(string $lang) {
        $this->lang = $lang;
    }

    /**
     * @return string
     */
    public function getAvatar() {
        if (empty($this->avatar)){
            $this->avatar = "user_default.png";
        }
        return $this->avatar;
    }

    /**
     * @param string $avatar
     */
    public function setAvatar(string $avatar) {
        $this->avatar = $avatar;
    }

    /**
     * @return int
     */
    public function getIdUserGroup():int {
        return $this->id_user_group;
    }

    /**
     * @param int $id_user_group
     */
    public function setIdUserGroup(int $id_user_group) {
        $this->id_user_group = $id_user_group;
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


}