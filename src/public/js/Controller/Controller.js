import {EnemiesController} from "./EnemiesController.js";
import {TowerController} from "./TowerController.js";
import {HUDController} from "./HUDController.js";
import {Model} from "../Model/Model.js";
import {Display} from "../Vue/Display.js";
import {enumEnemies} from '../Model/enumEnemies.js';

export class Controller{
    constructor() {
        this.model = new Model();
        this.display = new Display();
        this.enemiesController = new EnemiesController(this.model);
        this.towerController = new TowerController(this.model, this.display)
        this.HUDController = new HUDController(this.model, this.display, this.towerController)
    }
    
    updateEnemiesPosition(enemy, nextPosition){
        //Update enemy position within its object (enemy.position) by tick
        const matrice = this.model.getMatrice();

        enemy.position.x += nextPosition[0]
        enemy.position.y += nextPosition[1]

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
        this.display.initializeBoard(this.model.getMatrice());
    }

    async loop(diffculty){
        // Find path for waves using model's matrice, entry and end points

        console.log('wait timeBeforeStart', this.model.timeBeforeStart)
        await new Promise(r => setTimeout(r, this.model.timeBeforeStart));
                

        for(let waves of this.model.waves[diffculty]){
            if (this.model.waves[diffculty].indexOf(waves) != 0)
                {console.log('wait timeBetweenWaves', this.model.timeBetweenWaves)
                await new Promise(r => setTimeout(r, this.model.timeBetweenWaves));
                }
                this.model.currentWave++;

            for (let group of waves){
                if (waves.indexOf(group) != 0)
                    {console.log('wait timeBetweenGroups', this.model.timeBetweenGroups)
                    await new Promise(r => setTimeout(r, this.model.timeBetweenGroups));
                    }
                this.model.currentGroup++;

                let indexOfEntryPoints = (waves.indexOf(group)) % (this.model.entryPoints.length);
                let indexOfEndPoints = (waves.indexOf(group)) % (this.model.endPoints.length);
                let path = this.model.findPathForWaves(this.model.getMatrice(), this.model.entryPoints[indexOfEntryPoints], this.model.endPoints[indexOfEndPoints]);

                if(path == 0){
                    console.log('can not find path')
                    return
                }
                for (let mob = 0; mob < group[0]; mob++){

                    /*console.log('path')
                    console.log(path)*/

                    let enemy = this.enemiesController.createEnnemyObject(this.model.mobId, enumEnemies, path, this.model.entryPoints[indexOfEntryPoints], group[1])

                    this.display.initializeEnemy(enemy);
                    
                    this.run(enemy, path, this.model.endPoints[indexOfEndPoints]); // Run the movement loop for each enemy
                    await new Promise(r => setTimeout(r, 500)); // Delay 500ms between each enemy's movement for smoother animation
                    this.model.mobId++;
                }
            }
        }
    }

    async run(enemy, path, endPoints) {
        try {
            for (let step = 0; step <= path.length; step++) {
                // Add your code to handle end of path reached
                if (enemy.position.x == endPoints[0] && enemy.position.y == endPoints[1] ){
                    console.log('-1 pv - end reach - enemy dead', enemy.typeOfEnemies);                    
                    this.display.removeEnemy(enemy);
                    this.model.matrice[enemy.position.x][enemy.position.y].enemies.splice(enemy,1)
                    return
                }

                if (path[step][1] < 0){
                    this.display.flipItLeft(enemy);
                }
                if (path[step][1] > 0){
                    this.display.flipItLeftRight(enemy);
                }

                if (enemy.life <= 0){
                    console.log('enemy killed');                    
                    this.display.removeEnemy(enemy);
                    this.model.matrice[enemy.position.x][enemy.position.y].enemies.splice(enemy,1)
                    return
                }

                if (step <= path.length-1) {
                    await this.updateEnemiesPosition(enemy, path[step]); // Await the update of the enemy's position
                } 

                await this.display.nextMoveEnemy(enemy, path[step]); // Await the next move of the enemy using the nextMoveEnemy() method
            }

        } catch (error) {
            // Handle any errors that may occur during the enemy's movement
            console.error('Error:', error);
        }
    }
}