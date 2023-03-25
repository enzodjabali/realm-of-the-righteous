import {Display} from "./Vue/Display.js";
import {Controller} from "./Controller/Controller.js";

let controller = new Controller()

controller.createEnnemies();
let display = new Display();
display.initializeGame(controller.model.getMatrice());

