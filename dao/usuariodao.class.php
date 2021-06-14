<?php
require "conexaobanco.class.php";

class UsuarioDAO {
    private $conexao = null;

    public function __construct(){
        $this->conexao = ConexaoBanco::getInstance();
    }
    public function __destruct(){}

    public function cadastrarUsuario($u){
        try {
            $stat = $this->conexao->prepare("insert into usuario(idUsuario,login,senha,tipo)values(null,?,?,?);");
            $stat->bindValue(1,$u->login);
            $stat->bindValue(2,$u->senha);
            $stat->bindValue(3,$u->tipo);
            $stat->execute();
            $this->conexao = null;
        } catch (PDOException $ex) {
            echo "Erro ao cadastrar! ".$ex;
        }//fecha catch
    }//fecha método cadastrarUsuario

    public function buscarUsuarios(){
        try{
            $stat = $this->conexao->query("select * from usuario");
            $array = $stat->fetchAll(PDO::FETCH_CLASS,'Usuario');
            return $array;
        } catch (PDOException $ex) {
            echo 'Erro ao buscar usuários!'.$ex;
        }//fecha catch
    }//fecha buscarUsuarios

    public function deletarUsuario($id){
        try {
            $stat = $this->conexao->prepare(
            "delete from usuario where idusuario = ?");

            $stat->bindValue(1, $id);
            $stat->execute();

        } catch (PDOException $ex) {
            echo 'Erro ao deletar! '.$ex;
        }//fecha catch
    }//fecha deletarUsuario

    public function filtrar($query){
        try {
            $stat = $this->conexao->query("select * from usuario ".$query);
            $array = $stat->fetchAll(PDO::FETCH_CLASS,'Usuario');
            return $array;
        } catch (PDOException $ex) {
            echo 'Erro ao filtrar! '.$ex;
        }
    }//fecha filtrar

    public function alterarUsuario($u){
        try {
            $stat = $this->conexao->prepare("update usuario set login = ?, senha = ?, tipo = ? where idusuario = ?");

            $stat->bindValue(1, $u->login);
            $stat->bindValue(2, $u->senha);
            $stat->bindValue(3, $u->tipo);
            $stat->bindValue(4, $u->idUsuario);

            $stat->execute();
        } catch (PDOException $exc) {
            echo 'Erro ao alterar!' . $exc;
        }//fecha catch
    }//fecha alterarUsuario

    public function verificarUsuario($u){
      try {
          $stat = $this->conexao->query("select * from usuario where login='$u->login' and senha='$u->senha' and tipo='$u->tipo'");
          $usuario = null;
          $usuario = $stat->fetchObject('Usuario');
          return $usuario;
      } catch (PDOException $ex) {
          echo 'Erro ao verificar! '.$ex;
      }//fecha catch
    }

   public function gerarJSON($query) {
        try {
            $stat = $this->conexao->query("select * from usuario ".$query);

            return json_encode($stat->fetchAll(PDO::FETCH_ASSOC));

        } catch (PDOException $exc) {
            echo 'Erro ao gerar JSON de usuários! ' . $exc;
        }//fecha catch
    }//fecha método filtrar
}//fecha classe
