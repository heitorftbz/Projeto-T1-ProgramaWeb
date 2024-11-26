<?php

$host = 'localhost';
$dbname = 'nome_do_banco';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['adicionar'])) {
        $titulo = $_POST['titulo'];
        $ano = $_POST['ano'];
        $genero = $_POST['genero'];
        $pdo->prepare("INSERT INTO filmes (titulo, ano, genero) VALUES (?, ?, ?)")
            ->execute([$titulo, $ano, $genero]);
    } elseif (isset($_POST['alterar'])) {
        $id = $_POST['id'];
        $titulo = $_POST['titulo'];
        $ano = $_POST['ano'];
        $genero = $_POST['genero'];
        $pdo->prepare("UPDATE filmes SET titulo = ?, ano = ?, genero = ? WHERE id = ?")
            ->execute([$titulo, $ano, $genero, $id]);
    } elseif (isset($_POST['apagar'])) {
        $id = $_POST['id'];
        $pdo->prepare("DELETE FROM filmes WHERE id = ?")->execute([$id]);
    }
}

$filmes = $pdo->query("SELECT * FROM filmes")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Filmes</title>
</head>
<body>
    <h1>Gerenciar Filmes</h1>

    <h2>Adicionar Filme</h2>
    <form method="POST">
        <input type="text" name="titulo" placeholder="Título" required>
        <input type="number" name="ano" placeholder="Ano" required>
        <input type="text" name="genero" placeholder="Gênero">
        <button type="submit" name="adicionar">Adicionar</button>
    </form>

    <h2>Filmes Cadastrados</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Ano</th>
            <th>Gênero</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($filmes as $filme): ?>
            <tr>
                <td><?= $filme['id'] ?></td>
                <td><?= $filme['titulo'] ?></td>
                <td><?= $filme['ano'] ?></td>
                <td><?= $filme['genero'] ?></td>
                <td>
                    <form method="POST" style="display:inline-block;">
                        <input type="hidden" name="id" value="<?= $filme['id'] ?>">
                        <input type="text" name="titulo" value="<?= $filme['titulo'] ?>" required>
                        <input type="number" name="ano" value="<?= $filme['ano'] ?>">
                        <input type="text" name="genero" value="<?= $filme['genero'] ?>">
                        <button type="submit" name="alterar">Alterar</button>
                    </form>
                    <form method="POST" style="display:inline-block;">
                        <input type="hidden" name="id" value="<?= $filme['id'] ?>">
                        <button type="submit" name="apagar">Apagar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
