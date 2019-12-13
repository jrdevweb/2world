<?php
date_default_timezone_set('America/Sao_Paulo');
$inputs = json_decode(file_get_contents("php://input"));
$data = array();
$error = array();
require 'conectar.php';

// function validaCPF($cpf) {
//
//   $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
//   if (strlen($cpf) != 11) {
//     return false;
//   }
//   if (preg_match('/(\d)\1{10}/', $cpf)) {
//     return false;
//   }
//   for ($t = 9; $t < 11; $t++) {
//     for ($d = 0, $c = 0; $c < $t; $c++) {
//       $d += $cpf{$c} * (($t + 1) - $c);
//     }
//     $d = ((10 * $d) % 11) % 10;
//     if ($cpf{$c} != $d) {
//       return false;
//     }
//   }
//   return true;
// }

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

elseif(isset($inputs->email)){

  $email = mysqli_real_escape_string($connect, $inputs->email);
  $query = mysqli_query($connect, "SELECT user.id FROM usuario user WHERE email = '$email'");
  if(mysqli_num_rows($query) > 0)
  $error["email"] = "Já existe um cadastro com esse email.";
}

// if(empty($inputs->cpf))
// {
//   $error["cpf"] = "O CPF é obrigatório *";
// }
//
// elseif(!validaCPF($inputs->cpf))
// {
//   $error["cpf"] = "O CPF é inválido *";
// }

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
  // $cpf = mysqli_real_escape_string($connect, $inputs->cpf);
  $senha = mysqli_real_escape_string($connect, md5($inputs->senha));
  $datecreated = date("Y/m/d H:i:s");
  $ativo = 'NAO';

  $query = "INSERT INTO usuario (nome, data_nascimento, email, senha, ativo, id_usuario_indicador, datecreated) VALUES

  ('$nome','$data_nascimento','$email','$senha','$ativo','$indicacao','$datecreated')";

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

}

echo json_encode($data);

?>
