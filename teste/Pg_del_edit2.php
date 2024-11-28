<?php
include('db.php');


session_start();
$usuario_logado = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;

$sql = "SELECT * FROM filmes";
$result = $conn->query($sql);

if (isset($_GET['apagar_comentario'])) {
    $comentario_id = $_GET['apagar_comentario'];
    $sql = "DELETE FROM comentarios WHERE id = $comentario_id AND usuario = '$usuario_logado'";
    $conn->query($sql);
    header("Location: feed_filmes.php");
}


if (isset($_POST['editar_comentario'])) {
    $comentario_id = $_POST['comentario_id'];
    $novo_comentario = $_POST['comentario'];
    $sql = "UPDATE comentarios SET comentario = '$novo_comentario' WHERE id = $comentario_id AND usuario = '$usuario_logado'";
    $conn->query($sql);
    header("Location: feed_filmes.php"); 
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feed de Filmes</title>

    <style>

        body 
        {
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

        h1 
        {
            font-size: 36px;
            color: #343a40;
            margin-bottom: 30px;
        }

        .movie-container 
        {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            width: 80%;
            max-width: 1200px;
        }

        .movie-card 
        {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s;
        }

        .movie-card:hover 
        {
            transform: translateY(-10px);
        }

        .movie-image 
        {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 2px solid #ddd;
        }

        .movie-info 
        {
            padding: 15px;
        }

        .movie-title 
        {
            font-size: 20px;
            font-weight: bold;
            color: #007bff;
            margin: 0;
            margin-bottom: 10px;
        }

        .movie-description 
        {
            font-size: 14px;
            color: #555;
            margin-bottom: 10px;
        }

        .movie-user 
        {
            font-size: 12px;
            color: #888;
            text-align: right;
        }

        /* Comentários */
        .comentarios 
        {
            margin-top: 20px;
        }

        .comentario 
        {
            background-color: #f1f1f1;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .comentario p 
        
        {
            margin: 0;
        }

        .comentario-actions {
            margin-top: 10px;
            text-align: right;
        }

        @media (max-width: 768px)
        {
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
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '<div class="movie-card">';
            echo '<img src="' . $row['image'] . '" alt="' . $row['title'] . '" class="movie-image">';
            echo '<div class="movie-info">';
            echo '<h3 class="movie-title">' . $row['title'] . '</h3>';
            echo '<p class="movie-description">' . $row['description'] . '</p>';
            echo '<p class="movie-user">Postado por: ' . $row['user'] . '</p>';

            $filme_id = $row['id'];
            $sql_comentarios = "SELECT * FROM comentarios WHERE filme_id = $filme_id";
            $comentarios_result = $conn->query($sql_comentarios);
            
            echo '<div class="comentarios">';
            while ($comentario = $comentarios_result->fetch_assoc()) {
                echo '<div class="comentario">';
                echo '<p><strong>' . $comentario['usuario'] . ':</strong> ' . $comentario['comentario'] . '</p>';
                if ($comentario['usuario'] === $usuario_logado) {
                    echo '<div class="comentario-actions">';
                    echo '<a href="edit_comentario.php?id=' . $comentario['id'] . '">Editar</a> | ';
                    echo '<a href="?apagar_comentario=' . $comentario['id'] . '">Apagar</a>';
                    echo '</div>';
                }
                echo '</div>';
            }
            echo '</div>';
            
            if ($usuario_logado) {
                echo '<form method="POST" action="adicionar_comentario.php">';
                echo '<input type="hidden" name="filme_id" value="' . $row['id'] . '">';
                echo '<textarea name="comentario" placeholder="Deixe seu comentário..." required></textarea>';
                echo '<button type="submit">Comentar</button>';
                echo '</form>';
            }
            
            echo '</div></div>';
        }
    } else {
        echo '<p>Nenhum filme encontrado.</p>';
    }

    $conn->close();
    ?>
</div>

</body>
</html>
