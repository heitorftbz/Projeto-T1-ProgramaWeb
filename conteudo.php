<?php
require 'db.php';  // Inclui a conexão ao banco de dados

// Consulta para obter todos os filmes
$filmes = $pdo->query("SELECT * FROM catalogofilmes ORDER BY release_date DESC")->fetchAll(PDO::FETCH_ASSOC);

$comentarios_por_filme = [];

// Consulta para buscar os comentários de todos os filmes
foreach ($filmes as $filme) {
    $filme_id = $filme['id'];
    $comentarios_stmt = $pdo->prepare("SELECT * FROM comentarios WHERE filme_id = :id ORDER BY data_comentario DESC");
    $comentarios_stmt->bindParam(':id', $filme_id, PDO::PARAM_INT);
    $comentarios_stmt->execute();
    $comentarios_por_filme[$filme_id] = $comentarios_stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Filmes com Comentários</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .catalogo {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            padding: 20px;
        }
        .filme {
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin: 15px;
            padding: 15px;
            width: 300px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .filme img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .info {
            margin-top: 10px;
        }
        .comentarios {
            margin-top: 20px;
            padding: 10px;
            border-top: 1px solid #ddd;
        }
        .comentario {
            margin-bottom: 15px;
            padding: 10px;
            background: #f1f1f1;
            border-radius: 5px;
        }
        .comentario p {
            margin: 0;
        }
        .comentario .autor {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .no-comments {
            font-style: italic;
            color: #777;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Catálogo de Filmes</h1>

    <div class="catalogo">
        <?php foreach ($filmes as $filme): ?>
            <div class="filme">
                <img src="<?= htmlspecialchars($filme['image']) ?>" alt="Imagem do Filme">
                <div class="info">
                    <h3><?= htmlspecialchars($filme['title']) ?></h3>
                    <p><?= htmlspecialchars($filme['description']) ?></p>
                    <p class="data">Lançamento: <?= htmlspecialchars($filme['release_date']) ?></p>
                </div>
                <div class="comentarios">
                    <h4>Comentários:</h4>
                    <?php if (!empty($comentarios_por_filme[$filme['id']])): ?>
                        <?php foreach ($comentarios_por_filme[$filme['id']] as $comentario): ?>
                            <div class="comentario">
                                <p class="autor"><?= htmlspecialchars($comentario['autor']) ?> disse:</p>
                                <p class="texto"><?= htmlspecialchars($comentario['comentario']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="no-comments">Nenhum comentário encontrado para este filme.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
