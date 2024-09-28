<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>
    <link rel="stylesheet" href="script.css"> <!-- Substitua 'styles.css' pelo caminho do seu arquivo CSS -->
</head>

<body>
    <div class="container">
        <h2>Cadastrar usuário</h2>
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
            <a href="main.php" class="button-link">Login</a>
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
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Hash da senha

    // Verificar se o usuário já existe
    $sql_select = "SELECT * FROM usuarios WHERE nome = ?";
    $stmt = $conn->prepare($sql_select);
    $stmt->bind_param("s", $nome);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['message'] = 'Usuário existente!';
        header("Location: " . $_SERVER['PHP_SELF']);
    } else {
        $sql_insert = "INSERT INTO usuarios (nome, senha) VALUES (?, ?)";
        $stmt = $conn->prepare($sql_insert);
        $stmt->bind_param("ss", $nome, $senha);

        if ($stmt->execute()) {
            $_SESSION['message'] = 'Novo registro criado com sucesso!';
            header("Location: main.php");
        } else {
            $_SESSION['message'] = 'Erro: ' . $stmt->error;
            header("Location: " . $_SERVER['PHP_SELF']);
        }
    }
}

$conn->close();
?>