import {enumTower} from '../Model/enumTower.js';

export class HUDController {
    constructor(model, display, towerController, playerController) {
        this.model = model;
        this.display = display;
        this.towerController = towerController;
        this.playerController = playerController

        //Set up the inital value of the player
        document.getElementById('money').innerText = this.playerController.player.money;
        document.getElementById('life').innerText = this.playerController.player.life;
    }

    createTower() {
        /**
         * Permit to create tower on click
         */
        let buttonContainer = document.getElementById('button-container')
        for(const key in enumTower){
            let button = document.createElement('button');
            button.innerText = ('Buy '+key);
            button.onclick = () => {
                if(this.display.pile == -1){
                } else {
                    if(this.playerController.buyTower(enumTower[key].price[0])){
                        this.display.updatePlayerData(this.playerController.player.money, this.playerController.player.life);
                        this.towerController.placeTowerInMatrice(enumTower[key]);
                        this.display.pile = -1;
                    } else{
                        console.log(this.playerController.player)
                    }
                }
            }
            buttonContainer.appendChild(button)
        }
    }
}