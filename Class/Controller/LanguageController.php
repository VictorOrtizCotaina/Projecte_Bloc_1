<?php


namespace App\Controller;


class LanguageController extends AbstractController
{
    public function changeLanguage()
    {
        $_COOKIE['lang'] = $_GET["lang"];
        setcookie("lang", $_GET["lang"]);
        putenv("LANGUAGE=".$_GET['lang']);
        putenv("LC_ALL=".$_GET['lang']);
        putenv("LANG=".$_GET['lang']);

        header("Location:http://".$_GET["url"]);
    }
}