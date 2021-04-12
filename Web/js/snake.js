    const INITIAL_GAME_SPEED = 70;
    const CANVAS_BACKGROUND_COLOUR = 'white';
    const SNAKE_COLOUR = '#88ac0b';
    const APPLE_COLOUR = 'red';

    const TILE_SIZE = 20;

    let snake;
    // The user's score
    let score;
    // When set to true the snake is changing direction
    let changingDirection;
    // apple x-coordinate
    let appleX;
    // apple y-coordinate
    let appleY;
    // Horizontal velocity
    let dx;
    // Vertical velocity
    let dy;
    //
    let gameSpeed;
    // Get the canvas element
    const gameCanvas = document.getElementById("gameCanvas");
    // Return a two dimensional drawing context
    const ctx = gameCanvas.getContext("2d");

    // Call changeDirection whenever a key is pressed
    document.addEventListener("keydown", changeDirection);

    if(confirm("Click to start the game !")) {
      main();
    }

    /**
     * Main function of the game
     */
    function main() {
      //initialize the game
      initializeGame();
      // Start game
      gameLoop();
    }
    /**
     * Main function of the game
     * called repeatedly to advance the game
     */
    function gameLoop() {

      changingDirection = false;

      moveSnake();

      clearCanvas();
      drawApple();
      drawSnake();

      // If the game ended return early to stop game
      if (didGameEnd()) { endGame(); return; };
      setTimeout(function onTick() {
        // Call game again
        gameLoop();
      }, gameSpeed);
    }
    /**
     * Initialize Game
     */
    function initializeGame() {

      var canvasCenterX = 200;
      var canvasCenterY = gameCanvas.height/2;

      snake = [
        {x: canvasCenterX, y: canvasCenterY},
        {x: canvasCenterX - TILE_SIZE, y: canvasCenterY},
        {x: canvasCenterX - 2*TILE_SIZE, y: canvasCenterY},
        {x: canvasCenterX - 3*TILE_SIZE, y: canvasCenterY},
        {x: canvasCenterX - 4*TILE_SIZE, y: canvasCenterY}
      ]

      // Create the first apple location
      createApple();

      document.getElementById('score').innerHTML = "Score : 0";
      document.getElementById('speed').innerHTML = "Speed : 1";

      score = 0;
      changingDirection = false;
      dx = TILE_SIZE;
      dy = 0;
      gameSpeed = INITIAL_GAME_SPEED;
    }
    /**
     * Returns true if the head of the snake touched another part of the game
     * or any of the walls
     */
    function didGameEnd() {
      for (let i = 4; i < snake.length; i++) {
        if (snake[i].x === snake[0].x && snake[i].y === snake[0].y) return true
      }
      const hitLeftWall = snake[0].x < 0;
      const hitRightWall = snake[0].x > gameCanvas.width - 10;
      const hitToptWall = snake[0].y < 0;
      const hitBottomWall = snake[0].y > gameCanvas.height - 10;
      return hitLeftWall || hitRightWall || hitToptWall || hitBottomWall
    }
    /**
     * 
     */
    function endGame() {

      if(confirm("voulez vous rejouer ?")) {
          main();
      }
    }
    /**
     * Change the background colour of the canvas to CANVAS_BACKGROUND_COLOUR and
     * draw a border around it
     */
    function clearCanvas() {
      //  Select the colour to fill the drawing
      ctx.fillStyle = CANVAS_BACKGROUND_COLOUR;
      // Draw a "filled" rectangle to cover the entire canvas
      ctx.fillRect(0, 0, gameCanvas.width, gameCanvas.height);
    }
    /**
     * Draw the apple on the canvas
     */
    function drawApple() {
      ctx.fillStyle = APPLE_COLOUR;
      ctx.fillRect(appleX, appleY, TILE_SIZE, TILE_SIZE);
    }
    /**
     * Draws the snake on the canvas
     */
    function drawSnake() {
      // loop through the snake parts drawing each part on the canvas
      snake.forEach(drawSnakePart)
    }
    /**
     * Draws a part of the snake on the canvas
     * @param { object } snakePart - The coordinates where the part should be drawn
     */
    function drawSnakePart(snakePart) {
      // Set the colour of the snake part
      ctx.fillStyle = SNAKE_COLOUR;
      // Draw a "filled" rectangle to represent the snake part at the coordinates
      // the part is located
      ctx.fillRect(snakePart.x, snakePart.y, TILE_SIZE, TILE_SIZE);
    }
    /**
     * Generates a random number that is a multiple of 10 given a minumum
     * and a maximum number
     * @param { number } min - The minimum number the random number can be
     * @param { number } max - The maximum number the random number can be
     */
    function randomTen(min, max) {
      return Math.round((Math.random() * (max-min) + min) / TILE_SIZE) * TILE_SIZE;
    }
    /**
     * Creates random set of coordinates for the snake apple.
     */
    function createApple() {
      // Generate a random number the apple x-coordinate
      appleX = randomTen(0, gameCanvas.width - TILE_SIZE);
      // Generate a random number for the apple y-coordinate
      appleY = randomTen(0, gameCanvas.height - TILE_SIZE);
      // if the new apple location is where the snake currently is, generate a new apple location
      snake.forEach(function isAppleOnSnake(part) {
        const appleIsOnSnake = part.x == appleX && part.y == appleY;
        if (appleIsOnSnake) { createApple() };
      });
    }
    /**
     * Advances the snake by changing the x-coordinates of its parts
     * according to the horizontal velocity and the y-coordinates of its parts
     * according to the vertical veolocity
     */
    function moveSnake() {
      // Create the new Snake's head
      const head = {x: snake[0].x + dx, y: snake[0].y + dy};
      // Add the new head to the beginning of snake body
      snake.unshift(head);
      const didEatApple = snake[0].x === appleX && snake[0].y === appleY;
      if (didEatApple) {
        // acclerate the game 
        gameSpeed--;
        // Increase score
        score += 10;

        let speed = INITIAL_GAME_SPEED - gameSpeed;
        // Display score on screen
        document.getElementById('score').innerHTML = "Score : " + score;
        document.getElementById('speed').innerHTML = "Speed : " + speed;
        // Generate new apple location
        createApple();
      } else {
        // Remove the last part of snake body
        snake.pop();
      }
    }
    /**
     * Changes the vertical and horizontal velocity of the snake according to the
     * key that was pressed.
     * The direction cannot be switched to the opposite direction, to prevent the snake
     * from reversing
     * For example if the the direction is 'right' it cannot become 'left'
     * @param { object } event - The keydown event
     */
    function changeDirection(event) {

      const LEFT_KEY = 37;
      const RIGHT_KEY = 39;
      const UP_KEY = 38;
      const DOWN_KEY = 40;
      /**
       * Prevent the snake from reversing
       * Example scenario:
       * Snake is moving to the right. User presses down and immediately left
       * and the snake immediately changes direction without taking a step down first
       */
      if (changingDirection) { return };
      changingDirection = true;
      const keyPressed = event.keyCode;
      const goingUp = dy === -TILE_SIZE;
      const goingDown = dy === TILE_SIZE;
      const goingRight = dx === TILE_SIZE;
      const goingLeft = dx === -TILE_SIZE;

      if (keyPressed === LEFT_KEY && !goingRight) {
        dx = -TILE_SIZE;
        dy = 0;
      }
      if (keyPressed === UP_KEY && !goingDown) {
        dx = 0;
        dy = -TILE_SIZE;
      }
      if (keyPressed === RIGHT_KEY && !goingLeft) {
        dx = TILE_SIZE;
        dy = 0;
      }
      if (keyPressed === DOWN_KEY && !goingUp) {
        dx = 0;
        dy = TILE_SIZE;
      }
    }


