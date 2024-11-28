<?php
include('db.php');  // Conexão com o banco de dados

$message = '';  // Mensagem a ser exibida ao usuário

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura e sanitiza os dados
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Consulta SQL para buscar o usuário
    $query = "SELECT * FROM login WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Verifica se a consulta retornou um resultado
    if ($result->num_rows > 0) {
        // Obtém o usuário
        $login = $result->fetch_assoc();
        
        // Verifica se a senha fornecida bate com a do banco de dados usando password_verify
        if (password_verify($password, $login['senha'])) {
            // Senha correta, redireciona para a página inicial
            header('Location: pginicial.php');
            exit(); // Importante para garantir que o script PHP pare após o redirecionamento
        } else {
            $message = "Email ou senha incorretos.";
        }
    } else {
        $message = "Email ou senha incorretos.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tela de Login</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="login-container">
    <h1>Login</h1>
    
    <!-- Exibe a mensagem, se houver -->
    <?php if (!empty($message)): ?>
      <p class="message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    
    <form action="" method="POST">
      <input type="email" name="email" placeholder="Email" required>
      <span class="icon"><ion-icon name="mail"></ion-icon></span>
      <br><br>
      <input type="password" name="password" placeholder="Senha" required>
      <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
      <br><br>
      <button type="submit">Entrar</button>
      <p>Não tem uma conta? <a href="cadastro.php" class="register-link">Cadastre-se</a></p>
    </form>
  </div>

  <script src="script.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
