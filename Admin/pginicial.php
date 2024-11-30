<?php
include("topo.php");  // Inclui o cabeçalho

if (empty($_SERVER['QUERY_STRING'])) {
    $var = "conteudo.php";  // Página padrão
    include("$var");
} else {
    $pg = $_GET['pg'];  // Página fornecida na URL
    include_once("$pg.php");
}

include_once("rodape.php");  // Inclui o rodapé
?>
