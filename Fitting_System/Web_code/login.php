<?php 
/*
Plugin Name: Login
Description: login form
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

session_start();

// define variables and set to empty values
$Err = "";
$id = $pass = "";
$submit = 0;
$result1 = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  	
  	if (empty($_POST["userid"]) || empty($_POST["pass"])) {
    	$Err = "* Empty value...";
  	} 
  	else {
    	$id = $_POST["userid"];
    	$pass = $_POST["pass"];
    	$submit++;
  	}
}

?>
<title>Login</title>
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

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
				
        ID: <input type="text" name="userid" value="<?php echo $id;?>"></br>
		        	
				Password : <input type="password" name="pass" value="<?php echo $pass;?>"> 
        <span class="error" style="color: red"> <?php echo $Err;?></span></br>
		<hr/>
      	<input class="button" id="b1" type="submit" name ="login" value="Login"/>
        <p> Aren't you SeeU member yet? <input class="button" id="b1" type="button" value="Register NOW" onclick="func()"/> </p>
</form> 

<script type="text/javascript">
  function func() {
    location.replace('register.php');
  }
</script>

<?php 

  $result_name = $result_id ="";

	if($submit == 1) {
		$sql = "SELECT user_id, password, user_name FROM user_info where user_id='$id' and password=PASSWORD('$pass')";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      
        while($row = $result->fetch_assoc()) {
            $result_id = $row["user_id"];
            $result_name = $row["user_name"];
        }

        // sessin
        session_start();
        $_SESSION['current_login'] = $result_id;

        echo("<script> alert('Welcome! < ".$result_name." >'); </script>"); 

        $result_exist = mysql_query("SHOW TABLES LIKE 'current_login_user'");
        $row_exist = mysql_fetch_array($result_exist); 

        if($row_exist == false){     
            $sql = "CREATE TABLE current_login_user (
              id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
              user_id VARCHAR(50) NOT NULL,
              user_name VARCHAR(50) NOT NULL
            )";
            $conn->query($sql);
        }

        $sql = "INSERT INTO current_login_user (user_id, user_name) VALUES ('$result_id', '$result_name')";
        $conn->query($sql);

        $current_date = date("Y-m-d");
        $sql = "UPDATE user_info set last_visit_date='$current_date' where user_id='$result_id'";
        $conn->query($sql);

        echo("<script>location.replace('add_body_value.php');</script>"); 
    } 
    else {
        echo("<script> alert('Login Fail... Input again'); </script>");
        echo("<script>location.replace('login.php');</script>"); 
    }
  }
?>

