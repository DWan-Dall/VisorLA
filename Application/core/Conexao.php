<?php

class Conexao
{
    public static $instance;

    public static function getInstance() {
        if (self::$instance === null){

            try {
                $host = 'localhost';
                $user = 'root';
                $pass = '';
                $dbname = 'visor-saude-la';
                self::$instance = new PDO("mysql: host=$host;dbname=" . $dbname, $user, $pass);

            } catch (PDOException $e) {
                die ("Connection Failed: {$e->getMessage()}");
            }

        }

       return self::$instance;
    }
}