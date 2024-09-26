<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="script.css"> <!-- Substitua 'styles.css' pelo caminho do seu arquivo CSS -->
</head>

<body>
    <div class="container">
        <h2>Cadastrar usuário</h2>
        <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="input-group">
                <label for="nome">Usuário:</label>
                <input type="text" name="nome" id="nome" placeholder="Digite seu usuário" required>
            </div>
            <div class="input-group">
                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha" placeholder="Digite sua senha" required>
            </div>
            <button class="button" name="ok" type="submit">Ok</button>
            <a href="main.php" class="button-link">Login</a> <!-- Botão link para login.php -->
        </form>
    </div>
</body>

</html>

<?php

session_start(); // Iniciar a sessão no topo do arquivo PHP
if (isset($_SESSION['message'])) {
    echo "<script>
alert('" . $_SESSION['
    message '] . "');
</script>";
    unset($_SESSION['message']); // Limpar a mensagem após exibi-la
}
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificar se o botão "Ok" foi pressionado
if (isset($_GET['ok']) && isset($_GET['nome']) && isset($_GET['senha'])) {
    $nome = $_GET['nome'];
    $senha = $_GET['senha'];

    // Verificar se o usuário já existe
    $sql_select = "SELECT * FROM usuarios WHERE nome = '$nome'";
    $result = $conn->query($sql_select);

    if ($result->num_rows > 0) {
        $_SESSION['message'] = 'Usuario existente!';
        header("Location: " . $_SERVER['PHP_SELF']);
    } else {
        $sql_insert = "INSERT INTO usuarios (nome, senha) VALUES ('$nome', '$senha')";

        if ($conn->query($sql_insert) === TRUE) {
            $_SESSION['message'] = 'Novo registro criado com sucesso!';
        } else {
            $_SESSION['message'] = 'Erro: ' . $conn->error;
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }



    //

    exit;
}

?>