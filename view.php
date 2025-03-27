<?php session_start(); ?>
<?php 
include 'connection.php'; 
if ((isset($_SESSION['username'])) )
    {

    }
    else{
        echo"<script>window.location.href='../index.php';</script>";
        
    }

            $id =  $_REQUEST["id"];


            $select_path="SELECT * FROM `board` WHERE id = '$id'";

            $var=mysqli_query($link,$select_path);

            
            while($row=mysqli_fetch_array($var))
            {

                 $l1=$row['l1'];
                 $l2=$row['l2'];
                 $l3=$row['l3'];
                 $l4=$row['l4'];

            }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LCD Display Page</title>
    <style>
        body {
            background-color: #f0f0f0; /* Light background color */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .lcd-container {
            position: relative;
            width: 400px; /* Adjust the width and height to match your LCD image dimensions */
            height: 160px;
            text-align: left;
            font-family: monospace;

            
        }

        .lcd-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .lcd-text {
            position: absolute;
            width: 100%;
            top: 20%;
            left: 9%;
            line-height: 0;
            font-weight: bold; /* Make the text bold */
            font-size: 20px; /* Set the font size to make it larger */
        }

        .lcd-text:nth-child(2) {
            top: 32%;
            left: 9%;
        }

        .lcd-text:nth-child(3) {
            top: 42%;
            left: 9%;
        }

        .lcd-text:nth-child(4) {
            top: 52%;
            left: 9%;
        }


        .home-button {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .home-button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

    </style>
</head>
<body>
    <a href="user_dashboard.php" class="home-button">Home</a>
    <div class="lcd-container">
        <img src="lcd.png" alt="LCD Image" class="lcd-image">
        <p class="lcd-text"><?php echo $l1; ?></p>
        <p class="lcd-text"><?php echo $l2; ?></p>
        <p class="lcd-text"><?php echo $l3; ?></p>
        <p class="lcd-text"><?php echo $l4; ?></p>
    </div>
</body>
</html>
