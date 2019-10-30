<?php
require 'conectar.php';
$inputs = json_decode(file_get_contents("php://input"));
session_start();
$ID_ACAO = $_SESSION['id_plano'];
if(!empty($_FILES))
{
  $path = pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);
  $image = time().'.'.$path;
  // $path = '../comprovantes/' . $_FILES['file']['name'];
  if(move_uploaded_file($_FILES["file"]["tmp_name"], '../../assets/images/acoes/'.$image))
  {
    $filename = $_FILES['file']['name'];
    $insertQuery = "UPDATE planos set imagem_acao = '$image' WHERE id = '$ID_ACAO'";
    if(mysqli_query($connect, $insertQuery))
    {
      echo 'Logo enviado com sucesso!';
    }
    else
    {
      echo 'Logo carregada, porém ocorreu um erro.';
    }
  }
}
else
{
  echo 'Para enviar a logo, escolha uma foto e clique em "ENVIAR"';
}
?>
