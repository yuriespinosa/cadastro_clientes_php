<?php
class Cliente {

  private $idCLiente;
  private $nome;
  private $idade;
  private $endereco;

  public function __construct(){}
  public function __destruct(){}

  public function __get($a){return $this->$a;}
  public function __set($a, $v){$this->$a = $v;}

  public function __toString(){
    return nl2br("Nome: $this->nome
                  Idade: $this->idade
                  Endereco: $this->endereco");
  }//fecha toString
}//fecha classe
