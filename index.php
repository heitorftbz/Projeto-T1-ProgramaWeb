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
  <style>
    /* Carregar a fonte Poppins do Google Fonts */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap');

    body {
      font-family: 'Roboto', sans-serif;
      background-image: url('https://wallpapers.com/images/featured/movie-9pvmdtvz4cb0xl37.jpg');
      background-size: cover;
      background-position: center;
      color: #f3f3f3;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login-container {
      background-color: rgba(0, 0, 0, 0.75); /* Fundo preto com transparência */
      padding: 40px 30px;
      border-radius: 10px;
      box-shadow: 0 8px 15px rgba(0, 0, 0, 0.6);
      width: 100%;
      max-width: 400px;
      text-align: center;
    }

    /* Estilo da palavra 'Login' */
    h1 {
      font-family: 'Poppins', sans-serif; /* Fonte moderna */
      font-size: 3rem; /* Tamanho maior */
      margin-bottom: 20px;
      color: #e50914; /* Cor vermelha estilo Netflix */
      font-weight: 600; /* Deixa o texto mais grosso */
      text-transform: uppercase; /* Texto em maiúsculas */
      letter-spacing: 2px; /* Aumenta o espaçamento entre as letras */
      text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.6); /* Sombra para dar profundidade */
    }

    .message {
      color: #e50914;
      font-size: 1.2rem;
      margin-bottom: 20px;
    }

    .login-container input {
      width: 100%;
      padding: 15px;
      margin: 10px 0;
      border: 1px solid #444;
      border-radius: 5px;
      background-color: rgba(255, 255, 255, 0.1);
      color: white;
      font-size: 1rem;
      box-sizing: border-box;
      outline: none;
      transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .login-container input:focus {
      background-color: rgba(255, 255, 255, 0.2);
      border-color: #e50914;
    }

    .login-container button {
      width: 100%;
      padding: 15px;
      background-color: #e50914;
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 1.2rem;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .login-container button:hover {
      background-color: #b20600; /* Cor vermelha mais escura */
    }

    .register-link {
      color: #fff;
      text-decoration: none;
      font-size: 1rem;
      margin-top: 15px;
      display: block;
    }

    .register-link:hover {
      text-decoration: underline;
      color: #e50914;
    }
  </style>
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
      <br><br>
      <input type="password" name="password" placeholder="Senha" required>
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
