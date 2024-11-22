<?php
$conn = mysqli_connect("localhost:3306", "root","root","suporte_tecnico");
if (!$conn) {
    die("Connection failed." . mysqli_connect_error());
}else {
    echo "ok";
}

?>