<?php
date_default_timezone_set('America/Sao_Paulo');
$inputs = json_decode(file_get_contents("php://input"));
$data = array();
$error = array();
require 'conectar.php';
session_start();
$ID_PLANO = $_SESSION['id_plano'];

if(empty($inputs->descricao))
{
  $error["descricao"] = "A descrição é obrigatório *";
}

if(empty($inputs->valor))
{
  $error["valor"] = "O valor é obrigatório *";
}

if(empty($inputs->porcentagem_ganho))
{
  $error["porcentagem_ganho"] = "A porcentagem de ganho é obrigatório *";
}

if(empty($inputs->porcentagem_perca))
{
  $error["porcentagem_perca"] = "A porcentagem de perca é obrigatório *";
}

if(empty($inputs->limite_maximo))
{
  $error["limite_maximo"] = "O Limite máximo investimento é obrigatório *";
}

if(empty($inputs->potencializar))
{
  $error["potencializar"] = "O limite a potencializar é obrigatório *";
}

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
  $ganho = mysqli_real_escape_string($connect, $inputs->porcentagem_ganho);
  $perca = mysqli_real_escape_string($connect, $inputs->porcentagem_perca);
  $limite_maximo = mysqli_real_escape_string($connect, $inputs->limite_maximo);
  $potencializar = mysqli_real_escape_string($connect, $inputs->potencializar);
  $taxa_saque = mysqli_real_escape_string($connect, $inputs->taxa_saque);
  $valor_minimo_saque = mysqli_real_escape_string($connect, $inputs->valor_minimo_saque);
  $valor_acao = mysqli_real_escape_string($connect, $inputs->valor_acao);
  $subir_descer = mysqli_real_escape_string($connect, $inputs->subir_descer);

  $query = "UPDATE planos set descricao = '$descricao', valor = '$valor', porcentagem_ganho = '$ganho', porcentagem_perca = '$perca',
   limite_maximo = '$limite_maximo', potencializar = '$potencializar', taxa_saque = '$taxa_saque', valor_minimo_saque = '$valor_minimo_saque', valor_acao = '$valor_acao', subir_descer = '$subir_descer' WHERE id = '$ID_PLANO'";
  if(mysqli_query($connect, $query))
  {
    $data["message"] = "O cadastro do plano foi atualizado com sucesso!";
  }
}

echo json_encode($data);

?>
