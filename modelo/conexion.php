<?php

class Conexion extends PDO{

    private $hostBD     = "localhost";
    private $nombreBD   = "web_service";
    private $usuarioBD  = "root";
    private $passwordBD = "";

    public function __construct(){

        $stringConexion = "mysql:host=$this->hostBD;
                                dbname=$this->nombreBD;
                                charset=utf8";

        try{

            parent::__construct($stringConexion,$this->usuarioBD,$this->passwordBD,
                                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }catch(PDOException $ex){
            echo "ERROR :". $ex->getMessage();
            exit;
        }
    }
}

?>