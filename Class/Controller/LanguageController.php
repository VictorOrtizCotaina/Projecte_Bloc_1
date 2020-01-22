<?php


namespace App\Controller;


class LanguageController extends AbstractController
{
    public function changeLanguage()
    {
        switch ($_GET["lang"]){
            case "es":
                $lang = "es.UTF-8";
                break;
            case "ca":
                $lang = "ca.UTF-8";
                break;
            case "en":
                $lang = "en.UTF-8";
                break;
            default:
                $lang = "es.UTF-8";
        }
        $_COOKIE['lang'] = $lang;
        setcookie("lang", $lang);

        putenv("LANGUAGE=".$lang);
        putenv("LC_ALL=".$lang);
        putenv("LANG=".$lang);
        setlocale(LC_ALL, $lang);

        header("Location:http://".$_GET["url"]);
    }
}