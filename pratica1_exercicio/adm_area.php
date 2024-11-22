<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['email'])) {
    header("Location: login.php"); // Redireciona para login se não estiver logado
    exit();
}

include "dbconnect.php";

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área Administrativa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Área Administrativa</h1>
    <p>Bem-vindo, <?php echo $_SESSION['email']; ?>! <a href="logout.php">Sair</a></p>

    <div class="menu">
    <h2>Área do Administrador</h2>
    <ul>
       
        <li><a href="adicionar_colaborador.php">Adicionar Colaborador</a></li> <!-- Novo botão -->
    </ul>
</div>

    <hr>

    <!-- Formulário para Cadastro de Clientes -->
    <div id="cadastrar-cliente">
        <h2>Cadastrar Novo Cliente</h2>
        <form action="cadastrar_cliente.php" method="POST">
            <div>
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone" required>
            </div>
            <button type="submit">Cadastrar Cliente</button>
        </form>
    </div>

    <hr>

    <!-- Formulário para Adicionar Chamado -->
    <div id="adicionar-chamado">
        <h2>Adicionar Novo Chamado</h2>
        <form action="cadastrar_chamado.php" method="POST">
            <div>
                <label for="cliente_id">Cliente:</label>
                <select id="cliente_id" name="cliente_id" required>
                    <option value="">Selecione o Cliente</option>
                    <?php
                    $clientesQuery = "SELECT * FROM clientes";
                    $clientesResult = mysqli_query($conn, $clientesQuery);
                    while ($cliente = mysqli_fetch_assoc($clientesResult)) {
                        echo "<option value='{$cliente['id']}'>{$cliente['nome']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div>
                <label for="descricao">Descrição do Problema:</label>
                <textarea id="descricao" name="descricao" required></textarea>
            </div>
            <div>
                <label for="criticidade">Criticidade:</label>
                <select id="criticidade" name="criticidade" required>
                    <option value="baixa">Baixa</option>
                    <option value="média">Média</option>
                    <option value="alta">Alta</option>
                </select>
            </div>
            <button type="submit">Adicionar Chamado</button>
        </form>
    </div>
</body>
</html>