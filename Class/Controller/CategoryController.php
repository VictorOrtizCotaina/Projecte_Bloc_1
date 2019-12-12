<?php


namespace App\Controller;

use App\Model\CategoryModel;
use App\Model\UserModel;


class CategoryController extends AbstractController
{
    public function index()
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

        /* Se recogen las categorias para mostrar en la página principal. */
        $categoryModel = new CategoryModel($this->db);
        $categories = $categoryModel->getAllCategories();
        $categoriesNavbar = $categories;

        require("views/front-office/index.view.php");
        return "";
    }

    public function getCategory($id_category)
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

        /* Comprueba que exista un parametro get de id_category para recoger un objecto Categoría. */
            $categoryModel = new CategoryModel($this->db);
            $categoriesNavbar = $categoryModel->getAllCategories();
            $category = $categoryModel->getCategoryById($id_category);

        $propierties = ["category" => $category, "session" => $_SESSION, "user" => $user, "categoriesNavbar" => $categoriesNavbar, "target_dir" => $target_dir, 'title' => "Foro Programacion &bull; " . $category->getTitle()];
        return $this->render('show.category.twig', $propierties);
//        require("views/front-office/category.view.php");

    }

    public function getAdminCategory()
    {
        session_start();

        /* En caso de que se pase el parametro para cerrar sesion, se hace un unset de la sesion y se elimina. */
        if (isset($_GET["cerrar_sesion"]) && $_GET["cerrar_sesion"] === "1") {
            session_unset();
            session_destroy();
        }

        if (isset($_SESSION["user"])) {
            $id = $_SESSION["user"]->getIdUser();

            $userModel = new UserModel($this->db);
            $user = $userModel->getUserById($id);
            $userGroup = $user->getIdUserGroup();
            if ($userGroup != 1) {
                $categoryModel = new CategoryModel($this->db);
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
                $categoryModel = new CategoryModel($this->db);
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

        require("views/back-office/category_list.view.php");
    }


    public function adminCategoryAdd()
    {
        session_start();

        /* En caso de que se pase el parametro para cerrar sesion, se hace un unset de la sesion y se elimina. */
        if (isset($_GET["cerrar_sesion"]) && $_GET["cerrar_sesion"] === "1") {
            session_unset();
            session_destroy();
        }

        $target_dir = $this->config->get('image')['src'];

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


            $categoryModel = new CategoryModel($this->db);
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

    }


    public function adminCategoryEdit($id_category)
    {
        session_start();

        /* En caso de que se pase el parametro para cerrar sesion, se hace un unset de la sesion y se elimina. */
        if (isset($_GET["cerrar_sesion"]) && $_GET["cerrar_sesion"] === "1") {
            session_unset();
            session_destroy();
        }

        $target_dir = $this->config->get('image')['src'];

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
            $url = $_SERVER["PHP_SELF"] . "?page=login";
            header("Location: $url");
        }


        $categoryModel = new CategoryModel($this->db);
        $category = $categoryModel->getCategoryById($id_category);
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
                $category->setIdCategory($id_category);
                $insert = $categoryModel->updateCategory($category);

                if ($insert) {
                    $url = $_SERVER["PHP_SELF"];
                    header("Location: $url");
                }
            }
        }

        require("views/back-office/forms/category_form.view.php");

    }
}