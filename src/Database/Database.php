<?php
namespace Database;

use PDO;
use PDOException;

class Database {

    private static $instance = null;
    
    public static function getDatabase() {
        if (self::$instance === null){
            try {
                self::$instance = new PDO(
                    "mysql:host=localhost;dbname=carrosfacil_ti50;charset=utf8m4",
                    "root",
                    "",
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                    ]
                    );
            } catch (PDOException $e) {
                die('Erro de conexão: '. $e->getMessage());
            }
        }

        return self::$instance;
    }
    
}
?>