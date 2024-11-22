<?php
include "dbconnect.php";

// Verifica se o ID do chamado foi passado
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID do chamado não fornecido.";
    exit();
}

$idChamado = intval($_GET['id']);

// Verifica se o formulário foi enviado para salvar as alterações
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $clienteId = intval($_POST['cliente_id']);
    $descricao = mysqli_real_escape_string($conn, $_POST['descricao']);
    $criticidade = mysqli_real_escape_string($conn, $_POST['criticidade']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $colaboradorId = isset($_POST['colaborador_id']) && !empty($_POST['colaborador_id']) ? intval($_POST['colaborador_id']) : "NULL";

    // Atualiza os dados no banco de dados
    $query = "UPDATE chamados 
              SET cliente_id = $clienteId, descricao = '$descricao', criticidade = '$criticidade', 
                  status = '$status', colaborador_id = $colaboradorId 
              WHERE id = $idChamado";

    if (mysqli_query($conn, $query)) {
        echo "Chamado atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar o chamado: " . mysqli_error($conn);
    }
    exit();
}

// Busca os dados do chamado para exibição
$query = "SELECT * FROM chamados WHERE id = $idChamado";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "Chamado não encontrado.";
    exit();
}

$chamado = mysqli_fetch_assoc($result);

// Busca os dados de clientes e colaboradores para os selects
$clientes = mysqli_query($conn, "SELECT id, nome FROM clientes");
$colaboradores = mysqli_query($conn, "SELECT id, nome FROM colaboradores");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Chamado</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Editar Chamado</h1>
        <form action="editar_chamado.php?id=<?php echo $idChamado; ?>" method="POST">
            <div>
                <label for="cliente_id">Cliente:</label>
                <select id="cliente_id" name="cliente_id" required>
                    <option value="">Selecione o Cliente</option>
                    <?php
                    while ($cliente = mysqli_fetch_assoc($clientes)) {
                        $selected = $cliente['id'] == $chamado['cliente_id'] ? "selected" : "";
                        echo "<option value='{$cliente['id']}' $selected>{$cliente['nome']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div>
                <label for="descricao">Descrição do Problema:</label>
                <textarea id="descricao" name="descricao" required><?php echo htmlspecialchars($chamado['descricao']); ?></textarea>
            </div>
            <div>
                <label for="criticidade">Criticidade:</label>
                <select id="criticidade" name="criticidade" required>
                    <option value="baixa" <?php echo $chamado['criticidade'] === 'baixa' ? 'selected' : ''; ?>>Baixa</option>
                    <option value="média" <?php echo $chamado['criticidade'] === 'média' ? 'selected' : ''; ?>>Média</option>
                    <option value="alta" <?php echo $chamado['criticidade'] === 'alta' ? 'selected' : ''; ?>>Alta</option>
                </select>
            </div>
            <div>
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="aberto" <?php echo $chamado['status'] === 'aberto' ? 'selected' : ''; ?>>Aberto</option>
                    <option value="em andamento" <?php echo $chamado['status'] === 'em andamento' ? 'selected' : ''; ?>>Em Andamento</option>
                    <option value="resolvido" <?php echo $chamado['status'] === 'resolvido' ? 'selected' : ''; ?>>Resolvido</option>
                </select>
            </div>
            <div>
                <label for="colaborador_id">Colaborador Responsável (Opcional):</label>
                <select id="colaborador_id" name="colaborador_id">
                    <option value="">Nenhum</option>
                    <?php
                    while ($colaborador = mysqli_fetch_assoc($colaboradores)) {
                        $selected = $colaborador['id'] == $chamado['colaborador_id'] ? "selected" : "";
                        echo "<option value='{$colaborador['id']}' $selected>{$colaborador['nome']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit">Salvar Alterações</button>
        </form>
        <a href="gerenciamento_chamados.php">Voltar</a>
    </div>
</body>
</html>