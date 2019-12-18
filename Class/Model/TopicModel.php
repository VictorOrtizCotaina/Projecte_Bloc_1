<?php

namespace App\Model;

use Exception;
use PDO;
use App\Entity\Topic;
use App\Entity\AbstractEntity;
use DateTime;


class TopicModel extends AbstractModel
{
    protected $className = 'App\Entity\Topic';
    protected $tableName = 'topic';


    /* Función para recoger un topic según su id. */
    function getTopicById(int $idTopic):Topic{
        $stmt = $this->pdo->prepare('SELECT * from topic WHERE id_topic = :id');
        try {
            $stmt->bindParam(':id', $idTopic, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->className);
            $topic = $stmt->fetch();

            $pM = new PostModel($this->pdo);
            $topic->setPosts($pM->getAllPostsByTopic($topic->getIdTopic()));

            return $topic;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /* Función para recoger un topic según el id del foro. */
    function getAllTopicsByForum(int $idForum):array {
        $stmt = $this->pdo->prepare('SELECT * from topic WHERE id_forum = :id');
        try {
            $stmt->bindParam(':id', $idForum, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->className);
            $topics = $stmt->fetchAll();

            foreach ($topics as $topic) {
                $pM = new PostModel($this->pdo);
                $topic->setPosts($pM->getAllPostsByTopic($topic->getIdTopic()));
                $uM = new UserModel($this->pdo);
                $topic->setUser($uM->getUserById($topic->getIdUser()));
            }
            return $topics;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    /* Se recogen los topics según los parametros, que icluye la paginación y los filtros. */
    function getAllTopicsPage(int $idForum, int $start, int $limit, string $search, string $dateIni, string $dateFin, int $idUser):array{
        $count = 0;
        $forum = "";
        $searchSQL = "";
        $dateSQL = "";
        $userSQL = "";
        if (!empty($idForum)){
            if ($count>0){
                $forum = " AND ";
            } else {
                $forum = " WHERE ";
            }
            $forum = $forum . " id_forum = :id ";
            $count++;
        }
        if (!empty($search)){
            if ($count>0){
                $searchSQL = " AND ";
            } else {
                $searchSQL = " WHERE ";
            }
            $searchSQL = $searchSQL . " CONCAT(title, '', description) LIKE :search ";
            $count++;
        }
        if (!empty($dateIni) && !empty($dateFin)){
            if ($count>0){
                $dateSQL = " AND ";
            } else {
                $dateSQL = " WHERE ";
            }
            $dateSQL = $dateSQL . " date_add between :dateIni and :dateFin ";
            $count++;
        }
        if (!empty($idUser)){
            if ($count>0){
                $userSQL = " AND ";
            } else {
                $userSQL = " WHERE ";
            }
            $userSQL = $userSQL . " id_user = :idUser ";
            $count++;
        }
        $sql = "SELECT * FROM topic " . $forum . $searchSQL . $dateSQL . $userSQL . " ORDER BY date_add DESC LIMIT :start, :limit";

        $stmt = $this->pdo->prepare($sql);
        try {
            $stmt->bindParam(':start', $start, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            if (!empty($idForum)){
                $stmt->bindParam(':id', $idForum, PDO::PARAM_INT);
            }
            if (!empty($search)){
                $search = '%' . $search . '%';
                $stmt->bindParam(':search', $search, PDO::PARAM_STR);
            }
            if ((!empty($dateIni) && !empty($dateFin))){
                $stmt->bindParam(':dateIni', $dateIni, PDO::PARAM_STR);
                $stmt->bindParam(':dateFin', $dateFin, PDO::PARAM_STR);
            }
            if (!empty($idUser)){
                $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
            }

            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->className);
            $topics = $stmt->fetchAll();

            foreach ($topics as $topic) {
                $pM = new PostModel($this->pdo);
                $topic->setPosts($pM->getAllPostsByTopic($topic->getIdTopic()));
                $uM = new UserModel($this->pdo);
                $topic->setUser($uM->getUserById($topic->getIdUser()));
            }
            return $topics;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    /*  Se recoge el numero total de topics según los parametros, que icluye la paginación y los filtros. */
    function getPagesTopics(int $idForum, string $search, string $dateIni, string $dateFin, int $idUser):int{

        $count = 0;
        $forum = "";
        $searchSQL = "";
        $dateSQL = "";
        $userSQL = "";
        if (!empty($idForum)){
            if ($count>0){
                $forum = " AND ";
            } else {
                $forum = " WHERE ";
            }
            $forum = $forum . " id_forum = :id ";
            $count++;
        }
        if (!empty($search)){
            if ($count>0){
                $searchSQL = " AND ";
            } else {
                $searchSQL = " WHERE ";
            }
            $searchSQL = $searchSQL . " CONCAT(title, '', description) LIKE :search ";
            $count++;
        }
        if (!empty($dateIni) && !empty($dateFin)){
            if ($count>0){
                $dateSQL = " AND ";
            } else {
                $dateSQL = " WHERE ";
            }
            $dateSQL = $dateSQL . " date_add between :dateIni and :dateFin ";
            $count++;
        }
        if (!empty($idUser)){
            if ($count>0){
                $userSQL = " AND ";
            } else {
                $userSQL = " WHERE ";
            }
            $userSQL = $userSQL . " id_user = :idUser ";
            $count++;
        }
        $sql = "SELECT count(id_topic) AS id_topic FROM topic " . $forum . $searchSQL . $dateSQL . $userSQL;

        $stmt = $this->pdo->prepare($sql);
        try {
            if (!empty($idForum)){
                $stmt->bindParam(':id', $idForum, PDO::PARAM_INT);
            }
            if (!empty($search)){
                $search = '%' . $search . '%';
                $stmt->bindParam(':search', $search, PDO::PARAM_STR);
            }
            if ((!empty($dateIni) && !empty($dateFin))){
                $stmt->bindParam(':dateIni', $dateIni, PDO::PARAM_STR);
                $stmt->bindParam(':dateFin', $dateFin, PDO::PARAM_STR);
            }
            if (!empty($idUser)){
                $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
            }

            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $topicCount = $stmt->fetchAll();
            return $topicCount[0]["id_topic"];

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }



    /* Inserta un topic a la base de datos según el topic pasado por parametro. */
    public function insertTopic(Topic $topic):bool {
        $title = $topic->getTitle();
        $description = $topic->getDescription();
        $image = $topic->getImage();
        $date_add = $topic->getDateAdd()->format('Y-m-d H:i:s');
        $user = $topic->getIdUser();
        $forum = $topic->getIdForum();

        try {
            $stmt = $this->pdo->prepare('INSERT INTO topic 
                VALUES(NULL, :title, :description, :image, :date_add, NULL, 1, :id_user, :id_forum)');
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':image', $image, PDO::PARAM_STR);
            $stmt->bindParam(':date_add', $date_add, PDO::PARAM_STR);
            $stmt->bindParam(':id_forum', $forum, PDO::PARAM_INT);
            $stmt->bindParam(':id_user', $user, PDO::PARAM_INT);
            return $stmt->execute();
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    /* Actualiza un topic de la base de datos según el topic pasado por parametro. */
    public function updateTopic(Topic $topic):bool {
        $id = $topic->getIdTopic();
        $title = $topic->getTitle();
        $description = $topic->getDescription();
        $image = $topic->getImage();
        $date_add = $topic->getDateAdd()->format('Y-m-d H:i:s');
        $user = $topic->getIdUser();
        $forum = $topic->getIdForum();

        try {

            $stmt = $this->pdo->prepare('UPDATE topic SET id_topic = :id, title = :title, 
                description = :description, image = :image, 
                date_add = :date_add, id_forum = :id_forum, id_user = :id_user WHERE id_topic = :id ');
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':image', $image, PDO::PARAM_STR);
            $stmt->bindParam(':date_add', $date_add, PDO::PARAM_STR);
            $stmt->bindParam(':id_forum', $forum, PDO::PARAM_INT);
            $stmt->bindParam(':id_user', $user, PDO::PARAM_INT);
            return $stmt->execute();
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    /* Elimina un topic de la base de datos según el topic pasado por parametro en caso de no tener posts, en caso de tener se desactiva. */
    public function deleteTopic(Topic $topic):bool {
        try {
            $this->pdo->beginTransaction();

            if (count($topic->getPosts()) > 0 ) {
                $sql = "UPDATE topic SET active = :active WHERE id_topic = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindValue(':active', false, PDO::PARAM_BOOL);
                $stmt->bindValue(':id', $topic->getIdTopic(), PDO::PARAM_INT);
                $stmt->execute();
            } else {
                $sql = "DELETE FROM topic WHERE id_topic = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindValue(':id', $topic->getIdTopic(), PDO::PARAM_INT);
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

    /* Función para activar un topic. */
    public function activeTopic(Topic $topic):bool {
        try {
            $this->pdo->beginTransaction();

            $sql = "UPDATE topic SET active = :active WHERE id_topic = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':active', true, PDO::PARAM_BOOL);
            $stmt->bindValue(':id', $topic->getIdTopic(), PDO::PARAM_INT);
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


    /* La función recibe un topic y comprueba que las propiedades sean validas. */
    public function validate(Topic $topic):array
    {
        $errors = [];

        $title = $topic->getTitle();
        if (empty($title)) {
            $errors["title"] = "El titulo no puede estar vacio";
        }
        $description = $topic->getDescription();
        if (empty($description)) {
            $errors["description"] = "La descripcion no puede estar vacia";
        }
        $date_add = $topic->getDateAdd()->format('d-m-Y');
        if (empty($date_add)) {
            $errors["date_add"] = "La fecha no puede estar vacia";
        } elseif ($date_add == "1910-01-01"){
            $errors["date_add"] = "No es una fecha valida.";
        } elseif (DateTime::createFromFormat('d-m-Y', $date_add) === false) {
            $errors["date_add"] = "La fecha no es una fecha valida (Y-m-d).";
        }
        $user = $topic->getIdUser();
        if (empty($user)){
            $errors["user"] = "El usuario no puede estar vacio";
        }
        $forum = $topic->getIdForum();
        if (empty($forum)){
            $errors["forum"] = "El foro no puede estar vacio";
        }

        return $errors;
    }

    /* La función se utiliza para recoger los datos de un formulario y crear un objecto Topic. */
    public function getData():Topic{
        $topic = new Topic();
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $image = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_STRING);
        try {
            $date_add = new DateTime(htmlspecialchars(trim($_POST["date"])));
        } catch (Exception $e){
            $date_add = new DateTime("1910-01-01");
        }
        $user = filter_input(INPUT_POST, 'user', FILTER_VALIDATE_INT);
        $forum = filter_input(INPUT_POST, 'forum', FILTER_VALIDATE_INT);

        $topic->setTitle(htmlspecialchars(trim($title)));
        $topic->setDescription(htmlspecialchars(trim($description)));
        $image = htmlspecialchars(trim($image));

        if (empty($image)){
            $image = "/icon-folder.png";
        }
        $topic->setImage($image);
        $topic->setDateAdd($date_add);
        $topic->setIdUser($user);
        $topic->setIdForum($forum);

        return $topic;
    }
}