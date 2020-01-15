<?php

namespace App\Controller;

use App\Model\PostModel;
use App\Model\UserModel;


class PostController extends AbstractController
{

    public function getAdminPost()
    {
        if (isset($_SESSION["user"])) {
            $id = $_SESSION["user"]->getIdUser();

            $userModel = new UserModel($this->db);
            $user = $userModel->getUserById($id);
            $userGroup = $user->getIdUserGroup();
            if ($userGroup != 1) {
                $id_user = $user->getIdUser();
                $postModel = new PostModel($this->db);
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
                $postModel = new PostModel($this->db);

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
            global $route;
            $url = $route->generateURL('User', 'login');
            header("Location: $url");
        }

        require("views/back-office/post_list.view.php");

    }


    public function adminPostAdd()
    {
        $target_dir = $this->config->get('image')['src'];
        global $route;
        $pageForm = $route->generateURL('Post', 'getAdminPost');
        $page = "post_add";

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

            $postModel = new PostModel($this->db);
            $post = $postModel->getData();
            $errors = $postModel->validate($post);

            if (!empty($errors)) {
                $insert = $postModel->insertPost($post);

                if ($insert) {
                    global $route;
                    header('Location: ' . $route->generateURL('Forum', 'getAdminForum'));
                }
            }
        }

        require("views/back-office/forms/post_form.view.php");

    }


    public function adminPostEdit($id_post)
    {
        $target_dir = $this->config->get('image')['src'];
        global $route;
        $pageForm = $route->generateURL('Post', 'adminPostEdit', ["id_post" => $id_post]);
        $page = "post_edit";

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


        $postModel = new PostModel($this->db);
        $post = $postModel->getPostById($id_post);
        $title = $post->getTitle();
        $text = $post->getText();
        $image = $target_dir . $post->getImage();
        $date = $post->getDateAdd()->format('Y-m-d');
        $id_user = $post->getIdUser();
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
                    global $route;
                    header('Location: ' . $route->generateURL('Forum', 'getAdminForum'));
                }
            }
        }

        require("views/back-office/forms/post_form.view.php");

    }


    public function adminPostDelete($id_post)
    {
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
        if (isset($id_post)) {
            $postModel = new PostModel($this->db);
            $post = $postModel->getPostById($id_post);
            $delete = $postModel->deletePost($post);
            global $route;
            header('Location: ' . $route->generateURL('Forum', 'getAdminForum'));
        }
    }


}
