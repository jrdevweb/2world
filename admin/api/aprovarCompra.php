<?php
date_default_timezone_set('America/Sao_Paulo');
$inputs = json_decode(file_get_contents("php://input"));
$data = array();
$error = array();
require 'conectar.php';
session_start();
$ID_ROBO_VENDA = $_SESSION['robo_venda_id'];

if(!empty($error))
{
  $data["error"] = $error;
}
else
{
  $status = 'PAGO';
  $statusUsuario = 'SIM';

  $CONSULTA = mysqli_query($connect, " SELECT * FROM checkout_robo where id = '$ID_ROBO_VENDA'");
  $r = mysqli_fetch_assoc($CONSULTA);
  $ID_USUARIO = $r['id_usuario'];

  $query = "UPDATE checkout_robo set status = '$status' WHERE id = '$ID_ROBO_VENDA'";
  if(mysqli_query($connect, $query))
  {
    $data["message"] = "Venda do robô aprovado com sucesso!";
  }

  $query = "UPDATE usuario set ativo = '$statusUsuario' WHERE id = '$ID_USUARIO'";
  if(mysqli_query($connect, $query))
  {
    $data["message"] = "Venda do robô aprovado com sucesso!";
  }
}

echo json_encode($data);

?>
