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
        $target_dir = $this->config->get('image')['src'];

        /* Se comprueba si hay una sessión de usuario creada (se crea al iniciar sessión) y de ser así se añade un objecto usuario. */
        if (isset($_SESSION["user"])) {
            $userModel = new UserModel($this->db);
            $user = $userModel->getUserById($_SESSION["user"]->getIdUser());
        }

        /* Se recogen las categorias para el menú. */
        $categoryModel = new CategoryModel($this->db);
        $categoriesNavbar = $categoryModel->getAllCategories();


        /* Parametros de filtrado. */
        $search = filter_input(INPUT_GET, 'search_keywords', FILTER_SANITIZE_STRING);
        $dateIni = filter_input(INPUT_GET, 'dateIni', FILTER_SANITIZE_STRING);
        $dateFin = filter_input(INPUT_GET, 'dateFin', FILTER_SANITIZE_STRING);

        $search = htmlspecialchars(trim($search));
        $dateIni = htmlspecialchars(trim($dateIni));
        $dateFin = htmlspecialchars(trim($dateFin));

        $forumModel = new ForumModel($this->db);
        $forum = $forumModel->getForumById($id_forum);
        $id_user = 0;

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
/*        if (!empty($query_Forum)) {
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
            $dateFin = "&=" . $dateFin;
        } else {
            $dateFin = "";
        }*/

        require("views/front-office/forum.view.php");
    }

    public function getForumUser($id_user)
    {
        $target_dir = $this->config->get('image')['src'];

        /* Se comprueba si hay una sessión de usuario creada (se crea al iniciar sessión) y de ser así se añade un objecto usuario. */
        if (isset($_SESSION["user"])) {
            $userModel = new UserModel($this->db);
            $user = $userModel->getUserById($_SESSION["user"]->getIdUser());
        }

        /* Se recogen las categorias para el menú. */
        $categoryModel = new CategoryModel($this->db);
        $categoriesNavbar = $categoryModel->getAllCategories();

        /* Parametros de filtrado. */
        $search = filter_input(INPUT_GET, 'search_keywords', FILTER_SANITIZE_STRING);
        $dateIni = filter_input(INPUT_GET, 'dateIni', FILTER_SANITIZE_STRING);
        $dateFin = filter_input(INPUT_GET, 'dateFin', FILTER_SANITIZE_STRING);

        $search = htmlspecialchars(trim($search));
        $dateIni = htmlspecialchars(trim($dateIni));
        $dateFin = htmlspecialchars(trim($dateFin));

        $id_forum = 0;
        $userModel = new UserModel($this->db);
        $userTopic = $userModel->getUserById($id_user);

        $forumModel = new ForumModel($this->db);

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


        require("views/front-office/forum.view.php");
    }


    public function getAdminForum()
    {
        if (isset($_SESSION["user"])) {
            $id = $_SESSION["user"]->getIdUser();
            $userModel = new UserModel($this->db);
            $user = $userModel->getUserById($id);
            $userGroup = $user->getIdUserGroup();
            if ($userGroup != 1) {
                $forumModel = new ForumModel($this->db);
                $limit = 2;
                $num_page = isset($_GET['num_page']) ? $_GET['num_page'] : 1;
                $start = ($num_page - 1) * $limit;

                $forums = $forumModel->getForumsPageByUser($start, $limit, $user->getIdUser());
                $forumCount = $forumModel->getPagesForumsByUser($user->getIdUser());
                $total = $forumCount;
                $pages = ceil($total / $limit);
                $Previous = $num_page - 1;
                $Next = $num_page + 1;
            } else {
                $forumModel = new ForumModel($this->db);
                $limit = 2;
                $num_page = isset($_GET['num_page']) ? $_GET['num_page'] : 1;
                $start = ($num_page - 1) * $limit;

                $forums = $forumModel->getAllForumsPage($start, $limit);
                $forumCount = $forumModel->getPagesForums();
                $total = $forumCount;
                $pages = ceil($total / $limit);
                $Previous = $num_page - 1;
                $Next = $num_page + 1;
            }
        } else {
            global $route;
            $url = $route->generateURL('User', 'login');
            header("Location: $url");
        }

        require("views/back-office/forum_list.view.php");
    }


    public function adminForumAdd()
    {
        $target_dir = $this->config->get('image')['src'];
        global $route;
        $pageForm = $route->generateURL('Forum', 'adminForumAdd');
        $page = "forum_add";

        if (isset($_SESSION["user"])) {
            $id = $_SESSION["user"]->getIdUser();
            $userModel = new UserModel($this->db);
            $user = $userModel->getUserById($id);
            $userGroup = $user->getIdUserGroup();
            if ($userGroup != 1) {
                global $route;
                header('Location: ' . $route->generateURL('Forum', 'getAdminForum'));
            }
        } else {
            global $route;
            $url = $route->generateURL('User', 'login');
            header("Location: $url");
        }


        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["image"])) {
                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                $uploadOk = 0;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                if ($_FILES["image"]["size"] > 0 && $_FILES["image"]["size"] < 100000) {
                    $uploadOk = 1;
                }
                if ($imageFileType == "jpg" && $imageFileType == "png") {
                    $uploadOk = 1;
                }
                $check = getimagesize($_FILES["image"]["tmp_name"]);
                if ($check !== false) {
                    $uploadOk = 1;
                } else {
                    $uploadOk = 0;
                }
                if ($uploadOk) {
                    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
                }
            }


            $forumModel = new ForumModel($this->db);
            $forum = $forumModel->getData();
            $errors = $forumModel->validate($forum);

            if (!($errors)) {
                $insert = $forumModel->insertForum($forum);

                if ($insert) {
                    global $route;
                    header('Location: ' . $route->generateURL('Forum', 'getAdminForum'));
                }
            }
        }

        require("views/back-office/forms/forum_form.view.php");
    }


    public function adminForumEdit($id_forum)
    {
        $target_dir = $this->config->get('image')['src'];
        global $route;
        $pageForm = $route->generateURL('Forum', 'adminForumEdit', ["id_forum" => $id_forum]);
        $page = "forum_edit";

        if (isset($_SESSION["user"])) {
            $id = $_SESSION["user"]->getIdUser();
            $userModel = new UserModel($this->db);
            $user = $userModel->getUserById($id);
            $userGroup = $user->getIdUserGroup();
            if ($userGroup != 1) {
                $url = $_SERVER["PHP_SELF"];
                header("Location: $url");
            }
        } else {
            global $route;
            $url = $route->generateURL('User', 'login');
            header("Location: $url");
        }


        $forumModel = new ForumModel($this->db);
        $forum = $forumModel->getForumById($id_forum);
        $title = $forum->getTitle();
        $description = $forum->getDescription();
        $image = $target_dir . $forum->getImage();
        $date = $forum->getDateAdd()->format('Y-m-d');
        $id_user = $forum->getIdUser();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["image"])) {
                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                $uploadOk = 0;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                if ($_FILES["image"]["size"] > 0 && $_FILES["image"]["size"] < 100000) {
                    $uploadOk = 1;
                }
                if ($imageFileType == "jpg" && $imageFileType == "png") {
                    $uploadOk = 1;
                }
                $check = getimagesize($_FILES["image"]["tmp_name"]);
                if ($check !== false) {
                    $uploadOk = 1;
                } else {
                    $uploadOk = 0;
                }
                if ($uploadOk) {
                    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
                }
            }

            $forumModel = new ForumModel($this->db);
            $forum = $forumModel->getData();
            $errors = $forumModel->validate($forum);

            if (!empty($errors)) {
                $forum->setIdForum($id_forum);
                $insert = $forumModel->updateForum($forum);

                if ($insert) {
                    global $route;
                    header('Location: ' . $route->generateURL('Forum', 'getAdminForum'));
                }
            }
        }

        require("views/back-office/forms/forum_form.view.php");
    }


    public function adminForumDelete($id_forum)
    {
        if (isset($_SESSION["user"])) {
            $id = $_SESSION["user"]->getIdUser();
            $userModel = new UserModel($this->db);
            $user = $userModel->getUserById($id);
            $userGroup = $user->getIdUserGroup();
            if ($userGroup != 1) {
                $url = $_SERVER["PHP_SELF"];
                header("Location: $url");
            }
        } else {
            global $route;
            $url = $route->generateURL('User', 'login');
            header("Location: $url");
        }
        if (isset($id_forum)) {
            $forumModel = new ForumModel($this->db);
            $forum = $forumModel->getForumById($id_forum);
            $delete = $forumModel->deleteForum($forum);
            global $route;
            header('Location: ' . $route->generateURL('Forum', 'getAdminForum'));
        }
    }


    public function adminForumActive($id_forum)
    {
        if (isset($_SESSION["user"])) {
            $id = $_SESSION["user"]->getIdUser();
            $userModel = new UserModel($this->db);
            $user = $userModel->getUserById($id);
            $userGroup = $user->getIdUserGroup();
            if ($userGroup != 1) {
                $url = $_SERVER["PHP_SELF"];
                header("Location: $url");
            }
        } else {
            global $route;
            $url = $route->generateURL('User', 'login');
            header("Location: $url");
        }
        if (isset($id_forum)) {
            $forumModel = new ForumModel($this->db);
            $forum = $forumModel->getForumById($id_forum);
            $active = $forumModel->activeForum($forum);
            global $route;
            header('Location: ' . $route->generateURL('Forum', 'getAdminForum'));
        }
    }

}