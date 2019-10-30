<?php
date_default_timezone_set('America/Sao_Paulo');
$inputs = json_decode(file_get_contents("php://input"));
$data = array();
$error = array();
session_start();
$ID_USUARIO = $_SESSION['id'];
require 'conectar.php';
$data_hoje_mostrar = date("d/m/Y H:i:s");

$data_hoje = date("Y/m/d");
if(isset($data_hoje)){
  $query = mysqli_query($connect, " SELECT * FROM saque_usuario where id_usuario = '$ID_USUARIO' and date_format(data_solicitacao,'%Y/%m/%d') = '$data_hoje' LIMIT 1");
  if(mysqli_num_rows($query) > 0)

  $error["carteira"] = "Você já fez saque hoje. Data do último saque: ".$data_hoje_mostrar." ";
}

$CONSULTA = mysqli_query($connect, " SELECT * FROM usuario where id = '$ID_USUARIO'");
$r = mysqli_fetch_assoc($CONSULTA);
$bitcoin = $r['bitcoin'];

if(empty($bitcoin))
{
  $error["carteira"] = "Você precisa atualizar os dados da sua carteira de Bitcoin";
}

$CONSULTA = mysqli_query($connect, " SELECT * FROM planos p inner join usuario usr on p.id = usr.plano_id WHERE usr.id = '$ID_USUARIO'");
$r = mysqli_fetch_assoc($CONSULTA);
$valor_minimo_saque = $r['valor_minimo_saque'];

$CONSULTA_SUM = mysqli_query($connect, "SELECT sum(valor_dolar) as valor_dolar FROM pagamento_diario WHERE id_usuario = '$ID_USUARIO' and status = 'PENDENTE'");
$r = mysqli_fetch_assoc($CONSULTA_SUM);
$valor_dolar = $r['valor_dolar'];

if($valor_dolar < $valor_minimo_saque)
{
  $error["carteira"] = "O valor mínimo de saque para seu plano é de USD $".$valor_minimo_saque." ";
}

if(!empty($error))
{
  $data["error"] = $error;
}
else
{

  $data_solicitacao = date("Y/m/d H:i:s");
  $status = 'PENDENTE';
  $carteira = 'BITCOIN';

  $query = "INSERT INTO saque_usuario (id_usuario, carteira, status, data_solicitacao) VALUES ('$ID_USUARIO','$carteira','$status','$data_solicitacao')";
  if(mysqli_query($connect, $query))
  {
    $data["message"] = "Seu saque foi solicitado com sucesso. Prazo para pagamento em até 24 horas.";
  }
}

echo json_encode($data);

?>
