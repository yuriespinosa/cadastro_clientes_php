<?php
class ConexaoBanco extends PDO {

  private static $instance = null;
                     //nome do banco, usuario e senha
  public function __construct($dsn,$user,$pass){
      //Construtor da classe pai PDO
      parent::__construct($dsn,$user,$pass);
  }
  public static function getInstance(){
    if(!isset(self::$instance)){
      try{
        /* Cria e retorna uma nova conexão. */
        self::$instance = new ConexaoBanco("mysql:dbname=cadastro_cliente;host=localhost","root","");
      }catch(PDOException $e){
        echo "Erro ao conectar! ".$e;
      }//fecha catch
    }//fecha if
    return self::$instance;
  }//fecha método
}//fecha classe
