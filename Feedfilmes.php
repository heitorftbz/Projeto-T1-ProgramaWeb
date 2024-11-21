<?php
// Incluir a conexão com o banco de dados
include('db.php');

// Query para buscar todos os filmes
$query = "SELECT * FROM filmes";
$stmt = $pdo->query($query);

$filmes = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $filmes[] = $row;
}

// Retornar os filmes em formato JSON
header('Content-Type: application/json');
echo json_encode($filmes);
?>
