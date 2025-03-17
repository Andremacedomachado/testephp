<?php
require_once 'vendor/autoload.php';

use app\database\Connection;
use \Dotenv\Dotenv;
use app\database\model\Products;

$path = dirname(__FILE__, 1);

$dotenv = Dotenv::createUnsafeImmutable($path);
$dotenv->load();

$productDao = new Products();

if (isset($_GET['search'])):
    $search = strip_tags(trim($_GET['search']));
    $products = $productDao->searchProducts(Connection::getConn(), $search);
else:
    $search = '';
    $products = $productDao->getProducts(Connection::getConn());
endif;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Teste PHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="d-flex flex-column justify-content-center align-items-center">
    <main class="d-flex flex-column mx-3 my-4 container-lg ">
        <section class="d-flex flex-column gap-2 justify-content-center align-items-center card p-2  ">
            <div class="d-flex flex-column  ">
                <div class="d-flex">
                    <h1 class="display-3">Dashboard - Controle Painel</h1>
                </div>
                <div class="d-flex p-2 ">
                    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="get" class="d-flex flex-row gap-2 container">
                        <input type="text" name="search" id="idSearch" value="<?= $search ?>"
                            placeholder="Digite o produto / EAN / Código interno" class="form-control ms-auto">
                        <button type="submit" class="btn btn-primary">Pesquisar</button>
                    </form>
                </div>
                <div class="d-flex border rounded px-4 py-2">
                    <table class="table table-striped align-middle ">
                        <thead>
                            <tr>
                                <th>EAN</th>
                                <th>Descrição</th>
                                <th>Cód. interno</th>
                                <th>Ações</th>
                            </tr>

                        </thead>
                        <tbody class="table-group-divider">
                            <?php foreach ($products as $product): ?>
                                <tr id="<?= $product->codigo_interno ?>">
                                    <td><?= $product->EAN ?></td>
                                    <td><?= $product->descricao ?></td>
                                    <td><?= $product->codigo_interno ?></td>
                                    <td>
                                        <form action="<?= $_SERVER['PHP_SELF'].'?search='.$search?>" method="post">
                                            <button type="submit" name="adicionar" value="<?= $product->codigo_interno ?>"
                                                class="btn btn-secondary">Adicionnar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>