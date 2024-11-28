<?php
include('db.php');
include_once('topo.php');

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['adicionar_filme'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $user = $_POST['user'];
    $image = $_POST['image'];

    // Adiciona um log para verificar os dados recebidos
    error_log("Recebendo: title=$title, description=$description, user=$user, image=$image");

    // Prepara a consulta SQL para adicionar o filme no banco de dados
    $sql = "INSERT INTO filmes (title, description, user, image) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Erro ao preparar a consulta: " . $conn->error);
    }

    // Realiza o bind dos parâmetros
    $stmt->bind_param("ssss", $title, $description, $user, $image);

    // Executa a consulta
    if ($stmt->execute()) {
        echo "<p style='color: green;'>Filme adicionado com sucesso!</p>";
    } else {
        echo "<p style='color: red;'>Erro ao adicionar filme: " . $stmt->error . "</p>";
    }

    // Fecha a consulta
    $stmt->close();
}

// Consulta para listar filmes do banco de dados
$sql_filmes = "SELECT * FROM filmes";
$result_filmes = $conn->query($sql_filmes);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Filme com Comentário</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            font-size: 36px;
            color: #343a40;
            margin-bottom: 30px;
        }

        .form-container {
            width: 80%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .form-container input, .form-container textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-container button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }

        .movie-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            width: 80%;
            max-width: 1200px;
            margin: 30px 0;
        }

        .movie-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .movie-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background-color: #f0f0f0;
        }

        .movie-info {
            padding: 15px;
        }

        .movie-title {
            font-size: 20px;
            font-weight: bold;
            color: #007bff;
            margin: 0 0 10px;
        }

        .movie-description {
            font-size: 14px;
            color: #555;
            margin-bottom: 10px;
        }

        .movie-user {
            font-size: 12px;
            color: #888;
            text-align: right;
        }
    </style>
</head>
<body>

<h1>Adicionar Filme</h1>

<div class="form-container">
    <form method="POST">
        <input type="url" name="image" placeholder="Link da imagem" required>
        <input type="text" name="title" placeholder="Título do Filme" required>
        <textarea name="description" placeholder="Descrição do Filme" required></textarea>
        <input type="text" name="user" placeholder="Usuário" required>
        <button type="submit" name="adicionar_filme">Adicionar Filme</button>
    </form>
</div>

<h2>Filmes Cadastrados</h2>
<div class="movie-container">
    <?php
    // Verifica se há filmes cadastrados no banco de dados
    if ($result_filmes->num_rows > 0) {
        while ($row = $result_filmes->fetch_assoc()) {
            echo '<div class="movie-card">';
            if (!empty($row['image'])) {
                echo '<img class="movie-image" src="' . htmlspecialchars($row['image']) . '" alt="Imagem do filme">';
            }
            echo '<div class="movie-info">';
            echo '<h3 class="movie-title">' . htmlspecialchars($row['title']) . '</h3>';
            echo '<p class="movie-description">' . htmlspecialchars($row['description']) . '</p>';
            echo '<p class="movie-user">Postado por: ' . htmlspecialchars($row['user']) . '</p>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p>Nenhum filme encontrado.</p>';
    }

    // Fecha a conexão com o banco de dados
    $conn->close();
    ?>
</div>

</body>
</html>

<?php include_once('rodape.php'); ?>
