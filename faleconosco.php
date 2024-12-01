<?php
require_once 'db.php';

// Exibir erros para depuração
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim(htmlspecialchars($_POST['nome']));
    $email = trim(htmlspecialchars($_POST['email']));
    $mensagem = trim(htmlspecialchars($_POST['mensagem']));

    // Validação dos campos
    if (empty($nome) || empty($email) || empty($mensagem)) {
        $erro = "Todos os campos são obrigatórios!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Por favor, insira um email válido.";
    } else {
        // Inserindo no banco de dados
        try {
            $sql = "INSERT INTO mensagens (nome, email, mensagem) VALUES (:nome, :email, :mensagem)";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':mensagem', $mensagem);

            if ($stmt->execute()) {
                $sucesso = "Mensagem enviada com sucesso!";
            } else {
                $erro = "Erro ao enviar mensagem: " . implode(", ", $stmt->errorInfo());
            }
        } catch (PDOException $e) {
            $erro = "Erro ao executar a consulta: " . $e->getMessage();
        }
    }

    // Mensagem de retorno para exibição no HTML
    $msg = isset($erro) ? $erro : (isset($sucesso) ? $sucesso : '');
}
?>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fale Conosco</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #141414;
            margin: 0;
            padding: 0;
            color: #f0f0f0;
        }
        .contato {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: #2f2f2f;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.5);
        }
        h3 {
            text-align: center;
            color: #e50914;
            font-size: 28px;
            margin-bottom: 20px;
            font-weight: bold;
        }
        label {
            font-size: 16px;
            color: #ccc;
            margin-bottom: 8px;
            display: block;
        }
        input, textarea {
            width: 100%;
            padding: 14px;
            border: 1px solid #444;
            border-radius: 8px;
            font-size: 16px;
            margin-bottom: 20px;
            background-color: #3a3a3a;
            color: #fff;
            transition: border-color 0.3s ease-in-out;
        }
        input:focus, textarea:focus {
            border-color: #e50914;
            background-color: #333;
        }
        input[type="submit"] {
            background-color: #e50914;
            color: white;
            border: none;
            font-size: 16px;
            padding: 14px;
            cursor: pointer;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #b20710;
        }
        textarea {
            height: 150px;
            resize: vertical;
        }
        .msg {
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
            color: #fff;
        }
        .voltar-btn {
            background-color: #333;
            color: #e50914;
            border: 1px solid #444;
            font-size: 16px;
            padding: 12px;
            cursor: pointer;
            border-radius: 8px;
            width: 100%;
            text-align: center;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .voltar-btn:hover {
            background-color: #e50914;
            color: white;
        }
        @media (max-width: 600px) {
            .contato {
                padding: 20px;
                margin: 20px;
            }
            h3 {
                font-size: 24px;
            }
        }
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        .contato {
            animation: fadeIn 0.8s ease-in-out;
        }
    </style>
</head>
<body>
    <div class="contato">
        <h3>Fale Conosco</h3>
        <form action="faleconosco.php" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
            
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="mensagem">Mensagem:</label>
            <textarea id="mensagem" name="mensagem" required></textarea>
            
            <input type="submit" value="Enviar">
        </form>

        <?php if (isset($msg)): ?>
            <div class="msg"><?= htmlspecialchars($msg); ?></div>
        <?php endif; ?>

        <button class="voltar-btn" onclick="window.history.back();">Voltar</button>
    </div>
</body>
</html>
