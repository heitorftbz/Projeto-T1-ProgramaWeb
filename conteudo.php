<?php
require 'db.php'; // Inclui a conexão ao banco de dados

// Verificação de formulário enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filme_id'])) {
    $filme_id = $_POST['filme_id'];
    $autor = !empty($_POST['autor']) ? $_POST['autor'] : 'Anônimo';
    $comentario = trim($_POST['comentario']); // Remover espaços extras

    // Validação para garantir que o comentário não está vazio
    if (!empty($comentario)) {
        // Inserir o comentário no banco
        $stmt = $pdo->prepare("INSERT INTO comentarios (filme_id, autor, comentario, data_comentario) VALUES (:filme_id, :autor, :comentario, NOW())");
        $stmt->bindParam(':filme_id', $filme_id, PDO::PARAM_INT);
        $stmt->bindParam(':autor', $autor, PDO::PARAM_STR);
        $stmt->bindParam(':comentario', $comentario, PDO::PARAM_STR);
        $stmt->execute();
    }
    
    // Redireciona após o envio para evitar o reenvio do formulário
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Consulta para obter todos os filmes
$filmes = $pdo->query("SELECT * FROM catalogofilmes ORDER BY release_date DESC")->fetchAll(PDO::FETCH_ASSOC);

// Consulta para obter os comentários por filme
$comentarios_por_filme = [];
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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Oswald:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Estilos Globais */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #141414;
            color: #fff;
            background-image: url('https://telaviva.com.br/wp-content/uploads/2022/05/streaming.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        h1 {
            text-align: center;
            color: #fff;
            padding: 80px 0;
            font-size: 50px;
            letter-spacing: 3px;
            font-weight: bold;
            text-transform: uppercase;
            background-color: rgba(0, 0, 0, 0.6);
            margin: 0;
            border-radius: 15px;
            font-family: 'Oswald', sans-serif;
        }
        .intro {
            text-align: center;
            color: #fff;
            padding: 20px;
            font-size: 18px;
            background-color: rgba(0, 0, 0, 0.7);
            margin-top: 20px;
            border-radius: 15px;
            font-family: 'Oswald', sans-serif;
        }

        .catalogo {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 40px 20px;
        }

        /* Cartões de Filmes */
        .filme {
            background: rgba(0, 0, 0, 0.8);
            border-radius: 15px;
            margin: 10px;
            padding: 20px;
            width: 270px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.8);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .filme:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 40px rgba(0, 0, 0, 0.9);
        }
        .filme img {
            max-width: 100%;
            border-radius: 12px;
        }
        .info {
            margin-top: 10px;
        }
        .info h3 {
            font-size: 22px;
            color: #fff;
            font-weight: 600;
            font-family: 'Oswald', sans-serif;
        }
        .info p {
            font-size: 14px;
            color: #bbb;
        }

        /* Comentários */
        .comentarios {
            margin-top: 30px;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 15px;
        }
        .comentario {
            background: rgba(0, 0, 0, 0.85);
            border-radius: 15px;
            margin-bottom: 15px;
            padding: 15px;
        }
        .comentario .autor {
            font-weight: bold;
            color: #ff6f61;
        }
        .comentario .texto {
            margin-top: 8px;
            font-size: 16px;
            color: #ddd;
        }

        /* Formulário de Comentários */
        .form-comentario input, .form-comentario textarea {
            width: 100%;
            padding: 14px;
            margin: 12px 0;
            border: none;
            border-radius: 15px;
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
            font-size: 16px;
        }
        .form-comentario button {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 15px;
            background-color: #e50914;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .form-comentario button:hover {
            background-color: #b20710;
        }
    </style>
</head>
<body>
    <h1>Catálogo de Filmes</h1>
    <div class="intro">
        <p>Explore nossos filmes mais recentes e deixe seus comentários!</p>
    </div>

    <div class="catalogo">
        <?php foreach ($filmes as $filme): ?>
            <div class="filme">
                <img src="<?= htmlspecialchars($filme['image']) ?>" alt="Imagem do Filme">
                <div class="info">
                    <h3><?= htmlspecialchars($filme['title']) ?></h3>
                    <p><?= htmlspecialchars($filme['release_date']) ?></p>
                </div>

                <div class="comentarios">
                    <?php if (!empty($comentarios_por_filme[$filme['id']])): ?>
                        <?php foreach ($comentarios_por_filme[$filme['id']] as $comentario): ?>
                            <div class="comentario">
                                <p class="autor"><?= htmlspecialchars($comentario['autor']) ?> - <?= htmlspecialchars($comentario['data_comentario']) ?></p>
                                <p class="texto"><?= htmlspecialchars($comentario['comentario']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Seja o primeiro a comentar!</p>
                    <?php endif; ?>

                    <form class="form-comentario" method="POST">
                        <input type="hidden" name="filme_id" value="<?= $filme['id'] ?>">
                        <input type="text" name="autor" placeholder="Seu nome (opcional)">
                        <textarea name="comentario" placeholder="Escreva seu comentário..." rows="4"></textarea>
                        <button type="submit">Comentar</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
