<?php
$servidor = "localhost";
$usuario = "root"; 
$senha = ""; 
$banco = "db_projeto1_php";

$conn = new mysqli($servidor, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe os dados do formulário e os sanitiza
    $username = trim(htmlspecialchars($_POST['username']));
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));
    $confirmar_password = trim(htmlspecialchars($_POST['confirmar_password']));
    $data_nascimento = trim(htmlspecialchars($_POST['data_nascimento']));

    // Validações dos campos
    if (empty($username) || empty($email) || empty($password) || empty($confirmar_password) || empty($data_nascimento)) {
        $erro = "Todos os campos são obrigatórios!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Por favor, insira um email válido.";
    } else {
        if ($password !== $confirmar_password) {
            $erro = "As senhas não coincidem!";
        } else {
            // Criptografando a senha antes de salvar no banco de dados
            $password_criptografada = password_hash($password, PASSWORD_BCRYPT);

            // Consulta SQL para inserir os dados no banco
            $sql = "INSERT INTO admin_users (username, email, password, data_nascimento) VALUES (?, ?, ?, ?)";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ssss", $username, $email, $password_criptografada, $data_nascimento);

                if ($stmt->execute()) {
                    $sucesso = "Cadastro realizado com sucesso!";
                } else {
                    $erro = "Erro ao cadastrar: " . $stmt->error;
                }

                $stmt->close();
            } else {
                $erro = "Erro ao preparar a consulta: " . $conn->error;
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Cadastro de Admin</title>
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
        <form action="admin_cadastro.php" method="POST">
            <fieldset>
                <legend><b>Cadastre-se aqui!</b></legend>
                <br>

                <?php if (isset($erro)): ?>
                    <p class="msg"><?= $erro; ?></p>
                <?php elseif (isset($sucesso)): ?>
                    <p class="msg success"><?= $sucesso; ?></p>
                <?php endif; ?>

                <div class="inputBox">
                    <input type="text" name="username" id="username" class="inputUser" required>
                    <label for="username" class="labelInput">Username</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="email" name="email" id="email" class="inputUser" required>
                    <label for="email" class="labelInput">Email</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="password" name="password" id="password" class="inputUser" required>
                    <label for="password" class="labelInput">Password</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="password" name="confirmar_password" id="confirmar_password" class="inputUser" required>
                    <label for="confirmar_password" class="labelInput">Confirmação de Password</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <label for="data_nascimento"><b>Data de nascimento</b></label>
                    <input type="date" name="data_nascimento" id="data_nascimento" required>
                </div>
                <br><br>
                <input type="submit" href="index.php" id="submit" value="Cadastrar">
                <nav>
                    <ul>
                        <li><a href="admin_pginicial.php">Voltar para o início</a></li>
                    </ul>
                </nav>
            </fieldset>
        </form>
    </div>
</body>
</html>
