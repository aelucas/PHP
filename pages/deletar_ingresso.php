<?php

include("lib/conexao.php");
include('lib/protect.php');
protect(1);
$id = intval($_GET['id']);

$mysql_query = $mysqli->query("SELECT imagem FROM ingressos WHERE id = '$id'") or die($mysqli->error);
$ingressos = $mysql_query->fetch_assoc();

if(unlink($ingressos['imagem'])) {
    $mysqli->query("DELETE FROM ingressos WHERE id = '$id'") or die($mysqli->error);
}

die("<script>location.href=\"index.php?p=gerenciar_ingresso\";</script>");