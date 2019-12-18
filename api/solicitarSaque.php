<?php
date_default_timezone_set('America/Sao_Paulo');
$inputs = json_decode(file_get_contents("php://input"));
$data = array();
$error = array();
session_start();
$ID_USUARIO = $_SESSION['id'];
require 'conectar.php';
$data_hoje_mostrar = date("d/m/Y H:i:s");

if(empty($inputs->metodo_recebimento))
{
  $error["metodo_recebimento"] = "O método de recebimento é obrigatório *";
}

elseif(isset($inputs->metodo_recebimento)){

  $status_pendente = 'PENDENTE';
  $query = mysqli_query($connect, "SELECT * from saque_usuario where id_usuario = '$ID_USUARIO' and status = '$status_pendente'");
  if(mysqli_num_rows($query) > 0)
  $error["metodo_recebimento"] = "Você já possui um saque com situação 'PENDENTE'. Aguarde o pagamento para solicitar um novo saque.";
}

$CONSULTA_SUM = mysqli_query($connect, "SELECT * FROM usuario WHERE id = '$ID_USUARIO' ");
$r = mysqli_fetch_assoc($CONSULTA_SUM);
$valor_saldo = $r['saldo_conta'];

if($valor_saldo <= 0)
{
  $error["metodo_recebimento"] = "Você não possui saldo para realizar este saque.";
}

if(!empty($error))
{
  $data["error"] = $error;
}
else
{

  $data_solicitacao = date("Y/m/d H:i:s");
  $status = 'PENDENTE';
  $metodo_recebimento = mysqli_real_escape_string($connect, $inputs->metodo_recebimento);

  $query = "INSERT INTO saque_usuario (id_usuario, metodo_recebimento, status, data_solicitacao) VALUES ('$ID_USUARIO','$metodo_recebimento','$status','$data_solicitacao')";
  if(mysqli_query($connect, $query))
  {
    $data["message"] = "Seu saque foi solicitado com sucesso.";
  }
}

echo json_encode($data);

?>
