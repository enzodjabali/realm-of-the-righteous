import {Model} from "./Model/Model.js";
import {Display} from "./Vue/Display.js";
let game = new Model();
let display = new Display();
display.displayBoard(game.getMatrice());
