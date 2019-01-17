<?php
// Design Pattern : Singleton
class Database {
    /** @var PDO */
    private $dbh;
    private static $_instance;

    private function __construct() {
        try {
            $configuration = parse_ini_file(
                __DIR__ . '/../config.ini',
                true 
            );
            $this->dbh = new PDO(
                'mysql:host=' . $configuration['database']['host'] . ';dbname=' . $configuration['database']['name'] . ';charset=utf8',
                $configuration['database']['username'],
                $configuration['database']['password'],
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING) 
            );
        }
        catch(Exception $exception) {
            die('Erreur de connexion...' . $exception->getMessage());
        }
    }

    public static function getPDO() {

        if (empty(self::$_instance)) {
            self::$_instance = new Database();
        }
        return self::$_instance->dbh;
    }
}