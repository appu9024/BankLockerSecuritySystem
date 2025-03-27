<?php


  include "connection.php";



$id=$_REQUEST['id'];
$l1=$_REQUEST['l1'];
$l2=$_REQUEST['l2'];
$l3=$_REQUEST['l3'];
$l4=$_REQUEST['l4'];

          
            
        $sql="UPDATE `board` SET `l1`='$l1',`l2`='$l2',`l3`='$l3',`l4`='$l4' WHERE `id` = '$id'";


            
        if(mysqli_query($link, $sql))
          {

                  echo"<script> alert('Data Saved') </script>";
                  echo '<script>window.location.href = "user_dashboard.php";</script>';
           
          } else{
              echo "ERROR: Could not able to execute $sql. ";
          }
          

  
  
   mysqli_close($link);
?>