<?php
include('db.php');

$query = "SELECT * FROM filmes";
$stmt = $pdo->query($query);

$filmes = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $filmes[] = $row;
}

header('Content-Type: application/json');
echo json_encode($filmes);
?>
