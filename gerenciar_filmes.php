<?php
include_once('topo.php');
$host = 'localhost';
$dbname = 'db_projeto1_php';
$user = 'root';
$password = '';

try 
{
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch (PDOException $e) 
{
    die("Erro ao conectar ao banco: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    if (isset($_POST['alterar'])) 
    {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $user = $_POST['user'];
        $image = $_POST['image'];
        $pdo->prepare("UPDATE filmes SET title = ?, description = ?, user = ?, image = ? WHERE id = ?")
            ->execute([$title, $description, $user, $image, $id]);
    } 
    elseif (isset($_POST['apagar'])) 
    {
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
        h2 {
            color: #333;
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
        input[type="text"], input[type="number"], input[type="email"], input[type="password"], input[type="file"] {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 100%;
        }
        input[type="text"]:focus, input[type="number"]:focus {
            border-color: #4CAF50;
            outline: none;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
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
            background-color: #4CAF50;
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
        .actions input, .actions button {
            margin-top: 5px;
        }
        .actions input[type="text"], .actions input[type="number"], .actions input[type="file"] {
            margin-bottom: 10px;
            width: auto;
        }
        img {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>
<body>

    <h1>Gerenciar Filmes</h1>

    <div class="container">

        <h2>Filmes Cadastrados</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Usuário</th>
                    <th>Imagem</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($filmes as $filme): ?>
                    <tr>
                        <td><?= $filme['id'] ?></td>
                        <td><?= $filme['title'] ?></td>
                        <td><?= $filme['description'] ?></td>
                        <td><?= $filme['user'] ?></td>
                        <td><img src="<?= $filme['image'] ?>" alt="Imagem do Filme"></td>
                        <td class="actions">
                            <form method="POST" style="width: 100%;">
                                <input type="hidden" name="id" value="<?= $filme['id'] ?>">
                                <input type="text" name="title" value="<?= $filme['title'] ?>" required>
                                <input type="text" name="description" value="<?= $filme['description'] ?>" required>
                                <input type="text" name="user" value="<?= $filme['user'] ?>" required>
                                <input type="text" name="image" value="<?= $filme['image'] ?>" required>
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
<?include_once('rodape.php');?>