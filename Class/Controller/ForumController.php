<?php

namespace App\Controller;

use App\Model\CategoryModel;
use App\Model\ForumModel;
use App\Model\TopicModel;
use App\Model\UserModel;


class ForumController extends AbstractController
{
    public function getForum($id_category, $id_forum)
    {
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

        /* Se recoge un parametro GET en caso de que se pase un foro.  */
//        $id_forum = filter_input(INPUT_GET, 'id_forum', FILTER_SANITIZE_NUMBER_INT);
//        $id_forum = htmlspecialchars(trim($id_forum));

        /* Parametros de filtrado. */
        $search = filter_input(INPUT_GET, 'search_keywords', FILTER_SANITIZE_STRING);
        $dateIni = filter_input(INPUT_GET, 'dateIni', FILTER_SANITIZE_STRING);
        $dateFin = filter_input(INPUT_GET, 'dateFin', FILTER_SANITIZE_STRING);
        $id_user = filter_input(INPUT_GET, 'id_user', FILTER_SANITIZE_NUMBER_INT);

        $search = htmlspecialchars(trim($search));
        $dateIni = htmlspecialchars(trim($dateIni));
        $dateFin = htmlspecialchars(trim($dateFin));

        if (!empty($id_forum)) {
            $forumModel = new ForumModel($this->db);
            $forum = $forumModel->getForumById($id_forum);
        } else {
            $id_forum = 0;
        }
        if (!empty($id_user)) {
            $userModel = new UserModel($this->db);
            $userTopic = $userModel->getUserById($id_user);
        } else {
            $id_user = 0;
        }

        $topicModel = new TopicModel($this->db);

        /* Parametros para implementar la paginación. */
        $limit = 2;
        $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);
        $page = isset($page) ? $page : 1;
        if (isset($_GET["submitFilter"])) {
            $page = 1;
        }
        $start = ($page - 1) * $limit;

        /*
            Se recoge los topics según los parametros de paginación y, en caso de haber, de los filtros.
            Se recoge el numero de paginas según los parametros de paginación y, en caso de haber, de los filtros.
        */
        $topics = $topicModel->getAllTopicsPage($id_forum, $start, $limit, $search, $dateIni, $dateFin, $id_user);
        $topicCount = $topicModel->getPagesTopics($id_forum, $search, $dateIni, $dateFin, $id_user);

        /* Parametros de paginación. */
        $total = $topicCount;
        $pages = ceil($total / $limit);
        $Previous = $page - 1;
        $Next = $page + 1;

        /* Parametros para la creación de la query. */
        if (!empty($query_Forum)) {
            $query_Forum = "&id_forum=" . $id_forum;
        } else {
            $query_Forum = "";
        }
        if (!empty($search)) {
            $search = "&search_keywords=" . $search;
        } else {
            $search = "";
        }
        if (!empty($dateIni)) {
            $dateIni = "&dateIni=" . $dateIni;
        } else {
            $dateIni = "";
        }
        if (!empty($dateFin)) {
            $dateFin = "&dateFin=" . $dateFin;
        } else {
            $dateFin = "";
        }
        if (!empty($query_User)) {
            $query_User = "&id_user=" . $id_user;
        } else {
            $query_User = "";
        }


        require("views/front-office/forum.view.php");
    }

}