<?php
date_default_timezone_set('America/Sao_Paulo');
$inputs = json_decode(file_get_contents("php://input"));
$data = array();
$error = array();
require 'conectar.php';

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;
//
// require 'PHPMailer/src/Exception.php';
// require 'PHPMailer/src/PHPMailer.php';
// require 'PHPMailer/src/SMTP.php';

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

if(empty($inputs->senha))
{
  $error["senha"] = "A senha é obrigatório *";
}

if(empty($inputs->pin))
{
  $error["pin"] = "O PIN é obrigatório *";
}

elseif(strlen($inputs->pin) > 8)
{
	$error["pin"] = "O PIN deve possuir no máximo 8 caracteres *";
}

if(empty($inputs->endereco))
{
  $error["endereco"] = "O endereço é obrigatório *";
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
  $senha = mysqli_real_escape_string($connect, md5($inputs->senha));
  $pin = mysqli_real_escape_string($connect, $inputs->pin);
  $endereco = mysqli_real_escape_string($connect, $inputs->endereco);
  $datecreated = date("d/m/Y H:i:s");
  $situacao = 'INATIVO';
  $data_cadastro = date("d/m/Y H:i:s");
  
  $query = "INSERT INTO usuario (nome, email, cpf, senha, pin, endereco, situacao, datecreated) VALUES ('$nome','$email','$cpf','$senha', '$pin','$endereco','$situacao','$datecreated')";
  if(mysqli_query($connect, $query))
  {
    $data["message"] = " ".$nome.", seu cadastro foi realizado com sucesso na plataforma!";
  }
}

echo json_encode($data);

?>
