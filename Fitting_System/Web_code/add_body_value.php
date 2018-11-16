<?php
/*
Plugin Name: Add Body Value (Manual)
Description: Add user body value manually
Version: 1.0
Author: YouMinJung
License: SeeU
*/

	  // connect to DB
	  $servername = "localhost";
	  $username = "root";
	  $password = "";
	  $dbname = "seeyou";

	  // Create connection
	  $conn = new mysqli($servername, $username, $password, $dbname);
	  // Check connection
	  if ($conn->connect_error) {
	      die("Connection failed: " . $conn->connect_error);
	  } 

	// define variables and set to empty values
	$shoulder = $chest = $armlength = $waist = $hip = $thigh = $leg = $hight;
	$Err = "";
	$submitnum = 0;

  session_start();
  if(strcmp($_SESSION['current_login'], "")==0) {
      echo("<script> alert('Login Please.'); </script>"); 
      echo("<script>location.replace('login.php');</script>"); 
  }
  
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

	    if (empty($_POST["shoulder"]) || empty($_POST["chest"]) || empty($_POST["armlength"]) || empty($_POST["waist"]) || empty($_POST["hip"]) || empty($_POST["thigh"]) || empty($_POST["leg"]) || empty($_POST["hight"])) {
	      $Err = "* Insufficient information. Please check again.";
	    } 
	    else {
	          $shoulder = (int)$_POST["shoulder"];
	          $chest = (int)$_POST["chest"];
	          $armlength = (int)$_POST["armlength"];
	          $waist = (int)$_POST["waist"];
	          $hip = (int)$_POST["hip"];
	          $thigh = (int)$_POST["thigh"];
	          $leg = (int)$_POST["leg"];
	          $hight = (int)$_POST["hight"];
	          $submitnum++;
	    }
	}
?>
<title>Add Body Value - manual</title>
<meta charset="utf-8">

<style type="text/css">
	.button {
          position: relative;
          background-color: #00BFFF;
          border: none;
          font-size: 12px;
          color: #FFFFFF;
          padding: 10px;
          width: 100px;
          text-align: center;
          -webkit-transition-duration: 0.4s; /* Safari */
          transition-duration: 0.4s;
          text-decoration: none;
          overflow: hidden;
          cursor: pointer;
      }

      .button:after {
          content: "";
          background: #A9F5F2;
          display: block;
          position: absolute;
          padding-top: 300%;
          padding-left: 350%;
          margin-left: -20px!important;
          margin-top: -120%;
          opacity: 0;
          transition: all 0.8s
      }

      .button:active:after {
          padding: 0;
          margin: 0;
          opacity: 1;
          transition: 0s
      }

</style>

In order to offer fitting system, Please fill this forms.</p>
<p><span class="error" style="color: red">* All fields are required.</span></p>
<p><span class="error" style="color: red">* All units are 'cm' and decimal point isn't available.</span></p>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  

    Shoulder: <input type="text" name="shoulder" value="<?php echo $shoulder;?>">
    <br><br>
    
    Chest: <input type="text" name="chest" value="<?php echo $chest;?>">
    <br><br>
    
    Arm Length: <input type="text" name="armlength" value="<?php echo $armlength;?>">
    <br><br>

    Waist: <input type="text" name="waist" value="<?php echo $waist;?>">
    <br><br>
    
    Hip: <input type="text" name="hip" value="<?php echo $hip;?>">
    <br><br>

    Thigh: <input type="text" name="thigh" value="<?php echo $thigh;?>">
    <br><br>
    
    Leg Length: <input type="text" name="leg" value="<?php echo $leg;?>">
    <br><br>

    Hight: <input type="text" name="hight" value="<?php echo $hight;?>">
    <br><br>

    <span class="error" style="color: red"><?php echo $Err;?></span>

    <hr/>
    <input class="button" id="b1" type="submit" name="submit" value="Submit"> 
    <input class="button" id="b2" type="reset" value="Reset"/> 
</form>

<?php

	if($submitnum == 1) {

		  $result_exist = mysql_query("SHOW TABLES LIKE 'body_value'");
      $row_exist = mysql_fetch_array($result_exist); 

	      if($row_exist == false){ 
			  // sql to create table
			$sql = "CREATE TABLE body_value (
				id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
				user_id VARCHAR(50) NOT NULL,
				shoulder INT(6) NOT NULL,
				chest INT(6) NOT NULL,
				arm INT(6) NOT NULL,
				waist INT(6) NOT NULL,
				hip INT(6) NOT NULL,
				thigh INT(6) NOT NULL,
				leg INT(6) NOT NULL,
				hight INT(6) NOT NULL,
        date_info TIMESTAMP NOT NULL
			)";

		  	$conn->query($sql);
		  }

		  $sql = "SELECT user_id FROM current_login_user";
    	  $result = $conn->query($sql);
    	  
    	  if ($result->num_rows > 0) {
      
        	while($row = $result->fetch_assoc()) {
            	$result_id = $row["user_id"];

            	session_start();
        		  $_SESSION['current_login'] = $result_id;
        	}

          $current_date = date("Y-m-d");
        	$sql = "INSERT INTO body_value (user_id, shoulder, chest, arm, waist, hip, thigh, leg, hight, date_info)
				    VALUES ('$result_id', '$shoulder', '$chest', '$armlength', '$waist', '$hip', '$thigh', '$leg', '$hight', '$current_date')";

		  	  $conn->query($sql);

	      	echo("<script> alert('Complete to add your body value.'); </script>"); 
	      	echo("<script>location.replace('shopping_list.php');</script>"); 
        }  
          
	}
?>