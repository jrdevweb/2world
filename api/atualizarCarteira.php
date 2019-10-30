<?php
date_default_timezone_set('America/Sao_Paulo');
$inputs = json_decode(file_get_contents("php://input"));
$data = array();
$error = array();
session_start();
$ID_USUARIO = $_SESSION['id'];
require 'conectar.php';

if(!empty($error))
{
  $data["error"] = $error;
}
else
{

  $banco = mysqli_real_escape_string($connect, $inputs->banco);
  $agencia = mysqli_real_escape_string($connect, $inputs->agencia);
  $conta = mysqli_real_escape_string($connect, $inputs->conta);
  $bitcoin = mysqli_real_escape_string($connect, $inputs->bitcoin);

  $query = "UPDATE usuario set bitcoin = '$bitcoin', banco = '$banco', agencia = '$agencia', conta = '$conta' WHERE id = '$ID_USUARIO'";
  if(mysqli_query($connect, $query))
  {
    $data["message"] = "Os dados das suas carteiras foram atualizadas!";
  }
}

echo json_encode($data);

?>
