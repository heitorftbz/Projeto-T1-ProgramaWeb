<?php
include_once("contato.php");
include_once("config.inc.php");

$nome = $_POST['nome'];
$email = $_POST['email'];
$mensagem = $_POST['mensagem'];

$sql = "INSERT INTO contatos (nome,email,mensagem) VALUES ('$nome','$email','$mensagem')";
mysqli_query($conexao, $sql);

mysqli_close($conexao);

echo"$nome $email $mensagem";
?>