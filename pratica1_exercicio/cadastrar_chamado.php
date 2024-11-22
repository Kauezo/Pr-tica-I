<?php
include "dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clienteId = mysqli_real_escape_string($conn, $_POST["cliente_id"]);
    $descricao = mysqli_real_escape_string($conn, $_POST["descricao"]);
    $criticidade = mysqli_real_escape_string($conn, $_POST["criticidade"]);

    $query = "INSERT INTO chamados (cliente_id, descricao, criticidade) 
              VALUES ('$clienteId', '$descricao', '$criticidade')";

    if (mysqli_query($conn, $query)) {
        echo "Chamado adicionado com sucesso!";
    } else {
        echo "Erro ao adicionar chamado: " . mysqli_error($conn);
    }
}
?>