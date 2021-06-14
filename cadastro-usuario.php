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
    <title>Cadastro de Usuário</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>
  <body>
      <div class="container">
        <h1 class="jumbotron bg-info">Cadastro de usuário</h1>

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
                  <li><a href="cadastro-livros.php">Cadastro</a></li>
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

        <form name="cadusuario" method="post" action="">
          <div class="form-group">
            <input type="text" name="txtlogin" placeholder="Login" class="form-control">
          </div>
          <div class="form-group">
            <input type="password" name="txtsenha" placeholder="Senha" class="form-control">
          </div>
          <div class="form-group">
            <select name="seltipo" class="form-control">
              <option value="Adm">Adm</option>
              <option value="Visitante">Visitante</option>
            </select>
          </div>
          <div class="form-group">
            <input type="submit" name="cadastrar" value="Cadastrar" class="btn btn-primary">
            <input type="reset" name="Limpar" value="Limpar" class="btn btn-danger">
          </div>
        </form>
        <?php
        if(isset($_POST['cadastrar'])){
          include_once 'modelo/usuario.class.php';
          include 'dao/usuariodao.class.php';
          include 'util/seguranca.class.php';

          //padronizacao
          $login = $_POST['txtlogin'];
          $senha = Seguranca::criptografar($_POST['txtsenha']);
          $tipo = $_POST['seltipo'];

          //validacao
          $u = new Usuario();
          $u->login = $login;
          $u->senha = $senha;
          $u->tipo = $tipo;

          //banco
          $uDAO = new UsuarioDAO();
          $uDAO->cadastrarUsuario($u);

          echo "Usuário cadastrado com sucesso!";
        }//fecha if
        ?>
      </div>
  </body>
</html>
