import {EnemiesController} from "./EnemiesController.js";
import {Model} from "../Model/Model.js";
import {Display} from "../Vue/Display.js";

export class Controller{
    constructor() {
        this.model = new Model();
        this.display = new Display();
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

    updateEnemiesPosition(enemy, nextPosition){
        //Update enemy position within its object (enemy.position) by tick
        const matrice = this.model.getMatrice();
        enemy.position.x = nextPosition[0]
        enemy.position.y = nextPosition[1]
        //supprime enemy dans matrice
        matrice[enemy.position.x][enemy.position.y].enemies.splice(enemy,1)

        // doit ajouter enemy dans matrice a nouvelle position
        this.updateEnemyInMatrice(enemy);
    }
    updateEnemyInMatrice(enemy) {
        //Update enemy in matrice by its position in its object (enemy.position.x / enemy.position.y)
        let matrice = this.model.getMatrice();
        matrice[enemy.position.x][enemy.position.y].enemies.push(enemy);
    }
    setup(){
        this.createEnnemies();
        this.display.initializeGame(this.model.getMatrice());
    }

    async loop(){
        let path = this.model.findPathForWaves(this.model.getMatrice(), this.model.entryPoints, this.model.endPoints)
        for(let enemy of this.enemiesController.enemies){
            console.log(`runing enemy `,enemy)
            this.run(enemy, path);
            await new Promise(r => setTimeout(r, 500));
        }
    }
    
    async run(enemy, path){
        enemy.step += 1;
        this.updateEnemiesPosition(enemy, path[enemy.step]);
        let test = this.display.nextMoveEnemy(enemy)
        test.then(value => {
            if(enemy.step != path.length -1){
                console.log(enemy)
                this.run(enemy, path)
            } else {
                //HELP perte de Live point
                console.log('complete')
            }

        })

    }



}