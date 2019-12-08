<?php
declare(strict_types=1);

namespace App\Model;

use App\Entity\AbstractEntity;
use App\Entity\Post;
use Exception;
use PDO;

class AbstractModel
{
    protected $pdo;
    protected $tableName;
    protected $className;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM post ORDER BY published_at DESC');

        $posts = $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, '\Entity\Post');

        // Afegim les dades relacionades
        foreach ($posts as $post) {
            $post->setTags($this->getTagsByPostId($post->getId()));

        }

        //var_dump($posts);
        return $posts;
    }

    public function getById(int $id): AbstractEntity
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->tableName} WHERE id = :id ");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->className);
        $stmt->execute();
        $entity = $stmt->fetch();
        if (empty($entity)) {
            throw new Exception("L\'entitat {$this->className} sol·licitada  {$id} no existeix");
        }
        return $entity;
    }

    private function getTagsByPostId(int $id): array
    {
        $stmt = $this->pdo->prepare('SELECT t.id, t.name FROM post_tag pt INNER JOIN tag t ON t.id = pt.tag_id WHERE pt.post_id = :post_id');
        $stmt->bindValue(':post_id', $id);
        $stmt->execute();
        $tags = $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Blog\Entity\Tag');
        return $tags;
    }

    public function insert(Post $post): bool
    {
        try {
            // prepare la consulta preparada SQL d'insercio en la BB.DD.
            $stmt = $this->pdo->prepare('INSERT INTO post(author_id, title, slug, summary, content, published_at) VALUES(:author_id, :title, :slug, :summary, :content, :published_at)');

            $stmt->bindValue(':author_id', $post->getAuthorId(), PDO::PARAM_INT);
            $stmt->bindValue(':title', $post->getTitle(), PDO::PARAM_STR);
            $stmt->bindValue(':slug', $post->getSlug(), PDO::PARAM_STR);
            $stmt->bindValue(':summary', $post->getSummary(), PDO::PARAM_STR);
            $stmt->bindValue(':content', $post->getContent(), PDO::PARAM_STR);
            $stmt->bindValue(':published_at', $post->getPublished_at()->format('Y-m-d'));

            $stmt->execute();

            if ($stmt->rowCount() == 1) {
                $post->setId((int)$this->pdo->lastInsertId());
                return true;
            } else
                return false;

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();

        }// tanque catch

    }

    public function update(Post $post): bool
    {
        try {
            // prepare la consulta preparada SQL d'insercio en la BB.DD.
            $sql = <<<SQL
              UPDATE post set author_id = :author_id, title = :title, slug =:slug, summary = :summary, 
               content = :content, published_at = :published_at WHERE id = :id
            SQL;
            $stmt = $this->pdo->prepare($sql);

            $stmt->bindValue(':id', $post->getId(), PDO::PARAM_INT);
            $stmt->bindValue(':author_id', $post->getAuthorId(), PDO::PARAM_INT);
            $stmt->bindValue(':title', $post->getTitle(), PDO::PARAM_STR);
            $stmt->bindValue(':slug', $post->getSlug(), PDO::PARAM_STR);
            $stmt->bindValue(':summary', $post->getSummary(), PDO::PARAM_STR);
            $stmt->bindValue(':content', $post->getContent(), PDO::PARAM_STR);
            $stmt->bindValue(':published_at', $post->getPublished_at()->format('Y-m-d'));

            $stmt->execute();

            if ($stmt->rowCount() == 1) {
                return true;
            } else
                return false;

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();

        }// tanque catch
    }

    public function delete(Post $post): bool
    {
        // prepare la consulta preparada SQL d'insercio en la BB.DD.

        try {
            $this->pdo->beginTransaction();
            // si existein etiquetes les haurem d'eliminar
            if (count($post->getTags()) > 0) {
                $stmt = $this->pdo->prepare('DELETE FROM post_tag WHERE post_id=:post_id');
                $stmt->bindValue(':post_id', $post->getId());
                $stmt->execute();
            }
            $sql = "DELETE FROM post WHERE  id = :id";
            $stmt = $this->pdo->prepare($sql);

            $stmt->bindValue(':id', $post->getId(), PDO::PARAM_INT);
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

/*    public function validate(Post $post): array
    {
        return [];
    }

    public function getData(): Post
    {
        $post = new Post();
        $post->setAuthorId(filter_input(INPUT_POST, 'author_id', FILTER_SANITIZE_NUMBER_INT));
        $post->setTitle(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
        $post->setSlug(filter_input(INPUT_POST, 'slug', FILTER_SANITIZE_STRING));
        $post->setSummary(filter_input(INPUT_POST, 'summary', FILTER_SANITIZE_STRING));
        $post->setContent(filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING));

        // En versiones de PHP anteriores a la 4.1.0, debería utilizarse $HTTP_POST_FILES en lugar
        // de $_FILES.

        //var_dump(__DIR__);

        $dir_subida = '/opt/lampp/htdocs/bloc-demo/uploads/';

        $fichero_subido = $dir_subida . basename($_FILES['image']['name']);

        var_dump($fichero_subido);

        echo '<pre>';
        if (move_uploaded_file($_FILES['image']['tmp_name'], $fichero_subido)) {
            echo "El fichero es válido y se subió con éxito.\n";
        } else {
            echo "¡Posible ataque de subida de ficheros!\n";
        }

        echo 'Más información de depuración:';
        print_r($_FILES);

        print "</pre>";

        return $post;
    }*/

}