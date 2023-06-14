import {EnemiesController} from "./EnemiesController.js";
import {TowerController} from "./TowerController.js";
import {HUDController} from "./HUDController.js";
import {Model} from "../Model/Model.js";
import {Display} from "../Vue/Display.js";
import { enumEnemies } from '../Model/enumEnemies.js';
import { PlayerController } from '../Controller/PlayerController.js';
import { FetchController } from '../Controller/FetchController.js';
let gameId = new URLSearchParams(window.location.search).get('gameId');
export class Controller{
    constructor(model) {
        this.model = new Model(model);
        this.display = new Display();
        this.enemiesController = new EnemiesController(this.model);
        this.playerController = new PlayerController(this.model.defaultMoneyPlayer[this.model.difficulty], this.model.defaultLifePlayer[this.model.difficulty], this.model, this.display);
        this.towerController = new TowerController(this.model, this.display, this.playerController)
        this.HUDController = new HUDController(this.model, this.display, this.towerController, this.playerController)
        this.fetchController = new FetchController(this.towerController, this.model)

        this.indexOfEntryPoints;
        this.indexOfEndPoints;
    }

    updateEnemiesPosition(enemy, nextPosition){
        /**
         * Permit to update the enemy coordinates in object and in matrice
         * @param {Enemy} enemy instance of enemy.
         * @param {number} nextPosition[0] new x coordinate.
         * @param {number} nextPosition[1] new y coordinate.
         */
        this.model.matrice[enemy.position.x][enemy.position.y].enemies.shift()
        enemy.position.x += nextPosition[0]
        enemy.position.y += nextPosition[1]
        this.model.matrice[enemy.position.x][enemy.position.y].enemies.unshift(enemy);

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
        this.display.updatePlayerData(this.playerController.player.money, this.playerController.player.life, this.playerController.player.killedEnemies, this.model.currentWave, this.model.currentWave);
        await new Promise(r => setTimeout(r, this.model.timeBeforeStart));
        let spawnedEnemies = 0;
        for(let i = this.model.currentWave; i < this.model.waves[diffculty].length; i++){

            await new Promise((resolve, reject) => {
                        document.getElementById("play-game").onclick = () => {
                            if(spawnedEnemies == 0 && this.model.currentWave < this.model.waves[diffculty].length) {
                                this.playerController.postLogs("New wave is coming!", 1)
                                this.display.updatePlayerData(this.playerController.player.money, this.playerController.player.life, this.playerController.player.killedEnemies, this.model.currentWave, this.model.currentWave);
                                resolve()
                            } else {
                                this.playerController.postLogs("You must end this wave first..", 1)
                            }
                        }
                 })
            let song;
            this.model.difficulty == "hard" ? song = "hardMusic" : song = "easyMusic"
            this.display.playSong(true, song)
            for (let group of this.model.waves[diffculty][i]){
                if (this.model.waves[diffculty][i].indexOf(group) != 0)
                {
                    console.log('wait timeBetweenGroups', this.model.timeBetweenGroups)
                    await new Promise(r => setTimeout(r, this.model.timeBetweenGroups));
                }

                this.model.currentGroup++;

                this.indexOfEntryPoints = (this.model.waves[diffculty][i].indexOf(group)) % (this.model.entryPoints.length);
                this.indexOfEndPoints = (this.model.waves[diffculty][i].indexOf(group)) % (this.model.endPoints.length);

                this.HUDController.setStartPoints(this.indexOfEntryPoints)
                this.HUDController.setEndPoints(this.indexOfEndPoints)
                
                let path = this.model.findPathForWaves(this.model.getMatrice(), this.model.entryPoints[this.indexOfEntryPoints], this.model.endPoints[this.indexOfEndPoints]);

                if(path == 0){
                    console.log('can not find path')
                    return
                }

                for (let mob = 0; mob < group[0]; mob++){
                    spawnedEnemies++;
                    let enemy = this.enemiesController.createEnnemyObject(this.model.mobId, enumEnemies, path, this.model.entryPoints[this.indexOfEntryPoints], group[1])
                    this.display.initializeEnemy(enemy);
                    let test = this.run(enemy, path, this.model.endPoints[this.indexOfEndPoints])
                        .then((test) => {
                            if(!test){
                                spawnedEnemies--;
                                if(spawnedEnemies == 0){
                                    this.display.stopSong();
                                    if(i == this.model.waves[diffculty].length-1 && this.playerController.player.life > 0){
                                        this.endGame(true)
                                    } else {
                                        this.display.playSong(false, "gainXp");
                                        this.model.currentWave++
                                    }
                                }
                            }
                        })
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
                this.HUDController.calculateGoldPerMinute()
                // Add your code to handle end of path reached
                if (enemy.position.x == endPoints[0] && enemy.position.y == endPoints[1] ){
                    if(!this.playerController.modifyPlayerLife(1)){
                        this.display.updatePlayerData(this.playerController.player.money, this.playerController.player.life, this.playerController.player.killedEnemies, this.model.currentWave, this.model.currentWave)
                        // Implémenter la fin de jeu (défaite)
                        console.log("passin false thru end game")
                        this.endGame(false)

                    }
                    this.display.updatePlayerData(this.playerController.player.money, this.playerController.player.life, this.playerController.player.killedEnemies, this.model.currentWave, this.model.currentWave)
                    this.display.removeEnemy(enemy);

                    this.model.matrice[enemy.position.x][enemy.position.y].enemies.filter(enemy => enemy.id !== enemy.id);
                    break;
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
                    this.model.defaultMoneyPlayer[this.model.difficulty] = this.playerController.player.money

                    this.playerController.player.killedEnemies++
                    this.model.killedEnemies = this.playerController.player.killedEnemies;
                    this.display.updatePlayerData(this.playerController.player.money, this.playerController.player.life, this.playerController.player.killedEnemies, this.model.currentWave);
                    this.display.removeEnemy(enemy);
                    this.model.matrice[enemy.position.x][enemy.position.y].enemies.filter(enemy => enemy.id !== enemy.id);

                    return false;
                }

                if (step <= path.length - 1) {
                    //Ici update la liste de step enemy si rock trouvé
                    try {
                        if (this.model.matrice[enemy.position.x + path[step][0]][enemy.position.y + path[step][1]].tower.type == "rock") {
                            let newPath = this.model.findPathForWaves(this.model.matrice, [enemy.position.x, enemy.position.y], this.model.endPoints[this.indexOfEndPoints])
                            enemy.path = newPath;
                            enemy.step = 0;
                            path = newPath;
                            step = -1;
                            endPoints = this.model.endPoints[this.indexOfEndPoints]
                            continue;
                        }
                    } catch (error) {
                        this.updateEnemiesPosition(enemy, path[step]); // Await the update of the enemy's position
                        await this.display.updateEnemyHealthBar(enemy);
                    }
                }
                await this.display.nextMoveEnemy(enemy, path[step]); // Await the next move of the enemy using the nextMoveEnemy() method
            }

        } catch (error) {
            // Handle any errors that may occur during the enemy's movement
            console.error('Error:', error);
        }
    }
    saveModel(model, playerValue) {
        for (let i = 0; i < model.matrice.length; i++) {
            for (let j = 0; j < model.matrice[i].length; j++) {
                model.matrice[i][j].enemies = [];
            }
        }
        model = JSON.stringify(model);
        /**
         * This function calls the update game model method
         */
        $(function () {

            $.post("api/v1/game/updateModel", { gameId: gameId, newModel: model}, function (response) {
                if (response["response"] === true) {
                    console.log('Game saved')
                } else {
                    console.log(response)
                }
            });
            return false;
        });
    }
    endGame(bool){
        if(bool){
            //win case
            $(`.game-over-background`).removeClass("game-over-background");
            document.getElementById("game-over-title").innerText = "Congratulation!"
            document.getElementById("game-over-speech").innerHTML = "<p>As the sun began to set, the player, a seasoned strategist, stood resolute atop their towering fortress. Waves of relentless enemies surged forward, their forces no match for the player's well-placed defenses. The player fought fiercely, commanding their troops with unwavering determination and tactical brilliance. With each passing wave, the enemies grew weaker and more desperate. <span style='color:green'> Finally, as the dust settled, the player stood triumphant, their fortress standing tall and unscathed.</span> The enemies lay defeated, scattered in disarray, as the player's victory echoed through the battlefield.</p>";
            this.display.playSong(false, 'winGame')
            $('#game-modal').modal('show');
            this.playerController.postLogs("Congratulation!", 4)
        } else {
            //lost case
            this.display.playSong(false, 'loseGame')
            this.playerController.postLogs("Game over!", 3)
            document.getElementById("game-over-speech").innerHTML = "<p> As the sun began to set, the player, a skilled strategist, stood confidently atop their towering fortress. Waves of relentless enemies surged forward, hell-bent on destruction. The player fought valiantly, commanding their defenses with precision and cunning. Yet, as the final assault descended upon them, the overwhelming force proved insurmountable. With sweat on their brow and exhaustion in their eyes <span id=\"game-over-speech-red\">the player watched helplessly as the enemies breached their defenses,realizing that despite their best efforts, victory had slipped through their fingers.</span></p>"
            $('#game-modal').modal('show');
            document.getElementById("game-over-title").innerText = "Game over!"

        }
        //Delete game
        $.post("api/v1/game/delete", {gameId: gameId}, function (response) {}).fail(function (response) {})

    }
}

