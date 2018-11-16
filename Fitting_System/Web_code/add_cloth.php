<?php

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
                    // sql to create table
                    $sql = "CREATE TABLE cloth_info1 (
                      id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                      name VARCHAR(10) NOT NULL,
                      size VARCHAR(10) NOT NULL,
                      waist INT(6),
                      hip INT(6), 
                      thigh INT(6), 
                      leg INT(6), 
                      under_length INT(6), 
                      upper_length INT(6),
                      skirt_under INT(6)  
                    )";
                    $conn->query($sql);

                    // add cloth info1 - bottom
                    $sql = "INSERT INTO cloth_info1 (name, size, waist, hip, thigh, leg, upper_length, under_length)
                      VALUES ('Mpan0', '28inch', '92', '92', '52', '102', '24', '16')";
                    $conn->query($sql);

                    $sql = "INSERT INTO cloth_info1 (name, size, waist, hip, thigh, leg, upper_length, under_length)
                      VALUES ('Mpan0', '30inch', '96', '96', '54', '103', '25', '17')";
                    $conn->query($sql);

                    $sql = "INSERT INTO cloth_info1 (name, size, waist, hip, thigh, leg, upper_length, under_length)
                      VALUES ('Mpan0', '32inch', '100', '100', '56', '104', '26', '18')";
                    $conn->query($sql);

                    $sql = "INSERT INTO cloth_info1 (name, size, waist, hip, thigh, leg, upper_length, under_length)
                      VALUES ('Mpan0', '34inch', '104', '104', '58', '104', '27', '19')";
                    $conn->query($sql);

                    $sql = "INSERT INTO cloth_info1 (name, size, waist, hip, thigh, leg, upper_length, under_length)
                      VALUES ('Mpan0', '36inch', '108', '108', '60', '104', '28', '20')";
                    $conn->query($sql);


                    $sql = "INSERT INTO cloth_info1 (name, size, waist, hip, thigh, leg, upper_length, under_length)
                      VALUES ('Mpan1', '28inch', '74', '92', '47', '70', '24', '17')";
                    $conn->query($sql);

                    $sql = "INSERT INTO cloth_info1 (name, size, waist, hip, thigh, leg, upper_length, under_length)
                      VALUES ('Mpan1', '30inch', '78', '94', '48', '72', '26', '18')";
                    $conn->query($sql);

                    $sql = "INSERT INTO cloth_info1 (name, size, waist, hip, thigh, leg, upper_length, under_length)
                      VALUES ('Mpan1', '32inch', '82', '96', '49', '74', '28', '19')";
                    $conn->query($sql);

                    $sql = "INSERT INTO cloth_info1 (name, size, waist, hip, thigh, leg, upper_length, under_length)
                      VALUES ('Mpan1', '34inch', '86', '98', '50', '76', '30', '20')";
                    $conn->query($sql);

                    $sql = "INSERT INTO cloth_info1 (name, size, waist, hip, thigh, leg, upper_length, under_length)
                      VALUES ('Wpan0', '25inch', '70', '76', '45', '93', '18', '21')";
                    $conn->query($sql);

                    $sql = "INSERT INTO cloth_info1 (name, size, waist, hip, thigh, leg, upper_length, under_length)
                      VALUES ('Wpan0', '26inch', '73', '78', '47', '94', '19', '22')";
                    $conn->query($sql);

                    $sql = "INSERT INTO cloth_info1 (name, size, waist, hip, thigh, leg, upper_length, under_length)
                      VALUES ('Wpan0', '27inch', '75', '82', '48', '95', '19', '23')";
                    $conn->query($sql);

                    $sql = "INSERT INTO cloth_info1 (name, size, waist, hip, thigh, leg, upper_length, under_length)
                      VALUES ('Wpan0', '28inch', '77', '84', '49', '95', '20', '24')";
                    $conn->query($sql);

                    $sql = "INSERT INTO cloth_info1 (name, size, waist, hip, thigh, leg, upper_length, under_length)
                      VALUES ('Wpan0', '29inch', '80', '86', '51', '96', '20', '25')";
                    $conn->query($sql);

                    $sql = "INSERT INTO cloth_info1 (name, size, waist, hip, thigh, leg, upper_length, under_length)
                      VALUES ('Wpan0', '30inch', '82', '90', '53', '97', '21', '26')";
                    $conn->query($sql);

                    $sql = "INSERT INTO cloth_info1 (name, size, waist, hip, thigh, leg, upper_length, under_length)
                      VALUES ('Wpan0', '32inch', '85', '95', '55', '97', '22', '28')";
                    $conn->query($sql);

                    $sql = "INSERT INTO cloth_info1 (name, size, waist, hip, thigh, leg, upper_length, under_length)
                      VALUES ('Wpan0', '34inch', '87', '99', '57', '98', '23', '30')";
                    $conn->query($sql);

                    $sql = "INSERT INTO cloth_info1 (name, size, waist, hip, leg, skirt_under)
                      VALUES ('sk0', 'S', '69', '88', '59', '45')";
                    $conn->query($sql);

                    $sql = "INSERT INTO cloth_info1 (name, size, waist, hip, leg, skirt_under)
                      VALUES ('sk0', 'M', '73', '92', '59', '47')";
                    $conn->query($sql);

                    $sql = "INSERT INTO cloth_info1 (name, size, waist, hip, leg, skirt_under)
                      VALUES ('sk0', 'L', '77', '96', '59', '49')";
                    $conn->query($sql);

                    $sql = "INSERT INTO cloth_info1 (name, size, waist, hip, leg, skirt_under)
                      VALUES ('sk1', 'S', '69', '85', '63', '41')";
                    $conn->query($sql);

                    $sql = "INSERT INTO cloth_info1 (name, size, waist, hip, leg, skirt_under)
                      VALUES ('sk1', 'M', '73', '89', '63', '43')";
                    $conn->query($sql);


                    // sql to create table
                    $sql = "CREATE TABLE cloth_info2 (
                      id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                      name VARCHAR(10) NOT NULL,
                      size VARCHAR(10) NOT NULL,
                      shoulder INT(6),
                      chest INT(6),
                      arm INT(6),
                      length INT(6)  
                    )";
                    $conn->query($sql);


                    // cloth_info2 - top
                    $sql = "INSERT INTO cloth_info2 (name, size, chest, arm, length)
                      VALUES ('Mtsh0', 'M', '98', '73', '68')";
                    $conn->query($sql);

                    $sql = "INSERT INTO cloth_info2 (name, size, chest, arm, length)
                      VALUES ('Mtsh0', 'L', '106', '76', '70')";
                    $conn->query($sql);

                    $sql = "INSERT INTO cloth_info2 (name, size, chest, arm, length)
                      VALUES ('Mtsh0', 'XL', '114', '79', '72')";
                    $conn->query($sql);

                    $sql = "INSERT INTO cloth_info2 (name, size, chest, arm, length)
                      VALUES ('Mtsh0', 'XXL', '122', '82', '74')";
                    $conn->query($sql);


                    $sql = "INSERT INTO cloth_info2 (name, size, shoulder, chest, arm, length)
                      VALUES ('Wsh0', 'F', '36', '95', '59', '75')";
                    $conn->query($sql);

                    $sql = "INSERT INTO cloth_info2 (name, size, shoulder, chest, arm, length)
                      VALUES ('Wsh0', 'L', '38', '100', '60', '76')";
                    $conn->query($sql);

                    $sql = "INSERT INTO cloth_info2 (name, size, shoulder, chest, arm, length)
                      VALUES ('Wsh0', 'XL', '40', '110', '61', '77')";
                    $conn->query($sql);

                    $sql = "INSERT INTO cloth_info2 (name, size, shoulder, chest, arm, length)
                      VALUES ('Wsh0', 'XXL', '42', '120', '61', '78')";
                    $conn->query($sql);
?>