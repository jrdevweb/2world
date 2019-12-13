<?php
date_default_timezone_set('America/Sao_Paulo');
$inputs = json_decode(file_get_contents("php://input"));
$data = array();
$error = array();
require 'conectar.php';
session_start();
$ID_PRODUTO = $_SESSION['id_produto'];

if(empty($inputs->descricao))
{
  $error["descricao"] = "A descrição é obrigatório *";
}

if(empty($inputs->valor))
{
  $error["valor"] = "O valor é obrigatório *";
}

if(empty($inputs->quantidade_disponivel))
{
  $error["quantidade_disponivel"] = "A quantidade é obrigatório *";
}

if(empty($inputs->imagem_produto))
{
  $error["imagem_produto"] = "A imagem do produto obrigatório *";
}

if(!empty($error))
{
  $data["error"] = $error;
}
else
{

  $descricao = mysqli_real_escape_string($connect, $inputs->descricao);
  $valor = mysqli_real_escape_string($connect, $inputs->valor);
  $quantidade_disponivel = mysqli_real_escape_string($connect, $inputs->quantidade_disponivel);
  $imagem_produto = mysqli_real_escape_string($connect, $inputs->imagem_produto);

  $query = "UPDATE loja set descricao = '$descricao', valor = '$valor', quantidade_disponivel = '$quantidade_disponivel', imagem_produto = '$imagem_produto' WHERE id = '$ID_PRODUTO'";
  if(mysqli_query($connect, $query))
  {
    $data["message"] = "O produto foi atualizado com sucesso!";
  }
}

echo json_encode($data);

?>
