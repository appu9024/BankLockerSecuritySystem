<?php 
session_start();
if ((isset($_SESSION['username'])) )
	{

	}
	else{
		echo"<script>window.location.href='index.php';</script>";
		
	}
	
?>

<script>
    window.setInterval('refresh()', 10000); 	
    // Call a function every 10000 milliseconds 
    // (OR 10 seconds).

    // Refresh or reload page.
    function refresh() {
        window .location.reload();
    }
</script>


<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">

  <style>
  table {
  border-spacing: 1;
  border-collapse: collapse;
  background: white;
  border-radius: 6px;
  overflow: hidden;
  max-width: 800px;
  width: 100%;
  margin: 0 auto;
  position: relative;
}
table * {
  position: relative;
}
table td, table th {
  padding-left: 8px;
}
table thead tr {
  height: 60px;
  background: #FFED86;
  font-size: 16px;
}
table tbody tr {
  height: 48px;
  border-bottom: 1px solid #E3F1D5;
}
table tbody tr:last-child {
  border: 0;
}
table td, table th {
  text-align: left;
}
table td.l, table th.l {
  text-align: right;
}
table td.c, table th.c {
  text-align: center;
}
table td.r, table th.r {
  text-align: center;
}

@media screen and (max-width: 35.5em) {
  table {
    display: block;
  }
  table > *, table tr, table td, table th {
    display: block;
  }
  table thead {
    display: none;
  }
  table tbody tr {
    height: auto;
    padding: 8px 0;
  }
  table tbody tr td {
    padding-left: 45%;
    margin-bottom: 12px;
  }
  table tbody tr td:last-child {
    margin-bottom: 0;
  }
  table tbody tr td:before {
    position: absolute;
    font-weight: 700;
    width: 40%;
    left: 10px;
    top: 0;
  }
  table tbody tr td:nth-child(1):before {
    content: "Code";
  }
  table tbody tr td:nth-child(2):before {
    content: "Stock";
  }
  table tbody tr td:nth-child(3):before {
    content: "Cap";
  }
  table tbody tr td:nth-child(4):before {
    content: "Inch";
  }
  table tbody tr td:nth-child(5):before {
    content: "Box Type";
  }
}
body {
  background: #9BC86A;
  font: 400 14px 'Calibri','Arial';
  padding: 20px;
   background-image: url("4.jpeg");
}

blockquote {
  color: white;
  text-align: center;
}

.logoutLblPos
{
   
  width: 250px;
  padding: 10px 25px 10px 25px;
  font-family: Arial;
  font-size: 16px;
  text-decoration: none;
  color: #ffffff;
  text-shadow: -1px -1px 2px #618926;
  background: -moz-linear-gradient(#98ba40, #a6c250 35%, #618926);
  background: -webkit-gradient(linear,left top,left bottom,color-stop(0, #98ba40),color-stop(.35, #a6c250),color-stop(1, #618926));
  border: 1px solid #618926;
  border-radius: 3px;
  -moz-border-radius: 3px;
  -webkit-border-radius: 3px;
}

.button {
  border-radius: 4px;
  background-color: #f4511e;
  border: none;
  color: #FFFFFF;
  text-align: center;
  font-size: 28px;
  padding: 20px;
  width: 200px;
  transition: all 0.5s;
  cursor: pointer;
  margin: 5px;
}

.button span {
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.5s;
}

.button span:after {
  content: '\00bb';
  position: absolute;
  opacity: 0;
  top: 0;
  right: -20px;
  transition: 0.5s;
}

.button:hover span {
  padding-right: 25px;
}

.button:hover span:after {
  opacity: 1;
  right: 0;


</style>



<div style="float:right">
<form align="right" name="form1" method="post" action="logout.php">
  <label class="logoutLblPos">
  <input name="submit2" type="submit" id="submit2" value="log out">
  </label>
</form>
</div>


<div style="float:Left" >
<form align="Left"  method="post" action="clear.php">
	<input type="hidden" name="table" value="1"><br>
	<button type="submit" class="button" ><span>Clear</span> </button><br>
 </form>



</div>



<body>

    
    
<table>
                  <thead>
                    <tr>
                      <th>Heart Rate</th>
                      <th>SpO2</th>
                      <th>Humidity(%)</th>     
                      <th>Temprature(D.C.)</th> 
                      <th>Time</th>

                    </tr>
                  <thead>
            	  
            <tbody>  
            
            <?php
            include "connection.php";
            
            $select_path="SELECT * FROM `sensordata` WHERE 1";
            
            $var=mysqli_query($link,$select_path);
            
            while($row=mysqli_fetch_array($var))
            {
             $m=$row['data1'];
             $t=$row['data2'];
             $h=$row['data3'];
             $x=$row['data4'];
             $time=$row["time"];
   
            
            ?>
                <tr>
                <td><p><?php echo $m; ?></p></td>
                <td><p><?php echo $t; ?></p></td>
                <td><p><?php echo $h; ?></p></td>
                <td><p><?php echo $x; ?></p></td>
                <td><p><?php echo $time; ?></p></td>
                </tr>
                <?php
              
            }
            
            ?>
            	  
            </tbody>
            
            <table/><br>
  
    
</body>
</html>
