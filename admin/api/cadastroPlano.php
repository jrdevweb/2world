<?php
date_default_timezone_set('America/Sao_Paulo');
$inputs = json_decode(file_get_contents("php://input"));
$data = array();
$error = array();
require 'conectar.php';

if(empty($inputs->descricao))
{
  $error["descricao"] = "A descrição é obrigatório *";
}

if(empty($inputs->valor))
{
  $error["valor"] = "O valor é obrigatório *";
}

if(empty($inputs->ganho))
{
  $error["ganho"] = "A porcentagem de ganho é obrigatório *";
}

if(empty($inputs->perca))
{
  $error["perca"] = "A porcentagem de perca é obrigatório *";
}

if(empty($inputs->limite_maximo))
{
  $error["limite_maximo"] = "O Limite máximo investimento é obrigatório *";
}

// if(empty($inputs->potencializar))
// {
//   $error["potencializar"] = "O limite a potencializar é obrigatório *";
// }

if(empty($inputs->taxa_saque))
{
  $error["taxa_saque"] = "A taxa de saque é obrigatório *";
}

if(empty($inputs->valor_minimo_saque))
{
  $error["valor_minimo_saque"] = "O valor mínimo de saque é obrigatório *";
}

if(empty($inputs->valor_acao))
{
  $error["valor_acao"] = "O valor da aplicação é obrigatório *";
}

if(empty($inputs->subir_descer))
{
  $error["subir_descer"] = "O opção das setas é obrigatório *";
}

if(!empty($error))
{
  $data["error"] = $error;
}
else
{
  $descricao = mysqli_real_escape_string($connect, $inputs->descricao);
  $valor = mysqli_real_escape_string($connect, $inputs->valor);
  $ganho = mysqli_real_escape_string($connect, $inputs->ganho);
  $perca = mysqli_real_escape_string($connect, $inputs->perca);
  $limite_maximo = mysqli_real_escape_string($connect, $inputs->limite_maximo);
  // $potencializar = mysqli_real_escape_string($connect, $inputs->potencializar);
  $taxa_saque = mysqli_real_escape_string($connect, $inputs->taxa_saque);
  $valor_minimo_saque = mysqli_real_escape_string($connect, $inputs->valor_minimo_saque);
  $valor_acao = mysqli_real_escape_string($connect, $inputs->valor_acao);
  $subir_descer = mysqli_real_escape_string($connect, $inputs->subir_descer);

  $query = "INSERT INTO planos (descricao, valor, porcentagem_ganho, porcentagem_perca, limite_maximo, taxa_saque, valor_minimo_saque, valor_acao, subir_descer)
  VALUES ('$descricao','$valor','$ganho','$perca','$limite_maximo','$taxa_saque','$valor_minimo_saque','$valor_acao','$subir_descer')";
  if(mysqli_query($connect, $query))
  {
    $data["message"] = "O cadastro da ação foi concluído com sucesso!";
  }
}

echo json_encode($data);

?>
