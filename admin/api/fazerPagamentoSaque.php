<?php
$inputs = json_decode(file_get_contents("php://input"));
$data = array();
$error = array();
require 'conectar.php';
session_start();
$ID_USUARIO = $_SESSION['id_usuario_saque'];

if(!empty($error))
{
  $data["error"] = $error;
}
else
{

  $CONSULTA = mysqli_query($connect, " SELECT * FROM usuario WHERE id = '$ID_USUARIO'");
  $r = mysqli_fetch_assoc($CONSULTA);
  $saldo_conta = $r['saldo_conta'];

  $status = 'PAGO';
  $status_pendente = 'PENDENTE';
  $data_pagamento = date("Y/m/d H:i:s");
  $query = "UPDATE saque_usuario set status = '$status', data_pagamento = '$data_pagamento', valor = '$saldo_conta' WHERE id_usuario = '$ID_USUARIO' and status = '$status_pendente'";
  if(mysqli_query($connect, $query))
  {

  }
  $zero = 0;
  $query = "UPDATE usuario set saldo_conta = '$zero' WHERE id = '$ID_USUARIO'";
  if(mysqli_query($connect, $query))
  {
    $data["message"] = "O Saque foi pago com sucesso. O valor foi debitado da conta do usuário.";
  }
}

echo json_encode($data);

?>
