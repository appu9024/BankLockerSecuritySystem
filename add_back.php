<?php


  include "connection.php";



$id=$_REQUEST['id'];
$name=$_REQUEST['name'];
$number=$_REQUEST['number'];
$email=$_REQUEST['email'];
$pass=$_REQUEST['pass'];
          
            
        $sql="INSERT INTO `user` (`finger_id`, `name`, `number`, `email`, `pass`) VALUES('$id','$name','$number','$email','$pass')";
            
        if(mysqli_query($link, $sql))
          {

                  echo"<script> alert('Data added') </script>";
                  echo '<script>window.location.href = "admin_dashboard.php";</script>';
           
          } else{
              echo "ERROR: Could not able to execute $sql. ";
          }
          

  
  
   mysqli_close($link);
?>