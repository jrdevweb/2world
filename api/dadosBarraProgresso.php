<?php
require 'conectar.php';
$output = array();
session_start();
$ID_USUARIO = $_SESSION['id'];
$cem = 100;
$duzentos = 200;

$CONSULTA_SUM = mysqli_query($connect, "SELECT * FROM usuario WHERE id = '$ID_USUARIO'");
$r = mysqli_fetch_assoc($CONSULTA_SUM);

//pega saldo da conta e valor do plano
$saldo_conta = $r['saldo_conta'];
$valor_plano = $r['plano_valor'];

//calcula valor total do plano
$valor_total_plano = ($valor_plano * $duzentos) / $cem;
//calcula valor maximo com o valor total
$valor_max = $valor_total_plano + $valor_plano;

//calcula porcentagem do saldo
$porcentagem_barraprogressp = ($saldo_conta * 100) / $valor_max;

echo json_encode($porcentagem_barraprogressp);


?>
