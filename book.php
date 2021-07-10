<?php
require 'product.php';
require 'backend.php';

class book extends Product
{
    public $weight;

    function get_weight()
    {
        return $this->weight;
    }
    function set_weight($weight)
    {
        $this->weight = $weight;
    }
    function __construct()
    {
        // This is left blank intentionally.
    }
}

$bookParentObj = Product::returnParent();
$bookObj = new book();
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $sku  = "";
    $name = "";
    $weight = "";
    $price = "";
    $type = "";

    $sku = $_POST['sku'];
    $name = $_POST['name'];
    $weight = $_POST['weight'];
    $price = $_POST['price'];
    $type = $_POST['type'];

    $bookObj->set_sku($sku);
    $bookObj->set_name($name);
    $bookObj->set_price($price);
    $bookObj->set_weight($weight);

    $sql = "INSERT INTO products (sku,pname,price,ptype) VALUES ('" . $bookObj->get_sku($sku) . "','" . $bookObj->get_name($name) . "','" . $bookObj->get_price($price) . "','" . $type . "')";

    if ($conn->query($sql) === TRUE) {
        // This if statement is left intentionally blank to display success. 
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $t_id = "SELECT `id` FROM `products` WHERE id=(select id from products ORDER BY id DESC LIMIT 1)";

    if (($result = $conn->query($t_id)) == TRUE) {

        $row = $result->fetch_assoc();

        $row = $row["id"];
        $sql = "INSERT INTO book (b_id,bweight) VALUES ($row,'" . $bookObj->get_weight($weight) . "' )";

        if ($conn->query($sql) === TRUE) {
            echo "<script> location.href='index.html'; </script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
