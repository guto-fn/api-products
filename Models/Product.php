<?php

namespace App\Models\Product;

use PDO;

require __DIR__ . './../Config/db.php';

class Product
{

    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function index()
    {
        $stmt = $this->pdo->query("SELECT * FROM products");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function store($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO products (name, description, price) VALUES (:name, :description, :price)");

        return $stmt->execute([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
        ]);
    }

    public function show($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");

        $stmt->execute([':id' => $id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $data)
    {
        $stmt = $this->pdo->prepare("UPDATE products SET name = :name, description = :description, price = :price WHERE id = :id");

        return $stmt->execute([
            ':name' => $data['name'],
            ':description' => $data['description'],
            ':price' => $data['price'],
            ':id' => $id
        ]);        
    }

    public function destroy($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = :id");

        return $stmt->execute([':id' => $id]);
    }
}
