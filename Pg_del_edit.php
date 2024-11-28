<?php
include('db.php');
session_start();

$usuario_logado = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;

if (isset($_GET['id'])) {
    $comentario_id = $_GET['id'];

    $sql = "SELECT * FROM comentarios WHERE id = $comentario_id AND usuario = '$usuario_logado'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $comentario = $result->fetch_assoc();
        $comentario_texto = $comentario['comentario'];
    } else {
        echo "Comentário não encontrado ou você não tem permissão para editá-lo.";
        exit();
    }
} else {
    echo "ID do comentário não fornecido.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novo_comentario = $_POST['comentario'];

    $sql = "UPDATE comentarios SET comentario = '$novo_comentario' WHERE id = $comentario_id AND usuario = '$usuario_logado'";

    if ($conn->query($sql) === TRUE) {
        echo "Comentário atualizado com sucesso!";
        header("Location: feed_filmes.php");
        exit();
    } else {
        echo "Erro ao atualizar comentário: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Comentário</title>
</head>
<body>

<h1>Editar Comentário</h1>

<form action="edit_comentario.php?id=<?php echo $comentario_id; ?>" method="POST">
    <textarea name="comentario" rows="4" cols="50"><?php echo htmlspecialchars($comentario_texto); ?></textarea><br>
    <button type="submit">Atualizar Comentário</button>
</form>

</body>
</html>
