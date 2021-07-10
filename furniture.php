<?php
require 'product.php';
require 'backend.php';

class furniture extends Product
{
    public $height;
    public $width;
    public $length;

    function get_length()
    {
        return $this->length;
    }
    function get_width()
    {
        return $this->width;
    }
    function get_height()
    {
        return $this->height;
    }
    function set_length($length)
    {
        $this->length = $length;
    }
    function set_width($width)
    {
        $this->width = $width;
    }
    function set_height($height)
    {
        $this->height = $height;
    }
    function __construct()
    {
        // This is left blank intentionally.
    }
}
$furnitureParentObj = Product::returnParent();
$furnitureObj = new furniture();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $sku  = "";
    $name = "";
    $price = "";
    $length = "";
    $height = "";
    $width = "";
    $type = "";

    $sku = $_POST['sku'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $type = $_POST['type'];
    $length = $_POST['length'];
    $height = $_POST['height'];
    $width = $_POST['width'];

    $furnitureObj->set_sku($sku);
    $furnitureObj->set_name($name);
    $furnitureObj->set_price($price);
    $furnitureObj->set_length($length);
    $furnitureObj->set_height($height);
    $furnitureObj->set_width($width);

    $sql = "INSERT INTO products (sku,pname,price,ptype) VALUES ('" . $furnitureObj->get_sku($sku) . "','" . $furnitureObj->get_name($name) . "','" . $furnitureObj->get_price($price) . "','" . $type . "')";

    if ($conn->query($sql) === TRUE) {
        // This if statement is left intentionally blank to display success. 
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $t_id = "SELECT `id` FROM `products` WHERE id=(select id from products ORDER BY id DESC LIMIT 1)";

    if ($conn->query($t_id) == TRUE) {
        $result = $conn->query($t_id);
        $row = $result->fetch_assoc();

        $row = $row["id"];
        $sql = "INSERT INTO furniture (f_id,flength,fheight,fwidth) VALUES ($row,'" . $furnitureObj->get_length($length) . "','" . $furnitureObj->get_height($height) . "','" . $furnitureObj->get_width($width) .  "')";

        if ($conn->query($sql) === TRUE) {
            echo "<script> location.href='index.html'; </script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
