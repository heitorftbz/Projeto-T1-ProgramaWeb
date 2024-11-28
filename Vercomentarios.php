<?php
include('db.php');

$sql = "SELECT * FROM filmes";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feed de Filmes</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        header {
            background-color: #343a40;
            color: #fff;
            width: 100%;
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            margin: 0;
            font-size: 36px;
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
            transition: transform 0.3s;
        }

        .movie-card:hover {
            transform: translateY(-10px);
        }

        .movie-image {
            width: 100%;
            height: 200px;
            object-fit: contain; /* Exibe a imagem inteira */
            background-color: #f0f0f0; /* Cor de fundo para preencher espaços vazios */
        }

        .movie-info {
            padding: 15px;
        }

        .movie-title {
            font-size: 20px;
            font-weight: bold;
            color: #007bff;
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

        .no-movies {
            text-align: center;
            color: #888;
            font-size: 18px;
            margin-top: 20px;
        }

        footer {
            background-color: #343a40;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            width: 100%;
            position: relative;
            bottom: 0;
        }

        @media (max-width: 768px) {
            .movie-container {
                grid-template-columns: 1fr;
                width: 95%;
            }
        }
    </style>
</head>
<body>

<header>
    <h1>Feed de Filmes</h1>
</header>

<main>
    <div class="movie-container">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="movie-card">
                    <?php if (!empty($row['image'])): ?>
                        <img class="movie-image" src="<?= htmlspecialchars($row['image']) ?>" alt="Imagem do filme">
                    <?php endif; ?>
                    <div class="movie-info">
                        <h3 class="movie-title"><?= htmlspecialchars($row['title']) ?></h3>
                        <p class="movie-description"><?= htmlspecialchars($row['description']) ?></p>
                        <p class="movie-user">Postado por: <?= htmlspecialchars($row['user']) ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="no-movies">Nenhum filme encontrado.</p>
        <?php endif; ?>
    </div>
</main>

<footer>
    <?php include_once("rodape.php"); ?>
</footer>

</body>
</html>

<?php
$conn->close();
?>
