<?php
$inputs = json_decode(file_get_contents("php://input"));
require 'conectar.php';
$data = array();
$error = array();
session_start();
$ID_USUARIO = $_SESSION['id'];

if(empty($inputs->valor))
{
  $error["valor"] = "O valor é obrigatório *";
}

if(!empty($error))
{
  $data["error"] = $error;
}
else
{

  $status = 'PENDENTE';
  $valor = mysqli_real_escape_string($connect, $inputs->valor);
  $query = "INSERT INTO potencializar (id_usuario, valor, status) VALUES ('$ID_USUARIO','$valor','$status')";
  if(mysqli_query($connect, $query))
  {
    $data["message"] = "Sua solicitação de potencializar foi recebido";
  }
}

echo json_encode($data);

?>
