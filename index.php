  <?php session_start(); ob_start();?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <title>Index</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>
  <body>
    <div class="container">
      <h1 class="jumbotron">Seja bem vindo!</h1>

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
      if(isset($_SESSION['privateUser'])){

        include_once 'modelo/usuario.class.php';
        $u = unserialize($_SESSION['privateUser']);
        echo "<div class='alert alert-success' role='alert' align='center'><h3>Olá $u->login, seja bem vindo</h3></div>";
        //<h2>Olá $u->login, seja bem vindo</h2>
        ?>
        
        <form name="deslogar" action="" method="post">
          <div class="form-group form-inline">
          <input type="submit" name="deslogar"
                 class="btn btn-primary" value="Deslogar">
          </div>
        </form>
      <?php
        if(isset($_POST['deslogar'])){
          unset($_SESSION['privateUser']);
          header("location:index.php");
        }
      } else {
      ?>
      <!-- INICIO LOGIN -->
      <h2>Login!</h2>
      <form name="login" action="" method="post">
        <div class="form-group form-inline">
          <input type="text" name="txtlogin" placeholder="Login"
                 class="form-control">
        </div>
        <div class="form-group form-inline">
          <input type="password" name="txtsenha" placeholder="Senha"
                 class="form-control">
        </div>
        <div class="form-group form-inline">
          <select name="seltipo" class="form-control">
            <option value="Adm">Adm</option>
            <option value="Visitante">Visitante</option>
          </select>
        </div>
        <div class="form-group form-inline">
          <input type="submit" name="entrar" value="Entrar"
                 class="form-control">
        </div>
      </form>

      <?php
      }//fecha

      if(isset($_POST['entrar'])){

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

        //teste, se aparecer aqui tá d boas
        var_dump($u);

        //DAO
        $uDAO = new UsuarioDAO();
        $usuario = $uDAO->verificarUsuario($u);

        if($usuario && !is_null($usuario)){
          //Significa que login tá certo!
          var_dump($usuario);
          $_SESSION['privateUser'] = serialize($usuario);
          header("location:index.php");
        }else{
          //Não existe usuário no banco
          echo "Erro!";
        }

        unset($_POST['entrar']);
      }//fecha if
      ?>
    </div>
  </body>
</html>