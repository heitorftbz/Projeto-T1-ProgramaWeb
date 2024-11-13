<?php 
include_once ("topo.php");
include ("config.inc.php");
?>
<html lang="pt-BR">
<div class="contato">
    <h3>Entre em Contato</h3>
    <form action="enviar_contato.php" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
        
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="mensagem">Mensagem:</label>
        <textarea id="mensagem" name="mensagem" required></textarea>
        
        <input type="submit" value="Enviar">
    </form>
</div>
