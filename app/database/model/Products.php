<?php
namespace app\database\model;

use PDO;
class Products
{
    public function getProducts(PDO $connection)
    {
        try {
            $query = "SELECT * FROM products";
            $prepare = $connection->prepare($query);
            $prepare->execute();
            if ($prepare->rowCount() > 0):
                return $prepare->fetchAll();
            else:
                return [];
            endif;
        } catch (\Throwable $e) {
            var_dump($e->getMessage());
        }
    }
    public function searchProducts(PDO $connection, $search)
    {
        try {
            $query = "SELECT * FROM `products` WHERE `EAN` LIKE :search OR `codigo_interno` LIKE :search OR `descricao` LIKE :search OR `imagem` LIKE :search ";
            $prepare = $connection->prepare($query);
            $prepare->execute([':search' => '%' . $search . '%']);
            $result = $prepare->fetchAll();
            if ($result):
                return $result;
            else:
                return [];
            endif;
        } catch (\Throwable $e) {
            var_dump($e->getMessage());
        }
    }
}
?>