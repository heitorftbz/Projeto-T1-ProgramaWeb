<?php
// Configurações de conexão com o banco de dados
$servidor = "localhost";
$usuario = "root"; // Altere para o seu usuário do banco de dados
$senha = ""; // Altere para a senha do banco de dados
$banco = "db_projeto1_php"; // Nome do banco de dados

// Criar conexão
$conn = new mysqli($servidor, $usuario, $senha, $banco);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Processar o formulário quando enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar e capturar dados do formulário
    $nome = trim(htmlspecialchars($_POST['nome']));
    $email = trim(htmlspecialchars($_POST['email']));
    $senha = trim(htmlspecialchars($_POST['senha']));
    $confirmar_senha = trim(htmlspecialchars($_POST['confirmar_senha']));
    $data_nascimento = trim(htmlspecialchars($_POST['data_nascimento']));

    // Verificar se todos os campos foram preenchidos
    if (empty($nome) || empty($email) || empty($senha) || empty($confirmar_senha) || empty($data_nascimento)) {
        $erro = "Todos os campos são obrigatórios!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Por favor, insira um email válido.";
    } else {
        // Verificar se as senhas coincidem
        if ($senha !== $confirmar_senha) {
            $erro = "As senhas não coincidem!";
        } else {
            // Criptografar a senha
            $senha_hashed = password_hash($senha, PASSWORD_DEFAULT);

            // Preparar a consulta SQL para inserir os dados
            $sql = "INSERT INTO login (usuario, email, senha, data_nascimento) VALUES (?, ?, ?, ?)";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ssss", $nome, $email, $senha_hashed, $data_nascimento);

                // Executar a consulta e verificar o sucesso
                if ($stmt->execute()) {
                    $sucesso = "Cadastro realizado com sucesso!";
                } else {
                    $erro = "Erro ao cadastrar: " . $stmt->error;
                }

                // Fechar o comando preparado
                $stmt->close();
            } else {
                $erro = "Erro ao preparar a consulta: " . $conn->error;
            }
        }
    }
}

// Fechar a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Cadastro</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-image: linear-gradient(to right, rgb(20, 147, 220), rgb(17, 54, 71));
        }
        .box {
            color: white;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.8);
            padding: 15px;
            border-radius: 15px;
            width: 20%;
        }
        fieldset {
            border: 3px solid dodgerblue;
        }
        legend {
            border: 1px solid dodgerblue;
            padding: 10px;
            text-align: center;
            background-color: dodgerblue;
            border-radius: 10px;
        }
        .inputBox {
            position: relative;
        }
        .inputUser {
            background: none;
            border: none;
            border-bottom: 1px solid white;
            outline: none;
            color: white;
            font-size: 15px;
            width: 100%;
            letter-spacing: 2px;
        }
        .labelInput {
            position: absolute;
            top: 0px;
            left: 0px;
            pointer-events: none;
            transition: .5s;
        }
        .inputUser:focus ~ .labelInput,
        .inputUser:valid ~ .labelInput {
            top: -20px;
            font-size: 12px;
            color: dodgerblue;
        }
        #data_nascimento {
            border: none;
            padding: 8px;
            border-radius: 10px;
            outline: none;
            font-size: 15px;
        }
        #submit {
            background-image: linear-gradient(to right, rgb(0, 92, 197), rgb(90, 20, 220));
            width: 100%;
            border: none;
            padding: 15px;
            color: white;
            font-size: 15px;
            cursor: pointer;
            border-radius: 10px;
        }
        .msg {
            color: red;
            text-align: center;
        }
        .success {
            color: green;
        }
    </style>
</head>
<body>
    <div class="box">
        <form action="cadastro.php" method="POST">
            <fieldset>
                <legend><b>Cadastre-se aqui!</b></legend>
                <br>

                <!-- Mensagem de erro ou sucesso -->
                <?php if (isset($erro)): ?>
                    <p class="msg"><?= $erro; ?></p>
                <?php elseif (isset($sucesso)): ?>
                    <p class="msg success"><?= $sucesso; ?></p>
                <?php endif; ?>

                <div class="inputBox">
                    <input type="text" name="nome" id="nome" class="inputUser" required>
                    <label for="nome" class="labelInput">Nome completo</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="email" name="email" id="email" class="inputUser" required>
                    <label for="email" class="labelInput">Email</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="password" name="senha" id="senha" class="inputUser" required>
                    <label for="senha" class="labelInput">Senha</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="password" name="confirmar_senha" id="confirmar_senha" class="inputUser" required>
                    <label for="confirmar_senha" class="labelInput">Confirmação de senha</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <label for="data_nascimento"><b>Data de nascimento</b></label>
                    <input type="date" name="data_nascimento" id="data_nascimento" required>
                </div>
                <br><br>
                <input type="submit" id="submit" value="Cadastrar">
            </fieldset>
        </form>
    </div>
</body>
</html>
