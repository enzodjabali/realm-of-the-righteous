import {Player} from '../Model/Player.js';
const gameId = new URLSearchParams(window.location.search).get('gameId');

export class PlayerController{

    /**
     * @param {number} money - The initial amount of money for the player.
     * @param {number} life - The initial amount of life for the player.
     * @param {Model} model - The game model.
     * @param {Display} display - The game display.
     */
    constructor(money, life, model, display) {
        this.model = model;
        this.player = new Player(money, life, this.model.killedEnemies);
        this.display = display;
    }

    /**
     * Deduct money from player with price value
     * @param {number} price - The price of the tower.
     * @returns {boolean} - Returns true if the tower is successfully bought, false otherwise.
     */
    buyTower(price){

        if(this.player.money >= price){
            this.player.money -= Math.round(price)
            this.model.defaultMoneyPlayer[this.model.difficulty] = this.player.money;
            return true;
        } else {
            return false;
        }
    }
    /**
     * Modify the player's life by subtracting the specified value.
     * @param {number} value - The value to subtract from the player's life.
     * @returns {boolean} - Returns true if the player is still alive after the modification, false otherwise.
     */
    modifyPlayerLife(value){
        this.player.life -= value;
        this.display.playBonusSong('loseHealth')
        this.model.defaultLifePlayer[this.model.difficulty] = this.player.life
        return this.isPlayerAlive()
    }

    /**
     * Check if the player has more than 0 HP (is alive).
     * @returns {boolean} - Returns true if the player is alive (has more than 0 HP), false otherwise.
     */
    isPlayerAlive(){
        /**
         * Check if the player has more than 0 HP (is alive ?), return TRUE or FALSE
         */
        if(this.player.life <= 0){
            return false;
        } else {
            return true;
        }
    }

    /**
     * Posts logs to the Database.
     * @param {string} content - The content of the log.
     * @param {number} type - The type of the log.
     * @returns {boolean} - Returns false.
     */
    async postLogs(content, type) {
        $.post("api/v1/game/insertLog", {gameId: gameId, content: content, type: type}, function (response) {
        }).fail(function (response) {
        });
        return false;
    }

    /**
     * Increments the player's experience points (XP).
     * @param {number} gainedXp - The amount of XP gained.
     */
    incrementExperience(gainedXp){
        $.post("/api/v1/player/incrementXP", {xp: gainedXp}, function (response) {}).fail(function (response) {});
    }
}