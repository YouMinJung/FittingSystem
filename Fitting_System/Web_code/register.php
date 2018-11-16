<?php 
/*
Plugin Name: Register
Description: Regiser form
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
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// if 'seeyou' DB didn't exist, create DB
$sql = "CREATE DATABASE IF NOT EXISTS seeyou";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . $conn->error;
}

$conn->close();

// define variables and set to empty values
$nameErr = $emailErr = $genderErr = $idErr = $passErr = "";
$name = $email = $gender = $id = $pass1 = $pass2 = $phone = "";
$submitnum = 0;
$result = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // user name
    if (empty($_POST["name"])) {
      $nameErr = "Name is required";
    } 
    else {
      // check if name only contains letters and whitespace
      if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
          $nameErr = "Only letters and white space allowed"; 
      }
      else {
          $name = $_POST["name"];
          $submitnum++;
      }
    }
  
    // user id
    if (empty($_POST["userid"])) {
      $idErr = "ID is required";
    } 
    else if(strcmp($result, "") !== 0) {
  		$idErr = "This ID already exists.";
  	}
    else {
      $id = $_POST["userid"];
      $submitnum++;
    }

    // user password
    if (empty($_POST["pass1"]) || empty($_POST["pass2"])) {
      $passErr = "Password is required";
    } 
    else if(strcmp($_POST["pass1"], $_POST["pass2"]) !== 0) {
  		$passErr = "Password and Check pass are not same.";
  	}
    else {
      $pass1 = $_POST["pass1"];
      $pass2 = $_POST["pass2"];
      $submitnum++;
    }

    // user email address
    if (empty($_POST["email"])) {
      $emailErr = "Email is required";
    } 
    else {
      // check if e-mail address is well-formed
      if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) == false) {
          $emailErr = "Invalid email format"; 
      }
      else {
          $email = $_POST["email"];
          $submitnum++;
      }
    }
    
    // user gender info
    if (empty($_POST["gender"])) {
      $genderErr = "Gender is required";
    } 
    else {
      $gender = $_POST["gender"];
      $submitnum++;
    }

    // user phone number
    $phone = $_POST["phone"];
}

?>
<title>Register</title>
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
          transition: all 0.8s;
      }

      .button:active:after {
          padding: 0;
          margin: 0;
          opacity: 1;
          transition: 0s;
      }

      .error {
        color: red;
      }

</style>
 
<p>Welcome to ShowYou!!</br>
Feel free to join our member. Please fill this forms.</p>
<p><span class="error">* : required field.</span></p>
</br>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
    Name: <input type="text" name="name" value="<?php echo $name;?>">
    <span class="error">* <?php echo $nameErr;?></span>
    <br><br>
    
    ID: <input type="text" name="userid" value="<?php echo $id;?>">
    <span class="error">* <?php echo $idErr;?></span>
    <br><br>

    Password : <input type="password" name="pass1" value="<?php echo $pass1;?>">
    <br/></br>

    Check Pass : <input type="password" name="pass2" value="<?php echo $pass2;?>">
    <span class="error"> * <?php echo $passErr;?></span>
    <br/></br>  

    Gender:
    <input type="radio" name="gender" <?php if (isset($gender) && $gender=="female") echo "checked";?> value="female">Female
    <input type="radio" name="gender" <?php if (isset($gender) && $gender=="male") echo "checked";?> value="male">Male
    <span class="error">* <?php echo $genderErr;?></span>
    <br><br>
  
    E-mail: <input type="text" name="email" placeholder="***@***.***" value="<?php echo $email;?>">
    <span class="error">* <?php echo $emailErr;?></span>
    <br><br>
  
    Phone Number : <input type="tel" name="phone" placeholder="010 - **** - ****" pattern="010-[0-9]{3,4}-[0-9]{4}" value="<?php echo $phone;?>">
    <br/></br>

    <hr/>
    <input class="button" id="b1" type="submit" name="submit" value="Submit"> 
    <input class="button" id="b2" type="reset" value="Reset"/> 
</form>

<?php

	if($submitnum == 5) {
    // connect to DB, table seeyou
    $conn = new mysqli($servername, $username, $password, $dbname);

		// sql to create table
    $result_exist = mysql_query("SHOW TABLES LIKE 'user_info'");
    $row_exist = mysql_fetch_array($result_exist); 

    if($row_exist == false){     
      $sql = "CREATE TABLE user_info (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        user_id VARCHAR(50) NOT NULL,
        password VARCHAR(50) NOT NULL,
        user_name VARCHAR(50) NOT NULL,
        gender VARCHAR(50) NOT NULL,
        email VARCHAR(50) NOT NULL,
        phone VARCHAR(50),
        register_date TIMESTAMP NOT NULL,
        last_visit_date TIMESTAMP NOT NULL
      )";
    } 
    $conn->query($sql);

    $sql = "SELECT user_id FROM user_info where user_id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo("<script> alert('This ID already exist. try different ID.'); </script>");
        echo("<script>location.replace('register.php');</script>"); 
    }
    else {
        $current_date = date("Y-m-d");

        // insert data
        $sql = "INSERT INTO user_info (user_id, password, user_name, gender, email, phone, register_date, last_visit_date)
          VALUES ('$id', PASSWORD('$pass1'), '$name', '$gender', '$email', '$phone', '$current_date', '$current_date')";

        if ($conn->query($sql) === TRUE) {
            echo("<script> alert('Register Complete. Thank you.'); </script>"); 
            echo("<script>location.replace('login.php');</script>"); 
        } 
    }
	}

?>
