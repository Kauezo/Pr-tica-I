<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['email'])) {
    header("Location: login.php"); // Redireciona para login se não estiver logado
    exit();
}

include "dbconnect.php";

// Consultar todos os chamados
$query = "SELECT c.id, c.descricao, c.criticidade, c.status, c.data_abertura, 
                 cl.nome AS cliente_nome, col.nome AS colaborador_nome
          FROM chamados c
          LEFT JOIN clientes cl ON c.cliente_id = cl.id
          LEFT JOIN colaboradores col ON c.colaborador_id = col.id";
$result = mysqli_query($conn, $query);

// Filtros (opcional)
$statusFilter = $_GET['status'] ?? '';
$criticidadeFilter = $_GET['criticidade'] ?? '';
$colaboradorFilter = $_GET['colaborador'] ?? '';

// Gerenciar filtros
if ($statusFilter) {
    $query .= " WHERE c.status = '$statusFilter'";
}
if ($criticidadeFilter) {
    $query .= " AND c.criticidade = '$criticidadeFilter'";
}
if ($colaboradorFilter) {
    $query .= " AND c.colaborador_id = '$colaboradorFilter'";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Chamados - Área Administrativa</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Gerenciamento de Chamados</h1>
    <p>Bem-vindo(a), <?php echo $_SESSION['email']; ?>! <a href="logout.php">Sair</a></p>

   

    <h2>Lista de Chamados</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Descrição</th>
                <th>Criticidade</th>
                <th>Status</th>
                <th>Data de Abertura</th>
                <th>Colaborador</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($chamado = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $chamado['id']; ?></td>
                    <td><?php echo $chamado['cliente_nome']; ?></td>
                    <td><?php echo $chamado['descricao']; ?></td>
                    <td><?php echo ucfirst($chamado['criticidade']); ?></td>
                    <td><?php echo ucfirst($chamado['status']); ?></td>
                    <td><?php echo $chamado['data_abertura']; ?></td>
                    <td><?php echo $chamado['colaborador_nome'] ?? 'Não Atribuído'; ?></td>
                    <td>
                        <a href="editar_chamado.php?id=<?php echo $chamado['id']; ?>">Editar</a> | 
                        <a href="delete_chamado.php?id=<?php echo $chamado['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este chamado?');">Excluir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>