
<?php

require_once('organism.class.php');
class berry extends organism{

  function __construct($x,$y)
  {
    $this->posX=$x;
    $this->posY=$y;
    $this->power=0;
    $this->id="JAGODA";
    $this->avatarTag = '<td><img src="images/berry.png" alt="player" width=30 height=30 ></td>';
  }

  function getX(){
    return $this->posX;
  }

  function getY(){
    return $this->posY;
  }

  function setX($x){
    $this->posX=$x;
  }

  function setY($y){
    $this->posY=$y;
  }
  function showAvatar(){
    echo $this->avatarTag;
  }
  function getPower(){
    return $this->power;
  }

  function setPower($x){
    $this->power=$x;
  }

  function action(&$gameStatus){
    $this->multiplication($gameStatus);
  }
  function getID(){
    return $this->id;
  }

  function multiplication(&$gameStatus){
    if(rand(0, 100)<MULTIPLICATION_PERCENT_PLANT){
      $x = $this->posX;
      $y = $this->posY;
      if($y+1 < WORLD_SIZE && $gameStatus[$y+1][$x] == NULL ){
        $gameStatus[$y+1][$x] = new berry($x,$y+1);
        $gameStatus[$y+1][$x]->setMove(true);
        }
      else if($y-1 >= 0 && $gameStatus[$y-1][$x] == NULL  ){
        $gameStatus[$y-1][$x] = new berry($x,$y-1);
        $gameStatus[$y-1][$x]->setMove(true);
        }
      else if($x+1<WORLD_SIZE && $gameStatus[$y][$x+1] == NULL ){
        $gameStatus[$y][$x+1] = new berry($x+1,$y);
        $gameStatus[$y][$x+1]->setMove(true);
        }
      else if($x-1>=0 && $gameStatus[$y][$x-1] == NULL){
        $gameStatus[$y][$x-1] = new berry($x-1,$y);
        $gameStatus[$y][$x-1]->setMove(true);
        }
      $_SESSION['dailyLog'].=$this->getID()." Rozprzestrzeniła się.<br>";
    }
}

  function collision($yAttacker, $xAttacker, &$gameStatus){
      $powerNow = $gameStatus[$yAttacker][$xAttacker]->getPower();
      $gameStatus[$yAttacker][$xAttacker]->setPower($powerNow+3);
      $x = $this->posX;
      $y = $this->posY;
      $gameStatus[$yAttacker][$xAttacker]->setY($y);
      $gameStatus[$yAttacker][$xAttacker]->setX($x);
      $_SESSION['dailyLog'].= $gameStatus[$yAttacker][$xAttacker]->getID()." (PWR = ".$gameStatus[$yAttacker][$xAttacker]->getPower().") zjadł Jagodę!<br>";
    }
}
 ?>
