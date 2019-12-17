<?php
date_default_timezone_set('America/Sao_Paulo');
$inputs = json_decode(file_get_contents("php://input"));
$data = array();
$error = array();
require 'conectar.php';
session_start();
$ID_PLANO_COMPRADO = $_SESSION['plano_comprado_id'];

if(!empty($error))
{
  $data["error"] = $error;
}
else
{
  $status = 'PAGO';
  $statusUsuario = 'SIM';

  //PEGANDO ID DO USUÁRIO

  $CONSULTA = mysqli_query($connect, " SELECT * FROM planos_comprados where id = '$ID_PLANO_COMPRADO'");
  $r = mysqli_fetch_assoc($CONSULTA);
  $ID_USUARIO = $r['usuario_id'];

  //ATUALIZANDO STATUS DO PLANO COMPRADO PARA PAGO

  $query = "UPDATE planos_comprados set status = '$status' WHERE id = '$ID_PLANO_COMPRADO'";
  if(mysqli_query($connect, $query))
  {
    $data["message"] = "Fatura paga com sucesso.";
  }


  //ATUALIZANDO USUARIO COMO ATIVO, ATUALIZANDO SALDO COM O PLANO

  $CONSULTAINDICACAO = mysqli_query($connect, " SELECT * FROM usuario where id = '$ID_USUARIO'");
  $r = mysqli_fetch_assoc($CONSULTAINDICACAO);
  $ID_USUARIO_INDICADOR = $r['id_usuario_indicador'];
  $PLANO_VALOR = $r['plano_valor'];

  $queryUsuario = "UPDATE usuario set ativo = '$statusUsuario', saldo_conta = saldo_conta + '$PLANO_VALOR' WHERE id = '$ID_USUARIO'";
  if(mysqli_query($connect, $queryUsuario))
  {

  }

  //PEGANDO A PORCENTAGEM DA INDICACAO


  $CONSULTANIVEL = mysqli_query($connect, " SELECT * from indicacao where id_usuario_indicado = '$ID_USUARIO'");
  $r_nivel = mysqli_fetch_assoc($CONSULTANIVEL);
  $nivel_indicacao = $r_nivel['nivel_indicacao'];

  //PEGANDO PORCNTAGEM DO NIVEL DE INDICAÇÃO

  $CONSULTAINDICACAO = mysqli_query($connect, " SELECT * from niveis_indicacao where nivel = '$nivel_indicacao'");
  $r_indicacao = mysqli_fetch_assoc($CONSULTAINDICACAO);
  $porcentagem_nivel_indicacao = $r_indicacao['porcentagem_nivel'];


  //CALCULO VALOR * PORCENTAGEM / 100

  $cem = 100;
  $valor = ($PLANO_VALOR * $porcentagem_nivel_indicacao) / $cem;

  $query = "UPDATE usuario set saldo_conta = saldo_conta + $valor WHERE id = '$ID_USUARIO_INDICADOR'";
  if(mysqli_query($connect, $query))
  {

  }

  //ATUALIZANDO INDICAÇÃO PARA PAGA

  $query = "UPDATE indicacao set status = 'PAGO' WHERE id_usuario_indicou = '$ID_USUARIO_INDICADOR' and id_usuario_indicado = '$ID_USUARIO'";
  if(mysqli_query($connect, $query))
  {

  }

}

echo json_encode($data);

?>
