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

if(empty($inputs->meses_rentabilidade))
{
  $error["meses_rentabilidade"] = "A descrição de meses de rentabilidade é obrigatório *";
}

if(empty($inputs->valor_plano))
{
  $error["valor_plano"] = "O valor é obrigatório *";
}

if(empty($inputs->porcentagem_diario))
{
  $error["porcentagem_diario"] = "A porcentagem de ganho diário é obrigatório *";
}

if(empty($inputs->porcentagem_total))
{
  $error["porcentagem_total"] = "A porcentagem de ganho total é obrigatório *";
}

if(empty($inputs->taxa_saque))
{
  $error["taxa_saque"] = "A taxa de saque é obrigatório *";
}

if(!empty($error))
{
  $data["error"] = $error;
}
else
{
  $descricao = mysqli_real_escape_string($connect, $inputs->descricao);
  $meses_rentabilidade = mysqli_real_escape_string($connect, $inputs->meses_rentabilidade);
  $valor_plano = mysqli_real_escape_string($connect, $inputs->valor_plano);
  $porcentagem_diario = mysqli_real_escape_string($connect, $inputs->porcentagem_diario);
  $porcentagem_total = mysqli_real_escape_string($connect, $inputs->porcentagem_total);
  $nivel_indicacao = mysqli_real_escape_string($connect, $inputs->nivel_indicacao);
  $taxa_saque = mysqli_real_escape_string($connect, $inputs->taxa_saque);

  $query = "INSERT INTO planos (descricao, meses_rentabilidade, valor_plano, porcentagem_diario, porcentagem_total, nivel_indicacao, taxa_saque)
                        VALUES ('$descricao','$meses_rentabilidade','$valor_plano','$porcentagem_diario','$porcentagem_total','$nivel_indicacao','$taxa_saque')";
  if(mysqli_query($connect, $query))
  {
    $data["message"] = "O cadastro do plano foi concluído com sucesso!";
  }
}

echo json_encode($data);

?>
