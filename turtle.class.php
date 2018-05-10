
<?php

require_once('organism.class.php');
class turtle extends organism{

  function __construct($x,$y)
  {
    $this->posX=$x;
    $this->posY=$y;
    $this->power=2;
    $this->id='ZOLW';
    $this->avatarTag = '<td><img src="images/turtle.png" alt="player" width=30 height=30 ></td>';
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
    $this->randomMove($gameStatus);
  }
  function getID(){
    return $this->id;
  }
  function multiplication(&$gameStatus){
    if(rand(0, 100)<=MULTIPLICATION_PERCENT_ANIMAL){
      $x = $this->posX;
      $y = $this->posY;
      if($y+1 < WORLD_SIZE && $gameStatus[$y+1][$x] == NULL ){
        $gameStatus[$y+1][$x] = new turtle($x,$y+1);
        $gameStatus[$y+1][$x]->setMove(true);
        }
      else if($y-1 >= 0 && $gameStatus[$y-1][$x] == NULL  ){
        $gameStatus[$y-1][$x] = new turtle($x,$y-1);
        $gameStatus[$y-1][$x]->setMove(true);
        }
      else if($x+1<WORLD_SIZE && $gameStatus[$y][$x+1] == NULL ){
        $gameStatus[$y][$x+1] = new turtle($x+1,$y);
        $gameStatus[$y][$x+1]->setMove(true);
        }
      else if($x-1>=0 && $gameStatus[$y][$x-1] == NULL){
        $gameStatus[$y][$x-1] = new turtle($x-1,$y);
        $gameStatus[$y][$x-1]->setMove(true);
      }
      $_SESSION['dailyLog'].=$this->getID()." Rozmnożył się.<br>";
    }
  }

    function randomMove(&$gameStatus){
      $op = rand(0,3);
      $x = $this->posX;
      $y = $this->posY;
      if($op == LEFT_DIR && $x-1>=0){
        if($gameStatus[$y][$x-1]!=NULL && $gameStatus[$y][$x-1]->getID()!=$this->getID())
          $gameStatus[$y][$x-1]->collision($y,$x,$gameStatus);
        else if($gameStatus[$y][$x-1]!=NULL && $gameStatus[$y][$x-1]->getID()==$this->getID())
          $this->multiplication($gameStatus);
        else if($gameStatus[$y][$x-1]==NULL)
          $this->posX--;
      }
      else if($op == RIGHT_DIR && $x+1<WORLD_SIZE){
        if($gameStatus[$y][$x+1]!=NULL && $gameStatus[$y][$x+1]->getID()!=$this->getID())
          $gameStatus[$y][$x+1]->collision($y,$x,$gameStatus);
        else if($gameStatus[$y][$x+1]==NULL)
          $this->posX++;
        else if($gameStatus[$y][$x+1]->getID() == $gameStatus[$y][$x]->getID())
          $this->multiplication($gameStatus);
      }
      else if($op == UP_DIR && $y-1>=0){
        if($gameStatus[$y-1][$x]!=NULL && $gameStatus[$y-1][$x]->getID()!=$this->getID())
          $gameStatus[$y-1][$x]->collision($y,$x,$gameStatus);
        else if($gameStatus[$y-1][$x]==NULL)
          $this->posY--;
        else if($gameStatus[$y-1][$x]->getID() == $gameStatus[$y][$x]->getID())
          $this->multiplication($gameStatus);
      }
      else if($op == DOWN_DIR && $y+1< WORLD_SIZE){
        if($gameStatus[$y+1][$x]!=NULL && $gameStatus[$y+1][$x]->getID()!=$this->getID())
          $gameStatus[$y+1][$x]->collision($y,$x,$gameStatus);
        else if($gameStatus[$y+1][$x]==NULL)
          $this->posY++;
        else if($gameStatus[$y+1][$x]->getID() == $gameStatus[$y][$x]->getID())
          $this->multiplication($gameStatus);
      }
    }

    function collision($yAttacker, $xAttacker, &$gameStatus){
      if(rand(0,4)<=1){
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
      else
        $_SESSION['dailyLog'].= $this->getID()." odparł atak ".$gameStatus[$yAttacker][$xAttacker]->getID()." (PWR = ".$gameStatus[$yAttacker][$xAttacker]->getPower(). ")<br>";
    }
  }
 ?>
