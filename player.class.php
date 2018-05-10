
<?php
require_once('organism.class.php');
class player extends organism{

  function __construct($x,$y)
  {
    $this->posX=$x;
    $this->posY=$y;
    $this->power=5;
    $this->id='GRACZ';
    $this->avatarTag = '<td><img src="images/player.png" alt="player" width=30 height=30 ></td>';
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

  function getPower(){
    return $this->power;
  }

  function setPower($x){
    $this->power=$x;
  }

  function showAvatar(){
    echo $this->avatarTag;
  }
  function getID(){
    return $this->id;
  }

  function action(&$gameStatus){
    if(isset($_REQUEST['up']) && $this->posY-1 >=0){
      if($gameStatus[$this->posY-1][$this->posX]==NULL)
        $this->posY--;
      else
        $gameStatus[$this->posY-1][$this->posX]->collision($this->posY, $this->posX, $gameStatus);
    }
    else if (isset($_REQUEST['down']) && $this->posY+1<WORLD_SIZE){
      if($gameStatus[$this->posY+1][$this->posX]==NULL)
        $this->posY++;
      else
        $gameStatus[$this->posY+1][$this->posX]->collision($this->posY, $this->posX, $gameStatus);
    }
    else if (isset($_REQUEST['left']) && $this->posX-1>=0){
      if($gameStatus[$this->posY][$this->posX-1]==NULL)
        $this->posX--;
      else
        $gameStatus[$this->posY][$this->posX-1]->collision($this->posY, $this->posX, $gameStatus);
    }
    else if (isset($_REQUEST['right']) && $this->posX+1<WORLD_SIZE){
      if($gameStatus[$this->posY][$this->posX+1]==NULL)
        $this->posX++;
      else
        $gameStatus[$this->posY][$this->posX+1]->collision($this->posY, $this->posX, $gameStatus);
    }
  }

  function collision($yAttacker, $xAttacker, &$gameStatus){
    $x = $this->posX;
    $y = $this->posY;
    $attackerPwr = $gameStatus[$yAttacker][$xAttacker]->getPower();
    if($attackerPwr>=$this->getPower()){
      $_SESSION['dailyLog'].= $gameStatus[$yAttacker][$xAttacker]->getID()." (PWR = ".$gameStatus[$yAttacker][$xAttacker]->getPower().") zabił ".$gameStatus[$y][$x]->getID()." (PWR = ".$gameStatus[$y][$x]->getPower(). ")<br>";
      $gameStatus[$yAttacker][$xAttacker]->setY($y);
      $gameStatus[$yAttacker][$xAttacker]->setX($x);
      $gameStatus[$y][$x] = NULL;
    }
    else {
      $_SESSION['dailyLog'].= $gameStatus[$y][$x]->getID()." (PWR = ".$gameStatus[$y][$x]->getPower().") zabił ".$gameStatus[$yAttacker][$xAttacker]->getID()." (PWR = ".$gameStatus[$yAttacker][$xAttacker]->getPower(). ")<br>";
      $gameStatus[$yAttacker][$xAttacker] = NULL;
    }
  }
}
 ?>
