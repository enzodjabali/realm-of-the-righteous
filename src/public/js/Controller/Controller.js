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
    /**
    * Create a new Game.
    * @param {Object} model - The game model.
    * @param {string} difficulty - The game difficulty.
    */
    constructor(model, difficulty) {
        this.model = new Model(model, difficulty);
        this.display = new Display();
        this.enemiesController = new EnemiesController(this.model);
        this.playerController = new PlayerController(this.model.defaultMoneyPlayer[this.model.difficulty], this.model.defaultLifePlayer[this.model.difficulty], this.model, this.display);
        this.towerController = new TowerController(this.model, this.display, this.playerController)
        this.HUDController = new HUDController(this.model, this.display, this.towerController, this.playerController)
        this.fetchController = new FetchController(this.towerController, this.model)
        this.endGameHolder = false;
        this.indexOfEntryPoints;
        this.indexOfEndPoints;
        document.getElementById('start-wave-counter').innerText = this.display.romanizeNumber(this.model.currentWave);
    }

    /**
    * Update the position of an enemy.
    * @param {Object} enemy - The enemy to update.
    * @param {Array} nextPosition - The next position of the enemy.
    */
    updateEnemiesPosition(enemy, nextPosition){
        this.model.matrice[enemy.position.x][enemy.position.y].enemies.shift()
        enemy.position.x += nextPosition[0]
        enemy.position.y += nextPosition[1]
        this.model.matrice[enemy.position.x][enemy.position.y].enemies.unshift(enemy);
    }

    /**
    * Set up the game.
    * - Initializes the board display with the current matrix.
    * - Runs the fetch controller to update the matrix based on data fetched from the database.
    * - Sets up an interval to save the model every 2 seconds.
    */
    setup(){
        // Display matrice
        this.display.initializeBoard(this.model.getMatrice());

        // Update matrice based on fetch from database
        this.fetchController.run()

        setInterval(this.saveModel, 2000, this.model);
        // On save, resume with group 0
    }

    /**
     * Main loop of the enemies, permit make them run with their logic by waves, groups and unit
     * @param {String} diffculty chosen difficulty.
     */
    async loop(diffculty){
        this.display.updatePlayerData(this.playerController.player.money, this.playerController.player.life, this.playerController.player.killedEnemies, this.model.currentWave, this.model.currentWave);
        await new Promise(r => setTimeout(r, this.model.timeBeforeStart));
        let spawnedEnemies = 0;
        let xp = 0;
        for(let i = this.model.currentWave; i < this.model.waves[this.model.difficulty].length; i++){
            await new Promise((resolve, reject) => {
                        document.getElementById("play-game").onclick = () => {
                            if(spawnedEnemies == 0 && this.model.currentWave < this.model.waves[this.model.difficulty].length) {
                                this.playerController.postLogs("Wave "+this.display.romanizeNumber(this.model.currentWave)+" is coming!", 1)
                                this.display.updatePlayerData(this.playerController.player.money, this.playerController.player.life, this.playerController.player.killedEnemies, this.model.currentWave);
                                this.HUDController.waveState = false;
                                resolve()
                            } else {
                                this.playerController.postLogs("You must end this wave first..", 1)
                            }
                        }
                 })
            this.display.updatePlayerData(this.playerController.player.money, this.playerController.player.life, this.playerController.player.killedEnemies, this.model.currentWave);
            let song;
            this.model.difficulty == "hard" ? song = "hardMusic" : song = "easyMusic"
            this.display.playBackgroundSong(song)
            for(let g of this.model.waves[this.model.difficulty][i]){spawnedEnemies += g[0]}
            for (let group of this.model.waves[this.model.difficulty][i]){
                if (this.model.waves[this.model.difficulty][i].indexOf(group) != 0) {
                    console.log('wait timeBetweenGroups', this.model.timeBetweenGroups)
                    await new Promise(r => setTimeout(r, this.model.timeBetweenGroups));
                }
                this.model.currentGroup++;
                this.indexOfEntryPoints = (this.model.waves[this.model.difficulty][i].indexOf(group)) % (this.model.entryPoints.length);
                this.indexOfEndPoints = (this.model.waves[this.model.difficulty][i].indexOf(group)) % (this.model.endPoints.length);
                let path = this.model.findPathForWaves(this.model.getMatrice(), this.model.entryPoints[this.indexOfEntryPoints], this.model.endPoints);
                if(path == 0){
                    this.playerController.postLogs("Cannot find path for enemy", 3)
                    return
                }
                for (let mob = 0; mob < group[0]; mob++){
                    let enemy = this.enemiesController.createEnnemyObject(this.model.mobId, enumEnemies, path, this.model.entryPoints[this.indexOfEntryPoints], group[1])
                    this.display.initializeEnemy(enemy);
                    let runEnemies = this.run(enemy, path)
                        .then((runEnemies) => {
                            if(!runEnemies){
                                xp += enemy.price
                                spawnedEnemies--;
                                if(spawnedEnemies == 0){
                                    this.model.currentWave++
                                    this.playerController.postLogs("End of wave "+this.display.romanizeNumber(this.model.currentWave-1), 2)
                                    this.HUDController.waveState = true;
                                    this.display.stopSong();
                                    xp = Math.round(xp)
                                    this.display.playBonusSong("gainXp");
                                    this.playerController.postLogs("You gained " + xp + " xp !", 2)
                                    this.playerController.incrementExperience(xp)
                                    xp = 0;
                                    document.getElementById('start-wave-counter').innerText = this.display.romanizeNumber(this.model.currentWave);
                                }
                                if(spawnedEnemies == 0 && i == this.model.waves[this.model.difficulty].length-1 && this.playerController.player.life > 0){
                                    this.endGame(true)
                                    let xpBonus;
                                    switch(this.model.difficulty){
                                        case "easy":
                                            xpBonus = 300;
                                            break;
                                        case "normal":
                                            xpBonus = 500;
                                            break;
                                        case "hard":
                                            xpBonus = 700;
                                            break;
                                    }
                                    return
                                }
                            }
                        })
                    await new Promise(r => setTimeout(r, 500)); // Delay 500ms between each enemy's movement for smoother animation
                    this.model.mobId++;
                }
            }
        }
    }

    /**
    * Main loop of the enemies, permit make them run with their logic
    * @param {Enemy} enemy instance of enemy.
    * @param {Enemy} path pathfinding list of cords.
    * @param {Enemy} endPoints couple of end coordinates.
    */
    async run(enemy, path) {
        try {
            for (let step = 0; step <= path.length; step++) {
                if (!this.endGameHolder) {
                    this.HUDController.calculateGoldPerMinute()
                    let enemyPositon = [enemy.position.x, enemy.position.y];
                    enemyPositon = JSON.stringify(enemyPositon);
                    let positionEnemy = [enemy.position.x, enemy.position.y];
                    let jsonEndpoints = JSON.stringify(this.model.endPoints)
                    if (jsonEndpoints.includes(enemyPositon)) {
                        if (!this.playerController.modifyPlayerLife(enemy.trueDamage)) {
                            this.display.updatePlayerData(this.playerController.player.money, this.playerController.player.life, this.playerController.player.killedEnemies, this.model.currentWave)
                            // Implémenter la fin de jeu (défaite)
                            this.display.stopSong()
                            this.endGame(false)
                            return
                        }
                        this.display.updatePlayerData(this.playerController.player.money, this.playerController.player.life, this.playerController.player.killedEnemies, this.model.currentWave)
                        // Ajouter les damage lorsque balance fait
                        this.playerController.postLogs(enemy.name + " dealt " + enemy.trueDamage + " damage", 3)
                        this.display.killEnemy(enemy);

                        this.model.matrice[enemy.position.x][enemy.position.y].enemies.filter(enemy => enemy.id !== enemy.id);
                        break;
                    }

                    if (path[step][1] < 0) {
                        this.display.flipItLeft(enemy);
                    }
                    if (path[step][1] > 0) {
                        this.display.flipItLeftRight(enemy);
                    }

                    if (enemy.curent_life <= 0) {
                        // Permit to give money to the player when an ennemy died
                        this.playerController.player.money += Math.round(enemy.price);
                        this.model.defaultMoneyPlayer[this.model.difficulty] = this.playerController.player.money

                        this.playerController.player.killedEnemies++
                        this.model.killedEnemies = this.playerController.player.killedEnemies;

                        this.display.updatePlayerData(this.playerController.player.money, this.playerController.player.life, this.playerController.player.killedEnemies);
                        this.display.killEnemy(enemy);


                        this.model.matrice[enemy.position.x][enemy.position.y].enemies.filter(enemy => enemy.id !== enemy.id);

                        return false;
                    }

                    if (step <= path.length - 1) {
                        //Ici update la liste de step enemy si rock trouvé
                        try {
                            if (this.model.matrice[enemy.position.x + path[step][0]][enemy.position.y + path[step][1]].tower.type == "rock") {
                                let newPath = this.model.findPathForWaves(this.model.matrice, [enemy.position.x, enemy.position.y], this.model.endPoints)
                                enemy.path = newPath;
                                enemy.step = 0;
                                path = newPath;
                                step = 0;
                                endPoints = this.model.endPoints[this.indexOfEndPoints]
                                continue;
                            }
                        } catch (error) {
                        }
                    }
                    this.updateEnemiesPosition(enemy, path[step]); // Await the update of the enemy's position
                    await this.display.updateEnemyHealthBar(enemy);
                    await this.display.nextMoveEnemy(enemy, path[step]); // Await the next move of the enemy using the nextMoveEnemy() method
                } else {
                    return;
                }
            }
        } catch (error) {
            // Handle any errors that may occur during the enemy's movement
            console.error('Error:', error);
        }
    }

    /**
     * Save the game model in Database
     * @param {Object} model - The game model to be saved.
     */
    saveModel(model) {
        model = JSON.parse(JSON.stringify(model));
        for (let i = 0; i < model.matrice.length; i++) {
            for (let j = 0; j < model.matrice[i].length; j++) {
                if(model.matrice[i][j].tower){
                    model.matrice[i][j].tower.buffedTower = [];
                }
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

    /**
     * End the game by displaying an win or a lose modal.
     * @param {boolean} bool - The result of the game (true for victory, false for defeat).
     */
    endGame(bool){
        this.endGameHolder = true;
        if(bool){
            $(`.game-over-background`).removeClass("game-over-background");
            document.getElementById("game-over-title").innerText = "Congratulation!"
            document.getElementById("game-over-speech").innerHTML = "<p>As the sun began to set, the player, a seasoned strategist, stood resolute atop their towering fortress. Waves of relentless enemies surged forward, their forces no match for the player's well-placed defenses. The player fought fiercely, commanding their troops with unwavering determination and tactical brilliance. With each passing wave, the enemies grew weaker and more desperate. <span style='color:green'> Finally, as the dust settled, the player stood triumphant, their fortress standing tall and unscathed.</span> The enemies lay defeated, scattered in disarray, as the player's victory echoed through the battlefield.</p>";
            this.display.playEndGameSong('winGame')
            $('#game-modal').modal('show');
            this.playerController.postLogs("Congratulation!", 4)
        } else {
            this.display.playEndGameSong('loseGame')
            this.playerController.postLogs("Game over!", 3)
            document.getElementById("game-over-speech").innerHTML = "<p> As the sun began to set, the player, a skilled strategist, stood confidently atop their towering fortress. Waves of relentless enemies surged forward, hell-bent on destruction. The player fought valiantly, commanding their defenses with precision and cunning. Yet, as the final assault descended upon them, the overwhelming force proved insurmountable. With sweat on their brow and exhaustion in their eyes <span id=\"game-over-speech-red\">the player watched helplessly as the enemies breached their defenses,realizing that despite their best efforts, victory had slipped through their fingers.</span></p>"
            $('#game-modal').modal('show');
            document.getElementById("game-over-title").innerText = "Game over!"

        }
        //Delete game
        $.post("api/v1/game/delete", {gameId: gameId}, function (response) {}).fail(function (response) {})
    }

}

