<?php


include "connection.php";
  
$id = $_REQUEST['id'];
$time = time();


$query7 = "SELECT * FROM `user` WHERE `finger_id` = '$id'";
$result7 = $link->query($query7);

if (!$result7) 
{
    die("Query failed: " . $mysqli->error);
}

$num_rows = mysqli_num_rows($result7);

if ($num_rows > 0)
{


        $query = "SELECT * FROM `tansact` WHERE `sent_id` = '$id' AND `state` = '1'";
        $result = $link->query($query);

        if (!$result) {
            die("Query failed: " . $mysqli->error);
        }

        $num_rows = mysqli_num_rows($result);

        if ($num_rows > 0) 
        {
            $query = "UPDATE `tansact` SET `time`='$time' WHERE `sent_id` = '$id' AND `state` = '1'";
            $result = $link->query($query);
            echo "updated";

        } else 
        {
            $query = "INSERT INTO `tansact`(`time`, `sent_id`, `state`) VALUES('$time','$id','1')";
            $result = $link->query($query);
            echo "inserted";
            
        }

}else
{

 echo "%NO user with This ID";

}

mysqli_close($link);

?>