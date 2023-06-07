import {EnemiesController} from "./EnemiesController.js";
import {TowerController} from "./TowerController.js";
import {HUDController} from "./HUDController.js";
import {Model} from "../Model/Model.js";
import {Display} from "../Vue/Display.js";
import { enumEnemies } from '../Model/enumEnemies.js';
import { PlayerController } from '../Controller/PlayerController.js';
import { FetchController } from '../Controller/FetchController.js';

export class Controller{
    constructor(model) {
        this.model = new Model(model);
        this.display = new Display();
        this.enemiesController = new EnemiesController(this.model);
        this.playerController = new PlayerController("John", 1000, 1);
        this.towerController = new TowerController(this.model, this.display, this.playerController)
        this.HUDController = new HUDController(this.model, this.display, this.towerController, this.playerController)
        this.fetchController = new FetchController(this.towerController, this.model)
    }

    updateEnemiesPosition(enemy, nextPosition){
        /**
         * Permit to update the enemy coordinates
         * @param {Enemy} enemy instance of enemy.
         * @param {number} nextPosition[0] new x coordinate.
         * @param {number} nextPosition[1] new y coordinate.
         */
        const matrice = this.model.getMatrice();

        matrice[enemy.position.x][enemy.position.y].enemies.shift()

        enemy.position.x += nextPosition[0]
        enemy.position.y += nextPosition[1]
        this.updateEnemyInMatrice(enemy);
    }

    updateEnemyInMatrice(enemy) {
        /**
         * Permit to update the matrice with the new enemy coordinates
         * @param {Enemy} enemy instance of enemy.
         */
        //Update enemy in matrice by its position in its object (enemy.position.x / enemy.position.y)
        this.model.matrice[enemy.position.x][enemy.position.y].enemies.push(enemy);
    }

    setup(){
        /**
         * Permit to setup the base board (tiles)
         */
        //display matrice
        this.display.initializeBoard(this.model.getMatrice());

        //update matrice based on fetch from database
        this.fetchController.run()

        setInterval(this.saveModel, 2000, this.model);
    }

    async loop(diffculty){
        /**
         * Main loop of the enemies, permit make them run wioth their logic
         * @param {String} diffculty chosen difficulty.
        */

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
        /**
         * Main loop of the enemies, permit make them run with their logic
         * @param {Enemy} enemy instance of enemy.
         * @param {Enemy} path pathfinding list of cords.
         * @param {Enemy} endPoints couple of end coordinates.
        */

        try {
            for (let step = 0; step <= path.length; step++) {
                // Add your code to handle end of path reached
                if (enemy.position.x == endPoints[0] && enemy.position.y == endPoints[1] ){
                    if(!this.playerController.modifyPlayerLife(1)){
                        // Implémenter la fin de jeu (défaite)
                        // alert('endgame')
                    }
                    this.display.removeEnemy(enemy);
                    this.model.matrice[enemy.position.x][enemy.position.y].enemies.splice(enemy, 1)
                    return
                }

                if (path[step][1] < 0){
                    this.display.flipItLeft(enemy);
                }
                if (path[step][1] > 0){
                    this.display.flipItLeftRight(enemy);
                }

                if (enemy.curent_life <= 0){
                    // Permit to give money to the player when an ennemy died
                    this.playerController.player.money += enemy.price;
                    this.display.updatePlayerData(this.playerController.player.money, this.playerController.player.life);
                    this.display.removeEnemy(enemy);
                    this.model.matrice[enemy.position.x][enemy.position.y].enemies.shift()
                    return;
                }

                if (step <= path.length-1) {
                    //this one ok GET RETURN ENEMY TO REFRESH ????
                    await this.updateEnemiesPosition(enemy, path[step]); // Await the update of the enemy's position
                    await this.display.updateEnemyHealthBar(enemy);
                }
                await this.display.nextMoveEnemy(enemy, path[step]); // Await the next move of the enemy using the nextMoveEnemy() method
            }

        } catch (error) {
            // Handle any errors that may occur during the enemy's movement
            console.error('Error:', error);
        }
    }
    saveModel(model) {
        model = JSON.stringify(model);
        /**
        * This function calls the update game model method
        */
        $(function () {
            let gameId = new URLSearchParams(window.location.search).get('game_id');
            $.post("api/UpdateGameModel.php", { gameId: gameId, newModel: model}, function (response) {
                if (response === "1") {
                    console.log('Game saved')                    
                } else {
                    console.log(response)
                }
            });
            return false;
        });
    }
}