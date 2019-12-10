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

        $propierties = ["category" => $category, "target_dir" => $target_dir, 'title' => "Foro Programacion &bull; " . $category->getTitle()];
        return $this->render('show.category.twig', $propierties);
//        require("views/front-office/category.view.php");

    }
}