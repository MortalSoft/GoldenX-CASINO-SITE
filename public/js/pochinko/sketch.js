var Engine = Matter.Engine,
World = Matter.World,
Events = Matter.Events,
Bodies = Matter.Bodies;

var particles = [];
var plinkos = [];
var divisions =[];

var score = 0;
var lunok = 16;

function setup() {
  createCanvas(600, 800);
  engine = Engine.create();
  world = engine.world;

  var rastPlinkoW = 37.5 * width / 600
  var otsPlinko = 65 * width / 600
  var radiusPlinko = 4 * width / 600
  var rastPlinkoH = 35 * width / 600 

  var divisionHeight=otsPlinko;

  // ground = new Ground(width/2,height,width,20);
  ground_left = new Ground(0,height / 2,2,height);
  ground_right = new Ground(width,height / 2,2,height);


  for (var i = 0; i < lunok - 1; i++) {
    pos_x = width / lunok * (i + 1)
    divisions.push(new Divisions(pos_x, height-divisionHeight/2, radiusPlinko, divisionHeight));

    divisions.push(new Divisions(pos_x, 0, radiusPlinko, divisionHeight));
  }


   // Делаем пины, от которых отскакивают шарики
   for (var i = 0; i <= 10 * 2 - 1; i++) {
    plus = rastPlinkoH * i + otsPlinko
    if(i % 2 == 0){
      pos_sm = rastPlinkoW / 2
    }else{
      pos_sm = 0
    }

    if(i < 19){
      plinkos.push(new Plinko(width - rastPlinkoW / 2 + rastPlinkoW / 4,plus - rastPlinkoH / 2, radiusPlinko, '#31251A'));
      plinkos.push(new Plinko(rastPlinkoW / 2 - rastPlinkoW / 4,plus - rastPlinkoH / 2, radiusPlinko, '#31251A'));
    }

    for (var j = pos_sm; j <= width - 0; j=j+rastPlinkoW) 
    {
      plinkos.push(new Plinko(j,plus, radiusPlinko, '#7e6752'));
    }
  }

    // Конец


  }



  function draw() {
    background("#31251A");
    textSize(20)
    text("1",5,20);
    text("2",45,20);
    text("3",85,20);
    text("4",125,20);
    text("5",165,20);
    text("6",205,20);
    text("7",245,20);
    text("8",285,20);
    text("9",320,20);
    text("10",345,20);
    text("11",385,20);
    text("12",420,20);
    text("13",455,20);
    text("14",495,20);
    text("15",535,20);
    text("16",575,20);

    text("1",5,770);
    text("2",45,770);
    text("3",85,770);
    text("4",125,770);
    text("5",165,770);
    text("6",205,770);
    text("7",245,770);
    text("8",285,770);
    text("9",320,770);
    text("10",345,770);
    text("11",385,770);
    text("12",420,770);
    text("13",455,770);
    text("14",495,770);
    text("15",535,770);
    text("16",575,770);

    Engine.update(engine);
    // ground.display();
    ground_left.display();
    ground_right.display();

    for (var i = 0; i < plinkos.length; i++) {

     plinkos[i].display();

   }


   for (var j = 0; j < particles.length; j++) {

     particles[j].display();
     position = particles[j].body.position
     // console.log(position)
     if(position.y > 778){
      // particles[j].destroy();
      particles = [];
      infoPachinko(informationPachinko)
     }

   }
   for (var k = 0; k < divisions.length; k++) {

     divisions[k].display();
   }
 }



