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

if (!$result) 
{
    die("Query failed: " . $mysqli->error);
}

$num_rows = mysqli_num_rows($result);

if ($num_rows > 0)
{


    while ($row = $result->fetch_assoc()) 
    {
        
        $time_rasp = $row["time"];
        $row_id = $row["id"];
    }


        if ( $time - $time_rasp > 60)
        {               
                $query1 = "DELETE FROM `tansact` WHERE id = '$row_id'";
                $result1 = $link->query($query1);
                echo "%timeout#";

        }else
        {

            $query2 = "UPDATE `tansact` SET `state`='2' WHERE `id` = '$row_id'";
            $result2 = $link->query($query2);


                $query3 = "SELECT * FROM `user` WHERE `finger_id` = '$id'";
                $result3 = $link->query($query3);

                if (!$result3) 
                {
                    die("Query failed: " . $mysqli->error);
                }else
                {

                    while ($row = $result3->fetch_assoc()) 
                    {
                        
                        $name = $row["name"];
                        $number = $row["number"];
                        $email = $row["email"];
                        $fin_id = $id;

                    }
                }



                $query4 = "INSERT INTO `in_logs`(`name`, `number`, `email`, `time`, `fin_id`) VALUES ('$name','$number','$email','$time','$fin_id')";
                $result4 = $link->query($query4);
                 echo "%inserted#";


        }
        
    






} else 
        {
            echo "%Scan face first !!#";
            
        }
}else
{

 echo "%NO user with This ID";

}
mysqli_close($link);

?>