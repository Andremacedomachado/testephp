<?php
namespace app\database;
use PDO;
class Connection
{
    private static ?PDO $instance = null;
    public static function getConn()
    {
        if (!self::$instance):
            $dsn = $_ENV['APIDRIVER'] . ':host=' . $_ENV['APIHOST'] . ';dbname=' . $_ENV['APIDB'] . ';charset=' . $_ENV['APICHARSET'];
            var_dump($dsn);
            self::$instance = new PDO($dsn, (string) $_ENV['APIUSER'], $_ENV['APIPASSWORD'], [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ]);
        endif;
        return self::$instance;
    }
}
?>