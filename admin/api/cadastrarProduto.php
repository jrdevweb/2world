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

  $query = "INSERT INTO loja (descricao, valor, quantidade_disponivel, imagem_produto)
                        VALUES ('$descricao','$valor','$quantidade_disponivel','$imagem_produto')";
  if(mysqli_query($connect, $query))
  {
    $data["message"] = "O cadastro do produto foi concluído com sucesso!";
  }
}

echo json_encode($data);

?>
