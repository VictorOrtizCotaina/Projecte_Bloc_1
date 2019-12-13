<?php

namespace App\Controller;

use App\Model\CategoryModel;
use App\Model\PostModel;
use App\Model\TopicModel;
use App\Model\UserModel;


class TopicController extends AbstractController
{
    public function getTopic($id_category, $id_forum, $id_topic)
    {
        /*Futuro cambio en la base de datos para que el topic tenga una descripcion completa, y los posts sean las respuestas al topic.*/
        session_start();

        /* En caso de que se pase el parametro para cerrar sesion, se hace un unset de la sesion y se elimina. */
        if (isset($_GET["cerrar_sesion"]) && $_GET["cerrar_sesion"] === "1") {
            session_unset();
            session_destroy();
        }

        $target_dir = $this->config->get('image')['src'];

        /* Se comprueba si hay una sessión de usuario creada (se crea al iniciar sessión) y de ser así se añade un objecto usuario. */
        if (isset($_SESSION["user"])) {
            $userModel = new UserModel($this->db);
            $user = $userModel->getUserById($_SESSION["user"]->getIdUser());
        }

        /* Se recogen las categorias para el menú. */
        $categoryModel = new CategoryModel($this->db);
        $categoriesNavbar = $categoryModel->getAllCategories();


        /* Se recoge un parametro GET para para realizar la busqueda del topic.  */
        $topicModel = new TopicModel($this->db);
        $topic = $topicModel->getTopicById($id_topic);

        $postModel = new PostModel($this->db);

        /* Parametros para implementar la paginación. */
        $limit = 2;
        $num_page = filter_input(INPUT_GET, 'num_page', FILTER_SANITIZE_STRING);
        $num_page = isset($num_page) ? $num_page : 1;
        if (isset($_GET["submitFilter"])) {
            $num_page = 1;
        }
        $start = ($num_page - 1) * $limit;

        /*
            Se recoge los posts según los parametros de paginación.
            Se recoge el numero de paginas según los parametros de paginación.
        */
        $posts = $postModel->getAllPostsByTopicPage($id_topic, $start, $limit);
        $postCount = $postModel->getPagesPostsByTopic($id_topic);

        /* Parametros para implementar la paginación. */
        $total = $postCount;
        $pages = ceil($total / $limit);
        $Previous = $num_page - 1;
        $Next = $num_page + 1;

        require("views/front-office/topic.view.php");

    }
}