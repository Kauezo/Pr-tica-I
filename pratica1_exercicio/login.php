<?php
session_start();
include "dbconnect.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $senha = mysqli_real_escape_string($conn, $_POST["senha"]);

    // Verifica o email e a senha na tabela adm
    $query = "SELECT * FROM adm WHERE email = '$email' AND senha = '$senha'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION["email"] = $email;
        header("Location: adm_area.php"); // Redireciona para a tela de administrador
        exit();
    } else {
        $message = "Email ou senha incorretos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <h1>Login - Administrador</h1>
        <?php if ($message): ?>
            <p class="error"><?php echo $message; ?></p>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>