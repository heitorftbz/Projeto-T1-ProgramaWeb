<?php
$servername = "localhost";
$username = "root"; 
$password = "C37785mc37785m"; 
$dbname = "db_projeto1_php"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
