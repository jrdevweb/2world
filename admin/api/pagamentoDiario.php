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
  $status = "PENDENTE";
  date_default_timezone_set('America/Sao_Paulo');
  $data_rendimento = date("d/m/Y H:i:s");
  $CONSULTA = mysqli_query($connect, " SELECT u.id, u.plano_valor, p.porcentagem_ganho, p.porcentagem_perca FROM usuario u inner join planos p on p.id = u.plano_id");

  foreach ($CONSULTA as $val) {
    $id = $val['id'];
    $v = $val['plano_valor'];
    $p_ganho = $val['porcentagem_ganho'];
    $p_perca = $val['porcentagem_perca'];

    $ganho = ($v*$p_ganho)/100;
    $perca = ($v*$p_perca)/100;
    $query = "INSERT INTO pagamento_diario (id_usuario, valor_dolar, status, data_rendimento, valor_perca) values ('$id', '$ganho', '$status','$data_rendimento','$perca')";
    if(mysqli_query($connect, $query))
    {
    }
  }

  $data["message"] = "Porcentagens lançadas nos usuários";

  $titulo = "Pagamento Diário (%)";
  $mensagem = "Você acaba de receber em sua conta da WP2, seu rendimento diário. Agora você pode solicitar seu saque. Fique atento ao seu valor mínimo para realizar a retirada. Obrigado!";
  $status = 'NAO_LIDO';
  $statusNotificacao = 'ENVIADO';
  $data_notificacao = date("Y/m/d H:i:s");

  $query = "INSERT INTO notificacao (titulo, mensagem, data_notificacao, status) VALUES ('$titulo','$mensagem','$data_notificacao','$statusNotificacao')";
  if(mysqli_query($connect, $query))
  {
  }
  $id_notificacao = mysqli_insert_id($connect);

  $CONSULTA = mysqli_query($connect, "SELECT * FROM usuario ");
  foreach ($CONSULTA as $val) {
    $id_usuario = $val['id'];
    $query = "INSERT INTO notificacao_usuario (id_usuario, id_notificacao, status) VALUES ('$id_usuario','$id_notificacao','$status')";
    if(mysqli_query($connect, $query))
    {
    }
  }
}

echo json_encode($data);

?>
