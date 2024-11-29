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
        /* Estilo Moderno */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #141414, #333);
            color: #fff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: #1c1c1c;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.7);
            max-width: 600px;
            width: 100%;
        }

        h1 {
            text-align: center;
            font-size: 32px;
            color: #e50914;
            margin-bottom: 20px;
            letter-spacing: 1px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            margin-bottom: 8px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #444;
            background: #222;
            color: #fff;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-group input[type="file"] {
            padding: 8px;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #e50914;
            box-shadow: 0 0 10px rgba(229, 9, 20, 0.6);
            outline: none;
        }

        button {
            width: 100%;
            padding: 14px;
            background-color: #e50914;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        button:hover {
            background-color: #b20710;
            transform: scale(1.05);
        }

        .btn-back {
            background-color: #333;
            color: #fff;
            padding: 14px;
            text-align: center;
            font-size: 18px;
            border-radius: 8px;
            margin-top: 20px;
            transition: background-color 0.3s ease;
            cursor: pointer;
            display: block;
            width: 100%;
        }

        .btn-back:hover {
            background-color: #555;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
                max-width: 90%;
            }

            h1 {
                font-size: 28px;
            }

            button, .btn-back {
                font-size: 16px;
            }
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

        <!-- Botão para voltar à página inicial -->
        <form action="pginicial.php" method="get">
            <button type="submit" class="btn-back">Voltar à Página Inicial</button>
        </form>
    </div>
</body>
</html>
