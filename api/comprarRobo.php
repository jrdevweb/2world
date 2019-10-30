<?php
date_default_timezone_set('America/Sao_Paulo');
$inputs = json_decode(file_get_contents("php://input"));
$data = array();
$error = array();
session_start();
$ID_USUARIO = $_SESSION['id'];
require 'conectar.php';

if(isset($inputs->id)){
  $id_robo = mysqli_real_escape_string($connect, $inputs->id);
  $query = mysqli_query($connect, " SELECT * FROM checkout_robo where id_usuario = '$ID_USUARIO' and id_plano = '$id_robo' and status = 'PENDENTE'");
  if(mysqli_num_rows($query) > 0)
  $error["id"] = "Você já comprou este robô. O status do pagamento dele é: PENDENTE.";
}

if(!empty($error))
{
  $data["error"] = $error;
}
else
{

  $data_compra = date("Y/m/d H:i:s");
  $id_robo = mysqli_real_escape_string($connect, $inputs->id);
  $status = "PENDENTE";

  $query = "INSERT INTO checkout_robo (id_usuario, id_plano, status, data_compra) VALUES ('$ID_USUARIO','$id_robo','$status','$data_compra')";
  if(mysqli_query($connect, $query))
  {
    $data["message"] = "Ótima escolha!. Você acaba de comprar um robo da WP2. Você será redirecinado para tela de pagamento!";
  }

  $ID_RECUPERADO = mysqli_insert_id($connect);
  $data["autorizado"] = "/bot/".$ID_RECUPERADO."";
}

echo json_encode($data);

?>
