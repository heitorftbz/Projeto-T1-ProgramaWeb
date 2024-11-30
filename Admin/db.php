<?php
$host = 'localhost';  // O endereço do servidor do banco de dados (geralmente localhost)
$dbname = 'db_projeto1_php';  // Nome do seu banco de dados
$username = 'root';  // Usuário do banco de dados
$password = 'C37785mc37785m';  // Senha do usuário do banco de dados

try {
    // Cria uma conexão PDO com o banco de dados
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Define o modo de erro para exceções
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Em caso de erro de conexão, exibe uma mensagem
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>
