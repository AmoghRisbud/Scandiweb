<?php
$servername = "remotemysql.com";
$username = "4UWileN0Bu";
$password = "kzBTjpPpht";
$database = "4UWileN0Bu";
$port = "3306";

$conn = new mysqli($servername, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS store";

if ($conn->query($sql) === TRUE) {
    // This if statement is left intentionally blank to display success. 
} else {
    echo "Error creating database: " . $conn->error;
}

$conn->select_db("store");

$sql = "CREATE TABLE IF NOT EXISTS products (
id INT(9) NOT NULL AUTO_INCREMENT,
sku VARCHAR(30) NOT NULL,
pname VARCHAR(30) NOT NULL,
price DOUBLE(50,2) NOT NULL,
PRIMARY KEY (id),
ptype VARCHAR(9) NOT NULL 
)";

if ($conn->query($sql) === TRUE) {
    // This if statement is left intentionally blank to display success. 
} else {
    echo "Error creating table: pro" . $conn->error;
}

$sql = "CREATE TABLE IF NOT EXISTS book (
bweight DOUBLE(50,2) NOT NULL,
b_id INT(9) NOT NULL ,
FOREIGN KEY (b_id)
        REFERENCES products(id)
        ON DELETE CASCADE)";

if ($conn->query($sql) === TRUE) {
   // This if statement is left intentionally blank to display success. 
} else {
    echo "Error creating table: " . $conn->error;
}

$sql = "CREATE TABLE IF NOT EXISTS dvd (
dsize DOUBLE(50,2) NOT NULL,
d_id INT(9) NOT NULL ,
FOREIGN KEY (d_id)
        REFERENCES products(id)
        ON DELETE CASCADE
)";

if ($conn->query($sql) === TRUE) {
    // This if statement is left intentionally blank to display success. 
} else {
    echo "Error creating table: " . $conn->error;
}

$sql = "CREATE TABLE IF NOT EXISTS furniture (
flength DOUBLE(50,2) NOT NULL,
fheight DOUBLE(50,2) NOT NULL,
fwidth DOUBLE(50,2) NOT NULL,
f_id INT(9) NOT NULL,
FOREIGN KEY (f_id)
        REFERENCES products(id)
        ON DELETE CASCADE
)";

if ($conn->query($sql) === TRUE) {
    // This if statement is left intentionally blank to display success. 
} else {
    echo "Error creating table: " . $conn->error;
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {  
    if ($_GET['q'] == 'getall') {   
        $sql = "SELECT id,sku,pname,ptype,price,bweight FROM products,book WHERE products.id= book.b_id";
        $result = $conn->query($sql);

        if ( $result->num_rows > 0 ) {
            
            while ($row = $result->fetch_assoc()) {
                echo '<div class="items">
                <input type="checkbox" class="delete-checkbox" id="' . $row["id"] . '"">
                <h4 class="sku">' . $row["sku"] . '</h4>
                <h4 class="name">' . $row["pname"] . '</h4>
                <h4 class="price">' . $row["price"] . '</h4>
                <h4 class="attr">Weight: ' . $row['bweight'] . '</h4>
                </div>';
            }
        }
           
        $sql = "SELECT id,sku,pname,ptype,price,flength,fwidth,fheight FROM products,furniture WHERE products.id= furniture.f_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
                    
            while ($row = $result->fetch_assoc()) {
                echo '<div class="items">
                <input type="checkbox" class="delete-checkbox" id="' . $row["id"] . '"">
                <h4 class="sku">' . $row["sku"] . '</h4>
                <h4 class="name">' . $row["pname"] . '</h4>
                <h4 class="price">' . $row["price"] . '</h4>
                <h4 class="attr">Length: ' . $row['flength'] . '</h4>
                <h4 class="attr">Height: ' . $row['fheight'] . '</h4>
                <h4 class="attr">Width: ' . $row['fwidth'] . '</h4>
                </div>';
            }
        }
        $sql = "SELECT id,sku,pname,ptype,price,dsize FROM products,dvd WHERE products.id= dvd.d_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
                    
            while ($row = $result->fetch_assoc()) {
                echo '<div class="items">
                <input type="checkbox" class="delete-checkbox" id="' . $row["id"] . '"">
                <h4 class="sku">' . $row["sku"] . '</h4>
                <h4 class="name">' . $row["pname"] . '</h4>
                <h4 class="price">' . $row["price"] . '</h4>
                <h4 class="attr">Size: ' . $row['dsize'] . '</h4>
                </div>';
            }
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    set_error_handler(function ($errno, $errstr, $errfile, $errline) {
        // error was suppressed with the @-operator
        if (0 === error_reporting()) {
            return false;
        }
        throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
    });
    try {
        if ($_GET['q'] == 'deleteall') {

            $i = 0;

            while (((int)$_POST['id' . $i]) == !null) {

                $sql = "DELETE FROM products WHERE id = " . (int)$_POST['id' . $i];

                if ($conn->query($sql) === TRUE) {
                    // This if statement is left intentionally blank. 
                    // Database uses ON DELETE CASECADE to remove entries from both tables.
                    // Please refer summary document for schema and other details.
                } else {
                    echo "Error deleting record: " . $conn->error;
                }
                $i = $i + 1;
            }
        } 
    } catch (\Throwable $th) {
        
    }    
}
?>
