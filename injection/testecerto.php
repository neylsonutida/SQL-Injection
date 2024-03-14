<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'test';

$conn = new mysqli($servername, $username, $password, $dbname);

if($error = $conn->connect_error) {
    die('Erro de conexão: ' . $error);
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    //  Prepare a consulta SQL com um espaço reservado para os valores
    $sql = "SELECT * FROM usuarios WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    
    // Vincule os parâmetros e execute a consulta
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();

    // Obtenha os parâmetros e execute a consulta
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        echo "Login realizado com sucesso";
    } else {   
        echo "Usuario ou senha incorretos!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="username">Usuário:</label><br>
        <input type="text" id="username" name="username"><br>
        <label for="password">Senha:</label><br>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>