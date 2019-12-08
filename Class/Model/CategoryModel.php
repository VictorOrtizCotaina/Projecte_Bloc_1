<?php

namespace App\Model;

use Exception;
use PDO;
use DateTime;
use App\Entity\Category;
use App\Entity\AbstractEntity;



class CategoryModel extends AbstractModel
{
    protected $className = 'App\Entity\Category';
    protected $tableName = 'category';


    /* Función para recoger todas las categorias activas, se devuelve un array. */
    function getAllCategories():array {
        $active = true;
        $stmt = $this->pdo->prepare('SELECT * from category WHERE active = :active');
        try {
            $stmt->bindParam(':active', $active, PDO::PARAM_BOOL);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->className);
            $categories = $stmt->fetchAll();

            foreach ($categories as $category) {
                $fM = new ForumModel($this->pdo);
                $category->setForums($fM->getAllForumByCategory($category->getIdCategory()));
            }

            return $categories;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /* Función para recoger una categoría según su id. */
    function getCategoryById(int $idCategory):Category{
        $stmt = $this->pdo->prepare('SELECT * from category WHERE id_category = :id');
        try {
            $stmt->bindParam(':id', $idCategory, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->className);
            $category = $stmt->fetch();

            $fM = new ForumModel($this->pdo);
            $category->setForums($fM->getAllForumByCategory($category->getIdCategory()));

            return $category;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /* Función para recoger las categorias de un usuario. */
    function getCategoryByUser(int $idUser):array{
        $active = true;
        $stmt = $this->pdo->prepare('SELECT * from category WHERE id_user = :id AND active = :active');
        try {
            $stmt->bindParam(':id', $idUser, PDO::PARAM_INT);
            $stmt->bindParam(':active', $active, PDO::PARAM_BOOL);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->className);
            $category = $stmt->fetch();
            return $category;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    /* Se recogen todas las categorias según la paginación. */
    function getAllCategoriesPage(int $start, int $limit):array{
        $stmt = $this->pdo->prepare('SELECT * from category LIMIT :start, :limit');
        try {
            $stmt->bindParam(':start', $start, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->className);
            $categories = $stmt->fetchAll();

            foreach ($categories as $category) {
                $fM = new ForumModel($this->pdo);
                $category->setForums($fM->getAllForumByCategory($category->getIdCategory()));
            }

            return $categories;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /* Se recogen el numero total de categorias. */
    function getPagesCategories():int{
        $stmt = $this->pdo->prepare('SELECT count(id_category) AS id_category from category');
        try {
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $categoryCount = $stmt->fetchAll();
            return $categoryCount[0]["id_category"];

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /* Se recogen las categorias del usuario según la paginación. */
    function getCategoriesPageByUser(int $start, int $limit, int $idUser):array{
        $stmt = $this->pdo->prepare('SELECT * from category WHERE id_user = :id LIMIT :start, :limit');
        try {
            $stmt->bindParam(':start', $start, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':id', $idUser, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->className);
            $categories = $stmt->fetchAll();

            foreach ($categories as $category) {
                $fM = new ForumModel($this->pdo);
                $category->setForums($fM->getAllForumByCategory($category->getIdCategory()));
            }


            return $categories;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /* Se recogen el numero total de categorias del usuario. */
    function getPagesCategoriesByUser(int $idUser):int{
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


    /* Inserta una categoría a la base de datos según la categoría pasada por parametro. */
    public function insertCategory(Category $category):bool {
        $title = $category->getTitle();
        $description = $category->getDescription();
        $image = $category->getImage();
        $date_add = $category->getDateAdd()->format('Y-m-d H:i:s');
        $user = $category->getIdUser();

        try {
            $stmt = $this->pdo->prepare('INSERT INTO category 
                    VALUES(NULL, :title, :description, :image, :date_add, 1, :id_user)');
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':image', $image, PDO::PARAM_STR);
            $stmt->bindParam(':date_add', $date_add, PDO::PARAM_STR);
            $stmt->bindParam(':id_user', $user, PDO::PARAM_INT);
            return $stmt->execute();
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    /* Actualiza una categoría a la base de datos según la categoría pasada por parametro. */
    public function updateCategory(Category $category):bool {
        $id = $category->getIdCategory();
        $title = $category->getTitle();
        $description = $category->getDescription();
        $image = $category->getImage();
        $date_add = $category->getDateAdd()->format('Y-m-d H:i:s');
        $user = $category->getIdUser();

        try {
            $stmt = $this->pdo->prepare('UPDATE category SET id_category = :id, title = :title, description = :description, 
                    image = :image, date_add = :date_add, id_user = :id_user WHERE id_category = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':image', $image, PDO::PARAM_STR);
            $stmt->bindParam(':date_add', $date_add, PDO::PARAM_STR);
            $stmt->bindParam(':id_user', $user, PDO::PARAM_STR);
            return $stmt->execute();
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    /* Elimina una categoría a la base de datos según la categoría pasada por parametro en caso de no tener foros, en caso de tener se desactiva. */
    public function deleteCategory(Category $category):bool {
        try {
            $this->pdo->beginTransaction();

            if (count($category->getForums()) > 0 ) {
                $sql = "UPDATE category SET active = :active WHERE id_category = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindValue(':active', false, PDO::PARAM_BOOL);
                $stmt->bindValue(':id', $category->getIdCategory(), PDO::PARAM_INT);
                $stmt->execute();
            } else {
                $sql = "DELETE FROM category WHERE id_category = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindValue(':id', $category->getIdCategory(), PDO::PARAM_INT);
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

    /* Función para activar una categoría. */
    public function activeCategory(Category $category):bool {
        try {
            $this->pdo->beginTransaction();

            $sql = "UPDATE category SET active = :active WHERE id_category = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':active', true, PDO::PARAM_BOOL);
            $stmt->bindValue(':id', $category->getIdCategory(), PDO::PARAM_INT);
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


    /* La función recibe una categoría y comprueba que las propiedades sean validas. */
    public function validate(Category $category):array {
        $errors = [];

        $title = $category->getTitle();
        if (empty($title)){
            $errors["title"] = "El titulo no puede estar vacio";
        }
        $description = $category->getDescription();
        if (empty($description)){
            $errors["description"] = "La descripcion no puede estar vacia";
        }
        $date_add = $category->getDateAdd()->format('Y-m-d');
        if (empty($date_add)){
            $errors["date_add"] = "La fecha no puede estar vacia";
        } elseif (DateTime::createFromFormat('d-m-Y', $date_add) === false) {
            $errors["date_add"] = "La fecha no es una fecha valida (d-m-Y).";
        }
        $user = $category->getIdUser();
        if (empty($user)){
            $errors["user"] = "El usuario no puede estar vacio";
        }

        return $errors;
    }

    /* La función se utiliza para recoger los datos de un formulario y crear un objecto Categoría. */
    public function getData():Category{
        $category = new Category();
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $image = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_STRING);
        $date_add = new DateTime(htmlspecialchars(trim($_POST["date"])));
        $user = filter_input(INPUT_POST, 'user', FILTER_VALIDATE_INT);

        $category->setTitle(htmlspecialchars(trim($title)));
        $category->setDescription(htmlspecialchars(trim($description)));
        $image = htmlspecialchars(trim($image));
        if (!empty($image)){
            $image = "icon-folder.png";
        }
        $category->setImage($image);
        $category->setDateAdd($date_add);
        $category->setIdUser($user);

        return $category;
    }

}