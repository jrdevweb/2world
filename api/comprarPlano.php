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
  $query = mysqli_query($connect, " SELECT * FROM planos_comprados where usuario_id = '$ID_USUARIO' and plano_id = '$id_plano'");
  if(mysqli_num_rows($query) > 0)
  $error["id"] = "Você já comprou esse plano.";
}

if(!empty($error))
{
  $data["error"] = $error;
}
else
{

  $data_compra = date("Y/m/d H:i:s");
  $id_plano = mysqli_real_escape_string($connect, $inputs->id);
  $status = "PENDENTE";

  $query = "INSERT INTO planos_comprados (usuario_id, plano_id, status, data_compra) VALUES ('$ID_USUARIO','$id_plano','$status','$data_compra')";
  if(mysqli_query($connect, $query))
  {
    $data["message"] = "Parabéns pela escolha. Agora você irá para o pagamento!";
  }

  $ID_RECUPERADO = mysqli_insert_id($connect);
  $data["autorizado"] = "/plano-comprado/".$ID_RECUPERADO."";
}

echo json_encode($data);

?>
