<?php

namespace App\Model;

use Exception;
use PDO;
use App\Entity\User;
use App\Entity\AbstractEntity;


class UserModel extends AbstractModel
{
    protected $className = 'App\Entity\User';
    protected $tableName = 'user';


    /* Busca todos los usuarios de la base de datos. */
    function getAllUsers():array {
        $stmt = $this->pdo->prepare('SELECT * FROM user');
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->className);
        $stmt->execute();
        $user = $stmt->fetchAll();
        return $user;
    }

    /* Busca el usuario de la base de datos según el parametro de la id del usuario. */
    function getUserById(int $idUser):User{
        $stmt = $this->pdo->prepare('SELECT * FROM user WHERE id_user = :id');
        $stmt->bindParam(':id', $idUser, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->className);
        $stmt->execute();
        $user = $stmt->fetch();
        return $user;
    }

    /* Busca el usuario de la base de datos según el parametro del email del usuario. */
    function getUserByEmail(string $email):?User {
        $stmt = $this->pdo->prepare('SELECT * from user WHERE email = :email');
        try {
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->className);
            $user = $stmt->fetch();
            if (!$user) $user = null;
            return $user;

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /* Crea un nuevo usuario según los parametros. */
    function register(string $email, string $password, string $username){
        $date_add = new DateTime();
        $date_add = $date_add->format('Y-m-d H:i:s');
        try {
            $stmt = $this->pdo->prepare("INSERT INTO user 
                VALUES(NULL, :username, :password, :email, 'es', 'user_default.png', :date_add, 1, 2)");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':date_add', $date_add, PDO::PARAM_STR);
            return $stmt->execute();
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    /* Edita el usuario para cambiar la imagen. */
    function editUserImage(int $idUser, string $img){
        $stmt = $this->pdo->prepare('UPDATE user SET avatar = :avatar WHERE id_user = :id');
        try {
            $stmt->bindParam("id", $idUser, PDO::PARAM_INT);
            $stmt->bindParam("avatar", $img, PDO::PARAM_LOB);
            return $stmt->execute();
        }
        catch(PDOException $e)
        {
            'Error : ' .$e->getMessage();
        }
    }

    /* Edita el usuario para cambiar la contraseña. */
    function editUserPass(int $idUser, string $pass){
        $stmt = $this->pdo->prepare('UPDATE user SET password = :pass WHERE id_user = :id');
        try {
            $stmt->bindParam("id", $idUser, PDO::PARAM_INT);
            $stmt->bindParam("pass", $pass, PDO::PARAM_LOB);
            return $stmt->execute();
        }
        catch(PDOException $e)
        {
            'Error : ' .$e->getMessage();
        }
    }
}