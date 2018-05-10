<?php

  include 'gameController.class.php';
  define("WORLD_SIZE", 15);
  session_start();
  if(isset($_SESSION['game']))
    $game = $_SESSION['game'];
  else
    $game = new gameController();
  if(isset($_SESSION['dailyLog']))
    $dailyLog = $_SESSION['dailyLog'];
  else
    $_SESSION['dailyLog'] = "<h2>DZISIAJ WYDARZYLO SIE:</h2><br>";
  if( isset($_REQUEST['up']) || isset($_REQUEST['left']) ||
      isset($_REQUEST['right']) || isset($_REQUEST['down']))
        $game->move();
  else if(isset($_REQUEST['reset'])){
    session_destroy();
  }
  showController();
  $game -> showStage();
  $_SESSION['game'] = $game;

  function showController(){
    echo '<div class="col-md-3 controllers">';

    echo '<div class="ctrlButtons">';
    echo '<div class="row">';
    echo '<div class="col-md-4">';
    echo "</div>";
    echo '<div class="col-md-4">';
    echo '<a href="index.php?up"><img src="images/u_btn.png" alt="player" width=30 height=30 ></a>';
    echo "</div>";
    echo '<div class="col-md-4">';
    echo "</div>";
    echo "</div>";

    echo '<div class="row">';
    echo '<div class="col-md-4">';
    echo '<a href="index.php?left"><img src="images/l_btn.png" alt="player" width=30 height=30 ></a> ';
    echo "</div>";
    echo '<div class="col-md-4">';
    echo "</div>";
    echo '<div class="col-md-4">';
    echo '<a href="index.php?right"><img src="images/r_btn.png" alt="player" width=30 height=30 ></a> ';
    echo "</div>";
    echo "</div>";

    echo '<div class="row">';
    echo '<div class="col-md-4">';
    echo "</div>";
    echo '<div class="col-md-4">';
    echo '<a href="index.php?down"><img src="images/d_btn.png" alt="player" width=30 height=30 ></a> ';
    echo "</div>";
    echo '<div class="col-md-4">';
    echo "</div>";
    echo "</div>";

    echo '<div class="row">';
    echo '<div class="col-md-4">';
    echo '<a href="index.php?reset"><img src="images/reset_btn.png" alt="player" width=30 height=30 ></a> ';
    echo "</div>";
    echo '<div class="col-md-4">';
    echo "</div>";
    echo '<div class="col-md-4">';
    echo '<a href="index.php"><img src="images/play_btn.png" alt="player" width=30 height=30 ></a> ';
    echo "</div>";
    echo "</div>";
    echo "</div>";

    echo "</div>";
  }
?>
