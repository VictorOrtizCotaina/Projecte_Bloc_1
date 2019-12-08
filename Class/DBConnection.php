<?php

namespace App;

use PDO;

class DBConnection {

    private $connection;

    //  Funcion para conectar con la base de datos.
    function __construct() {
        try {
            $fichero = file_get_contents("config/config.json", true);

            $dataBase = json_decode($fichero, true);

            $connection = $dataBase["database"]["connection"];
            $user = $dataBase["database"]["username"];
            $pass = $dataBase["database"]["password"];
            $options = $dataBase["database"]["options"];

            $this->connection = new PDO("$connection;charset=utf8", $user, $pass, $options);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        } catch (PDOException $e) {
            echo "Se ha producido un error al intentar conectar al servidor MySQL: " . $e->getMessage();
        }
    }

    function getConnection():PDO {
        return $this->connection;
    }
}