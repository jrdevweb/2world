<?php
date_default_timezone_set('America/Sao_Paulo');
$inputs = json_decode(file_get_contents("php://input"));
$data = array();
$error = array();
session_start();
$ID_PLANO = $_SESSION['plano_comprado_id'];
require 'conectar.php';

if(empty($inputs->hash))
{
  $error["hash"] = "O HASH de Pagamento é obrigatório *";
}

if(!empty($error))
{
  $data["error"] = $error;
}
else
{

  $hash = mysqli_real_escape_string($connect, $inputs->hash);

  $query = "UPDATE planos_comprados set hash = '$hash' where id = '$ID_PLANO'";
  if(mysqli_query($connect, $query))
  {
    $data["message"] = "Seu pagamento foi confirmardo através do HASH de Transação. Estamos validando sua transferência.";
  }
}

echo json_encode($data);

?>
