<?php

require_once __DIR__ . '/Config/db.php';
require_once __DIR__ . '/Controllers/ProductsController.php';

use App\Controllers\ProductsController\ProductsController;

$controller = new ProductsController();

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// remover as querys strings se existir
$uri = explode('?', $uri, 2)[0];

// roteamento
if ($uri === '/products' && $method === 'GET') {
    $controller->index();
} elseif (preg_match('/\/products\/(\d+)/', $uri, $matches)) {

    $id = $matches[1];

    if ($method === 'GET') {
        $controller->show($id);
    } elseif ($method === 'PUT') {
        $controller->update($id);
    } elseif ($method === 'DELETE') {
        $controller->destroy($id);
    } else {
        http_response_code(405);
        echo json_encode(['error' => 'Método não permitido']);
    }
} elseif ($uri === '/products' && $method === 'POST') {
    $controller->store();
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Rota não encontrada']);
}
