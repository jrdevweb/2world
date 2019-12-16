<?php
date_default_timezone_set('America/Sao_Paulo');
$inputs = json_decode(file_get_contents("php://input"));
$data = array();
$error = array();
session_start();
$ID_USUARIO = $_SESSION['id'];
require 'conectar.php';

if(isset($inputs->id)){
  $id_plano = mysqli_real_escape_string($connect, $inputs->id);
  $query = mysqli_query($connect, " SELECT * FROM planos_comprados where usuario_id = '$ID_USUARIO' and status = 'PENDENTE'");
  if(mysqli_num_rows($query) > 0)
  $error["id"] = "Você Já possui um plano comprado. Não é usuário novo.";
}

if(!empty($error))
{
  $data["error"] = $error;
}
else
{

  $CONSULTA_SUM = mysqli_query($connect, "SELECT * FROM planos_comprados WHERE usuario_id = '$ID_USUARIO' and status = 'PENDENTE'");
  $r = mysqli_fetch_assoc($CONSULTA_SUM);
  $id = $r['id'];
  $data["autorizado"] = "/plano-comprado/".$id."";
}

echo json_encode($data);

?>
