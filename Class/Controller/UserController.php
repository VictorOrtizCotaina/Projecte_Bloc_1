<?php

namespace App\Controller;

use App\Model\CategoryModel;
use App\Model\ForumModel;
use App\Model\TopicModel;
use App\Model\UserModel;
use App\Core\Router;


class UserController extends AbstractController
{
    public function login()
    {

        session_start();

        /* Se recogen las categorias para el menú. */
        $categoryModel = new CategoryModel($this->db);
        $categoriesNavbar = $categoryModel->getAllCategories();

        /*
         * Se comprueba que se ha enviado el formulario.
         * Se recogen los parametros POST de email y password.
         * Se comprueba que el email o el password no estén vacíos.
         * Se recoge el usuario según el email, y se comprueba que las contraseñas son la misma, de ser así se crea una sesión con el usuario.
         */
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
            if (!empty($email) && !empty($password)) {
                $userModel = new UserModel($this->db);
                $user = $userModel->getUserByEmail($email);
                if (!empty($user)) {
                    if (password_verify($password, $user->getPassword())) {
                        $_SESSION["user"] = $user;

                        $route = new Router($this->di);
                        $url = $route->generateURL('User', 'getUser');
                        header("Location: $url");
                    } else {
                        $error = "El email o la contraseña no son correctos.";
                    }
                } else {
                    $error = "El email o la contraseña no son correctos.";
                }
            } else {
                $error = "El email y la contraseña no pueden estar vacios.";
            }
        }

        require("views/front-office/login.view.php");
    }

    public function register()
    {
        session_start();

        /* Se recogen las categorias para el menú. */
        $categoryModel = new CategoryModel($this->db);
        $categoriesNavbar = $categoryModel->getAllCategories();

        /*
         * Se recogen los diferentes datos para el registro de un usuario.
         * Se comprueba que no estén vacíos y se comprueba que no exista, en caso de no existir se registra.
         */
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
            if (!empty($email) && !empty($password) && !empty($username)) {
                $userModel = new UserModel($this->db);
                $user = $userModel->getUserByEmail($email);
                if (!$user) {
                    $password = password_hash($password, PASSWORD_DEFAULT);
                    $register = $userModel->register($email, $password, $username);

                    $route = new Router($this->di);
                    $url = $route->generateURL('User', 'getUser');
                    header("Location: $url");
                } else {
                    $error = "El email ya existe.";
                }
            } else {
                $error = "El email, la contraseña o el nombre de usuario no pueden estar vacios.";
            }
        }

        require("views/front-office/register.view.php");
    }


    public function getUser()
    {
        session_start();

        /* Se comprueba si hay una sessión de usuario creada (se crea al iniciar sessión) y de no ser así le envía al login. */
        if (!isset($_SESSION["user"])) {
            global $route;
            $url = $route->generateURL('User', 'login');
            header("Location: $url");
        }

        $target_dir = $this->config->get('image')['src'];

        /* Se recoge el usuario de la sesión y se hace una busqueda en la base de datos. */
        $id = $_SESSION["user"]->getIdUser();

        $userModel = new UserModel($this->db);
        $user = $userModel->getUserById($id);

        /* Se recogen las categorias para el menú. */
        $categoryModel = new CategoryModel($this->db);
        $categoriesNavbar = $categoryModel->getAllCategories();

        /*
         * Se comprueba que que se envie un formulario POST y que se pulse el botón para añadir la imagen.
         * Una vez dentro se comprueba que el fichero no ocupe mas de 10Kb, que sea de formato jpg o png, y que exista.
         * Una vez echas las comprobaciones se añade la imagen al fichero, y se añade a la base de datos del usuario.
         */
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["imageBtn"])) {
            $target_file = basename($_FILES["image"]["name"]);
            $imageErrors = [];
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check === false) {
                array_push($imageErrors, "La imagen no se ha podido subir.");
            }
            else {
                if ($_FILES["image"]["size"] > 10) {
                    array_push($imageErrors, "La imagen no debe pesar mas de 10Kb.");
                }
                if ($imageFileType !== "jpg" && $imageFileType !== "png" && $imageFileType !== "jpeg") {
                    array_push($imageErrors, "La imagen debe ser png o jpg.");
                }
            }
            if (empty($imageErrors)) {
                move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir.$target_file);
//                    Intento de reescalar imagenes a 100px x 100px.
                /*$source_properties = getimagesize($target_file);
                if ($imageFileType == "jpg" || $imageFileType == "jpeg"){
                    $image_resource = imagecreatefromjpeg($target_file);
                } elseif ($imageFileType == "png"){
                    $image_resource = imagecreatefrompng($target_file);
                }
                $target_width = 100;
                $target_height = 100;
                $target_layer = imagecreatetruecolor($target_width,$target_height);
                imagecopyresampled($target_layer,$image_resource,0,0,0,0,$target_width,$target_height, $source_properties[0],$source_properties[1]);
                if ($imageFileType == "jpg" || $imageFileType == "jpeg"){
                    imagejpeg($target_layer, $_FILES["image"]["tmp_name"]);
                } elseif ($imageFileType == "png"){
                    imagepng($target_layer, $_FILES["image"]["tmp_name"]);
                }*/
                $userModel = new UserModel($this->db);
                $imgVal = $userModel->editUserImage($id, $target_file);
            }
        }

        /*
         * Se recoge el parametro POST de la contraseña.
         * Se convierte la contraseña a bcrypt y se le cambia al usuario actual.
         */
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($password)) {
            $userModel = new UserModel($this->db);
            $password = password_hash($password, PASSWORD_DEFAULT);
            $passVal = $userModel->editUserPass($id, $password);
        }


        require("views/front-office/user.view.php");
    }


    public function logout()
    {
        session_start();

        /* En caso de que se pase el parametro para cerrar sesion, se hace un unset de la sesion y se elimina. */
        session_unset();
        session_destroy();
        global $route;
        header('Location: ' . $route->generateURL('User', 'login'));
    }
}