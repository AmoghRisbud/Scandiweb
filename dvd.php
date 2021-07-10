<?php
require 'product.php';
require 'backend.php';

class dvd extends Product
{
    public $size;
    function get_size()
    {
        return $this->size;
    }
    function set_size($size)
    {
        $this->size = $size;
    }
    function __construct()
    {
        // This is left blank intentionally.
    }
}

$ParentObj = Product::returnParent();
$dvdObj = new dvd();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $sku  = "";
    $name = "";
    $size = "";
    $price = "";
    $type = "";

    $sku = $_POST['sku'];
    $name = $_POST['name'];
    $size = $_POST['size'];
    $price = $_POST['price'];
    $type = $_POST['type'];

    $dvdObj->set_sku($sku);
    $dvdObj->set_name($name);
    $dvdObj->set_price($price);
    $dvdObj->set_size($size);

    $sql = "INSERT INTO products (sku,pname,price,ptype) VALUES ('" . $dvdObj->get_sku($sku) . "','" . $dvdObj->get_name($name) . "','" . $dvdObj->get_price($price) . "','" . $type . "')";

    if ($conn->query($sql) === TRUE) {
        // This if statement is left intentionally blank to display success. 
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $t_id = "SELECT `id` FROM `products` WHERE id=(select id from products ORDER BY id DESC LIMIT 1)";

    if (($result = $conn->query($t_id)) == TRUE) {
        $row = $result->fetch_assoc();

        $row = $row["id"];
        $sql = "INSERT INTO dvd (d_id,dsize) VALUES ($row,'" . $dvdObj->get_size($size) . "')";

        if ($conn->query($sql) === TRUE) {
            echo "<script> location.href='index.html'; </script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
