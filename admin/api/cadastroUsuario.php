<?php
date_default_timezone_set('America/Sao_Paulo');
$inputs = json_decode(file_get_contents("php://input"));
$data = array();
$error = array();
require 'conectar.php';

function validaCPF($cpf) {

  $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
  if (strlen($cpf) != 11) {
    return false;
  }
  if (preg_match('/(\d)\1{10}/', $cpf)) {
    return false;
  }
  for ($t = 9; $t < 11; $t++) {
    for ($d = 0, $c = 0; $c < $t; $c++) {
      $d += $cpf{$c} * (($t + 1) - $c);
    }
    $d = ((10 * $d) % 11) % 10;
    if ($cpf{$c} != $d) {
      return false;
    }
  }
  return true;
}

if(empty($inputs->nome))
{
  $error["nome"] = "O nome completo é obrigatório *";
}

if(empty($inputs->email))
{
  $error["email"] = "O email é obrigatório *";
}

elseif(isset($inputs->email)){

  $email = mysqli_real_escape_string($connect, $inputs->email);
  $query = mysqli_query($connect, "SELECT user.id FROM usuario user WHERE email = '$email'");
  if(mysqli_num_rows($query) > 0)
  $error["email"] = "Já existe um cadastro com esse email.";
}

if(empty($inputs->cpf))
{
  $error["cpf"] = "O CPF é obrigatório *";
}

elseif(!validaCPF($inputs->cpf))
{
  $error["cpf"] = "O CPF é inválido *";
}

if(empty($inputs->data_nascimento))
{
  $error["data_nascimento"] = "A data de nascimento é obrigatório *";
}

if(empty($inputs->ativo))
{
  $error["ativo"] = "O campo conta ativa é obrigatório *";
}

if(empty($inputs->robo_ligado))
{
  $error["robo_ligado"] = "O campo Robô ligado é obrigatório *";
}

if(empty($inputs->plano))
{
  $error["plano"] = "O campo plano robô é obrigatório *";
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
  $nome = mysqli_real_escape_string($connect, $inputs->nome);
  $email = mysqli_real_escape_string($connect, $inputs->email);
  $cpf = mysqli_real_escape_string($connect, $inputs->cpf);
  $data_nascimento = mysqli_real_escape_string($connect, $inputs->data_nascimento);
  $ativo = mysqli_real_escape_string($connect, $inputs->ativo);
  $robo_ligado = mysqli_real_escape_string($connect, $inputs->robo_ligado);
  $plano_id = mysqli_real_escape_string($connect, $inputs->plano);
  $senha = mysqli_real_escape_string($connect, md5($inputs->senha));

  $CONSULTA = mysqli_query($connect, " SELECT * FROM planos WHERE id = '$plano_id'");
  $r = mysqli_fetch_assoc($CONSULTA);
  $plano_valor = $r['valor'];

  $query = "INSERT INTO usuario (nome, email, cpf, data_nascimento, ativo, robo_ligado, plano_valor, plano_id, senha)
  VALUES ('$nome','$email','$cpf','$data_nascimento','$ativo','$robo_ligado','$plano_valor','$plano_id','$senha')";
  if(mysqli_query($connect, $query))
  {
    $data["message"] = "O cadastro do usuário ".$nome." foi feito com sucesso!";
  }
}

echo json_encode($data);

?>
