<?php
require 'db.php';  // Inclui a conexão ao banco de dados

$filmes = $pdo->query("SELECT * FROM Catalogofilmes ORDER BY release_date DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Filmes</title>
    <style>
        
    </style>
</head>
<body>

    <h1>Catálogo de Filmes</h1>

    <div class="catalogo">
        <?php foreach ($filmes as $filme): ?>
            <div class="filme">
                <img src="<?= $filme['image'] ?>" alt="Imagem do Filme">
                <div class="info">
                    <h3><?= $filme['title'] ?></h3>
                    <p><?= $filme['description'] ?></p>
                    <p class="data">Lançamento: <?= $filme['release_date'] ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>
