<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="script.css"> <!-- Substitua 'styles.css' pelo caminho do seu arquivo CSS -->
</head>

<body>
    <div class="container">
        <h2>Login</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="input-group">
                <label for="nome">Usuário:</label>
                <input type="text" name="nome" id="nome" placeholder="Digite seu usuário" required>
            </div>
            <div class="input-group">
                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha" placeholder="Digite sua senha" required>
            </div>
            <button class="button" name="ok" type="submit">Ok</button>
            <a href="cadastrarUsuario.php" class="button-link">Novo cadastro</a>
        </form>
    </div>
</body>

</html>

<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificar se o formulário foi enviado
if (isset($_POST['ok'])) {
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    // Verificar se o usuário existe
    $sql_select = "SELECT * FROM usuarios WHERE nome = ?";
    $stmt = $conn->prepare($sql_select);
    $stmt->bind_param("s", $nome);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verificar a senha
        if (password_verify($senha, $user['senha'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: main.php"); // Redirecionar para a página principal após login
        } else {
            $_SESSION['message'] = 'Senha incorreta!';
            header("Location: " . $_SERVER['PHP_SELF']);
        }
    } else {
        $_SESSION['message'] = 'Usuário não encontrado!';
        header("Location: " . $_SERVER['PHP_SELF']);
    }
}

$conn->close();
?>