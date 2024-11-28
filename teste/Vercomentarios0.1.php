<?php
// Incluir arquivo de conexão com o banco de dados
include('db.php');

// Consultar todos os filmes
$sql = "SELECT * FROM filmes";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feed de Filmes</title>

    <!-- Estilos internos para melhorar a aparência -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        h1 {
            font-size: 36px;
            color: #343a40;
            margin-bottom: 30px;
        }

        .movie-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            width: 80%;
            max-width: 1200px;
        }

        .movie-card {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s;
        }

        .movie-card:hover {
            transform: translateY(-10px);
        }

        .movie-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 2px solid #ddd;
        }

        .movie-info {
            padding: 15px;
        }

        .movie-title {
            font-size: 20px;
            font-weight: bold;
            color: #007bff;
            margin: 0;
            margin-bottom: 10px;
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

        /* Responsividade para dispositivos móveis */
        @media (max-width: 768px) {
            .movie-container {
                grid-template-columns: 1fr;
                width: 95%;
            }
        }
    </style>

</head>
<body>

<h1>Feed de Filmes</h1>
<div class="movie-container">
    <?php
    // Verifica se a consulta retornou resultados
    if ($result->num_rows > 0) {
        // Exibir cada filme
        while($row = $result->fetch_assoc()) {
            echo '<div class="movie-card">';
            echo '<img src="' . $row['image'] . '" alt="' . $row['title'] . '" class="movie-image">';
            echo '<div class="movie-info">';
            echo '<h3 class="movie-title">' . $row['title'] . '</h3>';
            echo '<p class="movie-description">' . $row['description'] . '</p>';
            echo '<p class="movie-user">Postado por: ' . $row['user'] . '</p>';
            echo '</div></div>';
        }
    } else {
        echo '<p>Nenhum filme encontrado.</p>';
    }

    // Fechar a conexão
    $conn->close();
    ?>
</div>

</body>
</html>
