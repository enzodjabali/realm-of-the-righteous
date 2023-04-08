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
        // ID of each enemy
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

    updateEnemiesPosition(){
        //Update enemy position within its object (enemy.position) by tick
        let enemiesToMove = [];
        const matrice = this.model.getMatrice();
        console.log(matrice)
        for (let x = 0 ; x < matrice.length; x++){
            for (let y = 0 ; y < matrice[x].length; y++){
                for(let j = matrice[x][y].enemies.length - 1; j >= 0; j--){
                    let enemy = matrice[x][y].enemies[0];
                    enemy.position.y += 0 // put the path finding function here
                    matrice[x][y].enemies.splice(enemy,1)
                    enemiesToMove.push(enemy);
                }
            }
        }
        this.updateEnemyInMatrice(enemiesToMove);
    }
    updateEnemyInMatrice(enemiesToMove) {
        //Update enemy in matrice by its position in its object (enemy.position.x / enemy.position.y)
        let matrice = this.model.getMatrice()
        enemiesToMove.map(data => {
            matrice[data.position.x][data.position.y].enemies.push(data);
        })
    }

    run(){
        this.createEnnemies();
        let display = new Display();
        display.initializeGame(this.model.getMatrice());
        // this.updateEnemiesPosition()
        display.nextMoveEnemies(this.model.getMatrice())
        // Probleme : si la position de départ n'est pas 0,0 --> se déplace automatiquement dès le départ (x,y inversé ?? )
    }
}