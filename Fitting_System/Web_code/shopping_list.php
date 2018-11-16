<?php
/*
Plugin Name: shopping_list
Description: show shopping list 
Version: 1.0
Author: YouMinJung
License: SeeU
*/

session_start();

?>

<title>Shopping List</title>
<meta charset="utf-8">

    <style>
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

      fieldset {
        border-radius:20px; 
        border-style:dotted;
      }
      
    </style>

    <script type="text/javascript">

      // Create a new blank image.
      var image0 = new Image(); 
      var image1 = new Image();
      var image2 = new Image();
      var image3 = new Image();
      var image4 = new Image();
      var image5 = new Image();
      var image6 = new Image();
      
      // Load the image and display it.
      function displayImage() {
        canvas0 = document.getElementById("Canvas0");
        canvas1 = document.getElementById("Canvas1");
        canvas2 = document.getElementById("Canvas2");
        canvas3 = document.getElementById("Canvas3");
        canvas4 = document.getElementById("Canvas4");
        canvas5 = document.getElementById("Canvas5");
        canvas6 = document.getElementById("Canvas6");

        // Make sure you got it.
        if (canvas0.getContext) {
            ctx0 = canvas0.getContext("2d");

            // When the image is loaded, draw it.
            image0.onload = function() {
              ctx0.font = "bold 10pt Batang";
              ctx0.fillText("T-shirt", 120, 10);
              //drawImage (image sx, sy, sWidth, sHeight, dx, dy, dWidth, dHeight)
              ctx0.drawImage(image0, 45, 30, 200, 200);
            }

            // Define the source of the image.
            image0.src = "cloth/Mtsh0.GIF";
        }

        if (canvas1.getContext) {
            ctx1 = canvas1.getContext("2d");

            // When the image is loaded, draw it.
            image1.onload = function() {
              ctx1.font = "bold 10pt Batang";
              ctx1.fillText("Pants", 120, 10);
              //drawImage (image sx, sy, sWidth, sHeight, dx, dy, dWidth, dHeight)
              ctx1.drawImage(image1, 45, 30, 200, 200);
            }

            // Define the source of the image.
            image1.src = "cloth/Mpan0.GIF";
        }

        if (canvas2.getContext) {
            ctx2 = canvas2.getContext("2d");

            // When the image is loaded, draw it.
            image2.onload = function() {
              ctx2.font = "bold 10pt Batang";
              ctx2.fillText("Pants", 120, 10);
              //drawImage (image sx, sy, sWidth, sHeight, dx, dy, dWidth, dHeight)
              ctx2.drawImage(image2, 45, 30, 200, 200);
            }

            // Define the source of the image.
            image2.src = "cloth/Mpan1.GIF";
        }

        if (canvas3.getContext) {
            ctx3 = canvas3.getContext("2d");

            // When the image is loaded, draw it.
            image3.onload = function() {
              ctx3.font = "bold 10pt Batang";
              ctx3.fillText("Top Cloth", 120, 10);
              //drawImage (image sx, sy, sWidth, sHeight, dx, dy, dWidth, dHeight)
              ctx3.drawImage(image3, 30, 30, 250, 200);
            }

            // Define the source of the image.
            image3.src = "cloth/Wsh0.GIF";
        }

        if (canvas4.getContext) {
            ctx4 = canvas4.getContext("2d");

            // When the image is loaded, draw it.
            image4.onload = function() {
              ctx4.font = "bold 10pt Batang";
              ctx4.fillText("Pants", 120, 10);
              //drawImage (image sx, sy, sWidth, sHeight, dx, dy, dWidth, dHeight)
              ctx4.drawImage(image4, 30, 30, 200, 250);
            }

            // Define the source of the image.
            image4.src = "cloth/Wpan0.GIF";
        }

        if (canvas5.getContext) {
            ctx5 = canvas5.getContext("2d");

            // When the image is loaded, draw it.
            image5.onload = function() {
              ctx5.font = "bold 10pt Batang";
              ctx5.fillText("Skirt", 120, 10);
              //drawImage (image sx, sy, sWidth, sHeight, dx, dy, dWidth, dHeight)
              ctx5.drawImage(image5, 45, 30, 200, 250);
            }

            // Define the source of the image.
            image5.src = "cloth/sk0.GIF";
        }

        if (canvas6.getContext) {
            ctx6 = canvas6.getContext("2d");

            // When the image is loaded, draw it.
            image6.onload = function() {
              ctx6.font = "bold 10pt Batang";
              ctx6.fillText("Skirt", 120, 10);
              //drawImage (image sx, sy, sWidth, sHeight, dx, dy, dWidth, dHeight)
              ctx6.drawImage(image6, 45, 30, 200, 250);
            }

            // Define the source of the image.
            image6.src = "cloth/sk1.GIF";
        }


        var b0 = document.getElementById("b0");
        var b1 = document.getElementById("b1");
        var b2 = document.getElementById("b2");
        var b3 = document.getElementById("b3");
        var b4 = document.getElementById("b4");
        var b5 = document.getElementById("b5");
        var b6 = document.getElementById("b6");

        // click event
        b0.onclick = function() {
              document.cookie = "cloth = Mtsh0";
              document.cookie = "type = top";
              alert('Complete to choose cloth. << Man T-shirt 0 >>');
              location.replace('fitting_result.php'); 
        }

        b1.onclick = function() {
              document.cookie = "cloth = Mpan0";
              document.cookie = "type = bottom";
              alert('Complete to choose cloth. << Man Pants 0 >>');
              location.replace('fitting_result.php');
        }

        b2.onclick = function() {
              document.cookie = "cloth = Mpan1";
              document.cookie = "type = bottom";
              alert('Complete to choose cloth. << MAn Pants 1 >>');
              location.replace('fitting_result.php');
        }

        b3.onclick = function() {
              document.cookie = "cloth = Wsh0";
              document.cookie = "type = top";
              alert('Complete to choose cloth. << Woman shirts 0 >>');
              location.replace('fitting_result.php');
        }

        b4.onclick = function() {
              document.cookie = "cloth = Wpan0";
              document.cookie = "type = bottom";
              alert('Complete to choose cloth. << Woman Pants 0 >>');
              location.replace('fitting_result.php');
        }

        b5.onclick = function() {
              document.cookie = "cloth = sk0";
              document.cookie = "type = bottom";
              alert('Complete to choose cloth. << Skirt 0 >>');
              location.replace('fitting_result.php');
        }

        b6.onclick = function() {
              document.cookie = "cloth = sk1";
              document.cookie = "type = bottom";
              alert('Complete to choose cloth. << Skirt 1 >>');
              location.replace('fitting_result.php');
        }
      }

    </script>
  
  <body onload="displayImage()">
    <h1>SHOPPING MALL</h1>
    <p style="color: red"> * Choose what you want to buy. * </p>
    <br>
    <p> << MAN >> </p>
    <fieldset>
      <p> Top </p><br>
      <canvas id="Canvas0" width="300" height="250"> </canvas>
      <button class="button" id="b0" style="position: relative; top: 25px; right : 210px;">Choose</button>
    </fieldset>
    <br><br>

    <fieldset>
      <p> * Bottom </p><br>
      <canvas id="Canvas1" width="300" height="250"> </canvas>
      <button class="button" id="b1" style="position: relative; top: 25px; right : 210px;">Choose</button>
      <canvas id="Canvas2" width="300" height="250"> </canvas>
      <button class="button" id="b2" style="position: relative; top: 25px; right : 210px;">Choose</button>
    </fieldset>
    <br><br>
    
    <p> << WOMAN >> </p>
    <fieldset>
      <p> * Top </p><br>
      <canvas id="Canvas3" width="300" height="250"> </canvas>
      <button class="button" id="b3" style="position: relative; top: 25px; right : 210px;">Choose</button>
    </fieldset>
    <br><br>

    <fieldset>
      <p> * Bottom </p><br>
      <canvas id="Canvas4" width="300" height="300"> </canvas>
      <button class="button" id="b4" style="position: relative; top: 25px; right : 220px;">Choose</button>
      <canvas id="Canvas5" width="300" height="300"> </canvas>
      <button class="button" id="b5" style="position: relative; top: 25px; right : 210px;">Choose</button>
      <canvas id="Canvas6" width="300" height="300"> </canvas>
      <button class="button" id="b6" style="position: relative; top: 25px; right : 210px;">Choose</button>
    </fieldset>

    <br><br><br>
  </body>
