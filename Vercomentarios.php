<?php
require 'db.php'; // Inclui a conexão ao banco de dados

$filme_id = isset($_GET['id']) ? $_GET['id'] : 1; // Obtém o ID do filme da URL, caso contrário, define um padrão

// Consulta para obter o filme
$sql = "SELECT * FROM filmes WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $filme_id, PDO::PARAM_INT);
$stmt->execute();
$filme = $stmt->fetch(PDO::FETCH_ASSOC);

// Consulta para obter os comentários do filme
$comentarios_sql = "SELECT * FROM comentarios WHERE filme_id = :id ORDER BY data_comentario DESC";
$comentarios_stmt = $pdo->prepare($comentarios_sql);
$comentarios_stmt->bindParam(':id', $filme_id, PDO::PARAM_INT);
$comentarios_stmt->execute();
$comentarios = $comentarios_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentários do Filme</title>
    <link rel="stylesheet" href="style.css"> <!-- Incluindo o arquivo CSS -->
</head>
<body>

<header>
    <h1>Comentários sobre: <?= htmlspecialchars($filme['title']) ?></h1>
</header>

<main>
    <div class="movie-container">
        <?php if ($comentarios): ?>
            <?php foreach ($comentarios as $comentario): ?>
                <div class="comment-card">
                    <p class="comment-author"><?= htmlspecialchars($comentario['autor']) ?> disse:</p>
                    <p class="comment-text"><?= htmlspecialchars($comentario['comentario']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-comments">Nenhum comentário encontrado.</p>
        <?php endif; ?>
    </div>
</main>

<footer>
    <?php include_once("rodape.php"); ?>
</footer>

</body>
</html>

<?php
$pdo = null;  // Fechando a conexão
?>
