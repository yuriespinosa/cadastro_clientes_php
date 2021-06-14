<?php
class Seguranca {

  //Criptografado com md5, colocando a senha entre duas palavras aleatórias.
  public static function criptografar($v){
    return md5('Aula'.$v.'PHP');
  }//fecha criptografar
  
}//fecha classe
