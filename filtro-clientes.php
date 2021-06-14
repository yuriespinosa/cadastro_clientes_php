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
    <title>Filtro de Livros</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>
  <body>
    <div class="container"> <!-- container-fluid -->
      <h1 class="jumbotron bg-info">Filtro de Clientes</h1>
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

      <form name="filtrocliente" method="post" action="">
        <div class="form-group">
          <input type="text" name="txtpesquisa" class="form-control"
                 placeholder="Digite o que deseja pesquisar">
        </div>
        <div class="radio-inline">
          <label class="radio-inline">
          <input type="radio" name="rdfiltro" value="idcliente">
          Código</label>
          <label class="radio-inline">
          <input type="radio" name="rdfiltro" value="nome">
          Nome</label>
          <label class="radio-inline">
          <input type="radio" name="rdfiltro" value="idade">
          Idade</label>
          <label class="radio-inline">
          <input type="radio" name="rdfiltro" value="endereco">
          Endereço</label>
          <label class="radio-inline">
          <input type="radio" name="rdfiltro" value="todos"
                 checked="checked">
          Todos</label>
        </div>
        <div class="form-group">
          <input type="submit" name="filtrar" value="Filtrar"
                 class="btn btn-primary">
        </div>
      </form>

      <?php
      include 'dao/clientedao.class.php';
      include 'modelo/cliente.class.php';

      if(isset($_POST['filtrar'])){

        $pesq = "";
        $pesq = $_POST['txtpesquisa']; //O que o user digitou
        $query = "";

        if($pesq != ""){

          $filtro = $_POST['rdfiltro']; //RadioButton

          if($filtro == 'idcliente'){
            $query = "where idcliente = ".$pesq;
          }else if($filtro == 'nome'){
            $query = "where nome like '%".$pesq."%'";
          }else if($filtro == 'idade'){
            $query = "where idade like '%".$pesq."%'";
          }else if($filtro == 'endereco'){
            $query = "where endereco like '%".$pesq."%'";
          }else{
            $query = "";
          }
        }//fecha if isset rdfiltro

        $cliDAO = new ClienteDAO();
        $array = $cliDAO->filtrar($query);

        unset($_POST['filtrar']);

      } else {

        $cliDAO = new ClienteDAO();
        $array = $cliDAO->buscarCliente();

      }//fecha else

      /* Testando se retornou dados */
      if(count($array) != 0) {
      ?>
      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover table-condensed">
          <thead>
            <tr>
              <th>Código</th>
              <th>Nome</th>
              <th>Idade</th>
              <th>Endereço</th>
            </tr>
          </thead>

          <tfoot>
            <tr>
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
                echo "<td>$a->idCliente</td>";
                echo "<td>$a->nome</td>";
                echo "<td>$a->idade</td>";
                echo "<td>$a->endereco</td>";
              echo "</tr>";
            }//fecha foreach
            unset($array);
            ?>
          </tbody>
        </table>
      </div> <!-- div tabela -->
      <?php
      } else {
        echo "<h2>Não há cliente(s) para ser(em) exibidos!</h2>";
      }//fecha else
      ?>
    </div>
  </body>
</html>
