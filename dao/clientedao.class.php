<?php
require 'conexaobanco.class.php';
 class ClienteDAO { //DATA ACCESS OBJECT

   private $conexao = null;

   public function __construct(){
     $this->conexao = ConexaoBanco::getInstance();
   }

   public function __destruct(){}

   public function cadastrarCliente($cli){//obj livro
     try {
       //SQL - CASE INSENSITIVE
       $stat = $this->conexao->prepare("insert into cliente(idCliente,nome,idade,endereco)values(null,?,?,?)");
       $stat->bindValue(1,$cli->nome);
       $stat->bindValue(2,$cli->idade);
       $stat->bindValue(3,$cli->endereco);
       $stat->execute();
     }catch (PDOException $pe){
       echo "ERRO ao cadastrar Cliente!!".$pe;
     }
   }//fecha cadastrarLivro
   public function buscarCliente(){
     try {
       $stat = $this->conexao->query("select * from cliente");
       $array = $stat->fetchAll(PDO::FETCH_CLASS, 'Cliente');
       return $array;//NÃO ESQUECER
     }catch(PDOException $pe){
       echo "erro ao buscar Clientes no banco!".$pe;
     }
   }
                          //where titulo like '%a%'
   public function filtrar($query){
     try {
       $stat = $this->conexao->query("select * from cliente ".$query);
       $array = $stat->fetchAll(PDO::FETCH_CLASS, 'Cliente');
       return $array;
     } catch (PDOException $pe) {
       echo "Erro ao filtrar!!".$pe;
     }
   }

   public function deletarCliente($id){
     try {
       $stat = $this->conexao->prepare("delete from cliente where idcliente = ?");
       $stat->bindValue(1, $id);
       $stat->execute();
     } catch (PDOException $pe) {
       echo "Erro ao excluir!".$pe;
     }
   }

   public function alterarCliente($cli){
     try {
       $stat = $this->conexao->prepare("update cliente set nome=?, idade=?, endereco=? where idcliente =?");
       $stat->bindValue(1, $cli->nome);
       $stat->bindValue(2, $cli->idade);
       $stat->bindValue(3, $cli->endereco);
       $stat->bindValue(4, $cli->idCliente);
       $stat->execute();
     }catch(PDOException $pe){
       echo "Erro ao alterar cliente na base de dados! ".$pe;
     }
   }
   
   public function gerarJSON(){
     try {
       $stat = $this->conexao->query("select * from cliente");
       return json_encode($stat->fetchAll(PDO::FETCH_ASSOC));
     } catch (PDOException $pe) {
       echo "Erro ao gerar JSON".$pe;
     }
   }
 }//fecha classe
