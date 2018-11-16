<?php 
/*
Plugin Name: Logout
Description: logout form
Version: 1.0
Author: YouMinJung
License: SeeU
*/

// connect to DB
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "seeyou";

session_start();
if(empty($_SESSION['current_login'])) {
      echo("<script> alert('Login Please.'); </script>"); 
      echo("<script>location.replace('login.php');</script>"); 
}
$result_id = $_SESSION['current_login'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT user_id FROM current_login_user";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
      
    while($row = $result->fetch_assoc()) {
        $result_id = $row["user_id"];
    }

    // session clear
    session_start();
    unset($_SESSION['current_login']);

    $sql = "DELETE FROM current_login_user WHERE user_id = '$result_id'";
    $conn->query($sql);

    echo("<script> alert('Logout Complete. See you next time.'); </script>");
    echo("<script>location.replace('login.php');</script>"); 
}

?>
<title>Logout</title>
<meta charset="utf-8">