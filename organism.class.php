<?php

define("MULTIPLICATION_PERCENT_PLANT", 2.5);
define("MULTIPLICATION_PERCENT_ANIMAL", 15);
define("LEFT_DIR", 0);
define("RIGHT_DIR", 1);
define("UP_DIR", 2);
define("DOWN_DIR", 3);

class organism{
  private $posX;
  private $posY;
  private $avatarTag;
  private $power;
  private $id;
  private $moved = false;

  function setMove($op){
    $this->moved= $op;
  }
  function isMoved(){
    return $this->moved;
  }
  function multiplication(&$gameStatus){}
  function collision($yAttacker, $xAttacker, &$gameStatus){}
  function action(&$gameStatus){}
}
?>
