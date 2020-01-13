<?php

namespace App\Model;

use Exception;
use PDO;
use App\Entity\Post;
use App\Entity\AbstractEntity;
use DateTime;


class PostModel extends AbstractModel
{
    protected $className = 'App\Entity\Post';
    protected $tableName = 'post';


    /* Función para recoger un post según su id. */
    function getPostById(int $idPost):Post{
        $stmt = $this->pdo->prepare('SELECT * from post WHERE id_post = :id');
        try {
            $stmt->bindParam(':id', $idPost, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->className);
            $post = $stmt->fetch();
            $uM = new UserModel($this->pdo);
            $post->setUser($uM->getUserById($post->getIdUser()));

            return $post;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /* Función para recoger todos los posts del topic, se devuelve un array. */
    function getAllPostsByTopic(int $idTopic):array {
        $stmt = $this->pdo->prepare('SELECT * from post WHERE id_topic = :id');
        try {
            $stmt->bindParam(':id', $idTopic, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->className);
            $posts = $stmt->fetchAll();

            foreach ($posts as $post) {
                $uM = new UserModel($this->pdo);
                $post->setUser($uM->getUserById($post->getIdUser()));
            }

            return $posts;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /* Se recogen los posts del topic según la paginación. */
    function getAllPostsByTopicPage(int $idTopic, int $start, int $limit):array{
        $stmt = $this->pdo->prepare('SELECT * from post WHERE id_topic = :id ORDER BY date_add DESC LIMIT :start, :limit ');
        try {
            $stmt->bindParam(':id', $idTopic, PDO::PARAM_INT);
            $stmt->bindParam(':start', $start, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->className);
            $posts = $stmt->fetchAll();

            foreach ($posts as $post) {
                $uM = new UserModel($this->pdo);
                $post->setUser($uM->getUserById($post->getIdUser()));
            }

            return $posts;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /* Se recoge el numero total de posts del topic. */
    function getPagesPostsByTopic(int $idTopic):int{
        $stmt = $this->pdo->prepare('SELECT count(id_post) AS id_post from post WHERE id_topic = :id ORDER BY date_add');
        try {
            $stmt->bindParam(':id', $idTopic, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $postCount = $stmt->fetchAll();
            return $postCount[0]["id_post"];

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }



    /* Se recogen todos los posts según la paginación. */
    function getAllPostsPage(int $start, int $limit):array{
        $stmt = $this->pdo->prepare('SELECT * from post LIMIT :start, :limit');
        try {
            $stmt->bindParam(':start', $start, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->className);
            $posts = $stmt->fetchAll();

            foreach ($posts as $post) {
                $uM = new UserModel($this->pdo);
                $post->setUser($uM->getUserById($post->getIdUser()));
            }

            return $posts;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /* Se recoge el numero total de posts. */
    function getPagesPosts():int{
        $stmt = $this->pdo->prepare('SELECT count(id_post) AS id_post from post');
        try {
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $postCount = $stmt->fetchAll();
            return $postCount[0]["id_post"];

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /* Se recogen los posts del usuario según la paginación. */
    function getPostsPageByUser(int $start, int $limit, int $idUser):array{
        $stmt = $this->pdo->prepare('SELECT * from post WHERE id_user = :id LIMIT :start, :limit');
        try {
            $stmt->bindParam(':start', $start, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':id', $idUser, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->className);
            $posts = $stmt->fetchAll();

            foreach ($posts as $post) {
                $uM = new UserModel($this->pdo);
                $post->setUser($uM->getUserById($post->getIdUser()));
            }

            return $posts;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /* Se recoge el numero total de posts del usuario. */
    function getPagesPostsByUser(int $idUser):int{
        $active = true;
        $stmt = $this->pdo->prepare('SELECT count(id_post) AS id_post from post WHERE id_user = :id');
        try {
            $stmt->bindParam(':id', $idUser, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $postCount = $stmt->fetchAll();
            return $postCount[0]["id_post"];

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    /* Se recogen los posts del usuario. */
    function getPostsByUser(int $idUser):array{
        $stmt = $this->pdo->prepare('SELECT * from post WHERE id_user = :id_user');
        try {
            $stmt->bindParam(':id_user', $idUser, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->className);
            $posts = $stmt->fetchAll();

            foreach ($posts as $post) {
                $uM = new UserModel($this->pdo);
                $post->setUser($uM->getUserById($post->getIdUser()));
            }

            return $posts;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    /* Inserta un post de la base de datos según el post pasado por parametro. */
    public function insertPost(Post $post):bool {
        $title = $post->getTitle();
        $text = $post->getText();
        $image = $post->getImage();
        $date_add = $post->getDateAdd()->format('Y-m-d H:i:s');
        $user = $post->getIdUser();
        $topic = $post->getIdTopic();

        try {
            $stmt = $this->pdo->prepare('INSERT INTO post 
                VALUES(NULL, :title, :text, :image, :date_add, 1, :id_user, :id_topic)');
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':text', $text, PDO::PARAM_STR);
            $stmt->bindParam(':image', $image, PDO::PARAM_STR);
            $stmt->bindParam(':date_add', $date_add, PDO::PARAM_STR);
            $stmt->bindParam(':id_user', $user, PDO::PARAM_INT);
            $stmt->bindParam(':id_topic', $topic, PDO::PARAM_INT);
            return $stmt->execute();
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    /* Actualiza un post de la base de datos según el post pasado por parametro. */
    public function updatePost(Post $post):bool {
        $id = $post->getIdPost();
        $title = $post->getTitle();
        $text = $post->getText();
        $image = $post->getImage();
        $date_add = $post->getDateAdd()->format('Y-m-d H:i:s');
        $user = $post->getIdUser();
        $topic = $post->getIdTopic();

        try {
            $stmt = $this->pdo->prepare('UPDATE post SET id_post = :id, title = :title,
                    description = :description, image = :image, date_add = :date_add,
                    id_topic = :id_topic, id_user = :id_user WHERE id_post = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':text', $text, PDO::PARAM_STR);
            $stmt->bindParam(':image', $image, PDO::PARAM_STR);
            $stmt->bindParam(':date_add', $date_add, PDO::PARAM_STR);
            $stmt->bindParam(':id_user', $user, PDO::PARAM_INT);
            $stmt->bindParam(':id_topic', $topic, PDO::PARAM_INT);
            return $stmt->execute();
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    /* Elimina un post de la base de datos según el post pasado por parametro. */
    public function deletePost(Post $post):bool {
        try {
            $this->pdo->beginTransaction();

            $sql = "DELETE FROM post WHERE id_post = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':id', $post->getIdPost(), PDO::PARAM_INT);
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


    /* La función recibe un post y comprueba que las propiedades sean validas. */
    public function validate(Post $post):array {
        $errors = [];

        $title = $post->getTitle();
        if (empty($title)){
            $errors["title"] = "El titulo no puede estar vacio";
        }
        $description = $post->getText();
        if (empty($description)){
            $errors["description"] = "La descripcion no puede estar vacia";
        }
        $date_add = $post->getDateAdd()->format('d-m-Y');
        if (empty($date_add)){
            $errors["date_add"] = "La fecha no puede estar vacia";
        } elseif (DateTime::createFromFormat('d-m-Y', $date_add) === false) {
            $errors["date_add"] = "La fecha no es una fecha valida (d-m-Y).";
        }
        $user = $post->getIdUser();
        if (empty($user)){
            $errors["user"] = "El usuario no puede estar vacio";
        }
        $topic = $post->getIdTopic();
        if (empty($topic)){
            $errors["topic"] = "El topic no puede estar vacio";
        }

        return $errors;
    }

    /* La función se utiliza para recoger los datos de un formulario y crear un objecto Post. */
    public function getData():Post{
        $post = new Post();
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_STRING);
        $image = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_STRING);
        $date_add = new DateTime(htmlspecialchars(trim($_POST["date"])));
        $user = filter_input(INPUT_POST, 'user', FILTER_VALIDATE_INT);
        $topic = filter_input(INPUT_POST, 'topic', FILTER_VALIDATE_INT);

        $post->setTitle(htmlspecialchars(trim($title)));
        $post->setText(htmlspecialchars(trim($text)));
        $image = htmlspecialchars(trim($image));
        if (!empty($image)){
            $image = "/icon-folder.png";
        }
        $post->setImage($image);
        $post->setDateAdd($date_add);
        $post->setIdUser($user);
        $post->setIdTopic($topic);

        return $post;
    }
}