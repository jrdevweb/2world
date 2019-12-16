<?php
date_default_timezone_set('America/Sao_Paulo');
$inputs = json_decode(file_get_contents("php://input"));
$data = array();
$error = array();
require 'conectar.php';

if(empty($inputs->nomeCadastro))
{
  $error["nomeCadastro"] = "O nome completo é obrigatório *";
}

if(empty($inputs->data_nascimento))
{
  $error["data_nascimento"] = "O nome data de nascimento é obrigatório *";
}


if(empty($inputs->email))
{
  $error["email"] = "O email é obrigatório *";
}

if(empty($inputs->plano))
{
  $error["plano"] = "O plano de investimento é obrigatório *";
}

elseif(isset($inputs->email)){

  $email = mysqli_real_escape_string($connect, $inputs->email);
  $query = mysqli_query($connect, "SELECT user.id FROM usuario user WHERE email = '$email'");
  if(mysqli_num_rows($query) > 0)
  $error["email"] = "Já existe um cadastro com esse email.";
}

if(empty($inputs->senha))
{
  $error["senha"] = "A senha é obrigatório *";
}

if(!empty($error))
{
  $data["error"] = $error;
}
else
{
  $indicacao = mysqli_real_escape_string($connect, $inputs->id);
  $nome = mysqli_real_escape_string($connect, $inputs->nomeCadastro);
  $data_nascimento = mysqli_real_escape_string($connect, $inputs->data_nascimento);
  $email = mysqli_real_escape_string($connect, $inputs->email);
  $senha = mysqli_real_escape_string($connect, md5($inputs->senha));
  $datecreated = date("Y/m/d H:i:s");
  $ativo = 'NAO';
  $plano_id = mysqli_real_escape_string($connect, $inputs->plano);

  $CONSULTA = mysqli_query($connect, " SELECT * FROM planos WHERE id = '$plano_id'");
  $r = mysqli_fetch_assoc($CONSULTA);
  $plano_valor = $r['valor_plano'];

  $query = "INSERT INTO usuario (nome, data_nascimento, email, senha, ativo, plano_id, plano_valor, id_usuario_indicador, datecreated) VALUES

  ('$nome','$data_nascimento','$email','$senha','$ativo','$plano_id','$plano_valor','$indicacao','$datecreated')";

  if(mysqli_query($connect, $query))
  {
    $data["message"] = " ".$nome.", seu cadastro foi realizado com sucesso na plataforma!";
  }

  $ID_USUARIO_RECUPERADO = mysqli_insert_id($connect);
  $STATUS = 'PENDENTE';
  $DATA_INDICACAO = date("Y/m/d H:i:s");
  $query = "INSERT INTO indicacao (id_usuario_indicou, id_usuario_indicado, data_indicacao, status) VALUES('$indicacao','$ID_USUARIO_RECUPERADO','$DATA_INDICACAO','$STATUS')";
  if(mysqli_query($connect, $query))
  {

  }

  $data_compra = date("Y/m/d H:i:s");
  $status = "PENDENTE";

  $query = "INSERT INTO planos_comprados (usuario_id, plano_id, status, data_compra) VALUES ('$ID_USUARIO_RECUPERADO','$plano_id','$status','$data_compra')";
  if(mysqli_query($connect, $query))
  {
    
  }

}

echo json_encode($data);

?>
