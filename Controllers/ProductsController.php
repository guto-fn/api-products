<?php

namespace App\Controllers\ProductsController;

require_once './Models/Product.php';
require_once './Config/db.php';

use App\Models\Product\Product;

class ProductsController
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = connect();
    }

    public function index()
    {
        $products = new Product($this->pdo);

        $data = $products->index();

        echo json_encode([
            'status' => 200,
            'message' => 'Requisição ok',
            'data' => $data
        ]);
    }

    public function store()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $products = new Product($this->pdo);

        $create = $products->store($data);

        if ($create) {

            echo json_encode([
                'status' => 201,
                'message' => 'Produto registrado com sucesso!',
                'data' => $create,
            ]);
        } else {

            http_response_code(500);

            echo json_encode([
                'status' => 500,
                'error' => 'Erro ao registrar o produto',
            ]);
        }
    }

    public function show($id)
    {
        $products = new Product($this->pdo);

        $data = $products->show($id);

        if (!$data) {
            http_response_code(404);
            echo json_encode([
                'status' => 404,
                'message' => 'Produto não encontrado'
            ]);

            return;
        }

        echo json_encode([
            'status' => 200,
            'message' => 'Requisição ok',
            'data' => $data
        ]);
    }

    public function update($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $products = new Product($this->pdo);

        $id_product = $products->show($id);

        if (!$id_product) {

            http_response_code(404);

            echo json_encode([
                'status' => 404,
                'message' => 'Produto não encontrado',
            ]);

            return;
        }

        $update = $products->update($id, $data);

        if ($update) {
            echo json_encode([
                'status' => 200,
                'message' => 'Produto atualizado com sucesso',
                'data' => $update
            ]);
        } else {
            http_response_code(500);

            echo json_encode([
                'status' => '500',
                'error' => 'Não foi possível atualizar o produto',
            ]);
        }
    }

    public function destroy($id)
    {
        $products = new Product($this->pdo);

        $data = $products->destroy($id);

        if ($data) {
            echo json_encode([
                'status' => 200,
                'message' => 'Produto deletado com sucesso'
            ]);
        } else {
            http_response_code(500);

            echo json_encode([
                'status' => 500,
                'error' => 'Não foi possível deletar o produto',
            ]);
        }
    }
}
