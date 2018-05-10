

<?php
include 'player.class.php';
include 'wolf.class.php';
include 'turtle.class.php';
include 'berry.class.php';
include 'poison.class.php';
define("GRASS", 0);
define("PLAYER", 1);
define("WOLF_NO", 9);
define("TURTLE_NO", 8);
define("BERRY_NO", 8);
define("POISON_NO", 5);

class gameController
{
  private $stageSize = WORLD_SIZE;
  private $gameStatus = array();
  function __construct()
  {
    $this->initStage();
  }

  function showStage(){
    echo '<div class="col-md-6 stage">';
    echo "<table>";
    for($i=0;$i<$this->stageSize;$i++){
      echo "<tr>";
      for($j=0;$j<$this->stageSize;$j++){
        if($this->gameStatus[$i][$j]==NULL)
          echo '<td><img src="images/grass.png" alt="grass"></td>';
        else
          $this->gameStatus[$i][$j]->showAvatar();
      }
      echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
  }

  function initStage(){
    for($i=0;$i<$this->stageSize;$i++)
      for($j=0;$j<$this->stageSize;$j++)
        $this->gameStatus[$i][$j] =NULL;
    $randX=rand(0, WORLD_SIZE-1);
    $randY=rand(0, WORLD_SIZE-1);
    $this->gameStatus[$randY][$randX] =new player($randX,$randY);
    for($i=0; $i<WOLF_NO; $i++){
      do {
        $randX=rand(0, WORLD_SIZE-1);
        $randY=rand(0, WORLD_SIZE-1);
      } while ($this->gameStatus[$randY][$randX]!=NULL);
      $this->gameStatus[$randY][$randX] =new wolf($randX,$randY);;
    }
    for($i=0; $i<TURTLE_NO; $i++){
      do {
        $randX=rand(0, WORLD_SIZE-1);
        $randY=rand(0, WORLD_SIZE-1);
      } while ($this->gameStatus[$randY][$randX]!=NULL);
      $this->gameStatus[$randY][$randX] =new turtle($randX,$randY);;
    }
    for($i=0; $i<BERRY_NO; $i++){
      do {
        $randX=rand(0, WORLD_SIZE-1);
        $randY=rand(0, WORLD_SIZE-1);
      } while ($this->gameStatus[$randY][$randX]!=NULL);
      $this->gameStatus[$randY][$randX] =new berry($randX,$randY);
    }
    for($i=0; $i<POISON_NO; $i++){
      do {
        $randX=rand(0, WORLD_SIZE-1);
        $randY=rand(0, WORLD_SIZE-1);
      } while ($this->gameStatus[$randY][$randX]!=NULL);
      $this->gameStatus[$randY][$randX] =new poison($randX,$randY);;
    }
  }

  function move(){
    if($this->continueGame()){
      for($i=0;$i<$this->stageSize;$i++)
        for($j=0;$j<$this->stageSize;$j++){
          if($this->gameStatus[$i][$j] !=NULL && $this->gameStatus[$i][$j]->isMoved() ==false ){
            $this->gameStatus[$i][$j]->setMove(true);
            $this->gameStatus[$i][$j]->action($this->gameStatus);
            if($this->gameStatus[$i][$j]!=NULL){
              $newX= $this->gameStatus[$i][$j]->getX();
              $newY= $this->gameStatus[$i][$j]->getY();
              if( $this->gameStatus[$i][$j] !=$this->gameStatus[$newY][$newX] ){
                   $this->gameStatus[$newY][$newX] = $this->gameStatus[$i][$j];
                   $this->gameStatus[$i][$j]=NULL;
               }
            }
          }
        }
        for($i=0;$i<$this->stageSize;$i++)
          for($j=0;$j<$this->stageSize;$j++)
            if($this->gameStatus[$i][$j] !=NULL)
              $this->gameStatus[$i][$j]->setMove(false);
    }
  }

  function continueGame(){
    $playerIsAlive = false;
    $wolfsAreAlive = false;
    for($i=0;$i<$this->stageSize;$i++){
      for($j=0;$j<$this->stageSize;$j++){
        if($this->gameStatus[$i][$j]!=NULL){
          if($this->gameStatus[$i][$j]->getID()=='GRACZ')
            $playerIsAlive = true;
          else if($this->gameStatus[$i][$j]->getID()=='WILK')
            $wolfsAreAlive = true;
        }
      }
    }
    if($playerIsAlive && $wolfsAreAlive) return true;
    $_SESSION['dailyLog'] ="<h1>GAME OVER</h1>";
  }
}
?>
