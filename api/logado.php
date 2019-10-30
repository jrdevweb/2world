<?php
session_start();
require 'conectar.php';
$output = array();
$output['uid_user_robo'] = $_SESSION['uid_user_robo'];
$output['id'] = $_SESSION['id'];
$output['nome'] = $_SESSION['nome'];
$output['email'] = $_SESSION['email'];
$output['cpf'] = $_SESSION['cpf'];
$output['plano_valor'] = $_SESSION['plano_valor'];
$output['plano_id'] = $_SESSION['plano_id'];
$output['robo_ligado'] = $_SESSION['robo_ligado'];
$output['ativo'] = $_SESSION['ativo'];
echo json_encode($output);


?>
