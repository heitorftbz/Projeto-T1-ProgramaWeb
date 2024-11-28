<?php
$host = 'localhost';
$dbname = 'db_projeto1_php';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco: " . $e->getMessage());
}

$filmes = $pdo->query("SELECT * FROM Catalogofilmes ORDER BY release_date DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Filmes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            color: #333;
            padding: 20px;
            background-color: #4CAF50;
            color: white;
            margin: 0;
        }
        .catalogo {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 20px;
        }
        .filme {
            width: 250px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .filme img {
            width: 100%;
            height: auto;
        }
        .filme .info {
            padding: 15px;
        }
        .filme .info h3 {
            font-size: 18px;
            margin: 0;
        }
        .filme .info p {
            font-size: 14px;
            color: #555;
            margin: 10px 0;
        }
        .filme .info .data {
            font-size: 12px;
            color: #888;
        }
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
