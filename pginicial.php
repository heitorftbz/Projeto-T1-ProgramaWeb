<?php
include("topo.php");
include_once("menu.php");

if (empty($_SERVER['QUERY_STRING'])) 
{
    $var = "conteudo.php";
    include("$var");
}
else
{
    $pg = $_GET ['pg'];
    include_once ("$pg.php");
}
include_once('Vercomentarios.php');


include_once ("rodape.php");