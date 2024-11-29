<?php
include('db.php');  // Inclui a conexão PDO

$message = '';  // Mensagem a ser exibida ao usuário

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura os dados do formulário
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Consulta SQL para buscar o usuário
        $query = "SELECT * FROM login WHERE email = :email";
        $stmt = $pdo->prepare($query);
        
        // Bind do parâmetro
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        // Verifica se a consulta retornou um resultado
        if ($stmt->rowCount() > 0) {
            $login = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Verifica se a senha fornecida bate com a do banco de dados usando password_verify
            if (password_verify($password, $login['senha'])) {
                // Senha correta, redireciona para a página inicial
                header('Location: pginicial.php');
                exit(); // Impede que o script continue executando após o redirecionamento
            } else {
                $message = "Email ou senha incorretos.";
            }
        } else {
            $message = "Email ou senha incorretos.";
        }
    } catch (PDOException $e) {
        $message = "Erro ao consultar o banco de dados: " . $e->getMessage();
    }
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
