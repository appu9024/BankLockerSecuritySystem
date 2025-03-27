<?php

  include "connection.php";



  $sql = "truncate sensordata";

  if(mysqli_query($link, $sql))
  {
      echo '<script>window.location.href = "table1.php";</script>';
   
} else{
    echo "ERROR: Could not able to execute $sql. ";
}
   
   mysqli_close($link);
?>