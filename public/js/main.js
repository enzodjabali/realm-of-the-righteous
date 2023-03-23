import {Game} from "./Game.js";
import {Display} from "./Display.js";
let game = new Game();
let display = new Display();
display.displayBoard(game.getMatrice());
