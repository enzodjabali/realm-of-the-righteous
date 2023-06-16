import {Player} from '../Model/Player.js';

const gameId = new URLSearchParams(window.location.search).get('gameId');

export class PlayerController{
    constructor(money, life, model, display) {
        this.model = model;
        this.player = new Player(money, life, this.model.killedEnemies);
        this.display = display;
    }
    buyTower(price){
        /**
         * Permits the user to buy a tower if he has enough money
         * @param {price} price price of the tower
         */
        if(this.player.money >= price){
            this.player.money -= Math.round(price)
            this.model.defaultMoneyPlayer[this.model.difficulty] = this.player.money
            return true;
        } else {
            return false;
        }
    }
    modifyPlayerLife(value){
        /**
         * Modify HP of the user, return if TRUE or FALSE if the player is alive or not
         * @param {value} value that modify the user HP (positive or negative)
         *
         */
        this.player.life -= value;
        this.display.playSong(false, 'loseHealth')
        this.model.defaultLifePlayer[this.model.difficulty] = this.player.life
        return this.isPlayerAlive()
    }
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
    async postLogs(content, type) {
        $.post("api/v1/game/insertLog", {gameId: gameId, content: content, type: type}, function (response) {
        }).fail(function (response) {
        });
        return false;


    }
}