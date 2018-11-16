<?php
/*
Plugin Name: Fitting Result
Description: Show Fitting Result to User
Version: 1.0
Author: YouMinJung
License: SeeU
*/

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


  $historicalData = [];
  $shoulder = $chest = $arm = $waist = $hip = $thigh = $leg = $hight;
  $name = $size = $Cwaist = $Chip = $Cthigh = $Cleg = $Cunder = $Cupper = $Cskirt = [];
  $Cshoulder = $Cchest = $Carm = $Clength = [];


  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  } 

  session_start();
  $result_id = $_SESSION['current_login'];

  // get user body value 
  $sql = "SELECT shoulder, chest, arm, waist, hip, thigh, leg, hight FROM body_value where user_id='$result_id' order by date_info DESC limit 1";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $shoulder = $row['shoulder'];
        $chest = $row['chest'];
        $arm = $row['arm'];
        $waist = $row['waist'];
        $hip = $row['hip'];
        $thigh = $row['thigh'];
        $leg = $row['leg'];
        $hight = $row['hight'];
      }
  }
          
  // get cloth information
  $cloth_name = $_COOKIE['cloth'];
  $cloth_type = $_COOKIE['type'];

  if(strcmp($cloth_type, "bottom") == 0) {
      $sql = "SELECT size, waist, hip, thigh, leg, under_length, upper_length, skirt_under FROM cloth_info1 where name='$cloth_name'";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()) {
              array_push($size, $row['size']);
              array_push($Cwaist, $row['waist']);
              array_push($Chip, $row['hip']);
              array_push($Cthigh, $row['thigh']);
              array_push($Cleg, $row['leg']);
              array_push($Cunder, $row['under_length']);
              array_push($Cupper, $row['upper_length']);
              array_push($Cskirt, $row['skirt_under']);
          }

          $historicalData['size'] = $size;
          $historicalData['Cwaist'] = $Cwaist;
          $historicalData['Chip'] = $Chip;
          $historicalData['Cthigh'] = $Cthigh;
          $historicalData['Cleg'] = $Cleg;
          $historicalData['Cunder'] = $Cunder;
          $historicalData['Cupper'] = $Cupper;
          $historicalData['Cskirt'] = $Cskirt;
      } 
  }
  else if(strcmp($cloth_type, "top") == 0) {
      $sql = "SELECT size, shoulder, chest, arm, length FROM cloth_info2 where name='$cloth_name'";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()) {
              array_push($size, $row['size']);
              array_push($Cshoulder, $row['shoulder']);
              array_push($Cchest, $row['chest']);
              array_push($Carm, $row['arm']);
              array_push($Clength, $row['length']);
          }

          $historicalData['size'] = $size;
          $historicalData['Cshoulder'] = $Cshoulder;
          $historicalData['Cchest'] = $Cchest;
          $historicalData['Carm'] = $Carm;
          $historicalData['Clength'] = $Clength;
      } 
  }

  $historicalData = json_encode($historicalData);

?>


<title>Result Avatar</title>
<meta charset="utf-8">

<body>
<svg width="1500" height="900" viewBox="0 0 1500 900" preserveAspectRatio="xMinYMin meet">

  // avatar1
  <circle cx="300" cy="100" r="40" stroke="black" stroke-width="1" fill="black" />
    Sorry, your browser does not support inline SVG.

  // neck
  <rect x="290" y="145" rx="20" ry="20" width="20" height="20" style="fill:black; stroke:black; stroke-width:1" />
  Sorry, your browser does not support inline SVG.

  // chest
  <polygon id="CHEST0" points="220,170 380,170 340,230 260,230" onmouseover="chest_hover();" onmouseout="mouse_out();" style="fill:white; stroke:black; stroke-width:1" />
    Sorry, your browser does not support inline SVG.

  // waist
  <polygon id="WAIST0" points="260,240 340,240 340,300 260,300" onmouseover="waist_hover();" onmouseout="mouse_out();" style="fill:white; stroke:black; stroke-width:1" />
    Sorry, your browser does not support inline SVG.
 
  // under waist
  <polygon id="U_WAIST0" points="260,310 340,310 300,350" onmouseover="waist_hover();" onmouseout="mouse_out();" style="fill:white; stroke:black; stroke-width:1" />
    Sorry, your browser does not support inline SVG.
 
  // left arm
  <polygon id="L_ARM0" points="220,190 240,230 200,290 180,270" onmouseover="arm_hover();" onmouseout="mouse_out();" style="fill:white; stroke:black; stroke-width:1" />
    Sorry, your browser does not support inline SVG.

  <polygon id="L_ARM1" points="175,275 195,295 140,370 140,350" onmouseover="arm_hover();" onmouseout="mouse_out();" style="fill:white; stroke:black; stroke-width:1" />
    Sorry, your browser does not support inline SVG.

  // right arm
  <polygon id="R_ARM0" points="360,230 380,190 420,270 400,290" onmouseover="arm_hover();" onmouseout="mouse_out();" style="fill:white; stroke:black; stroke-width:1" />
    Sorry, your browser does not support inline SVG.

  <polygon id="R_ARM1" points="425,275 405,295 460,370 460,350" onmouseover="arm_hover();" onmouseout="mouse_out();" style="fill:white; stroke:black; stroke-width:1" />
    Sorry, your browser does not support inline SVG.

  // left leg
  <polygon id="L_LEG0" points="260,320 240,430 260,450 280,450 290,350" onmouseover="thigh_hover();" onmouseout="mouse_out();" style="fill:white; stroke:black; stroke-width:1" />
    Sorry, your browser does not support inline SVG.

  <polygon id="L_LEG1" points="240,460 245,630 265,630 280,460" onmouseover="leg_hover();" onmouseout="mouse_out();" style="fill:white; stroke:black; stroke-width:1" />
    Sorry, your browser does not support inline SVG.

  // right leg
  <polygon id="R_LEG0" points="340,320 310,350 320,450 340,450 360,430" onmouseover="thigh_hover();" onmouseout="mouse_out();" style="fill:white; stroke:black; stroke-width:1" />
    Sorry, your browser does not support inline SVG.

  <polygon id="R_LEG1" points="320,460 360,460 355,630 335,630" onmouseover="leg_hover();" onmouseout="mouse_out();" style="fill:white; stroke:black; stroke-width:1" />
    Sorry, your browser does not support inline SVG.


  //avatar2
  <circle cx="700" cy="100" r="40" stroke="black" stroke-width="1" fill="black" />
    Sorry, your browser does not support inline SVG.
  
  //neck
  <rect x="690" y="145" rx="20" ry="20" width="20" height="20" style="fill:black; stroke:black; stroke-width:1" />
  Sorry, your browser does not support inline SVG.

  // chest
  <polygon id="CHEST1" points="680,170 640,230 740,230 740,170" onmouseover="chest_hover();" onmouseout="mouse_out();" style="fill:white; stroke:black; stroke-width:1" />
    Sorry, your browser does not support inline SVG.

  // waist
  <polygon id="WAIST1" points="660,240 740,240 720,290 720,310 660,310" onmouseover="waist_hover();" onmouseout="mouse_out();" style="fill:white; stroke:black; stroke-width:1" />
    Sorry, your browser does not support inline SVG.

  // hip
  <polygon id="HIP" points="660,320 660,350 720,350  735,335 720,320" onmouseover="hip_hover();" onmouseout="mouse_out();" style="fill:white; stroke:black; stroke-width:1" />
    Sorry, your browser does not support inline SVG.

  // leg
  <polygon id="LEG0" points="660,360 670,450 710,450 720,360" onmouseover="thigh_hover();" onmouseout="mouse_out();" style="fill:white; stroke:black; stroke-width:1" />
    Sorry, your browser does not support inline SVG.

  <polygon id="LEG1" points="670,460 710,460 695,630 675,630" onmouseover="leg_hover();" onmouseout="mouse_out();" style="fill:white; stroke:black; stroke-width:1" />
    Sorry, your browser does not support inline SVG.

  // image text
  <text x="230" y="700" fill="black">< Front Avatar ></text>
  <text x="620" y="700" fill="black">< Side Avatar ></text>

  // reference
  <text x="1000" y="80" fill="red">** Note please **</text>
  <text x="1000" y="100" fill="red">Red : 맞지않음. Yellow : 조금 낌. White : 맞음.</text>
  <text x="1000" y="120" fill="red">Blue : 살짝 헐렁함. Green : 헐렁함.</text>

  // body value
  <text x="1000" y="170" fill="black" id="t0"></text>
  <text x="1000" y="200" fill="black" id="t1"></text>
  <text x="1000" y="230" fill="black" id="t2"></text>
  <text x="1000" y="260" fill="black" id="t3"></text>
  <text x="1000" y="290" fill="black" id="t4"></text>
  <text x="1000" y="320" fill="black" id="t5"></text>
  <text x="1000" y="350" fill="black" id="t6"></text>

  // total result
  <text x="1000" y="430" fill="black" id="cloth"></text>
  <text x="1000" y="460" fill="blue" id="result"></text>
  <text x="1000" y="490" fill="black" id="t00"></text>
  <text x="1000" y="520" fill="black" id="t01"></text>
  <text x="1000" y="550" fill="black" id="t02"></text>
  <text x="1000" y="580" fill="black" id="t03"></text>
  <text x="1000" y="610" fill="black" id="t04"></text>
  <text x="1000" y="640" fill="black" id="t05"></text>

 
  <text x="1000" y="700" fill="orange" font-weight="bold" id="h00"></text>
  <text x="1000" y="710" fill="orange" font-weight="bold" id="h01"></text>
  <text x="1000" y="720" fill="orange" font-weight="bold" id="h02"></text>
  
