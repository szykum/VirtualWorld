<?php
  echo '<div class="col-md-3 dailyLog">';
  if(isset($_SESSION['dailyLog'])){
    $dailyLog = $_SESSION['dailyLog'];
    echo $dailyLog;
  }
  $_SESSION['dailyLog'] = "<h2>DZISIAJ WYDARZYLO SIE:</h2><br>";
  echo "</div>";
 ?>
