<?php
include('admin_topo.php');
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['adicionar'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $image = $_POST['image'];
        $release_date = $_POST['release_date'];

        $pdo->prepare("INSERT INTO Catalogofilmes (title, description, image, release_date) VALUES (?, ?, ?, ?)")
            ->execute([$title, $description, $image, $release_date]);
    } elseif (isset($_POST['alterar'])) {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $image = $_POST['image'];
        $release_date = $_POST['release_date'];

        $pdo->prepare("UPDATE Catalogofilmes SET title = ?, description = ?, image = ?, release_date = ? WHERE id = ?")
            ->execute([$title, $description, $image, $release_date, $id]);
    } elseif (isset($_POST['apagar'])) {
        $id = $_POST['id'];
        $pdo->prepare("DELETE FROM Catalogofilmes WHERE id = ?")->execute([$id]);
    }
}

$Catalogofilmes = $pdo->query("SELECT * FROM Catalogofilmes ORDER BY release_date DESC")->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração do Catálogo de Catalogofilmes</title>
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
            background-color: #1a4e8a;
            color: white;
            margin: 0;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 20px;
        }
        input[type="text"], input[type="date"], textarea {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 100%;
        }
        textarea {
            resize: vertical;
            font-family: Arial, sans-serif;
        }
        button {
            background-color:#1a4e8a;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #1a4e8a;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #1a4e8a;
            color: white;
        }
        table td {
            background-color: #f9f9f9;
        }
        table tr:nth-child(even) td {
            background-color: #f1f1f1;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .actions form {
            display: inline-block;
        }
        .description-cell {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
</head>
<body>

    <h1>Administração do Catálogo de Catalogofilmes</h1>

    <div class="container">

        <h2>Adicionar Filme</h2>
        <form method="POST">
            <input type="text" name="title" placeholder="Título" required>
            <textarea name="description" placeholder="Descrição" rows="4" cols="50" required></textarea>
            <input type="text" name="image" placeholder="Imagem (URL)" required>
            <input type="date" name="release_date" required>
            <button type="submit" name="adicionar">Adicionar Filme</button>
        </form>

        <h2>Catalogofilmes Cadastrados</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Imagem</th>
                    <th>Lançamento</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($Catalogofilmes as $filme): ?>
                    <tr>
                        <td><?= $filme['id'] ?></td>
                        <td><?= $filme['title'] ?></td>
                        <td class="description-cell" title="<?= $filme['description'] ?>"><?= substr($filme['description'], 0, 50) . (strlen($filme['description']) > 50 ? '...' : '') ?></td>
                        <td><img src="<?= $filme['image'] ?>" alt="Imagem do Filme" width="100"></td>
                        <td><?= $filme['release_date'] ?></td>
                        <td class="actions">
                            <form method="POST" style="width: 100%;">
                                <input type="hidden" name="id" value="<?= $filme['id'] ?>">
                                <input type="text" name="title" value="<?= $filme['title'] ?>" required>
                                <textarea name="description" rows="4" cols="50" required><?= $filme['description'] ?></textarea>
                                <input type="text" name="image" value="<?= $filme['image'] ?>" required>
                                <input type="date" name="release_date" value="<?= $filme['release_date'] ?>" required>
                                <button type="submit" name="alterar">Alterar</button>
                            </form>
                            <form method="POST" style="width: 100%;">
                                <input type="hidden" name="id" value="<?= $filme['id'] ?>">
                                <button type="submit" name="apagar" onclick="return confirm('Tem certeza que deseja apagar este filme?')">Apagar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

</body>
</html>
<?include('admin_rodape.php');?>