</svg>
<p id="demo"></p>

  <style type="text/css">
    svg {
        max-width: 100%;
        max-height: 100%
        height: auto;
        width: auto;
    }

    polygon:hover {
        opacity: 0.5;
    }
    
  </style>

  <script type="text/javascript">

      var i=0;
      var result_index=0;
      var obj = JSON.parse('<?php echo $historicalData ; ?>');
      var cloth_type = '<?=$cloth_type?>';
      var cloth_name = '<?=$cloth_name?>';
      document.getElementById("cloth").innerHTML = "** << "+cloth_name+" >> Result **";
  
      // user body value
      var shoulder = '<?=$shoulder?>';
      var chest = '<?=$chest?>';
      var arm = '<?=$arm?>';
      var waist = '<?=$waist?>';
      var hip = '<?=$hip?>';
      var leg = '<?=$leg?>';
      var thigh = '<?=$thigh?>';

      document.getElementById('t0').innerHTML = "Shoulder : "+shoulder+" cm";
      document.getElementById("t1").innerHTML = "Chest : "+chest+" cm";
      document.getElementById("t2").innerHTML = "Arm Length : "+arm+" cm";
      document.getElementById("t3").innerHTML = "Waist : "+waist+" cm";
      document.getElementById("t4").innerHTML = "Hip : "+hip+" cm";
      document.getElementById("t5").innerHTML = "Leg Length : "+leg+" cm";
      document.getElementById("t6").innerHTML = "Thigh : "+thigh+" cm";

      var cloth_size = obj.size;
      var cloth_waist = obj.Cwaist;
      var cloth_upper = obj.Cupper;
      var cloth_under = obj.Cunder;
      var cloth_hip = obj.Chip;
      var cloth_leg = obj.Cleg;
      var cloth_thigh = obj.Cthigh;
      var cloth_skirt = obj.Cskirt;

      var cloth_shoulder = obj.Cshoulder;
      var cloth_chest = obj.Cchest;
      var cloth_arm = obj.Carm;
      var cloth_length = obj.Clength;

      var waist_term=[], hip_term=[], thigh_term=[];
      var shoulder_term=[], chest_term=[];
      var index0=0, index1=0, index2=0;
      var min0=100, min1=100, min2=100;
      var state0=0, state1=0, state2=0;

      // cloth value
      if(cloth_type == "bottom") {

          // pants
          if(cloth_skirt[0] == null) {

              for(i=0; i<cloth_size.length; i++) {
                  waist_term[i] =  cloth_waist[i] - waist;
                  hip_term[i] = cloth_hip[i] - hip;
                  thigh_term[i] = cloth_thigh[i] - thigh;
              }

              // minium waist
              for(i=0; i<cloth_size.length; i++) {
                  if(min0 > Math.abs(waist_term[i])) {
                    min0 =  Math.abs(waist_term[i]);
                    index0 = i;
                  }
              }

              // Too many differences
              if(waist_term[index0] < -2) {
                  state0 = 1;
                  document.getElementById("WAIST0").style.fill='red';
                  document.getElementById("WAIST1").style.fill='red';
                  document.getElementById("U_WAIST0").style.fill='red';
                  document.getElementById("t00").innerHTML = "Waist : The size for this size is "+cloth_size[index0] + ", Over "+Math.abs(waist_term[index0])+" cm";
              }
              else if(waist_term[index0] > 2) {
                  state0 = 2;
                  document.getElementById("WAIST0").style.fill='green';
                  document.getElementById("WAIST1").style.fill='green';
                  document.getElementById("U_WAIST0").style.fill='green';
                  document.getElementById("t00").innerHTML = "Waist : The size for this size is "+cloth_size[index0] + ", Over "+Math.abs(waist_term[index0])+" cm";
              }
            
              // minium hip
              for(i=0; i<cloth_size.length; i++) {
                  if(min1 > Math.abs(hip_term[i])) {
                    min1 =  Math.abs(hip_term[i]);
                    index1 = i;
                  }
              }

              // Too many differences
              if(hip_term[index1] < -2) {
                  state1 = 1;
                  document.getElementById("HIP").style.fill='red';
                  document.getElementById("t01").innerHTML = "Hip : The size for this size is "+cloth_size[index1] + ", Over "+Math.abs(hip_term[index1])+" cm";
              }
              else if(hip_term[index1] > 2) {
                  state1 = 2;
                  document.getElementById("HIP").style.fill='green';
                  document.getElementById("t01").innerHTML = "Hip : The size for this size is "+cloth_size[index1] + ", Over "+Math.abs(hip_term[index1])+" cm";
              }

              // minium thigh
              for(i=0; i<cloth_size.length; i++) {
                  if(min2 > Math.abs(thigh_term[i])) {
                    min2 =  Math.abs(thigh_term[i]);
                    index2 = i;
                  }
              }

              // Too many differences
              if(thigh_term[index2] < -2) {
                  state2 = 1;
                  document.getElementById("LEG0").style.fill='red';
                  document.getElementById("L_LEG0").style.fill='red';
                  document.getElementById("R_LEG0").style.fill='red';
                  document.getElementById("t02").innerHTML = "Thigh : The size for this size is "+cloth_size[index2] + ", Over "+Math.abs(thigh_term[index2])+" cm";
              }
              else if(thigh_term[index2] > 2) {
                  state2 = 2;
                  document.getElementById("LEG0").style.fill='green';
                  document.getElementById("L_LEG0").style.fill='green';
                  document.getElementById("R_LEG0").style.fill='green';
                  document.getElementById("t02").innerHTML = "Thigh : The size for this size is "+cloth_size[index2] + ", Over "+Math.abs(thigh_term[index2])+" cm";
              }


              if(index0 == index1 && index0 == index2 && state0 == 0 && state1 == 0 && state2 == 0) {
                  result_index = index0;
                  document.getElementById("result").innerHTML = "Best Size : "+cloth_size[index0];

                  // thigh
                  if(thigh_term[index0] <= 2 && thigh_term[index0] > 0) {
                      document.getElementById("LEG0").style.fill='blue';
                      document.getElementById("L_LEG0").style.fill='blue';
                      document.getElementById("R_LEG0").style.fill='blue';
                      document.getElementById("t02").innerHTML = "Thigh : It does not lightly fit. "+ Math.abs(thigh_term[index0])+" cm";
                  }
                  else if(thigh_term[index0] >= -2 && thigh_term[index0] < 0) {
                      document.getElementById("LEG0").style.fill='yellow';
                      document.getElementById("L_LEG0").style.fill='yellow';
                      document.getElementById("R_LEG0").style.fill='yellow';
                      document.getElementById("t02").innerHTML = "Thigh : It does not lightly fit. "+ Math.abs(thigh_term[index0])+" cm";
                  }
                  else {
                      document.getElementById("t02").innerHTML = "Thigh : Very Good";
                  }

                  // hip
                  if(hip_term[index0] <= 2 && hip_term[index0] > 0) {
                      document.getElementById("HIP").style.fill='blue';
                      document.getElementById("t01").innerHTML = "Hip : It does not lightly fit. "+ Math.abs(hip_term[index0])+" cm";
                  } 
                  else if(hip_term[index0] >= -2 && hip_term[index0] < 0) {
                      document.getElementById("HIP").style.fill='yellow';
                      document.getElementById("t01").innerHTML = "Hip : It does not lightly fit. "+ Math.abs(hip_term[index0])+" cm";
                  }
                  else {
                      document.getElementById("t01").innerHTML = "Hip : Very Good";
                  }

                  // waist
                  if(waist_term[index0] <= 2 && waist_term[index0] > 0) {
                      document.getElementById("WAIST0").style.fill='blue';
                      document.getElementById("WAIST1").style.fill='blue';
                      document.getElementById("U_WAIST0").style.fill='blue';
                      document.getElementById("t00").innerHTML = "Waist : It does not lightly fit. "+ Math.abs(waist_term[index0])+" cm";
                  } 
                  else if(waist_term[index0] >= -2 && waist_term[index0] < 0) {
                      document.getElementById("WAIST0").style.fill='yellow';
                      document.getElementById("WAIST1").style.fill='yellow';
                      document.getElementById("U_WAIST0").style.fill='yellow';
                      document.getElementById("t00").innerHTML = "Waist : It does not lightly fit. "+ Math.abs(waist_term[index0])+" cm";
                  }
                  else {
                      document.getElementById("t00").innerHTML = "Waist : Very Good";
                  }

                  // leg
                  if(leg < cloth_leg[index0]) {
                      document.getElementById("L_LEG1").style.fill='blue';
                      document.getElementById("R_LEG1").style.fill='blue';
                      document.getElementById("LEG1").style.fill='blue';
                      document.getElementById("t03").innerHTML = "Leg Length : It is long. "+ Math.abs(leg - cloth_leg[index0])+" cm";
                  }
                  else if(leg > cloth_leg[index0]) {
                      document.getElementById("L_LEG1").style.fill='yellow';
                      document.getElementById("R_LEG1").style.fill='yellow';
                      document.getElementById("LEG1").style.fill='yellow';
                      document.getElementById("t03").innerHTML = "Leg Length : It is short. "+ Math.abs(leg - cloth_leg[index0])+" cm";
                  }
                  else {
                      document.getElementById("t03").innerHTML = "Leg Length : Very Good";
                  }

                  // under length
                  document.getElementById("t04").innerHTML = "Under Length : "+cloth_under[index0]+" cm";

                  // upper length
                  document.getElementById("t05").innerHTML = "Upper Length : "+cloth_upper[index0]+" cm";
              }
              else if(index0 == index1 && state0 == 0 && state1 == 0 && state2 == 0) {
                  result_index = index0;
                  document.getElementById("result").innerHTML = "Recommended Size : "+cloth_size[index0];

                  // thigh
                  if(thigh_term[index0] <= 2 && thigh_term[index0] > 0) {
                      document.getElementById("LEG0").style.fill='blue';
                      document.getElementById("L_LEG0").style.fill='blue';
                      document.getElementById("R_LEG0").style.fill='blue';
                      document.getElementById("t02").innerHTML = "Thigh : It does not lightly fit. "+ Math.abs(thigh_term[index0])+" cm";
                  }
                  else if(thigh_term[index0] >= -2 && thigh_term[index0] < 0) {
                      document.getElementById("LEG0").style.fill='yellow';
                      document.getElementById("L_LEG0").style.fill='yellow';
                      document.getElementById("R_LEG0").style.fill='yellow';
                      document.getElementById("t02").innerHTML = "Thigh : It does not lightly fit. "+ Math.abs(thigh_term[index0])+" cm";
                  }
                  else if(thigh_term[index0] > 2 || thigh_term[index0] < -2) {
                      document.getElementById("LEG0").style.fill='red';
                      document.getElementById("L_LEG0").style.fill='red';
                      document.getElementById("R_LEG0").style.fill='red';
                      document.getElementById("t02").innerHTML = "Thigh : The size for this size is "+cloth_size[index2] + ", Over "+Math.abs(thigh_term[index2])+" cm";
                  }
                  else {
                      document.getElementById("t02").innerHTML = "Thigh : Very Good";
                  }

                  // hip
                  if(hip_term[index0] <= 2 && hip_term[index0] > 0) {
                      document.getElementById("HIP").style.fill='blue';
                      document.getElementById("t01").innerHTML = "Hip : It does not lightly fit. "+ Math.abs(hip_term[index0])+" cm";
                  } 
                  else if(hip_term[index0] >= -2 && hip_term[index0] < 0) {
                      document.getElementById("HIP").style.fill='yellow';
                      document.getElementById("t01").innerHTML = "Hip : It does not lightly fit. "+ Math.abs(hip_term[index0])+" cm";
                  }
                  else {
                      document.getElementById("t01").innerHTML = "Hip : Very Good";
                  }

                  // waist
                  if(waist_term[index0] <= 2 && waist_term[index0] > 0) {
                      document.getElementById("WAIST0").style.fill='blue';
                      document.getElementById("WAIST1").style.fill='blue';
                      document.getElementById("U_WAIST0").style.fill='blue';
                      document.getElementById("t00").innerHTML = "Waist : It does not lightly fit. "+ Math.abs(waist_term[index0])+" cm";
                  } 
                  else if(waist_term[index0] >= -2 && waist_term[index0] < 0) {
                      document.getElementById("WAIST0").style.fill='yellow';
                      document.getElementById("WAIST1").style.fill='yellow';
                      document.getElementById("U_WAIST0").style.fill='yellow';
                      document.getElementById("t00").innerHTML = "Waist : It does not lightly fit. "+ Math.abs(waist_term[index0])+" cm";
                  }
                  else {
                      document.getElementById("t00").innerHTML = "Waist : Very Good";
                  }

                  // leg
                  if(leg < cloth_leg[index0]) {
                      document.getElementById("L_LEG1").style.fill='blue';
                      document.getElementById("R_LEG1").style.fill='blue';
                      document.getElementById("LEG1").style.fill='blue';
                      document.getElementById("t03").innerHTML = "Leg Length : It is long. "+ Math.abs(leg - cloth_leg[index0])+" cm";
                  }
                  else if(leg > cloth_leg[index0]) {
                      document.getElementById("L_LEG1").style.fill='yellow';
                      document.getElementById("R_LEG1").style.fill='yellow';
                      document.getElementById("LEG1").style.fill='yellow';
                      document.getElementById("t03").innerHTML = "Leg Length : It is short. "+ Math.abs(leg - cloth_leg[index0])+" cm";
                  }
                  else {
                      document.getElementById("t03").innerHTML = "Leg Length : Very Good";
                  }

                  // under length
                  document.getElementById("t04").innerHTML = "Under Length : "+cloth_under[index0]+" cm";

                  // upper length
                  document.getElementById("t05").innerHTML = "Upper Length : "+cloth_upper[index0]+" cm";
              }
              else if(index0 == index2 && state0 == 0 && state1 == 0 && state2 == 0) {
                  result_index = index0;
                  document.getElementById("result").innerHTML = "Recommended Size : "+cloth_size[index0];

                  // thigh
                  if(thigh_term[index0] <= 2 && thigh_term[index0] > 0) {
                      document.getElementById("LEG0").style.fill='blue';
                      document.getElementById("L_LEG0").style.fill='blue';
                      document.getElementById("R_LEG0").style.fill='blue';
                      document.getElementById("t02").innerHTML = "Thigh : It does not lightly fit. "+ Math.abs(thigh_term[index0])+" cm";
                  }
                  else if(thigh_term[index0] >= -2 && thigh_term[index0] < 0) {
                      document.getElementById("LEG0").style.fill='yellow';
                      document.getElementById("L_LEG0").style.fill='yellow';
                      document.getElementById("R_LEG0").style.fill='yellow';
                      document.getElementById("t02").innerHTML = "Thigh : It does not lightly fit. "+ Math.abs(thigh_term[index0])+" cm";
                  }
                  else {
                      document.getElementById("t02").innerHTML = "Thigh : Very Good";
                  }

                  // hip
                  if(hip_term[index0] <= 2 && hip_term[index0] > 0) {
                      document.getElementById("HIP").style.fill='blue';
                      document.getElementById("t01").innerHTML = "Hip : It does not lightly fit. "+ Math.abs(hip_term[index1])+" cm";
                  } 
                  else if(hip_term[index0] >= -2 && hip_term[index0] < 0) {
                      document.getElementById("HIP").style.fill='yellow';
                      document.getElementById("t01").innerHTML = "Hip : It does not lightly fit. "+ Math.abs(hip_term[index1])+" cm";
                  }
                  else if(hip_term[index0] > 2 || hip_term[index0] < -2) {
                      document.getElementById("HIP").style.fill='red';
                      document.getElementById("t01").innerHTML = "Hip : The size for this size is "+cloth_size[index1] + ", Over "+Math.abs(hip_term[index1])+" cm";
                  }
                  else {
                      document.getElementById("t01").innerHTML = "Hip : Very Good";
                  }

                  // waist
                  if(waist_term[index0] <= 2 && waist_term[index0] > 0) {
                      document.getElementById("WAIST0").style.fill='blue';
                      document.getElementById("WAIST1").style.fill='blue';
                      document.getElementById("U_WAIST0").style.fill='blue';
                      document.getElementById("t00").innerHTML = "Waist : It does not lightly fit. "+ Math.abs(waist_term[index0])+" cm";
                  } 
                  else if(waist_term[index0] >= -2 && waist_term[index0] < 0) {
                      document.getElementById("WAIST0").style.fill='yellow';
                      document.getElementById("WAIST1").style.fill='yellow';
                      document.getElementById("U_WAIST0").style.fill='yellow';
                      document.getElementById("t00").innerHTML = "Waist : It does not lightly fit. "+ Math.abs(waist_term[index0])+" cm";
                  }
                  else {
                      document.getElementById("t00").innerHTML = "Waist : Very Good";
                  }

                  // leg
                  if(leg < cloth_leg[index0]) {
                      document.getElementById("L_LEG1").style.fill='blue';
                      document.getElementById("R_LEG1").style.fill='blue';
                      document.getElementById("LEG1").style.fill='blue';
                      document.getElementById("t03").innerHTML = "Leg Length : It is long. "+ Math.abs(leg - cloth_leg[index0])+" cm";
                  }
                  else if(leg > cloth_leg[index0]) {
                      document.getElementById("L_LEG1").style.fill='yellow';
                      document.getElementById("R_LEG1").style.fill='yellow';
                      document.getElementById("LEG1").style.fill='yellow';
                      document.getElementById("t03").innerHTML = "Leg Length : It is short. "+ Math.abs(leg - cloth_leg[index0])+" cm";
                  }
                  else {
                      document.getElementById("t03").innerHTML = "Leg Length : Very Good";
                  }

                  // under length
                  document.getElementById("t04").innerHTML = "Under Length : "+cloth_under[index0]+" cm";

                  // upper length
                  document.getElementById("t05").innerHTML = "Upper Length : "+cloth_upper[index0]+" cm";
              }
              else if(index1 == index2 && state0 == 0 && state1 == 0 && state2 == 0) {
                  result_index = index1;
                  document.getElementById("result").innerHTML = "Recommended Size : "+cloth_size[index1];

                  // thigh
                  if(thigh_term[index1] <= 2 && thigh_term[index1] > 0) {
                      document.getElementById("LEG0").style.fill='blue';
                      document.getElementById("L_LEG0").style.fill='blue';
                      document.getElementById("R_LEG0").style.fill='blue';
                      document.getElementById("t02").innerHTML = "Thigh : It does not lightly fit. "+ Math.abs(thigh_term[index1])+" cm";
                  }
                  else if(thigh_term[index1] >= -2 && thigh_term[index1] < 0) {
                      document.getElementById("LEG0").style.fill='yellow';
                      document.getElementById("L_LEG0").style.fill='yellow';
                      document.getElementById("R_LEG0").style.fill='yellow';
                      document.getElementById("t02").innerHTML = "Thigh : It does not lightly fit. "+ Math.abs(thigh_term[index1])+" cm";
                  }
                  else {
                      document.getElementById("t02").innerHTML = "Thigh : Very Good";
                  }

                  // hip
                  if(hip_term[index1] <= 2 && hip_term[index1] > 0) {
                      document.getElementById("HIP").style.fill='blue';
                      document.getElementById("t01").innerHTML = "Hip : It does not lightly fit. "+ Math.abs(hip_term[index1])+" cm";
                  } 
                  else if(hip_term[index1] >= -2 && hip_term[index1] < 0) {
                      document.getElementById("HIP").style.fill='yellow';
                      document.getElementById("t01").innerHTML = "Hip : It does not lightly fit. "+ Math.abs(hip_term[index1])+" cm";
                  }
                  else {
                      document.getElementById("t01").innerHTML = "Hip : Very Good";
                  }

                  // waist
                  if(waist_term[index1] <= 2 && waist_term[index1] > 0) {
                      document.getElementById("WAIST0").style.fill='blue';
                      document.getElementById("WAIST1").style.fill='blue';
                      document.getElementById("U_WAIST0").style.fill='blue';
                      document.getElementById("t00").innerHTML = "Waist : It does not lightly fit. "+ Math.abs(waist_term[index0])+" cm";
                  } 
                  else if(waist_term[index1] >= -2 && waist_term[index1] < 0) {
                      document.getElementById("WAIST0").style.fill='yellow';
                      document.getElementById("WAIST1").style.fill='yellow';
                      document.getElementById("U_WAIST0").style.fill='yellow';
                      document.getElementById("t00").innerHTML = "Waist : It does not lightly fit. "+ Math.abs(waist_term[index0])+" cm";
                  }
                  else if(waist_term[index1] > 2 || waist_term[index1] < -2) {
                      document.getElementById("LEG0").style.fill='red';
                      document.getElementById("L_LEG0").style.fill='red';
                      document.getElementById("R_LEG0").style.fill='red';
                      document.getElementById("t00").innerHTML = "Waist : The size for this size is "+cloth_size[index0] + ", Over "+Math.abs(waist_term[index0])+" cm";
                  }
                  else {
                      document.getElementById("t00").innerHTML = "Waist : Very Good";
                  }

                  // leg
                  if(leg < cloth_leg[index1]) {
                      document.getElementById("L_LEG1").style.fill='blue';
                      document.getElementById("R_LEG1").style.fill='blue';
                      document.getElementById("LEG1").style.fill='blue';
                      document.getElementById("t03").innerHTML = "Leg Length : It is long. "+ Math.abs(leg - cloth_leg[index1])+" cm";
                  }
                  else if(leg > cloth_leg[index1]) {
                      document.getElementById("L_LEG1").style.fill='yellow';
                      document.getElementById("R_LEG1").style.fill='yellow';
                      document.getElementById("LEG1").style.fill='yellow';
                      document.getElementById("t03").innerHTML = "Leg Length : It is short. "+ Math.abs(leg - cloth_leg[index1])+" cm";
                  }
                  else {
                      document.getElementById("t03").innerHTML = "Leg Length : Very Good";
                  }

                  // under length
                  document.getElementById("t04").innerHTML = "Under Length : "+cloth_under[index1]+" cm";

                  // upper length
                  document.getElementById("t05").innerHTML = "Upper Length : "+cloth_upper[index1]+" cm";
              }
              else {
                  result_index = 100;
                  // hip
                  if(hip_term[index1] <= 2 && hip_term[index1] > 0) {
                      document.getElementById("HIP").style.fill='blue';
                  } 
                  else if(hip_term[index1] >= -2 && hip_term[index1] < 0) {
                      document.getElementById("HIP").style.fill='yellow';
                  }

                  // waist
                  if(waist_term[index0] <= 2 && waist_term[index0] > 0) {
                      document.getElementById("WAIST0").style.fill='blue';
                      document.getElementById("WAIST1").style.fill='blue';
                      document.getElementById("U_WAIST0").style.fill='blue';
                  } 
                  else if(waist_term[index0] >= -2 && waist_term[index0] < 0) {
                      document.getElementById("WAIST0").style.fill='yellow';
                      document.getElementById("WAIST1").style.fill='yellow';
                      document.getElementById("U_WAIST0").style.fill='yellow';
                  }

                  // thigh
                  if(thigh_term[index2] <= 2 && thigh_term[index2] > 0) {
                      document.getElementById("LEG0").style.fill='blue';
                      document.getElementById("L_LEG0").style.fill='blue';
                      document.getElementById("R_LEG0").style.fill='blue';
                  }
                  else if(thigh_term[index2] >= -2 && thigh_term[index2] < 0) {
                      document.getElementById("LEG0").style.fill='yellow';
                      document.getElementById("L_LEG0").style.fill='yellow';
                      document.getElementById("R_LEG0").style.fill='yellow';
                  }

                  document.getElementById("result").innerHTML = "Nothing... You'd better to do not buy.";
                  document.getElementById("t00").innerHTML = "Waist : The size for this size is "+cloth_size[index0] + ", Over "+Math.abs(waist_term[index0])+" cm";
                  document.getElementById("t01").innerHTML = "Hip : The size for this size is "+cloth_size[index1] + ", Over "+Math.abs(hip_term[index1])+" cm";
                  document.getElementById("t02").innerHTML = "Thigh : The size for this size is "+cloth_size[index2] + ", Over "+Math.abs(thigh_term[index2])+" cm";
                  document.getElementById("t03").innerHTML = "Leg Length : Not provided because it is not recommended.";
                  document.getElementById("t04").innerHTML = "Under Length : Not provided because it is not recommended.";
                  document.getElementById("t05").innerHTML = "Upper Length : Not provided because it is not recommended.";
              }

          }
          //skirt
          else {

              for(i=0; i<cloth_size.length; i++) {
                  waist_term[i] = cloth_waist[i] - waist;
                  hip_term[i] = cloth_hip[i] - hip;
              }

              // minium waist
              for(i=0; i<cloth_size.length; i++) {
                  if(min0 > Math.abs(waist_term[i])) {
                    min0 =  Math.abs(waist_term[i]);
                    index0 = i;
                  }
              }

              // Too many differences
              if(waist_term[index0] < -4) {
                  state0 = 1;
                  document.getElementById("WAIST0").style.fill='red';
                  document.getElementById("WAIST1").style.fill='red';
                  document.getElementById("U_WAIST0").style.fill='red';
                  document.getElementById("t00").innerHTML = "Waist : The size for this size is "+cloth_size[index0] + ", Over "+Math.abs(waist_term[index0])+" cm";
              }
              else if(waist_term[index0] > 4) {
                  state0 = 2;
                  document.getElementById("WAIST0").style.fill='green';
                  document.getElementById("WAIST1").style.fill='green';
                  document.getElementById("U_WAIST0").style.fill='green';
                  document.getElementById("t00").innerHTML = "Waist : The size for this size is "+cloth_size[index0] + ", Over "+Math.abs(waist_term[index0])+" cm";
              }
            
              // minium hip
              for(i=0; i<cloth_size.length; i++) {
                  if(min1 > Math.abs(hip_term[i])) {
                    min1 =  Math.abs(hip_term[i]);
                    index1 = i;
                  }
              }

              // Too many differences
              if(hip_term[index1] < -4) {
                  state1 = 1;
                  document.getElementById("HIP").style.fill='red';
                  document.getElementById("t01").innerHTML = "Hip : The size for this size is "+cloth_size[index1] + ", Over "+Math.abs(hip_term[index1])+" cm";
              }
              else if(hip_term[index1] > 4) {
                  state1 = 2;
                  document.getElementById("HIP").style.fill='green';
                  document.getElementById("t01").innerHTML = "Hip : The size for this size is "+cloth_size[index1] + ", Over "+Math.abs(hip_term[index1])+" cm";
              }


              if(index0 == index1 && state0 == 0 && state1 == 0) {
                  result_index = index0;
                  document.getElementById("result").innerHTML = "Best Size : "+cloth_size[index0];

                  // hip
                  if(hip_term[index0] <= 2 && hip_term[index0] > 0) {
                      document.getElementById("HIP").style.fill='blue';
                      document.getElementById("t01").innerHTML = "Hip : It does not lightly fit. "+ Math.abs(hip_term[index0])+" cm";
                  } 
                  else if(hip_term[index0] >= -2 && hip_term[index0] < 0) {
                      document.getElementById("HIP").style.fill='yellow';
                      document.getElementById("t01").innerHTML = "Hip : It does not lightly fit. "+ Math.abs(hip_term[index0])+" cm";
                  }
                  else {
                      document.getElementById("t01").innerHTML = "Hip : Very Good";
                  }

                  // waist
                  if(waist_term[index0] <= 2 && waist_term[index0] > 0) {
                      document.getElementById("WAIST0").style.fill='blue';
                      document.getElementById("WAIST1").style.fill='blue';
                      document.getElementById("U_WAIST0").style.fill='blue';
                      document.getElementById("t00").innerHTML = "Waist : It does not lightly fit. "+ Math.abs(waist_term[index0])+" cm";
                  } 
                  else if(waist_term[index0] >= -2 && waist_term[index0] < 0) {
                      document.getElementById("WAIST0").style.fill='yellow';
                      document.getElementById("WAIST1").style.fill='yellow';
                      document.getElementById("U_WAIST0").style.fill='yellow';
                      document.getElementById("t00").innerHTML = "Waist : It does not lightly fit. "+ Math.abs(waist_term[index0])+" cm";
                  }
                  else {
                      document.getElementById("t00").innerHTML = "Waist : Very Good";
                  }

                  // leg - total length
                  document.getElementById("t03").innerHTML = "Total Length : "+cloth_leg[index0]+" cm";
                  
                  // under skirt
                  document.getElementById("t02").innerHTML = "Skirt Under : "+cloth_skirt[index0]+" cm";
              }
              else {
                  result_index = 100;
                  document.getElementById("result").innerHTML = "Nothing... You'd better to do not buy.";

                  // hip
                  if(hip_term[index1] <= 2 && hip_term[index1] > 0) {
                      document.getElementById("HIP").style.fill='blue';
                  } 
                  else if(hip_term[index1] >= -2 && hip_term[index1] < 0) {
                      document.getElementById("HIP").style.fill='yellow';
                  }

                  // waist
                  if(waist_term[index0] <= 2 && waist_term[index0] > 0) {
                      document.getElementById("WAIST0").style.fill='blue';
                      document.getElementById("WAIST1").style.fill='blue';
                      document.getElementById("U_WAIST0").style.fill='blue';
                  } 
                  else if(waist_term[index0] >= -2 && waist_term[index0] < 0) {
                      document.getElementById("WAIST0").style.fill='yellow';
                      document.getElementById("WAIST1").style.fill='yellow';
                      document.getElementById("U_WAIST0").style.fill='yellow';
                  }

                  document.getElementById("t00").innerHTML = "Waist : The size for this size is "+cloth_size[index0] + ", Over "+Math.abs(waist_term[index0])+" cm";
                  document.getElementById("t01").innerHTML = "Hip : The size for this size is "+cloth_size[index1] + ", Over "+Math.abs(hip_term[index1])+" cm";
                  document.getElementById("t03").innerHTML = "Total Length : Not provided because it is not recommended.";
                  document.getElementById("t02").innerHTML = "Skirt Under : Not provided because it is not recommended.";
              }

          }
      }
      else if(cloth_type == "top") {

          if(cloth_shoulder[0] == null) {
              
              document.getElementById("t00").innerHTML = "Shoulder : This cloth does not need shoulder size.";

              for(i=0; i<cloth_size.length; i++) {
                  chest_term[i] = cloth_chest[i] - chest;
              }

              // minium chest
              for(i=0; i<cloth_size.length; i++) {
                  if(min0 > Math.abs(chest_term[i])) {
                    min0 =  Math.abs(chest_term[i]);
                    index0 = i;
                  }
              }

              // Too many differences
              if(chest_term[index0] < -8) {
                  result_index = 100;
                  state0 = 1;
                  document.getElementById("CHEST0").style.fill='red';
                  document.getElementById("CHEST1").style.fill='red';
                  document.getElementById("t01").innerHTML = "Chest : The size for this size is "+cloth_size[index0] + ", Over "+Math.abs(chest_term[index0])+" cm";
                  document.getElementById("result").innerHTML = "Nothing... You'd better to do not buy.";
              }
              else if(chest_term[index0] > 8) {
                  result_index = 100;
                  state0 = 2;
                  document.getElementById("CHEST0").style.fill='green';
                  document.getElementById("CHEST1").style.fill='green';
                  document.getElementById("t01").innerHTML = "Chest : The size for this size is "+cloth_size[index0] + ", Over "+Math.abs(chest_term[index0])+" cm";
                  document.getElementById("result").innerHTML = "Nothing... You'd better to do not buy.";
              }
              // normal
              else if(chest_term[index0] <= 8 && chest_term[index0] > 3) {
                  result_index = index0;
                  document.getElementById("CHEST0").style.fill='blue';
                  document.getElementById("CHEST1").style.fill='blue';
                  document.getElementById("t01").innerHTML = "Chest : It does not lightly fit. "+ Math.abs(chest_term[index0])+" cm";
                  document.getElementById("result").innerHTML = "Recommended Size : "+cloth_size[index0];
                  //total length
                  document.getElementById("t03").innerHTML = "Total Length : "+cloth_length[index0]+" cm";
              }
              else if(chest_term[index0] < -3 && chest_term[index0] >= -8) {
                  result_index = index0;
                  document.getElementById("CHEST0").style.fill='yellow';
                  document.getElementById("CHEST1").style.fill='yellow';
                  document.getElementById("t01").innerHTML = "Chest : It does not lightly fit. "+ Math.abs(chest_term[index0])+" cm";
                  document.getElementById("result").innerHTML = "Recommended Size : "+cloth_size[index0];
                  //total length
                  document.getElementById("t03").innerHTML = "Total Length : "+cloth_length[index0]+" cm";
              }
              else {
                  result_index = index0;
                  document.getElementById("result").innerHTML = "Recommended Size : "+cloth_size[index0];
                  //total length
                  document.getElementById("t03").innerHTML = "Total Length : "+cloth_length[index0]+" cm";
                  document.getElementById("t01").innerHTML = "Chest : Very Good";
              }


              // arm length
              if(cloth_arm[index0] < arm) {
                  document.getElementById("L_ARM0").style.fill='yellow';
                  document.getElementById("L_ARM1").style.fill='yellow';
                  document.getElementById("R_ARM0").style.fill='yellow';
                  document.getElementById("R_ARM1").style.fill='yellow';
                  document.getElementById("t02").innerHTML = "Arm Length : It is short. "+ Math.abs(arm - cloth_arm[index0])+" cm";
              }
              else if(cloth_arm[index0] > arm) {
                  document.getElementById("L_ARM0").style.fill='blue';
                  document.getElementById("L_ARM1").style.fill='blue';
                  document.getElementById("R_ARM0").style.fill='blue';
                  document.getElementById("R_ARM1").style.fill='blue';
                  document.getElementById("t02").innerHTML = "Arm Length : It is long. "+ Math.abs(arm - cloth_arm[index0])+" cm";
              }
              else {
                  document.getElementById("t02").innerHTML = "Arm Length : Very Good";
              }  
  
          }
          else {

              for(i=0; i<cloth_size.length; i++) {
                  shoulder_term[i] = cloth_shoulder[i] - shoulder;
                  chest_term[i] = cloth_chest[i] - chest;
              }

              // minium shoulder
              for(i=0; i<cloth_size.length; i++) {
                  if(min0 > Math.abs(shoulder_term[i])) {
                    min0 =  Math.abs(shoulder_term[i]);
                    index0 = i;
                  }
              }

              // Too many differences
              if(shoulder_term[index0] < -2) {
                  state0 = 1;
                  document.getElementById("CHEST0").style.fill='red';
                  document.getElementById("CHEST1").style.fill='red';
                  document.getElementById("t00").innerHTML = "Shoulder : The size for this size is "+cloth_size[index0] + ", Over "+Math.abs(shoulder_term[index0])+" cm";
              }
              else if(shoulder_term[index0] > 2) {
                  state0 = 2;
                  document.getElementById("CHEST0").style.fill='green';
                  document.getElementById("CHEST1").style.fill='green';
                  document.getElementById("t00").innerHTML = "Shoulder : The size for this size is "+cloth_size[index0] + ", Over "+Math.abs(shoulder_term[index0])+" cm";
              }

              // minium chest
              for(i=0; i<cloth_size.length; i++) {
                  if(min1 > Math.abs(chest_term[i])) {
                    min1 =  Math.abs(chest_term[i]);
                    index1 = i;
                  }
              }

              // Too many differences
              if(chest_term[index1] < -5) {
                  state1=1;
                  document.getElementById("CHEST0").style.fill='red';
                  document.getElementById("CHEST1").style.fill='red';
                  document.getElementById("t01").innerHTML = "Chest : The size for this size is "+cloth_size[index1] + ", Over "+Math.abs(chest_term[index1])+" cm";
              }
              else if(chest_term[index1] > 5) {
                  state1=2;
                  document.getElementById("CHEST0").style.fill='green';
                  document.getElementById("CHEST1").style.fill='green';
                  document.getElementById("t01").innerHTML = "Chest : The size for this size is "+cloth_size[index1] + ", Over "+Math.abs(chest_term[index1])+" cm";
              }


              if(index0 == index1 && state0 == 0 && state1 == 0) {
                  result_index = index0;
                  document.getElementById("result").innerHTML = "Best Size : "+cloth_size[index0];

                  // shoulder
                  if(shoulder_term[index0] <= 2 && shoulder_term[index0] > 0) {
                      document.getElementById("CHEST0").style.fill='blue';
                      document.getElementById("CHEST1").style.fill='blue';
                      document.getElementById("t00").innerHTML = "Shoulder : It does not lightly fit. "+ Math.abs(shoulder_term[index0])+" cm";
                  } 
                  else if(shoulder_term[index0] >= -2 && shoulder_term[index0] < 0) {
                      document.getElementById("CHEST0").style.fill='yellow';
                      document.getElementById("CHEST0").style.fill='yellow';
                      document.getElementById("t00").innerHTML = "Shoulder : It does not lightly fit. "+ Math.abs(shoulder_term[index0])+" cm";
                  }
                  else {
                      document.getElementById("t00").innerHTML = "Shoulder : Very Good";
                  }

                  // chest
                  if(chest_term[index0] <= 2 && chest_term[index0] > 0) {
                      document.getElementById("CHEST0").style.fill='blue';
                      document.getElementById("CHEST1").style.fill='blue';
                      document.getElementById("t01").innerHTML = "Chest : It does not lightly fit. "+ Math.abs(chest_term[index0])+" cm";
                  } 
                  else if(chest_term[index0] >= -2 && chest_term[index0] < 0) {
                      document.getElementById("CHEST0").style.fill='yellow';
                      document.getElementById("CHEST0").style.fill='yellow';
                      document.getElementById("t01").innerHTML = "Chest : It does not lightly fit. "+ Math.abs(chest_term[index0])+" cm";
                  }
                  else {
                      document.getElementById("t01").innerHTML = "Chest : Very Good";
                  }

                  // arm length
                  if(cloth_arm[index0] < arm) {
                      document.getElementById("L_ARM0").style.fill='yellow';
                      document.getElementById("L_ARM1").style.fill='yellow';
                      document.getElementById("R_ARM0").style.fill='yellow';
                      document.getElementById("R_ARM1").style.fill='yellow';
                      document.getElementById("t02").innerHTML = "Arm Length : It is short. "+ Math.abs(arm - cloth_arm[index0])+" cm";
                  }
                  else if(cloth_arm[index0] > arm) {
                      document.getElementById("L_ARM0").style.fill='blue';
                      document.getElementById("L_ARM1").style.fill='blue';
                      document.getElementById("R_ARM0").style.fill='blue';
                      document.getElementById("R_ARM1").style.fill='blue';
                      document.getElementById("t02").innerHTML = "Arm Length : It is long. "+ Math.abs(arm - cloth_arm[index0])+" cm";
                  }
                  else {
                      document.getElementById("t02").innerHTML = "Arm Length : Very Good";
                  }  

                  //total length
                  document.getElementById("t03").innerHTML = "Total Length : "+cloth_length[index0]+" cm";
              }
              else {
                  result_index = 100;
                  document.getElementById("result").innerHTML = "Nothing... You'd better to do not buy.";

                  // shoulder
                  if(shoulder_term[index0] <= 2 && shoulder_term[index0] > 0) {
                      document.getElementById("CHEST0").style.fill='blue';
                      document.getElementById("CHEST1").style.fill='blue';
                  } 
                  else if(shoulder_term[index0] >= -2 && shoulder_term[index0] < 0) {
                      document.getElementById("CHEST0").style.fill='yellow';
                      document.getElementById("CHEST0").style.fill='yellow';
                  }

                  // chest
                  if(chest_term[index1] <= 2 && chest_term[index1] > 0) {
                      document.getElementById("CHEST0").style.fill='blue';
                      document.getElementById("CHEST1").style.fill='blue';
                  } 
                  else if(chest_term[index1] >= -2 && chest_term[index1] < 0) {
                      document.getElementById("CHEST0").style.fill='yellow';
                      document.getElementById("CHEST0").style.fill='yellow';
                  }
                  
                  document.getElementById("t00").innerHTML = "Shoulder : The size for this size is "+cloth_size[index0] + ", Over "+Math.abs(shoulder_term[index0])+" cm";
                  document.getElementById("t01").innerHTML = "Chest : The size for this size is "+cloth_size[index1] + ", Over "+Math.abs(chest_term[index1])+" cm";

                  document.getElementById("t02").innerHTML = "Arm Length : Not provided because it is not recommended.";
                  document.getElementById("t03").innerHTML = "Total Length : Not provided because it is not recommended.";
              } 
          }
      }

      function mouse_out() {
          document.getElementById("h00").innerHTML = "";
          document.getElementById("h01").innerHTML = "";
          document.getElementById("h02").innerHTML = "";
      }

      function chest_hover() {
        if(cloth_type == "top") {
          document.getElementById("h00").innerHTML = "Part : Chest AND Shoulder";
          document.getElementById("h01").innerHTML = "Set Size : "+cloth_size[result_index];
          document.getElementById("h02").innerHTML = "Difference by "+chest_term[result_index]+" cm"+" AND "+Math.abs(shoulder - cloth_shoulder[result_index])+" cm";
        }
        
        if(cloth_type == "top" && result_index == 100) {
            document.getElementById("h00").innerHTML = "Part : Chest AND Shoulder";
            document.getElementById("h01").innerHTML = "Set Size : Not provided.";
            document.getElementById("h02").innerHTML = "";
        } 
          document.getElementById("h00").setAttribute('x', '420');
          document.getElementById("h00").setAttribute('y', '190');

          document.getElementById("h01").setAttribute('x', '420');
          document.getElementById("h01").setAttribute('y', '210');

          document.getElementById("h02").setAttribute('x', '420');
          document.getElementById("h02").setAttribute('y', '230');
        
      }

      function arm_hover() {
        if(cloth_type == "top") {
          document.getElementById("h00").innerHTML = "Part : Arm Length";
          document.getElementById("h01").innerHTML = "Set Size : "+cloth_size[result_index];
          document.getElementById("h02").innerHTML = "Difference by "+Math.abs(arm - cloth_arm[result_index])+" cm";
        }
        
        if(cloth_type == "top" && result_index == 100) {
            document.getElementById("h00").innerHTML = "Part : Arm Length";
            document.getElementById("h01").innerHTML = "Set Size : Not provided.";
            document.getElementById("h02").innerHTML = "";
        }
          
          document.getElementById("h00").setAttribute('x', '440');
          document.getElementById("h00").setAttribute('y', '190');

          document.getElementById("h01").setAttribute('x', '440');
          document.getElementById("h01").setAttribute('y', '210');

          document.getElementById("h02").setAttribute('x', '440');
          document.getElementById("h02").setAttribute('y', '230');
        
      }

      function waist_hover() {
        if(cloth_type == "bottom") {
            document.getElementById("h00").innerHTML = "Part : Waist";
            document.getElementById("h01").innerHTML = "Set Size : "+cloth_size[result_index];
            document.getElementById("h02").innerHTML = "Difference by "+Math.abs(waist - cloth_waist[result_index])+" cm";
        }
        else {
            document.getElementById("h00").innerHTML = "Part : Total Length";
            document.getElementById("h01").innerHTML = "Set Size : "+cloth_size[result_index];
            document.getElementById("h02").innerHTML = "Length : "+cloth_length[result_index]+" cm";

            if(result_index == 100) {
                document.getElementById("h00").innerHTML = "Part : Waist";
                document.getElementById("h01").innerHTML = "Set Size : Not provided.";
                document.getElementById("h02").innerHTML = "";
            }
        }

        if(cloth_type == "bottom" && result_index == 100) {
            document.getElementById("h00").innerHTML = "Part : Waist";
            document.getElementById("h01").innerHTML = "Set Size : Not provided.";
            document.getElementById("h02").innerHTML = "";
        }
            document.getElementById("h00").setAttribute('x', '450');
            document.getElementById("h00").setAttribute('y', '250');

            document.getElementById("h01").setAttribute('x', '450');
            document.getElementById("h01").setAttribute('y', '270');

            document.getElementById("h02").setAttribute('x', '450');
            document.getElementById("h02").setAttribute('y', '290');
      }

      function hip_hover() {
        if(cloth_type == "bottom") {
            document.getElementById("h00").innerHTML = "Part : Hip";
            document.getElementById("h01").innerHTML = "Set Size : "+cloth_size[result_index];
            document.getElementById("h02").innerHTML = "Difference by "+Math.abs(hip - cloth_hip[result_index])+" cm";
        }
        
        if(cloth_type == "bottom" && result_index == 100) {
            document.getElementById("h00").innerHTML = "Part : Hip";
            document.getElementById("h01").innerHTML = "Set Size : Not provided.";
            document.getElementById("h02").innerHTML = "";
        }
            
            document.getElementById("h00").setAttribute('x', '750');
            document.getElementById("h00").setAttribute('y', '330');

            document.getElementById("h01").setAttribute('x', '750');
            document.getElementById("h01").setAttribute('y', '350');

            document.getElementById("h02").setAttribute('x', '750');
            document.getElementById("h02").setAttribute('y', '370');
      }

      function thigh_hover() {
        if(cloth_type == "bottom") {
            document.getElementById("h00").innerHTML = "Part : Thigh";
            document.getElementById("h01").innerHTML = "Set Size : "+cloth_size[result_index];
            document.getElementById("h02").innerHTML = "Difference by "+Math.abs(thigh - cloth_thigh[result_index])+" cm";
        }

        if(cloth_type == "bottom" && result_index == 100) {
            document.getElementById("h00").innerHTML = "Part : Thigh";
            document.getElementById("h01").innerHTML = "Set Size : Not provided.";
            document.getElementById("h02").innerHTML = "";
        }
            
            document.getElementById("h00").setAttribute('x', '450');
            document.getElementById("h00").setAttribute('y', '390');

            document.getElementById("h01").setAttribute('x', '450');
            document.getElementById("h01").setAttribute('y', '410');

            document.getElementById("h02").setAttribute('x', '450');
            document.getElementById("h02").setAttribute('y', '430');
      }

      function leg_hover() {
        if(cloth_type == "bottom") {
            document.getElementById("h00").innerHTML = "Part : Leg Length";
            document.getElementById("h01").innerHTML = "Set Size : "+cloth_size[result_index];
            document.getElementById("h02").innerHTML = "Difference by "+Math.abs(leg - cloth_leg[result_index])+" cm";
        }

        if(cloth_type == "bottom" && result_index == 100) {
            document.getElementById("h00").innerHTML = "Part : Leg Length";
            document.getElementById("h01").innerHTML = "Set Size : Not provided.";
            document.getElementById("h02").innerHTML = "";
        }
            
            document.getElementById("h00").setAttribute('x', '440');
            document.getElementById("h00").setAttribute('y', '500');

            document.getElementById("h01").setAttribute('x', '440');
            document.getElementById("h01").setAttribute('y', '520');

            document.getElementById("h02").setAttribute('x', '440');
            document.getElementById("h02").setAttribute('y', '540');
        
      }

/*
      // clear cookies
      document.cookie = "cloth=";
      document.cookie = "type=";
*/
    </script>

</body>
</html>

