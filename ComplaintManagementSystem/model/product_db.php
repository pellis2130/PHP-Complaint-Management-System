<?php

require_once('database.php');
require_once('product.php');

class ProductDB
{
    // Get all products
    public static function getProducts()
    {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "SELECT * FROM products
                  ORDER BY ProductID";

        $result = mysqli_query($connection, $query);

        $products = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $product = new Product(
                $row['ProductID'],
                $row['ProductName'],
                $row['Description'],
                $row['Active']
            );

            $products[] = $product;
        }

        return $products;
    }

    // Get one product
    public static function getProduct($productId)
    {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "SELECT * FROM products
                  WHERE ProductID = ?";

        $stmt = mysqli_prepare($connection, $query);

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $productId
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        mysqli_stmt_close($stmt);

        if ($row) {
            return new Product(
                $row['ProductID'],
                $row['ProductName'],
                $row['Description'],
                $row['Active']
            );
        }

        return null;
    }

    // Add product
    public static function addProduct($product)
    {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "INSERT INTO products
                  (ProductName, Description, Active)
                  VALUES (?, ?, ?)";

        $stmt = mysqli_prepare($connection, $query);

        $productName = $product->getProductName();
        $description = $product->getDescription();
        $active = $product->getActive();

        mysqli_stmt_bind_param(
            $stmt,
            "ssi",
            $productName,
            $description,
            $active
        );

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    // Update product
    public static function updateProduct($product)
    {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "UPDATE products
                  SET ProductName = ?,
                      Description = ?,
                      Active = ?
                  WHERE ProductID = ?";

        $stmt = mysqli_prepare($connection, $query);

        $productName = $product->getProductName();
        $description = $product->getDescription();
        $active = $product->getActive();
        $productId = $product->getProductId();

        mysqli_stmt_bind_param(
            $stmt,
            "ssii",
            $productName,
            $description,
            $active,
            $productId
        );

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    // Delete product
    public static function deleteProduct($productId)
    {
        $db = new Database();
        $connection = $db->getConnection();

        $query = "DELETE FROM products
                  WHERE ProductID = ?";

        $stmt = mysqli_prepare($connection, $query);

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $productId
        );

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}
?>