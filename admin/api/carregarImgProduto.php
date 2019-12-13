<?php
require 'conectar.php';
$inputs = json_decode(file_get_contents("php://input"));
session_start();
$ID_PRODUTO = $_SESSION['id_produto'];
if(!empty($_FILES))
{
  $path = pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);
  $image = time().'.'.$path;

  if(move_uploaded_file($_FILES["file"]["tmp_name"], './../assets/images/img_produto/'.$image))
  {
    $filename = $_FILES['file']['name'];
    $insertQuery = "UPDATE loja set imagem_produto = '$image' WHERE id = '$ID_PRODUTO'";
    if(mysqli_query($connect, $insertQuery))
    {
      echo 'Imagem do produto enviado com sucesso!';
    }
    else
    {
      echo 'Imagem carregada, porém ocorreu um erro.';
    }
  }
}
else
{
  echo 'Para enviar a imagem, escolha uma foto e clique em "ENVIAR"';
}
?>
