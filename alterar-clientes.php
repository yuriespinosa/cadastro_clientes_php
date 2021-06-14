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
    <title>Alterar livro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>
  <body>
      <div class="container">
        <h1 class="jumbotron bg-info">Alterar Clientes</h1>

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
        include 'modelo/cliente.class.php';
        include 'dao/clientedao.class.php';

        if (isset($_GET['id'])) {
          //echo "ID:".$_GET['id'];
          $cliDAO = new ClienteDAO();
          $query = "where idcliente=".$_GET['id'];
          $array = $cliDAO->filtrar($query);

          //var_dump($array);
          unset($_GET['id']);
        }
         ?>
        <form name="alterarcliente" method="post" action="">
          <div class="form-group">
            <input type="text" name="txtidcliente" placeholder="Código" class="form-control"
            readonly="readonly" value="<?php if(isset($array)) echo $array[0]->idCliente?>">
          </div>
          <div class="form-group">
            <input type="text" name="txtnome" placeholder="Nome" class="form-control"
            value="<?php if(isset($array)) echo $array[0]->nome?>">
          </div>
          <div class="form-group">
            <input type="text" name="txtidade" placeholder="Idade" class="form-control"
            value="<?php if(isset($array)) echo $array[0]->idade?>">
          </div>
          <div class="form-group">
            <input type="text" name="txtendereco" placeholder="Endereço" class="form-control"
            value="<?php if(isset($array)) echo $array[0]->endereco?>">
          </div>
          <div class="form-group">
            <input type="submit" name="alterar" value="Alterar" class="btn btn-primary">
            <input type="reset" name="Limpar" value="Limpar" class="btn btn-danger">
          </div>
        </form>
        <?php
        if(isset($_POST['alterar'])){
          include 'util/padronizacao.class.php';

          //padronizacao
          $idCliente = $_POST['txtidcliente'];
          $nome = Padronizacao::padronizarMaiMin($_POST['txtnome']);
          $idade = Padronizacao::padronizarMaiMin($_POST['txtidade']);
          $endereco = Padronizacao::padronizarMaiMin($_POST['txtendereco']);

          //validacao
          $cli = new Cliente();
          $cli->idCliente = $idCliente;
          $cli->nome = $nome;
          $cli->idade = $idade;
          $cli->endereco = $endereco;

          //banco
          $cliDAO = new ClienteDAO();
          $cliDAO->alterarCliente($cli);
          header("location:consulta-clientes.php");
        }//fecha if
        ?>
      </div>
  </body>
</html>
