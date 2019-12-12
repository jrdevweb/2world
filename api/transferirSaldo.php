<?php
date_default_timezone_set('America/Sao_Paulo');
$inputs = json_decode(file_get_contents("php://input"));
$data = array();
$error = array();
session_start();
$ID_USUARIO = $_SESSION['id'];
require 'conectar.php';

if(empty($inputs->usuario))
{
  $error["usuario"] = "O nome usuário é obrigatório *";
}

elseif(isset($inputs->usuario)){

  $email = mysqli_real_escape_string($connect, $inputs->usuario);
  $query = mysqli_query($connect, "SELECT user.email FROM usuario user WHERE email = '$email'");
  if(mysqli_num_rows($query) <= 0)
  $error["usuario"] = "Esse e-mail não existe para nenhum usuário em nossos registros.";

}

if(empty($inputs->valor))
{
  $error["valor"] = "O valor a ser transferido é obrigatório *";
}

elseif(isset($inputs->usuario)){

  $CONSULTA = mysqli_query($connect, " SELECT * FROM usuario where id = '$ID_USUARIO'");
  $r = mysqli_fetch_assoc($CONSULTA);
  $saldo_conta = $r['saldo_conta'];

  if($saldo_conta <= 0)
  {
    $error["valor"] = "Você não possui saldo disponível para transferência.";
  }

  if($saldo_conta < $inputs->valor)
  {
    $error["valor"] = "O valor que deseja transferir é maior que seu saldo.";
  }
}


if(!empty($error))
{
  $data["error"] = $error;
}
else
{

  $usuario = mysqli_real_escape_string($connect, $inputs->usuario);
  $valor = mysqli_real_escape_string($connect, $inputs->valor);

  $usuario = mysqli_real_escape_string($connect, $inputs->usuario);
  $CONSULTA = mysqli_query($connect, " SELECT * FROM usuario where email = '$usuario'");
  $r = mysqli_fetch_assoc($CONSULTA);
  $id_usuario_transferencia = $r['id'];

  $query = "UPDATE usuario set saldo_conta = saldo_conta - $valor where id = '$ID_USUARIO'";
  if(mysqli_query($connect, $query))
  {
  }

  $query = "UPDATE usuario set saldo_conta = saldo_conta + $valor where id = '$id_usuario_transferencia'";
  if(mysqli_query($connect, $query))
  {
    $data["message"] = "Sua transferência foi completada com sucesso!";
  }
}

echo json_encode($data);

?>
