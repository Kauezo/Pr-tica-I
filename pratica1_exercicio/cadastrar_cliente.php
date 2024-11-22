<?php
include "dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = mysqli_real_escape_string($conn, $_POST["nome"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $telefone = mysqli_real_escape_string($conn, $_POST["telefone"]);

    $query = "INSERT INTO clientes (nome, email, telefone) VALUES ('$nome', '$email', '$telefone')";

    if (mysqli_query($conn, $query)) {
        echo "Cliente cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar cliente: " . mysqli_error($conn);
    }
}
?>