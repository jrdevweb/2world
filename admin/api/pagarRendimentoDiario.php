<?php
$inputs = json_decode(file_get_contents("php://input"));
$data = array();
$error = array();
require 'conectar.php';

if(!empty($error))
{
  $data["error"] = $error;
}
else
{
  $status = "PAGO";
  $ativo = "SIM";
  $cem = 100;
  date_default_timezone_set('America/Sao_Paulo');
  $data_rendimento = date("d/m/Y H:i:s");
  $CONSULTA = mysqli_query($connect, " SELECT u.id, u.plano_valor, p.porcentagem_diario FROM usuario u
                                                                                        inner join planos p on p.id = u.plano_id
                                                                                        where u.ativo = '$ativo'");

  foreach ($CONSULTA as $val) {
    $id = $val['id'];
    $plano_valor = $val['plano_valor'];
    $porcentagem_diario = $val['porcentagem_diario'];

    $valor_porcentagem = ($plano_valor * $porcentagem_diario) / $cem;
    $query = "INSERT INTO rendimento_diario (id_usuario, valor_rendimento, status, data_rendimento) values ('$id', '$valor_porcentagem', '$status','$data_rendimento')";
    if(mysqli_query($connect, $query))

    {
    }

    $query = "UPDATE usuario set saldo_conta = saldo_conta + $valor_porcentagem where id = '$id'";
    if(mysqli_query($connect, $query))
    {
    }

  }

  $data["message"] = "Pagamento Diário feito em : ".$data_rendimento.".";

  // $titulo = "Pagamento Diário (%)";
  // $mensagem = "Você acaba de receber em sua conta da WP2, seu rendimento diário. Agora você pode solicitar seu saque. Fique atento ao seu valor mínimo para realizar a retirada. Obrigado!";
  // $status = 'NAO_LIDO';
  // $statusNotificacao = 'ENVIADO';
  // $data_notificacao = date("Y/m/d H:i:s");
  //
  // $query = "INSERT INTO notificacao (titulo, mensagem, data_notificacao, status) VALUES ('$titulo','$mensagem','$data_notificacao','$statusNotificacao')";
  // if(mysqli_query($connect, $query))
  // {
  // }
  // $id_notificacao = mysqli_insert_id($connect);
  //
  // $CONSULTA = mysqli_query($connect, "SELECT * FROM usuario ");
  // foreach ($CONSULTA as $val) {
  //   $id_usuario = $val['id'];
  //   $query = "INSERT INTO notificacao_usuario (id_usuario, id_notificacao, status) VALUES ('$id_usuario','$id_notificacao','$status')";
  //   if(mysqli_query($connect, $query))
  //   {
  //   }
  // }
}

echo json_encode($data);

?>
