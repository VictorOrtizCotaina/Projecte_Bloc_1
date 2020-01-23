<?php


namespace App\Controller;


class LanguageController extends AbstractController
{
    public function changeLanguage()
    {
        $getLang = filter_input(INPUT_GET, 'lang', FILTER_SANITIZE_STRING);
        if (!empty($getLang)){
            setcookie("lang", $getLang);
        } elseif (!empty($_COOKIE['lang'])){
            $getLang = $_COOKIE['lang'];
        }

        switch ($getLang){
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

        putenv("LANGUAGE=".$lang);
        putenv("LC_ALL=".$lang);
        putenv("LANG=".$lang);
        setlocale(LC_ALL, $lang);

        header("Location:http://".$_GET["url"]);
    }
}