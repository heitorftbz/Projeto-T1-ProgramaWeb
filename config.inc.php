<?php

$conexao = mysqli_connect( "localhost", "heitor","123321");

$db = mysqli_select_db($conexao,"db_projeto1_php");

if (!$conexao) 
{
    die("Connection failed: " . mysqli_connect_error());
}
  echo "Connected successfully";
?>