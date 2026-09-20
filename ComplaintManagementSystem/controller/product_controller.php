<?php

session_start();

require_once __DIR__ . '/../model/product.php';
require_once __DIR__ . '/../model/product_db.php';

if (
    !isset($_SESSION['employee_id']) ||
    ($_SESSION['user_type'] ?? '') !== 'Administrator'
) {
    header("Location: ../view/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action = $_POST['action'] ?? '';

    // Add a new product or service
    if ($action === 'Add') {

        $productName = trim($_POST['product_name'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if ($productName === '' || $description === '') {
            header("Location: ../view/admin_products.php?error=1");
            exit;
        }

        $product = new Product(
            null,
            $productName,
            $description,
            1
        );

        ProductDB::addProduct($product);

        header("Location: ../view/admin_products.php?added=1");
        exit;
    }

    // Remove a product or service
    if ($action === 'Remove') {

        $productId = (int) ($_POST['product_id'] ?? 0);

        if ($productId <= 0) {
            header("Location: ../view/admin_products.php?error=1");
            exit;
        }

        ProductDB::deleteProduct($productId);

        header("Location: ../view/admin_products.php?deleted=1");
        exit;
    }
}

header("Location: ../view/admin_products.php");
exit;

?>