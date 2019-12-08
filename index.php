<?php

use App\Entity\Category;
use App\Entity\Forum;
use App\Entity\Post;
use App\Entity\Topic;
use App\Entity\User;

use App\Model\CategoryModel;
use App\Model\ForumModel;
use App\Model\PostModel;
use App\Model\TopicModel;
use App\Model\UserModel;
use App\Core\Router;
use App\Core\Config;
use App\Core\Request;

use App\DBConnection;

require __DIR__ . '/config/bootstrap.php';

$di = new \App\Utils\DependencyInjector();

$db = new DBConnection();
$di->set('PDO', $db->getConnection());

$config = new Config();
$di->set("Config", $config);

$request = new Request();

$route = new Router($di);
$route->route($request);

$page = $_GET['action'] ?? "indexARR";


require __DIR__ . "/Class/Controller/validateForm.php";

$fichero = file_get_contents("./config/config.json", true);
$imageConf = json_decode($fichero, true);
$target_dir = $imageConf["image"]["src"];

switch ($page) {
    case "index":
        {
            break;
        };
    case "category":
        {
            break;
        };
    case "forum":
        {
            break;
        };
    case "topic":
        {
            break;
        };
    case "user":
        {
            break;
        };
    case "login":
        {
            break;
        };
    case "register":
        {
            break;
        };


    case "category_list":
        {
            session_start();

            /* En caso de que se pase el parametro para cerrar sesion, se hace un unset de la sesion y se elimina. */
            if (isset($_GET["cerrar_sesion"]) && $_GET["cerrar_sesion"] === "1") {
                session_unset();
                session_destroy();
            }

            if (isset($_SESSION["user"])) {
                $id = $_SESSION["user"]->getIdUser();
                $pdo = new DBConnection();
                $userModel = new UserModel($pdo->getConnection());
                $user = $userModel->getUserById($id);
                $userGroup = $user->getIdUserGroup();
                if ($userGroup != 1) {
                    $categoryModel = new CategoryModel($pdo->getConnection());
                    $categories = $categoryModel->getCategoryByUser($id);
                    $limit = 2;
                    $num_page = isset($_GET['num_page']) ? $_GET['num_page'] : 1;
                    $start = ($num_page - 1) * $limit;

                    $categories = $categoryModel->getCategoriesPageByUser($start, $limit, $user->getIdUser());
                    $categoryCount = $categoryModel->getPagesCategoriesByUser($user->getIdUser());

                    $total = $categoryCount;
                    $pages = ceil($total / $limit);
                    $Previous = $num_page - 1;
                    $Next = $num_page + 1;
                } else {
                    $categoryModel = new CategoryModel($pdo->getConnection());
//                    $categories = $categoryModel->getAllCategories();
                    $limit = 2;
                    $num_page = isset($_GET['num_page']) ? $_GET['num_page'] : 1;
                    $start = ($num_page - 1) * $limit;

                    $categories = $categoryModel->getAllCategoriesPage($start, $limit);
                    $categoryCount = $categoryModel->getPagesCategories();

                    $total = $categoryCount;
                    $pages = ceil($total / $limit);
                    $Previous = $num_page - 1;
                    $Next = $num_page + 1;
                }
            } else {
                $url = $_SERVER["PHP_SELF"] . "?page=login";
                header("Location: $url");
            }

            require("views/back-office/$page.view.php");
            break;
        };
    case "category_add":
        {
            session_start();

            /* En caso de que se pase el parametro para cerrar sesion, se hace un unset de la sesion y se elimina. */
            if (isset($_GET["cerrar_sesion"]) && $_GET["cerrar_sesion"] === "1") {
                session_unset();
                session_destroy();
            }

            $pdo = new DBConnection();

            if (isset($_SESSION["user"])) {
                $id = $_SESSION["user"]->getIdUser();
                $userModel = new UserModel($pdo->getConnection());
                $user = $userModel->getUserById($id);
                $userGroup = $user->getIdUserGroup();
                if ($userGroup != 1) {
                    $url = $_SERVER["PHP_SELF"];
                    header("Location: $url");
                }
            } else {
                $url = $_SERVER["PHP_SELF"] . "?page=login";
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


                $categoryModel = new CategoryModel($pdo->getConnection());
                $category = $categoryModel->getData();
                $errors = $categoryModel->validate($category);

                if (empty($errors)) {
                    $insert = $categoryModel->insertCategory($category);

                    if ($insert) {
                        $url = $_SERVER["PHP_SELF"];
                        header("Location: $url");
                    }
                }
            }

            require("views/back-office/forms/category_form.view.php");
            break;
        };
    case "category_edit":
        {
            session_start();

            /* En caso de que se pase el parametro para cerrar sesion, se hace un unset de la sesion y se elimina. */
            if (isset($_GET["cerrar_sesion"]) && $_GET["cerrar_sesion"] === "1") {
                session_unset();
                session_destroy();
            }

            $pdo = new DBConnection();

            if (isset($_SESSION["user"])) {
                $id = $_SESSION["user"]->getIdUser();
                $userModel = new UserModel($pdo->getConnection());
                $user = $userModel->getUserById($id);
                $userGroup = $user->getIdUserGroup();
                if ($userGroup != 1) {
                    $url = $_SERVER["PHP_SELF"];
                    header("Location: $url");
                }
            } else {
                $url = $_SERVER["PHP_SELF"] . "?page=login";
                header("Location: $url");
            }


            $id_cat = $_GET['id_category'];
            $categoryModel = new CategoryModel($pdo->getConnection());
            $category = $categoryModel->getCategoryById($id_cat);
            $title = $category->getTitle();
            $description = $category->getDescription();
            $image = $target_dir . $category->getImage();
            $date = $category->getDateAdd()->format('Y-m-d');
            $id_user = $category->getIdUser();


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


                $category = $categoryModel->getData();
                $errors = $categoryModel->validate($category);

                if (empty($errors)) {
                    $category->setIdCategory($id_cat);
                    $insert = $categoryModel->updateCategory($category);

                    if ($insert) {
                        $url = $_SERVER["PHP_SELF"];
                        header("Location: $url");
                    }
                }
            }

            require("views/back-office/forms/category_form.view.php");
            break;
        };
    case "category_delete":
        {
            session_start();

            /* En caso de que se pase el parametro para cerrar sesion, se hace un unset de la sesion y se elimina. */
            if (isset($_GET["cerrar_sesion"]) && $_GET["cerrar_sesion"] === "1") {
                session_unset();
                session_destroy();
            }

            $pdo = new DBConnection();

            if (isset($_SESSION["user"])) {
                $id = $_SESSION["user"]->getIdUser();
                $userModel = new UserModel($pdo->getConnection());
                $user = $userModel->getUserById($id);
                $userGroup = $user->getIdUserGroup();
                if ($userGroup != 1) {
                    $url = $_SERVER["PHP_SELF"];
                    header("Location: $url");
                }
            } else {
                $url = $_SERVER["PHP_SELF"] . "?page=login";
                header("Location: $url");
            }
            if (isset($_GET['id_category'])) {
                $id_cat = filter_input(INPUT_GET, 'id_category', FILTER_SANITIZE_NUMBER_INT);
                $categoryModel = new CategoryModel($pdo->getConnection());
                $category = $categoryModel->getCategoryById($id_cat);
                $delete = $categoryModel->deleteCategory($category);
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
            break;
        };
    case "category_active":
        {
            session_start();

            /* En caso de que se pase el parametro para cerrar sesion, se hace un unset de la sesion y se elimina. */
            if (isset($_GET["cerrar_sesion"]) && $_GET["cerrar_sesion"] === "1") {
                session_unset();
                session_destroy();
            }

            $pdo = new DBConnection();

            if (isset($_SESSION["user"])) {
                $id = $_SESSION["user"]->getIdUser();
                $userModel = new UserModel($pdo->getConnection());
                $user = $userModel->getUserById($id);
                $userGroup = $user->getIdUserGroup();
                if ($userGroup != 1) {
                    $url = $_SERVER["PHP_SELF"];
                    header("Location: $url");
                }
            } else {
                $url = $_SERVER["PHP_SELF"] . "?page=login";
                header("Location: $url");
            }
            if (isset($_GET['id_category'])) {
                $id_cat = filter_input(INPUT_GET, 'id_category', FILTER_SANITIZE_NUMBER_INT);
                $categoryModel = new CategoryModel($pdo->getConnection());
                $category = $categoryModel->getCategoryById($id_cat);
                $active = $categoryModel->activeCategory($category);
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
            break;
        };

    case "forum_list":
        {
            session_start();

            /* En caso de que se pase el parametro para cerrar sesion, se hace un unset de la sesion y se elimina. */
            if (isset($_GET["cerrar_sesion"]) && $_GET["cerrar_sesion"] === "1") {
                session_unset();
                session_destroy();
            }

            if (isset($_SESSION["user"])) {
                $id = $_SESSION["user"]->getIdUser();
                $pdo = new DBConnection();
                $userModel = new UserModel($pdo->getConnection());
                $user = $userModel->getUserById($id);
                $userGroup = $user->getIdUserGroup();
                if ($userGroup != 1) {
                    $forumModel = new ForumModel($pdo->getConnection());
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
                    $forumModel = new ForumModel($pdo->getConnection());
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
                $url = $_SERVER["PHP_SELF"] . "?page=login";
                header("Location: $url");
            }

            require("views/back-office/$page.view.php");
            break;
        };
    case "forum_add":
        {
            session_start();

            /* En caso de que se pase el parametro para cerrar sesion, se hace un unset de la sesion y se elimina. */
            if (isset($_GET["cerrar_sesion"]) && $_GET["cerrar_sesion"] === "1") {
                session_unset();
                session_destroy();
            }

            $pdo = new DBConnection();

            if (isset($_SESSION["user"])) {
                $id = $_SESSION["user"]->getIdUser();
                $userModel = new UserModel($pdo->getConnection());
                $user = $userModel->getUserById($id);
                $userGroup = $user->getIdUserGroup();
                if ($userGroup != 1) {
                    $url = $_SERVER["PHP_SELF"];
                    header("Location: $url");
                }
            } else {
                $url = $_SERVER["PHP_SELF"] . "?page=login";
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


                $forumModel = new ForumModel($pdo->getConnection());
                $forum = $forumModel->getData();
                $errors = $forumModel->validate($forum);

                if (!($errors)) {
                    $insert = $forumModel->insertForum($forum);

                    if ($insert) {
                        $url = $_SERVER["PHP_SELF"] . "?page=forum_list";
                        header("Location: $url");
                    }
                }
            }

            require("views/back-office/forms/forum_form.view.php");
            break;
        };
    case "forum_edit":
        {
            session_start();

            /* En caso de que se pase el parametro para cerrar sesion, se hace un unset de la sesion y se elimina. */
            if (isset($_GET["cerrar_sesion"]) && $_GET["cerrar_sesion"] === "1") {
                session_unset();
                session_destroy();
            }

            $pdo = new DBConnection();

            if (isset($_SESSION["user"])) {
                $id = $_SESSION["user"]->getIdUser();
                $userModel = new UserModel($pdo->getConnection());
                $user = $userModel->getUserById($id);
                $userGroup = $user->getIdUserGroup();
                if ($userGroup != 1) {
                    $url = $_SERVER["PHP_SELF"];
                    header("Location: $url");
                }
            } else {
                $url = $_SERVER["PHP_SELF"] . "?page=login";
                header("Location: $url");
            }


            $id_forum = filter_input(INPUT_GET, 'id_forum', FILTER_SANITIZE_NUMBER_INT);
            $forumModel = new ForumModel($pdo->getConnection());
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

                $forumModel = new ForumModel($pdo->getConnection());
                $forum = $forumModel->getData();
                $errors = $forumModel->validate($forum);

                if (!empty($errors)) {
                    $forum->setIdForum($id_forum);
                    $insert = $forumModel->updateForum($forum);

                    if ($insert) {
                        $url = $_SERVER["PHP_SELF"] . "?page=forum_list";
                        header("Location: $url");
                    }
                }
            }

            require("views/back-office/forms/forum_form.view.php");
            break;
        };
    case "forum_delete":
        {
            session_start();

            /* En caso de que se pase el parametro para cerrar sesion, se hace un unset de la sesion y se elimina. */
            if (isset($_GET["cerrar_sesion"]) && $_GET["cerrar_sesion"] === "1") {
                session_unset();
                session_destroy();
            }

            $pdo = new DBConnection();

            if (isset($_SESSION["user"])) {
                $id = $_SESSION["user"]->getIdUser();
                $userModel = new UserModel($pdo->getConnection());
                $user = $userModel->getUserById($id);
                $userGroup = $user->getIdUserGroup();
                if ($userGroup != 1) {
                    $url = $_SERVER["PHP_SELF"];
                    header("Location: $url");
                }
            } else {
                $url = $_SERVER["PHP_SELF"] . "?page=login";
                header("Location: $url");
            }
            if (isset($_GET['id_forum'])) {
                $id_forum = filter_input(INPUT_GET, 'id_forum', FILTER_SANITIZE_NUMBER_INT);
                $forumModel = new ForumModel($pdo->getConnection());
                $forum = $forumModel->getForumById($id_forum);
                $delete = $forumModel->deleteForum($forum);
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
            break;
        };
    case "forum_active":
        {
            session_start();

            /* En caso de que se pase el parametro para cerrar sesion, se hace un unset de la sesion y se elimina. */
            if (isset($_GET["cerrar_sesion"]) && $_GET["cerrar_sesion"] === "1") {
                session_unset();
                session_destroy();
            }

            $pdo = new DBConnection();

            if (isset($_SESSION["user"])) {
                $id = $_SESSION["user"]->getIdUser();
                $userModel = new UserModel($pdo->getConnection());
                $user = $userModel->getUserById($id);
                $userGroup = $user->getIdUserGroup();
                if ($userGroup != 1) {
                    $url = $_SERVER["PHP_SELF"];
                    header("Location: $url");
                }
            } else {
                $url = $_SERVER["PHP_SELF"] . "?page=login";
                header("Location: $url");
            }
            if (isset($_GET['id_forum'])) {
                $id_forum = filter_input(INPUT_GET, 'id_forum', FILTER_SANITIZE_NUMBER_INT);
                $forumModel = new ForumModel($pdo->getConnection());
                $forum = $forumModel->getForumById($id_forum);
                $active = $forumModel->activeForum($forum);
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
            break;
        };

    case "topic_list":
        {
            session_start();

            /* En caso de que se pase el parametro para cerrar sesion, se hace un unset de la sesion y se elimina. */
            if (isset($_GET["cerrar_sesion"]) && $_GET["cerrar_sesion"] === "1") {
                session_unset();
                session_destroy();
            }

            /* Se comprueba si hay una sessión de usuario creada (se crea al iniciar sessión) y de no ser así le envía al login. */
            if (isset($_SESSION["user"])) {
                /* Se recoge el usuario para saber el tipo de usuario. */
                $id = $_SESSION["user"]->getIdUser();
                $pdo = new DBConnection();
                $userModel = new UserModel($pdo->getConnection());
                $user = $userModel->getUserById($id);
                $userGroup = $user->getIdUserGroup();

                $forumModel = new ForumModel($pdo->getConnection());
                $forums = $forumModel->getAllForums();
                if ($userGroup != 1) {
                    $forum = filter_input(INPUT_GET, 'forums', FILTER_SANITIZE_STRING);
                    $search = filter_input(INPUT_GET, 'search_keywords', FILTER_SANITIZE_STRING);
                    $dateIni = filter_input(INPUT_GET, 'dateIni', FILTER_SANITIZE_STRING);
                    $dateFin = filter_input(INPUT_GET, 'dateFin', FILTER_SANITIZE_STRING);

                    $search = htmlspecialchars(trim($search));
                    $dateIni = htmlspecialchars(trim($dateIni));
                    $dateFin = htmlspecialchars(trim($dateFin));

                    $id_user = $user->getIdUser();
                    $topicModel = new TopicModel($pdo->getConnection());
                    $limit = 2;
                    $num_page = filter_input(INPUT_GET, 'num_page', FILTER_SANITIZE_STRING);
                    $num_page = isset($num_page) ? $num_page : 1;
                    $start = ($num_page - 1) * $limit;

                    if (!empty($forum)) {
                        $forum = 0;
                    }

                    $id_user = $user->getIdUser();
                    $topics = $topicModel->getAllTopicsPage($forum, $start, $limit, $search, $dateIni, $dateFin, $id_user);
                    $topicCount = $topicModel->getPagesTopics($forum, $search, $dateIni, $dateFin, $id_user);
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
                    $forum = filter_input(INPUT_GET, 'forums', FILTER_SANITIZE_NUMBER_INT);
                    $search = filter_input(INPUT_GET, 'search_keywords', FILTER_SANITIZE_STRING);
                    $dateIni = filter_input(INPUT_GET, 'dateIni', FILTER_SANITIZE_STRING);
                    $dateFin = filter_input(INPUT_GET, 'dateFin', FILTER_SANITIZE_STRING);

                    if (empty($forum)) {
                        $forum = 0;
                    }

                    $search = htmlspecialchars(trim($search));
                    $dateIni = htmlspecialchars(trim($dateIni));
                    $dateFin = htmlspecialchars(trim($dateFin));

                    $topicModel = new TopicModel($pdo->getConnection());

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
                    $topics = $topicModel->getAllTopicsPage($forum, $start, $limit, $search, $dateIni, $dateFin, 0);
                    $topicCount = $topicModel->getPagesTopics($forum, $search, $dateIni, $dateFin, 0);

                    /* Parametros de paginación. */
                    $total = $topicCount;
                    $pages = ceil($total / $limit);
                    $Previous = $num_page - 1;
                    $Next = $num_page + 1;

                    /* Parametros para la creación de la query. */
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
                }
            } else {
                $url = $_SERVER["PHP_SELF"] . "?page=login";
                header("Location: $url");
            }

            require("views/back-office/$page.view.php");
            break;
        };
    case "topic_add":
        {
            session_start();

            /* En caso de que se pase el parametro para cerrar sesion, se hace un unset de la sesion y se elimina. */
            if (isset($_GET["cerrar_sesion"]) && $_GET["cerrar_sesion"] === "1") {
                session_unset();
                session_destroy();
            }

            $pdo = new DBConnection();

            /* Se comprueba si hay una sessión de usuario creada (se crea al iniciar sessión) y de no ser así le envía al login. */
            if (isset($_SESSION["user"])) {
                $id = $_SESSION["user"]->getIdUser();
                $userModel = new UserModel($pdo->getConnection());
                $user = $userModel->getUserById($id);
                $userGroup = $user->getIdUserGroup();
            } else {
                $url = $_SERVER["PHP_SELF"] . "?page=login";
                header("Location: $url");
            }

            /* Variables para los selectores. */
            $forumModel = new ForumModel($pdo->getConnection());
            $forums = $forumModel->getAllForums();
            $userModel = new UserModel($pdo->getConnection());
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
                $topicModel = new TopicModel($pdo->getConnection());
                $topic = $topicModel->getData();
                $errors = $topicModel->validate($topic);

                if (empty($errors)) {
                    $insert = $topicModel->insertTopic($topic);

                    if ($insert) {
                        $url = $_SERVER["PHP_SELF"] . "?page=topic_list";
                        header("Location: $url");
                    }
                }
            }

            require("views/back-office/forms/topic_form.view.php");
            break;
        };
    case "topic_edit":
        {
            session_start();

            /* En caso de que se pase el parametro para cerrar sesion, se hace un unset de la sesion y se elimina. */
            if (isset($_GET["cerrar_sesion"]) && $_GET["cerrar_sesion"] === "1") {
                session_unset();
                session_destroy();
            }

            $pdo = new DBConnection();

            /* Se comprueba si hay una sessión de usuario creada (se crea al iniciar sessión) y de no ser así le envía al login. */
            if (isset($_SESSION["user"])) {
                $id = $_SESSION["user"]->getIdUser();
                $userModel = new UserModel($pdo->getConnection());
                $user = $userModel->getUserById($id);
                $userGroup = $user->getIdUserGroup();
            } else {
                $url = $_SERVER["PHP_SELF"] . "?page=login";
                header("Location: $url");
            }
            /* Variables para los selectores. */
            $forumModel = new ForumModel($pdo->getConnection());
            $forums = $forumModel->getAllForums();
            $userModel = new UserModel($pdo->getConnection());
            $users = $userModel->getAllUsers();

            /*
             * Se busca el id de topic actual pasado por GET.
             * Se busca un topic con ese id, para rellenar el formulario con esos datos.
             */
            $id_topic = filter_input(INPUT_GET, 'id_topic', FILTER_SANITIZE_NUMBER_INT);
            $topicModel = new TopicModel($pdo->getConnection());
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
                        $url = $_SERVER["PHP_SELF"] . "?page=topic_list";
                        header("Location: $url");
                    }
                }
            }

            require("views/back-office/forms/topic_form.view.php");
            break;
        };
    case "topic_delete":
        {
            session_start();

            /* En caso de que se pase el parametro para cerrar sesion, se hace un unset de la sesion y se elimina. */
            if (isset($_GET["cerrar_sesion"]) && $_GET["cerrar_sesion"] === "1") {
                session_unset();
                session_destroy();
            }

            $pdo = new DBConnection();

            /* Se comprueba si hay una sessión de usuario creada (se crea al iniciar sessión) y de no ser así le envía al login. */
            if (isset($_SESSION["user"])) {
                $id = $_SESSION["user"]->getIdUser();
                $userModel = new UserModel($pdo->getConnection());
                $user = $userModel->getUserById($id);
                $userGroup = $user->getIdUserGroup();
            } else {
                $url = $_SERVER["PHP_SELF"] . "?page=login";
                header("Location: $url");
            }
            /*
             * En caso de que se pulse sobre el botón de eliminar se comprobara que tiene un id para el topic.
             * En caso de tener se busca el topic, y si se encuentra se procede a ejecutar la función para eliminar/desactivar el topic.
             */
            if (isset($_GET['id_topic'])) {
                $id_topic = filter_input(INPUT_GET, 'id_topic', FILTER_SANITIZE_NUMBER_INT);
                $topicModel = new TopicModel($pdo->getConnection());
                $topic = $topicModel->getTopicById($id_topic);
                $delete = $topicModel->deleteTopic($topic);
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
            break;
        };
    case "topic_active":
        {
            session_start();

            /* En caso de que se pase el parametro para cerrar sesion, se hace un unset de la sesion y se elimina. */
            if (isset($_GET["cerrar_sesion"]) && $_GET["cerrar_sesion"] === "1") {
                session_unset();
                session_destroy();
            }

            $pdo = new DBConnection();

            /* Se comprueba si hay una sessión de usuario creada (se crea al iniciar sessión) y de no ser así le envía al login. */
            if (isset($_SESSION["user"])) {
                $id = $_SESSION["user"]->getIdUser();
                $userModel = new UserModel($pdo->getConnection());
                $user = $userModel->getUserById($id);
                $userGroup = $user->getIdUserGroup();
            } else {
                $url = $_SERVER["PHP_SELF"] . "?page=login";
                header("Location: $url");
            }
            /*
             * En caso de que se pulse sobre el botón de eliminar se comprobara que tiene un id para el topic.
             * En caso de tener se busca el topic, y si se encuentra se procede a ejecutar la función para activar el topic.
             */
            if (isset($_GET['id_topic'])) {
                $id_topic = filter_input(INPUT_GET, 'id_topic', FILTER_SANITIZE_NUMBER_INT);
                $topicModel = new TopicModel($pdo->getConnection());
                $topic = $topicModel->getTopicById($id_topic);
                $active = $topicModel->activeTopic($topic);
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
            break;
        };

    case "post_list":
        {
            session_start();

            /* En caso de que se pase el parametro para cerrar sesion, se hace un unset de la sesion y se elimina. */
            if (isset($_GET["cerrar_sesion"]) && $_GET["cerrar_sesion"] === "1") {
                session_unset();
                session_destroy();
            }

            if (isset($_SESSION["user"])) {
                $id = $_SESSION["user"]->getIdUser();
                $pdo = new DBConnection();
                $userModel = new UserModel($pdo->getConnection());
                $user = $userModel->getUserById($id);
                $userGroup = $user->getIdUserGroup();
                if ($userGroup != 1) {
                    $id_user = $user->getIdUser();
                    $postModel = new PostModel($pdo->getConnection());
                    $limit = 2;
                    $num_page = isset($_GET['num_page']) ? $_GET['num_page'] : 1;
                    $start = ($num_page - 1) * $limit;

                    $posts = $postModel->getPostsPageByUser($id_user, $start, $limit);
                    $postCount = $postModel->getPagesPostsByUser($id_user);
                    $total = $postCount;
                    $pages = ceil($total / $limit);
                    $Previous = $num_page - 1;
                    $Next = $num_page + 1;
                } else {
                    $postModel = new PostModel($pdo->getConnection());

                    $limit = 2;
                    $num_page = isset($_GET['num_page']) ? $_GET['num_page'] : 1;
                    $start = ($num_page - 1) * $limit;

                    $posts = $postModel->getAllPostsPage($start, $limit);
                    $postCount = $postModel->getPagesPosts();

                    $total = $postCount;
                    $pages = ceil($total / $limit);
                    $Previous = $num_page - 1;
                    $Next = $num_page + 1;
                }
            } else {
                $url = $_SERVER["PHP_SELF"] . "?page=login";
                header("Location: $url");
            }

            require("views/back-office/$page.view.php");
            break;
        };
    case "post_add":
        {
            session_start();

            /* En caso de que se pase el parametro para cerrar sesion, se hace un unset de la sesion y se elimina. */
            if (isset($_GET["cerrar_sesion"]) && $_GET["cerrar_sesion"] === "1") {
                session_unset();
                session_destroy();
            }

            $pdo = new DBConnection();

            if (isset($_SESSION["user"])) {
                $id = $_SESSION["user"]->getIdUser();
                $userModel = new UserModel($pdo->getConnection());
                $user = $userModel->getUserById($id);
                $userGroup = $user->getIdUserGroup();
            } else {
                $url = $_SERVER["PHP_SELF"] . "?page=login";
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

                $postModel = new PostModel($pdo->getConnection());
                $post = $postModel->getData();
                $errors = $postModel->validate($post);

                if (!empty($errors)) {
                    $insert = $postModel->insertPost($post);

                    if ($insert) {
                        $url = $_SERVER["PHP_SELF"] . "?page=topic_list";
                        header("Location: $url");
                    }
                }
            }

            require("views/back-office/forms/post_form.view.php");
            break;
        };
    case "post_edit":
        {
            session_start();

            /* En caso de que se pase el parametro para cerrar sesion, se hace un unset de la sesion y se elimina. */
            if (isset($_GET["cerrar_sesion"]) && $_GET["cerrar_sesion"] === "1") {
                session_unset();
                session_destroy();
            }

            $pdo = new DBConnection();

            if (isset($_SESSION["user"])) {
                $id = $_SESSION["user"]->getIdUser();
                $userModel = new UserModel($pdo->getConnection());
                $user = $userModel->getUserById($id);
                $userGroup = $user->getIdUserGroup();
            } else {
                $url = $_SERVER["PHP_SELF"] . "?page=login";
                header("Location: $url");
            }


            $id_post = filter_input(INPUT_GET, 'id_post', FILTER_SANITIZE_NUMBER_INT);
            $postModel = new PostModel($pdo->getConnection());
            $post = $postModel->getPostById($id_post);
            $title = $post->getTitle();
            $text = $post->getText();
            $image = $target_dir . $post->getImage();
            $date = $post->getDateAdd()->format('Y-m-d');
            $id_user = $post->getIdUser();
            $id_category = $post->getIdCategory();
            $id_forum = $post->getIdForum();
            $id_topic = $post->getIdTopic();


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

                $post = $postModel->getData();
                $errors = $postModel->validate($post);

                if (!empty($errors)) {
                    $post->setIdPost($id_post);
                    $insert = $postModel->updatePost($post);

                    if ($insert) {
                        $url = $_SERVER["PHP_SELF"] . "?page=topic_list";
                        header("Location: $url");
                    }
                }
            }

            require("views/back-office/forms/post_form.view.php");
            break;
        };
    case "post_delete":
        {
            session_start();

            /* En caso de que se pase el parametro para cerrar sesion, se hace un unset de la sesion y se elimina. */
            if (isset($_GET["cerrar_sesion"]) && $_GET["cerrar_sesion"] === "1") {
                session_unset();
                session_destroy();
            }

            $pdo = new DBConnection();

            if (isset($_SESSION["user"])) {
                $id = $_SESSION["user"]->getIdUser();
                $userModel = new UserModel($pdo->getConnection());
                $user = $userModel->getUserById($id);
                $userGroup = $user->getIdUserGroup();
            } else {
                $url = $_SERVER["PHP_SELF"] . "?page=login";
                header("Location: $url");
            }
            if (isset($_GET['id_post'])) {
                $id_post = filter_input(INPUT_GET, 'id_post', FILTER_SANITIZE_NUMBER_INT);
                $postModel = new PostModel($pdo->getConnection());
                $post = $postModel->getPostById($id_post);
                $delete = $postModel->deletePost($post);
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
            break;
        };

    default:
        {
            // require("views/error.view.php");
        };

}