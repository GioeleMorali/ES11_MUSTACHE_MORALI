<?php
require("Alunno.php");
class Classe{
    public $arrayy = [];
    public function __construct(){
        $a1 = new Alunno("Gianlu", "Gianne", 18);
        $a2 = new Alunno("Gabri", "Lolla", 16);
        $a3 = new Alunno("Ebebu", "aaab", 15);
        $a4 = new Alunno("Costa", "Dangelo", 19);
        array_push($this->arrayy, $a1);
        array_push($this->arrayy, $a2);
        array_push($this->arrayy, $a3);
        array_push($this->arrayy, $a4);
    }
   public function getArray(){
    return $this->arrayy;
   }

   public function findByName($name){
    $alunno = null;
    foreach($this->arrayy as $alunno_nome){
        if($alunno_nome->getNome() == $name)
        {
            $alunno = $alunno_nome;
        }
    }
    return $alunno;
   }
   public function addAlunno($alunno)
   {
        array_push($this->arrayy, $alunno);
   }
   public function modificaAlunno($alunnoPassato)
   {
      foreach($this->arrayy as $alunno)
      {
        if($alunno->getNome() == $alunnoPassato->getNome())
        {
            $alunno->setCognome($alunnoPassato->getCognome());
            $alunno->setEta($alunnoPassato->getEta());
            return $alunno;
        }
      }
      return null;
   }
   public function cancellaAlunno($alunnoPassato)
   {
      $trovato=false;
      foreach($this->arrayy as $i => $alunno)
      {
        if($alunno->getNome() == $alunnoPassato->getNome())
        {
            $trovato = true;
            break;
        }
      }

      if($trovato)
      {
         unset($this->arrayy[$i]);
         return 1;
      }
    return null;
   }
}
?>