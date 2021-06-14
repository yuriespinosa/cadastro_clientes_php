<?php
include 'dao/clientedao.class.php';
include 'modelo/cliente.class.php';

$cliDAO = new ClienteDAO();
echo $cliDAO->gerarJSON();
 ?>
