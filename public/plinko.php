
<!DOCTYPE html><html lang="en"><head>
    <script src="libraries/p5.js"></script>
    <script src="libraries/p5.dom.min.js"></script>
    <script src="libraries/p5.sound.min.js"></script>
    <script src="libraries/matter.js"></script>
    <script src="js/ground.js"></script>
    <script src="js/divisions.js"></script>
    <script src= "js/Plinko.js"></script>
    <script src = "js/Particle.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <meta charset="utf-8">
    <style type="text/css">
      html, body {
        margin: 0;
        padding: 0;
      }
      canvas {
        transform-origin: left top;
        transform: scale(1.0);
      } 
    </style>
  </head>
  <body>
    <script src="sketch.js?v=1"></script>

    <div style="width: 600px;height: 800px;background: red;position: relative;" id="insertCanvas"></div>
    <div style="position: absolute;top:100px;left: 800px;">
      <input type="number" id="PosX" name="">
      <button onclick="go()">GO</button>
    </div>
    <script type="text/javascript">
      var radius = 12 * 600 / 600
      function go() {
        PosX = Number($('#PosX').val())
        particles.push(new Particle(PosX, 0,radius));
      }
    </script>
</body></html>