<?php

namespace App\Controller;

use App\Core\Request;
use App\Utils\DependencyInjector;
use Exception;

abstract class AbstractController {
    protected $request;
    protected $db;
    protected $config;
    protected $view;
    protected $log;
    protected $customerId;
    protected $di;

    public function __construct(DependencyInjector $di, Request $request)
    {
        $this->request = $request;
        $this->di = $di;

        $this->db = $di->get('PDO');
        $this->config = $di->get('Config');
        //$this->log = $di->get('Logger');
        $this->view = $di->get('Twig');
        //$this->config = $di->get('Utils\Config');

        $this->changeLanguage();
    }


    protected function render(string $template, array $params): string {
        return $this->view->load($template)->render($params);
//        require_once ($template);
    }


    public function changeLanguage()
    {
        $getLang = filter_input(INPUT_GET, 'lang', FILTER_SANITIZE_STRING);
        if (!empty($getLang)){
            setcookie("lang", $getLang,  time()+60*60*24*30*12, "/");
        } elseif (!empty($_COOKIE['lang'])){
            $getLang = $_COOKIE['lang'];
        }

        switch ($getLang){
            case "es":
                $lang = "es_ES.UTF-8";
                break;
            case "va":
                $lang = "ca.UTF-8";
                break;
            case "gb":
                $lang = "en_GB.UTF-8";
                break;
            default:
                $lang = "es_ES.UTF-8";
                setcookie("lang", "es");
        }

        putenv("LANGUAGE=".$lang);
        putenv("LC_ALL=".$lang);
        putenv("LANG=".$lang);
        setlocale(LC_ALL, $lang);

        // Specify location of translation tables
        bindtextdomain('main', 'locales');
        bind_textdomain_codeset('main', 'UTF-8');
        // Choose domain
        textdomain('main');

        
    }
}