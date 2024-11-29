<?php
// Incluir a conexão com o banco de dados
include("db.php");

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe os dados do formulário
    $title = $_POST['title'];
    $description = $_POST['description'];
    $release_date = $_POST['release_date'];
    $image = $_FILES['image']['name'];

    // Caminho para onde a imagem será movida
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_folder = "imagens/" . basename($image);

    // Mover a imagem para a pasta desejada
    if (move_uploaded_file($image_tmp, $image_folder)) {
        try {
            // Preparar a query para inserir o filme no banco de dados
            $query = "INSERT INTO catalogofilmes (title, description, image, release_date) VALUES (:title, :description, :image, :release_date)";
            $stmt = $pdo->prepare($query);

            // Vincular os parâmetros
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':image', $image_folder);
            $stmt->bindParam(':release_date', $release_date);

            // Executar a query
            if ($stmt->execute()) {
                echo "Filme adicionado com sucesso!";
            } else {
                echo "Erro ao adicionar filme.";
            }
        } catch (PDOException $e) {
            echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
        }
    } else {
        echo "Erro ao fazer upload da imagem.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Filme</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group input[type="file"] {
            padding: 5px;
        }
        button {
            background-color: #007BFF;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Adicionar Filme</h1>
        <form action="adicionar_filme.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Título do Filme:</label>
                <input type="text" name="title" id="title" required>
            </div>
            <div class="form-group">
                <label for="description">Descrição:</label>
                <textarea name="description" id="description" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="release_date">Data de Lançamento:</label>
                <input type="date" name="release_date" id="release_date" required>
            </div>
            <div class="form-group">
                <label for="image">Imagem do Filme:</label>
                <input type="file" name="image" id="image" accept="image/*" required>
            </div>
            <button type="submit">Adicionar Filme</button>
        </form>
    </div>
</body>
</html>
