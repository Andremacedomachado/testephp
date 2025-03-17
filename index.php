<?php
require_once 'vendor/autoload.php';

use app\database\Connection;
use Dotenv\Dotenv;
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

session_start();

if (!isset($_SESSION['selecionados'])) {
    $_SESSION['selecionados'] = [];
}

if (isset($_POST['adicionar'])) {
    $id = (int) $_POST['adicionar'];
    if (!in_array($id, $_SESSION['selecionados'], true)) {
        $_SESSION['selecionados'][] = $id;
    }
}

$mapaProdutos = [];
foreach ($products as $produto) {
    $mapaProdutos[$produto->codigo_interno] = $produto;
}

$productsSelected = array_map(function ($codigo) use ($mapaProdutos) {
    return $mapaProdutos[$codigo] ?? null;
}, $_SESSION['selecionados']);

$productsSelected = array_filter($productsSelected);

if (isset($_POST['deletar_selecao'])) {
    session_unset();
    $productsSelected = [];
}

if (isset($_POST['imprimir_todos'])) {
    echo 'acionou ' . $_POST['imprimir_todos'] . '<hr/>';
}
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
                                        <form action="<?= $_SERVER['PHP_SELF'] . '?search=' . $search ?>" method="post">
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
            <div class="d-flex card container p-2 justify-content-center align-items-center ">
                <div
                    class="d-flex flex-column justify-content-center align-items-center px-auto border rounded  p-4 gap-4">
                    <h2 class="display-4">Fila de impressao</h2>
                    <div class="d-flex ">
                        <form action="" method="post">
                            <input type="submit" name="imprimir_todos" value="Imprimir todos" class="btn btn-primary" />
                            <input type="submit" name="deletar_selecao" value="Limpar impressões"
                                class="btn btn-secondary" />
                        </form>
                    </div>
                </div>
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
                        <?php if (!empty($productsSelected)): ?>
                            <?php foreach ($productsSelected as $product): ?>
                                <tr id="<?= $product->codigo_interno ?>">
                                    <td><?= $product->EAN ?></td>
                                    <td><?= $product->descricao ?></td>
                                    <td><?= $product->codigo_interno ?></td>
                                    <td>
                                        <form action="" method="post">
                                            <button type="submit" name="imprimir" value="<?= $product->codigo_interno ?>"
                                                class="btn btn-secondary">Imprimir</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr id="-1">
                                <td>--</td>
                                <td>--</td>
                                <td>--</td>
                                <td>
                                    --
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                </table>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>