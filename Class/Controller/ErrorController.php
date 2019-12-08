<?php

namespace App\Controller;

class ErrorController {
    public function notFound(): string {
        $properties = ['errorMessage' => 'Page not found!'];
        //return $this->render('error.twig', $properties);
        return require_once ('views/error.view.php');
    }
}