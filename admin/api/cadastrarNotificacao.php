<?php
date_default_timezone_set('America/Sao_Paulo');
$inputs = json_decode(file_get_contents("php://input"));
$data = array();
$error = array();
require 'conectar.php';

if(empty($inputs->titulo))
{
  $error["titulo"] = "O título é obrigatório *";
}

if(empty($inputs->mensagem))
{
  $error["mensagem"] = "A mensagem é obrigatório *";
}

if(!empty($error))
{
  $data["error"] = $error;
}
else
{

  $titulo = mysqli_real_escape_string($connect, $inputs->titulo);
  $mensagem = mysqli_real_escape_string($connect, $inputs->mensagem);
  $status = 'NAO_LIDO';
  $statusNotificacao = 'ENVIADO';
  $data_notificacao = date("Y/m/d H:i:s");

  $query = "INSERT INTO notificacao (titulo, mensagem, data_notificacao, status) VALUES ('$titulo','$mensagem','$data_notificacao','$statusNotificacao')";
  if(mysqli_query($connect, $query))
  {
  }
  $id_notificacao = mysqli_insert_id($connect);

  $CONSULTA = mysqli_query($connect, "SELECT * FROM usuario WHERE ativo = 'SIM'");
  foreach ($CONSULTA as $val) {
    $id_usuario = $val['id'];
    $query = "INSERT INTO notificacao_usuario (id_usuario, id_notificacao, status) VALUES ('$id_usuario','$id_notificacao','$status')";
    if(mysqli_query($connect, $query))
    {
    }
  }
  $data["message"] = "A notificação foi enviada para todos os usuários cadastrados.";
}

echo json_encode($data);

?>
