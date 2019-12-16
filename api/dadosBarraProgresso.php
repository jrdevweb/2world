<?php
require 'conectar.php';
$output = array();
session_start();
$ID_USUARIO = $_SESSION['id'];
$cem = 100;

$CONSULTA_SUM = mysqli_query($connect, "SELECT plano_valor FROM usuario WHERE id = '$ID_USUARIO'");
$r = mysqli_fetch_assoc($CONSULTA_SUM);

$valor_plano = $r['plano_valor'];

$valor_barra_progresso = $valor_plano / 100;

echo json_encode($valor_barra_progresso);


?>
