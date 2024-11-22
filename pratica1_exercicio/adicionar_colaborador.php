<?php
include "dbconnect.php";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Verifica se os campos obrigatórios foram preenchidos
    if (empty($nome) || empty($email)) {
        $erro = "Todos os campos são obrigatórios.";
    } else {
        // Insere o colaborador no banco de dados
        $query = "INSERT INTO colaboradores (nome, email) VALUES ('$nome', '$email')";

        if (mysqli_query($conn, $query)) {
            $sucesso = "Colaborador adicionado com sucesso!";
        } else {
            $erro = "Erro ao adicionar colaborador: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Colaborador</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Adicionar Colaborador</h1>
        <?php if (isset($erro)): ?>
            <div class="error"><?php echo $erro; ?></div>
        <?php endif; ?>
        <?php if (isset($sucesso)): ?>
            <div class="success"><?php echo $sucesso; ?></div>
        <?php endif; ?>
        <form action="adicionar_colaborador.php" method="POST">
            <div>
                <label for="nome">Nome do Colaborador:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div>
                <label for="email">Email do Colaborador:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <button type="submit">Adicionar</button>
        </form>
        <a href="adm_area.php">Voltar</a>
    </div>
</body>
</html>