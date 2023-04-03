import {EnemiesController} from "./EnemiesController.js";
import {Model} from "../Model/Model.js";
import {Display} from "../Vue/Display.js";

export class Controller{
    constructor() {
        this.model = new Model();
        this.enemiesController = new EnemiesController(this.model);
    }
    createEnnemies(){
        // Creates enemies with this.waves.
        //ID of each enemy
        let id = 0;
        let waves = this.model.getWaves()
        for(var wave of waves){
            //For each wave of enemies
            for(var groups of wave)
                // For each type of enemy + its quantity
                for(let test = 0; test < groups[0]; test++){
                    this.enemiesController.createEnemiesIntoToPlaceList(id, groups[1])
                    id++;
                }
            //Implement a win wave condition
        }
        this.enemiesController.placeEnemiesInMatrice();
    }

    updateEnemies(){
        //Probleme avec la liste du chemin pathfinding revoir avec baba HELP ME
        let matrice = this.model.getMatrice()
        let newMatrice = matrice;
        for (let x = 0 ; x < matrice.length; x++){
            for (let y = 0 ; y < matrice[x].length; y++){
                for (let j = 0 ; matrice[x][y].enemies.length > j ; j++){
                    // Moving Monster down by 1
                    let movingMonster = matrice[x][y].enemies[j]

                    newMatrice[x][y].enemies.splice(j)

                    // newMatrice[x][y+1].enemies.push(movingMonster)
                    console.log(newMatrice[x][y+1])
                }
            }
        }


        //console.log(this.model.getMatrice())
        this.model.updateMatrice(newMatrice);
        //console.log(this.model.getMatrice())
    }

    run(){
        this.createEnnemies();
        let display = new Display();
        display.initializeGame(this.model.getMatrice());
        this.updateEnemies()
        display.nextMoveEnemies(this.model.getMatrice())
    }

}