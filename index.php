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

ini_set( 'session.cookie_httponly', 1 );
//https://stackoverflow.com/questions/520237/how-do-i-expire-a-php-session-after-30-minutes

$db = new DBConnection();
$di->set('PDO', $db->getConnection());

$config = new Config();
$di->set("Config", $config);

// Carreguem l'entorn de Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader, [
    'debug' => true,
]);
$twig->addExtension(new \Twig\Extension\DebugExtension());
// Afegim una instància de Router a la plantilla.
// La utilitzarem en les plantilles per a generar URL.
$twig->addGlobal('router', new Router(new \App\Utils\DependencyInjector()));
//l'incloem al contenidor de serveis
$di->set('Twig', $twig);


$request = new Request();

$route = new Router($di);
echo $route->route($request);

$page = $_GET['action'] ?? "indexARR";

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
            break;
        };
    case "category_add":
        {
            break;
        };
    case "category_edit":
        {
            break;
        };
    case "category_delete":
        {
            break;
        };
    case "category_active":
        {
            break;
        };

    case "forum_list":
        {
            break;
        };
    case "forum_add":
        {
            break;
        };
    case "forum_edit":
        {
            break;
        };
    case "forum_delete":
        {
            break;
        };
    case "forum_active":
        {
            break;
        };

    case "topic_list":
        {
            break;
        };
    case "topic_add":
        {
            break;
        };
    case "topic_edit":
        {
            break;
        };
    case "topic_delete":
        {
            break;
        };
    case "topic_active":
        {
            break;
        };

    case "post_list":
        {
            break;
        };
    case "post_add":
        {
            break;
        };
    case "post_edit":
        {
            break;
        };
    case "post_delete":
        {
            break;
        };

    default:
        {
            // require("views/error.view.php");
        };

}