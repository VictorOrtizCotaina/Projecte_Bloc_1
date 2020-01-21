<?php


namespace App\Controller;


class LanguageController extends AbstractController
{
    public function changeLanguage()
    {
        $_COOKIE['lang'] = $_GET["lang"];
        setcookie("lang", $_GET["lang"]);
        var_dump($_COOKIE['lang']);
        putenv("LANGUAGE=".$_GET['lang']);
        putenv("LC_ALL=".$_GET['lang']);
        putenv("LANG=".$_GET['lang']);
//exit();
        header("Location:http://".$_GET["url"]);
    }
}