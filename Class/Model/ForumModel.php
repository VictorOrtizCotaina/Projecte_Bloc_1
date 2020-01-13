<?php

namespace App\Model;

use Exception;
use PDO;
use App\Entity\Forum;
use App\Entity\AbstractEntity;
use DateTime;


class ForumModel extends AbstractModel
{
    protected $className = 'App\Entity\Forum';
    protected $tableName = 'forum';


    /* Función para recoger todos los foros de la categoría, se devuelve un array. */
    function getAllForumByCategory(int $idCategory):array {
        $stmt = $this->pdo->prepare('SELECT * from forum WHERE id_category = :id');
        try {
            $stmt->bindParam(':id', $idCategory, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->className);
            $forums = $stmt->fetchAll();
            return $forums;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /* Función para recoger todos los foros, se devuelve un array. */
    function getAllForums():array{
        $stmt = $this->pdo->prepare('SELECT * from forum');
        try {
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->className);
            $forums = $stmt->fetchAll();
            return $forums;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /* Función para recoger un foro según su id. */
    function getForumById(int $idForum):Forum{
        $stmt = $this->pdo->prepare('SELECT * from forum WHERE id_forum = :id');
        try {
            $stmt->bindParam(':id', $idForum, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->className);
            $forum = $stmt->fetch();
            $tM = new TopicModel($this->pdo);
            $forum->setTopics($tM->getAllTopicsByForum($forum->getIdForum()));
            return $forum;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    /* Se recogen todos los foros según la paginación. */
    function getAllForumsPage(int $start, int $limit):array{
        $stmt = $this->pdo->prepare('SELECT * from forum LIMIT :start, :limit');
        try {
            $stmt->bindParam(':start', $start, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->className);
            $forums = $stmt->fetchAll();

            foreach ($forums as $forum) {
                $tM = new TopicModel($this->pdo);
                $forum->setTopics($tM->getAllTopicsByForum($forum->getIdForum()));
            }
            return $forums;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /* Se recoge el numero total de foros. */
    function getPagesForums():int{
        $stmt = $this->pdo->prepare('SELECT count(id_forum) AS id_forum from forum');
        try {
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $forumCount = $stmt->fetchAll();
            return $forumCount[0]["id_forum"];

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /* Se recogen los foros del usuario según la paginación. */
    function getForumsPageByUser(int $start, int $limit, int $idUser):array{
        $stmt = $this->pdo->prepare('SELECT * from forum WHERE id_user = :id LIMIT :start, :limit');
        try {
            $stmt->bindParam(':start', $start, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':id', $idUser, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->className);
            $forums = $stmt->fetchAll();

            foreach ($forums as $forum) {
                $tM = new TopicModel($this->pdo);
                $forum->setTopics($tM->getAllTopicsByForum($forum->getIdForum()));
            }
            return $forums;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /* Se recoge el numero total de foros del usuario. */
    function getPagesForumsByUser(int $idUser):int{
        $active = true;
        $stmt = $this->pdo->prepare('SELECT count(id_category) AS id_category from category WHERE id_user = :id');
        try {
            $stmt->bindParam(':id', $idUser, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $categoryCount = $stmt->fetchAll();
            return $categoryCount[0]["id_category"];

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }



    /* Inserta un foro de la base de datos según el foro pasado por parametro. */
    public function insertForum(Forum $forum):bool {
        $title = $forum->getTitle();
        $description = $forum->getDescription();
        $image = $forum->getImage();
        $date_add = $forum->getDateAdd()->format('Y-m-d H:i:s');
        $user = $forum->getIdUser();
        $category = $forum->getIdCategory();

        try {
            $stmt = $this->pdo->prepare('INSERT INTO forum 
                VALUES(NULL, :title, :description, :image, :date_add, 1, :id_category, :id_user)');
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':image', $image, PDO::PARAM_STR);
            $stmt->bindParam(':date_add', $date_add, PDO::PARAM_STR);
            $stmt->bindParam(':id_category', $category, PDO::PARAM_INT);
            $stmt->bindParam(':id_user', $user, PDO::PARAM_INT);
            return $stmt->execute();
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    /* Actualiza un foro de la base de datos según el foro pasado por parametro. */
    public function updateForum(Forum $forum):bool {
        $id = $forum->getIdForum();
        $title = $forum->getTitle();
        $description = $forum->getDescription();
        $image = $forum->getImage();
        $date_add = $forum->getDateAdd()->format('Y-m-d H:i:s');
        $user = $forum->getIdUser();
        $category = $forum->getIdCategory();

        try {
            $stmt = $this->pdo->prepare('UPDATE forum SET id_forum = :id_forum, title = :title, description = :description, 
                        image = :image, date_add = :date_add, id_category = :id_category, id_user = :id_user WHERE id_forum = :id');
            $stmt->bindParam(':id_forum', $id, PDO::PARAM_INT);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':image', $image, PDO::PARAM_STR);
            $stmt->bindParam(':date_add', $date_add, PDO::PARAM_STR);
            $stmt->bindParam(':id_category', $category, PDO::PARAM_INT);
            $stmt->bindParam(':id_user', $user, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    /* Elimina un foro de la base de datos según el foro pasado por parametro en caso de no tener topics, en caso de tener se desactiva. */
    public function deleteForum(Forum $forum):bool {
        try {
            $this->pdo->beginTransaction();

            if (count($forum->getTopics()) > 0 ) {
                $sql = "UPDATE forum SET active = :active WHERE id_forum = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindValue(':active', false, PDO::PARAM_BOOL);
                $stmt->bindValue(':id', $forum->getIdForum(), PDO::PARAM_INT);
                $stmt->execute();
            } else {
                $sql = "DELETE FROM forum WHERE id_forum = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindValue(':id', $forum->getIdForum(), PDO::PARAM_INT);
                $stmt->execute();
            }

            $this->pdo->commit();

        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new \PDOException($e->getMessage());
        }
        if ($stmt->rowCount() == 1) {
            return true;
        } else
            return false;
    }

    /* Función para activar un foro. */
    public function activeForum(Forum $forum):bool {
        try {
            $this->pdo->beginTransaction();

            $sql = "UPDATE forum SET active = :active WHERE id_forum = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':active', true, PDO::PARAM_BOOL);
            $stmt->bindValue(':id', $forum->getIdForum(), PDO::PARAM_INT);
            $stmt->execute();

            $this->pdo->commit();

        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new \PDOException($e->getMessage());
        }
        if ($stmt->rowCount() == 1) {
            return true;
        } else
            return false;
    }


    /* La función recibe un foro y comprueba que las propiedades sean validas. */
    public function validate(Forum $forum):array {
        $errors = [];

        $title = $forum->getTitle();
        if (empty($title)){
            $errors["title"] = "El titulo no puede estar vacio";
        }
        $description = $forum->getDescription();
        if (empty($description)){
            $errors["description"] = "La descripcion no puede estar vacia";
        }
        $date_add = $forum->getDateAdd()->format('d-m-Y');
        if (empty($date_add)){
            $errors["date_add"] = "La fecha no puede estar vacia";
        } elseif (DateTime::createFromFormat('d-m-Y', $date_add) === false) {
            $errors["date_add"] = "La fecha no es una fecha valida (d-m-Y).";
        }
        $user = $forum->getIdUser();
        if (empty($user)){
            $errors["user"] = "El usuario no puede estar vacio";
        }
        $category = $forum->getIdCategory();
        if (empty($category)){
            $errors["category"] = "La categoria no puede estar vacia";
        }

        return $errors;
    }

    /* La función se utiliza para recoger los datos de un formulario y crear un objecto Foro. */
    public function getData():Forum{
        $forum = new Forum();
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $image = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_STRING);
        $date_add = new DateTime(htmlspecialchars(trim($_POST["date"])));
        $user = filter_input(INPUT_POST, 'user', FILTER_VALIDATE_INT);
        $category = filter_input(INPUT_POST, 'category', FILTER_VALIDATE_INT);

        $forum->setTitle(htmlspecialchars(trim($title)));
        $forum->setDescription(htmlspecialchars(trim($description)));
        $image = htmlspecialchars(trim($image));
        if (!empty($image)){
            $image = "/icon-folder.png";
        }
        $forum->setImage($image);
        $forum->setDateAdd($date_add);
        $forum->setIdUser($user);
        $forum->setIdCategory($category);

        return $forum;
    }
}