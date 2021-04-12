const gameCanvas = document.getElementById("gameCanvas");
const context = gameCanvas.getContext("2d");

const TILE_SIZE = 20;
const CANVAS_COLOUR = 'white';

const UP = 0;
const DOWN = 1;
const LEFT = 2;
const RIGHT = 3;

var gameOver;
var platformCollection;
var platformTimer;
var platformSpeed;
var charactere;
var chrono;
/** 
 * 
 */
class Charactere {

  constructor() {
    this.colour = '#88ac0b';
    this.width = TILE_SIZE;
    this.height = TILE_SIZE;
    this.x = 100;
    this.y = 100;
    this.x_velocity = 0;
    this.y_velocity = 0;
    this.jumping = true;
  }

  move() {
    this.x += this.x_velocity;
    if(this.x < 0) {
      this.x = 0;
      this.x_velocity = 0;
    } else if (this.x + this.width > gameCanvas.width) {
      this.x = gameCanvas.width - TILE_SIZE;
      this.x_velocity = 0;
    }
  }

  update() { 

    if (controller.left) {
      if(!this.checkCollision(LEFT)) {
        this.x_velocity -= 0.5;
      } else { this.x_velocity = 0; }
    }

    if (controller.right) {
      if(!this.checkCollision(RIGHT)) {
        this.x_velocity += 0.5;
      } else { this.x_velocity = 0; }
    }

    this.move();
    this.x_velocity *= 0.9;// friction

    if (controller.up && !this.jumping) {
      this.jump();
    } else {
      this.y_velocity += 1.5;// gravity
      this.y += charactere.y_velocity;
      this.y_velocity *= 0.9;// friction

      if (this.checkCollision(DOWN)) {
        this.jumping = false;
        this.y_velocity = 0;
      } else if(this.checkCollision(UP)) {
        this.y_velocity = 0;
      } 
    }
  }

  jump() {
    controller.up = false;
    this.y_velocity -= 30;
    this.jumping = true;
    this.y += this.y_velocity;
    this.y_velocity *= 0.9;// friction
  }

  hasFall() {
    if(this.y >= gameCanvas.height) {
      return true;
    }

    return false;
  }

  draw() {
    context.fillStyle = this.colour;
    context.fillRect(this.x, this.y, this.width, this.height);
  }

  checkCollision(direction) {

    var onGround = false;
    platformCollection.forEach(platform => { 

      if(this.x < platform.x + platform.width && this.x + this.width > platform.x &&
      this.y < platform.y + platform.height && this.height + this.y > platform.y) {

        switch(direction) {
          case UP:
            if(this.y > platform.y ) {
              this.y = platform.y - this.height;
              onGround = true;
              return;
            }
          break;
          case DOWN:
            if(this.y < platform.y) {
              this.y = platform.y - this.height;
              onGround = true;
              return;
            }
          break;
          case LEFT:
            if(this.x > platform.x) {
              this.X = platform.y + platform.width;
              onGround = true;
              return;
            }
          break;
          case RIGHT:
            if(this.x < platform.x) {
              this.y = platform.y - this.width;
              onGround = true;
              return;
            }
          break;
        }
      }
    });

    return onGround;
  }
}
/**
 * 
 */
class Platform {

  constructor(width) {
    this.colour = '#CCC';
    this.width = width;
    this.height = TILE_SIZE;
    this.x = 0;
    this.y = 0; // Toujours 0 au début
  }

  move() {
  }

  update() {
    this.x -= platformSpeed;
    charactere.checkCollision(RIGHT);
  }

  draw() {
    context.fillStyle = this.colour;
    context.fillRect(this.x, this.y, this.width, this.height);
  }
}
/**
 * 
 */
class Chrono {

  constructor() {
    this.timerID = 0;
    this.chrono = 0;
    this.startTime = 0;
  }

  update() {
    var now = new Date();

    this.chrono = now.getTime() - this.startTime.getTime();
    this.draw();
  }

  draw() {
    var min = Math.trunc(this.chrono / 60000);
    var sec = Math.trunc((this.chrono % 60000) / 1000);
    var mili = (this.chrono % 60000) % 1000;

    if (min < 10){
      min = "0" + min;
    }

    if (sec < 10){
      sec = "0" + sec;
    }

    if (mili < 10){
      mili = "00" + sec;
    }

    document.getElementById("chronotime").innerHTML = min + ":" + sec + ":" + mili;
  }

  start() {
    this.startTime = new Date();
    this.update();
  }

  stop() {
    delete this.startTime;
    delete this.timerID;

  }

  reset() {
    document.getElementById("chronotime").innerHTML = "0:00:00";
  }
}
/**
 * 
 */
controller = {
  repeat:false,
  left:false,
  right:false,
  up:false,
  keyDownListener:function(event) {

    controller.up = false;

    switch(event.keyCode) {
      case 37:// left key
        controller.left = true;
      break;
      case 32:// up key
        if(!controller.repeat) {
          controller.up = true;
          controller.repeat = true;
        } else { controller.up = false; } 
      break;
      case 39:// right key
        controller.right = true;
      break;
    }
  },
  keyUpListener:function(event) {

    switch(event.keyCode) {
      case 37:// left key
        controller.left = false;
      break;
      case 32:// up
          controller.up = false;
          controller.repeat = false;
      break;
      case 39:// right key
        controller.right = false;
      break;
    }
  },
  reset:function() {
    controller.repeat = false;
    controller.left = false;
    controller.right = false;
    controller.up = false;
  }
};

window.addEventListener("keydown", controller.keyDownListener);
window.addEventListener("keyup", controller.keyUpListener);
/**
 * 
 */
gameLoop = function () {

  charactere.update();
  platformCollection.forEach(platform => { platform.update(); });

  if (charactere.hasFall()) {
      gameOver = true;
  }

  chrono.update();

  clearCanvas();
  charactere.draw();
  platformCollection.forEach(platform => { platform.draw(); });

  if (gameOver) { 
    endGame();
    return; 
  }

  window.requestAnimationFrame(gameLoop);
}

main();

function main() {

  initialize();
  gameLoop();
}
/**
 * 
 */
function initialize() {

  controller.reset();

  gameOver = false;
  platformSpeed = 2;
  var platform1 = new Platform(gameCanvas.width);
  platform1.x = 0;
  platform1.y = 220;

  chrono = new Chrono();
  chrono.reset();
  chrono.start();

  charactere = new Charactere();

  platformCollection = [platform1];

  generatePlatform();
}
/**
 * 
 */
function endGame() {

  chrono.stop();
  delete chrono;
  delete charactere;
  delete platformCollection;
  window.clearTimeout(platformTimer);
  cancelAnimationFrame(gameLoop);

  if(confirm("Time : " + document.getElementById("chronotime").innerHTML + "\nVoulez vous rejouez ?")) {
    main();
  }
}
/**
 * 
 */
function clearCanvas() {

  context.fillStyle = CANVAS_COLOUR;
  context.fillRect(0, 0, gameCanvas.width, gameCanvas.height);
}
/**
 * 
 */
function generatePlatform() {

  var newPlatform = new Platform(randomTen(40, 100));
  newPlatform.y = randomTen(TILE_SIZE*2, gameCanvas.height-TILE_SIZE);
  newPlatform.x = gameCanvas.width;

  platformCollection.push(newPlatform);

  platformTimer = setTimeout(function onTick() { generatePlatform(); }, randomTen(400, 800));
}
/**
 * 
 */
function randomTen(min, max) {
      return Math.round((Math.random() * (max-min) + min) / TILE_SIZE) * TILE_SIZE;
}


