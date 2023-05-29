import {Player} from '../Model/Player.js';

export class PlayerController{
    constructor(name, money, life) {
        this.player = new Player(name, money, life);
    }
    buyTower(price){
        if(this.player.money >= price){
            this.player.money -= price
            return true;
        } else {
            return false;
        }
    }
    modifyPlayerLife(){

    }

}