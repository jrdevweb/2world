<?php
require 'conectar.php';
$output = array();
session_start();
$data = json_decode(file_get_contents("php://input"));
$ID_PRODUTO = mysqli_real_escape_string($connect, $data->id);
$query = "SELECT * from loja where id = '$ID_PRODUTO'";
$result = mysqli_query($connect, $query);

if(mysqli_num_rows($result) > 0)
{
  while($row = mysqli_fetch_array($result))
  {
    $output[] = $row;
  }
  echo json_encode($output);
  $_SESSION['id_produto'] = $ID_PRODUTO;
}
?>
