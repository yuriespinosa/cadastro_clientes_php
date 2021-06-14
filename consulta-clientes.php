<?php
session_start();
ob_start();

if(isset($_SESSION['privateUser'])){
  include_once 'modelo/usuario.class.php';
  $u = unserialize($_SESSION['privateUser']);

  if($u->tipo != 'Adm'){
    header("location:index.php");
  }
}else{
  header("location:index.php");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <title>Consulta de Clientes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>
  <body>
    <div class="container"> <!-- container-fluid -->
      <h1 class="jumbotron bg-info">Consulta de Clientes</h1>
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand" href="#">Sistema</a>
          </div>
          <ul class="nav navbar-nav">
            <?php
            if(isset($_SESSION['privateUser'])){
              include_once 'modelo/usuario.class.php';
              $u = unserialize($_SESSION['privateUser']);
              if($u->tipo == 'Adm'){
            ?>
                <li><a href="index.php">Home</a></li>
                <li><a href="cadastro-clientes.php">Cadastro</a></li>
                <li><a href="consulta-clientes.php">Consulta</a></li>
                <li><a href="filtro-clientes.php">Filtrar</a></li>
                <li><a href="cadastro-usuario.php">Cad usuário</a></li>
            <?php
              }else if($u->tipo == 'Visitante'){
              ?>
                <li class="active"><a href="index.php">Home</a></li>
                <li><a href="cadastro-clientes.php">Cadastro</a></li>
              <?php
              }
            }else{
            ?>
            <li class="active"><a href="index.php">Home</a></li>
            <?php
            }
            ?>
          </ul>
        </div>
      </nav>

      <?php
      include 'dao/clientedao.class.php';
      include 'modelo/cliente.class.php';

      $cliDAO = new ClienteDAO();
      $array = $cliDAO->buscarCliente();

      if(count($array)!=0){
      ?>
      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover table-condensed">
          <thead>
            <tr>
              <th>Alterar</th>
              <th>Excluir</th>
              <th>Código</th>
              <th>Nome</th>
              <th>Idade</th>
              <th>Endereço</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>Alterar</th>
              <th>Excluir</th>
              <th>Código</th>
              <th>Nome</th>
              <th>Idade</th>
              <th>Endereço</th>
            </tr>
          </tfoot>

          <tbody>
            <?php
            foreach($array as $a){
              echo "<tr>";
                echo "<td><a href='alterar-clientes.php?id=$a->idCliente'>Alterar</a></td>";
                echo "<td><a href='consulta-clientes.php?id=$a->idCliente'><img src='images/trash.png' alt='Excluir' ></a></td>";
                echo "<td>$a->idCliente</td>";
                echo "<td>$a->nome</td>";
                echo "<td>$a->idade</td>";
                echo "<td>$a->endereco</td>";
              echo "</tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
      <?php
      } else {
        echo "Não há cliente(s) para ser(em) exibidos!";
      }

      if(isset($_GET['id'])){
        //só para teste
        //echo "foi.: ".$_GET['id'];

        $cliDAO = new ClienteDAO();
        $cliDAO->deletarCliente($_GET['id']);
        header('location:consulta-clientes.php');
        unset($_GET['id']);
      }
      ?>
    </div>
  </body>
</html>
