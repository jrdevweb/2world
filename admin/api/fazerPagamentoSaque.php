<?php
$inputs = json_decode(file_get_contents("php://input"));
$data = array();
$error = array();
require 'conectar.php';
session_start();
$ID_USUARIO = $_SESSION['id_usuario_saque'];

if(empty($inputs->hash_bitcoin))
{
  $error["hash_bitcoin"] = "O HASH ou Assinatura da transação é obrigatório *";
}

if(!empty($error))
{
  $data["error"] = $error;
}
else
{

  $hash = mysqli_real_escape_string($connect, $inputs->hash_bitcoin);
  $status = 'PAGO';
  $data_pagamento = date("Y/m/d H:i:s");
  $query = "UPDATE saque_usuario set status = '$status', data_pagamento = '$data_pagamento', hash_bitcoin = '$hash' WHERE id_usuario = '$ID_USUARIO'";
  if(mysqli_query($connect, $query))
  {

  }
  $query = "UPDATE pagamento_diario set status = '$status', data_pagamento = '$data_pagamento' WHERE id_usuario = '$ID_USUARIO'";
  if(mysqli_query($connect, $query))
  {
    $data["message"] = "O saque foi pago com sucesso.";
  }
}

echo json_encode($data);

?>
