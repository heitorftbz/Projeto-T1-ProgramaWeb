<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim(htmlspecialchars($_POST['nome']));
    $email = trim(htmlspecialchars($_POST['email']));
    $senha = trim(htmlspecialchars($_POST['senha']));
    $confirmar_senha = trim(htmlspecialchars($_POST['confirmar_senha']));
    $data_nascimento = trim(htmlspecialchars($_POST['data_nascimento']));

    if (empty($nome) || empty($email) || empty($senha) || empty($confirmar_senha) || empty($data_nascimento)) {
        $erro = "Todos os campos são obrigatórios!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Por favor, insira um email válido.";
    } else {
        if ($senha !== $confirmar_senha) {
            $erro = "As senhas não coincidem!";
        } else {
            $senha_criptografada = password_hash($senha, PASSWORD_BCRYPT);

            try {
                $sql = "INSERT INTO login (usuario, email, senha, data_nascimento) VALUES (:nome, :email, :senha, :data_nascimento)";
                $stmt = $pdo->prepare($sql);

                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':senha', $senha_criptografada);
                $stmt->bindParam(':data_nascimento', $data_nascimento);

                if ($stmt->execute()) {
                    $sucesso = "Cadastro realizado com sucesso!";
                } else {
                    $erro = "Erro ao cadastrar: " . implode(", ", $stmt->errorInfo());
                }
            } catch (PDOException $e) {
                $erro = "Erro ao executar a consulta: " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Cadastro</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('https://wallpapers.com/images/featured/movie-9pvmdtvz4cb0xl37.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: rgba(0, 0, 0, 0.7);
        }

        .box {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 30px;
            border-radius: 10px;
            width: 400px;
            text-align: center;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
        }

        h2 {
            color: #e50914;
        }

        .inputBox {
            position: relative;
            margin-bottom: 20px;
        }

        .inputUser {
            background: none;
            border: none;
            border-bottom: 1px solid white;
            outline: none;
            color: white;
            font-size: 15px;
            width: 100%;
            padding: 10px 0;
            letter-spacing: 2px;
        }

        .labelInput {
            position: absolute;
            top: 0px;
            left: 0px;
            pointer-events: none;
            transition: .5s;
            color: #bbb;
        }

        .inputUser:focus ~ .labelInput,
        .inputUser:valid ~ .labelInput {
            top: -20px;
            font-size: 12px;
            color: #e50914;
        }

        input[type="date"] {
            background: none;
            border: none;
            border-bottom: 1px solid white;
            color: white;
            font-size: 15px;
            padding: 8px;
            width: 100%;
        }

        #submit {
    background-color: #e50914; /* Alterado para vermelho */
    width: 100%;
    border: none;
    padding: 15px;
    color: white;
    font-size: 15px;
    cursor: pointer;
    border-radius: 10px;
    transition: background-color 0.3s;
}

#submit:hover {
    background-color: #b4070f; /* Um tom de vermelho mais escuro para o hover */
}

        .msg {
            color: red;
            text-align: center;
        }

        .success {
            color: green;
        }

        nav {
            margin-top: 15px;
        }

        nav a {
            color: #e50914;
            text-decoration: none;
            font-weight: bold;
        }

    </style>
</head>
<body>

    <div class="container">
        <div class="box">
            <form action="cadastro.php" method="POST">
                <h2>Cadastre-se</h2>
                <?php if (isset($erro)): ?>
                    <p class="msg"><?= $erro; ?></p>
                <?php elseif (isset($sucesso)): ?>
                    <p class="msg success"><?= $sucesso; ?></p>
                <?php endif; ?>

                <div class="inputBox">
                    <input type="text" name="nome" id="nome" class="inputUser" required>
                    <label for="nome" class="labelInput">Nome completo</label>
                </div>

                <div class="inputBox">
                    <input type="email" name="email" id="email" class="inputUser" required>
                    <label for="email" class="labelInput">Email</label>
                </div>

                <div class="inputBox">
                    <input type="password" name="senha" id="senha" class="inputUser" required>
                    <label for="senha" class="labelInput">Senha</label>
                </div>

                <div class="inputBox">
                    <input type="password" name="confirmar_senha" id="confirmar_senha" class="inputUser" required>
                    <label for="confirmar_senha" class="labelInput">Confirme a senha</label>
                </div>

                <div class="inputBox">
                    <label for="data_nascimento"><b>Data de nascimento</b></label>
                    <input type="date" name="data_nascimento" id="data_nascimento" required>
                </div>

                <input type="submit" id="submit" value="Cadastrar">

                <nav>
                    
                    <a href="index.php">Voltar para Login</a></li>
                    
                </nav>
            </form>
        </div>
    </div>

</body>
</html>
