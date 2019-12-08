<?php
    function initDataBase(){
        $host = 'localhost';
        $dbname = 'forum';
        $user = 'forum';
        $pass = 'forum1';

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
            return $pdo;
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
?>