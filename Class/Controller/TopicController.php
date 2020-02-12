<?php

namespace App\Controller;

use App\Model\CategoryModel;
use App\Model\ForumModel;
use App\Model\PostModel;
use App\Model\TopicModel;
use App\Model\UserModel;


class TopicController extends AbstractController
{
    public function getTopic($id_category, $id_forum, $id_topic)
    {
        $target_dir = $this->config->get('image')['src'];

        /* Se comprueba si hay una sessión de usuario creada (se crea al iniciar sessión) y de ser así se añade un objecto usuario. */
        $user = null;
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

        $forumModel = new ForumModel($this->db);
        $forum = $forumModel->getForumById($topic->getIdForum());


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

        $propierties = ["topic" => $topic, "posts" => $posts,"forum" => $forum, "pages" => $pages, "Previous" => $Previous, "Next" => $Next, "session" => $_SESSION, "user" => $user, "url" => $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"], "categoriesNavbar" => $categoriesNavbar, "target_dir" => $target_dir, 'title' => "Foro Programacion • " . $topic->getTitle()];
        return $this->render('topic/show.topic.twig', $propierties);

//        require("../views/front-office/topic.view.php");
    }


    public function getAdminTopic()
    {
        /* Se comprueba si hay una sessión de usuario creada (se crea al iniciar sessión) y de no ser así le envía al login. */
        if (isset($_SESSION["user"])) {
            /* Se recoge el usuario para saber el tipo de usuario. */
            $id = $_SESSION["user"]->getIdUser();
            $userModel = new UserModel($this->db);
            $user = $userModel->getUserById($id);
            $userGroup = $user->getIdUserGroup();

            $forumModel = new ForumModel($this->db);
            $forums = $forumModel->getAllForums();
            if ($userGroup != 1) {
                $id_forum = filter_input(INPUT_GET, 'forums', FILTER_SANITIZE_NUMBER_INT);
                $search = filter_input(INPUT_GET, 'search_keywords', FILTER_SANITIZE_STRING);
                $dateIni = filter_input(INPUT_GET, 'dateIni', FILTER_SANITIZE_STRING);
                $dateFin = filter_input(INPUT_GET, 'dateFin', FILTER_SANITIZE_STRING);

                $search = htmlspecialchars(trim($search));
                $dateIni = htmlspecialchars(trim($dateIni));
                $dateFin = htmlspecialchars(trim($dateFin));

                $id_user = $user->getIdUser();
                $topicModel = new TopicModel($this->db);
                $limit = 2;
                $num_page = filter_input(INPUT_GET, 'num_page', FILTER_SANITIZE_STRING);
                $num_page = isset($num_page) ? $num_page : 1;
                $start = ($num_page - 1) * $limit;

                if (empty($id_forum)) {
                    $id_forum = 0;
                }

                $id_user = $user->getIdUser();
                $topics = $topicModel->getAllTopicsPage($id_forum, $start, $limit, $search, $dateIni, $dateFin, $id_user);
                $topicCount = $topicModel->getPagesTopics($id_forum, $search, $dateIni, $dateFin, $id_user);
                $total = $topicCount;
                $pages = ceil($total / $limit);
                $Previous = $num_page - 1;
                $Next = $num_page + 1;

                if (!empty($forum)) {
                    $forum = "&id_forum=" . $forum;
                } else {
                    $forum = "";
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

            } else {
                /* Parametros de filtrado. */
                $id_forum = filter_input(INPUT_GET, 'forums', FILTER_SANITIZE_NUMBER_INT);
                $search = filter_input(INPUT_GET, 'search_keywords', FILTER_SANITIZE_STRING);
                $dateIni = filter_input(INPUT_GET, 'dateIni', FILTER_SANITIZE_STRING);
                $dateFin = filter_input(INPUT_GET, 'dateFin', FILTER_SANITIZE_STRING);

                if (empty($id_forum)) {
                    $id_forum = 0;
                }

                $search = htmlspecialchars(trim($search));
                $dateIni = htmlspecialchars(trim($dateIni));
                $dateFin = htmlspecialchars(trim($dateFin));

                $topicModel = new TopicModel($this->db);

                /* Parametros para implementar la paginación. */
                $limit = 2;
                $num_page = filter_input(INPUT_GET, 'num_page', FILTER_SANITIZE_STRING);

                $submitFilter = filter_input(INPUT_GET, 'submitFilter', FILTER_SANITIZE_STRING);
                if (!empty($submitFilter)) {
                    $num_page = 1;
                    $_GET["num_page"] = $num_page;
                }

                $num_page = isset($num_page) ? $num_page : 1;

                $start = ($num_page - 1) * $limit;

                /*
                    Se recoge los topics según los parametros de paginación y, en caso de haber, de los filtros.
                    Se recoge el numero de paginas según los parametros de paginación y, en caso de haber, de los filtros.
                */
                $topics = $topicModel->getAllTopicsPage($id_forum, $start, $limit, $search, $dateIni, $dateFin, 0);
                $topicCount = $topicModel->getPagesTopics($id_forum, $search, $dateIni, $dateFin, 0);

                /* Parametros de paginación. */
                $total = $topicCount;
                $pages = ceil($total / $limit);
                $Previous = $num_page - 1;
                $Next = $num_page + 1;

                /* Parametros para la creación de la query. */
                if (!empty($id_forum)) {
                    $id_forum = "&forums=" . $id_forum;
                } else {
                    $id_forum = "";
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
            }
        } else {
            global $route;
            $url = $route->generateURL('User', 'login');
            header("Location: $url");
        }

        require("../views/back-office/topic_list.view.php");

    }

    public function adminTopicAdd()
    {
        $target_dir = $this->config->get('image')['src'];
        global $route;
        $pageForm = $route->generateURL('Topic', 'adminTopicAdd');
        $page = "topic_add";

        /* Se comprueba si hay una sessión de usuario creada (se crea al iniciar sessión) y de no ser así le envía al login. */
        if (isset($_SESSION["user"])) {
            $id = $_SESSION["user"]->getIdUser();
            $userModel = new UserModel($this->db);
            $user = $userModel->getUserById($id);
            $userGroup = $user->getIdUserGroup();
        } else {
            global $route;
            $url = $route->generateURL('User', 'login');
            header("Location: $url");
        }

        /* Variables para los selectores. */
        $forumModel = new ForumModel($this->db);
        $forums = $forumModel->getAllForums();
        $userModel = new UserModel($this->db);
        $users = $userModel->getAllUsers();

        /*
         * Se comprueba que que se envie el formulario POST.
         * Una vez dentro se comprueba que el fichero no ocupe mas de 10Kb, que sea de formato jpg o png, y que exista.
         * Una vez echas las comprobaciones se añade la imagen al fichero, y se añade a la base de datos del usuario.
         */
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

            /*
             * Se añade un topic con los datos.
             * Se validan los datos, y en caso de que no existan errores se añade.
             */
            $topicModel = new TopicModel($this->db);
            $topic = $topicModel->getData();
            $errors = $topicModel->validate($topic);

            if (empty($errors)) {
                $insert = $topicModel->insertTopic($topic);

                if ($insert) {
                    global $route;
                    header('Location: ' . $route->generateURL('Topic', 'getAdminTopic'));
                }
            }
        }

        require("../views/back-office/forms/topic_form.view.php");

    }

    public function adminTopicEdit($id_topic)
    {
        $target_dir = $this->config->get('image')['src'];
        global $route;
        $pageForm = $route->generateURL('Topic', 'adminTopicEdit', ["id_topic" => $id_topic]);
        $page = "topic_edit";

        /* Se comprueba si hay una sessión de usuario creada (se crea al iniciar sessión) y de no ser así le envía al login. */
        if (isset($_SESSION["user"])) {
            $id = $_SESSION["user"]->getIdUser();
            $userModel = new UserModel($this->db);
            $user = $userModel->getUserById($id);
            $userGroup = $user->getIdUserGroup();
        } else {
            global $route;
            $url = $route->generateURL('User', 'login');
            header("Location: $url");
        }
        /* Variables para los selectores. */
        $forumModel = new ForumModel($this->db);
        $forums = $forumModel->getAllForums();
        $userModel = new UserModel($this->db);
        $users = $userModel->getAllUsers();

        /*
         * Se busca el id de topic actual pasado por GET.
         * Se busca un topic con ese id, para rellenar el formulario con esos datos.
         */
        $topicModel = new TopicModel($this->db);
        $topic = $topicModel->getTopicById($id_topic);
        $title = $topic->getTitle();
        $description = $topic->getDescription();
        $image = $target_dir . $topic->getImage();
        $date = $topic->getDateAdd()->format('Y-m-d');
        $id_user = $topic->getIdUser();
        $id_forum = $topic->getIdForum();

        /*
         * Se comprueba que que se envie un formulario POST y que se pulse el botón para añadir la imagen.
         * Una vez dentro se comprueba que el fichero no ocupe mas de 10Kb, que sea de formato jpg o png, y que exista.
         * Una vez echas las comprobaciones se añade la imagen al fichero, y se añade a la base de datos del usuario.
         */
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

            /*
             * Se añade un topic con los datos.
             * Se validan los datos, y en caso de que no existan errores se actualiza.
             */
            $topic = $topicModel->getData();
            $errors = $topicModel->validate($topic);

            if (empty($errors)) {
                $topic->setIdTopic($id_topic);
                $insert = $topicModel->updateTopic($topic);

                if ($insert) {
                    global $route;
                    header('Location: ' . $route->generateURL('Topic', 'getAdminTopic'));
                }
            }
        }

        require("../views/back-office/forms/topic_form.view.php");

    }

    public function adminTopicDelete($id_topic)
    {
        /* Se comprueba si hay una sessión de usuario creada (se crea al iniciar sessión) y de no ser así le envía al login. */
        if (isset($_SESSION["user"])) {
            $id = $_SESSION["user"]->getIdUser();
            $userModel = new UserModel($this->db);
            $user = $userModel->getUserById($id);
            $userGroup = $user->getIdUserGroup();
        } else {
            global $route;
            $url = $route->generateURL('User', 'login');
            header("Location: $url");
        }
        /*
         * En caso de que se pulse sobre el botón de eliminar se comprobara que tiene un id para el topic.
         * En caso de tener se busca el topic, y si se encuentra se procede a ejecutar la función para eliminar/desactivar el topic.
         */
        if (isset($id_topic)) {
            $topicModel = new TopicModel($this->db);
            $topic = $topicModel->getTopicById($id_topic);
            $delete = $topicModel->deleteTopic($topic);
            global $route;
            header('Location: ' . $route->generateURL('Topic', 'getAdminTopic'));
        }

    }

    public function adminTopicActive($id_topic)
    {
        /* Se comprueba si hay una sessión de usuario creada (se crea al iniciar sessión) y de no ser así le envía al login. */
        if (isset($_SESSION["user"])) {
            $id = $_SESSION["user"]->getIdUser();
            $userModel = new UserModel($this->db);
            $user = $userModel->getUserById($id);
            $userGroup = $user->getIdUserGroup();
        } else {
            global $route;
            $url = $route->generateURL('User', 'login');
            header("Location: $url");
        }
        /*
         * En caso de que se pulse sobre el botón de eliminar se comprobara que tiene un id para el topic.
         * En caso de tener se busca el topic, y si se encuentra se procede a ejecutar la función para activar el topic.
         */
        if (isset($id_topic)) {
            $topicModel = new TopicModel($this->db);
            $topic = $topicModel->getTopicById($id_topic);
            $active = $topicModel->activeTopic($topic);
            global $route;
            header('Location: ' . $route->generateURL('Topic', 'getAdminTopic'));
        }

    }
}