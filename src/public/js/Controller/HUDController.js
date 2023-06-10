import {enumTower} from '../Model/enumTower.js';
import {Tower} from "../Model/Tower.js";

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
                        if(this.model.matrice[this.display.pile[1][0]][this.display.pile[1][1]].tile == 'basepath' && key != "rock"){
                            console.log("vous ne pouvez pas place de tours ici")
                            return
                        } else if (key == "rock") {
                            let tempMatrice = structuredClone(this.model.matrice);
                            tempMatrice[this.display.pile[1][0]][this.display.pile[1][1]].tower = new Tower(
                                null,
                                null,
                                null,
                                { x: null, y: null },
                                null,
                                null,
                                null,
                                null,
                                null,
                                "rock",
                                null,
                                null,
                                null,
                                null,
                                null,
                                null,
                            )
                            let pathForEnemies = this.model.findPathForWaves(tempMatrice,this.model.entryPoints[this.indexOfEntryPoints], this.model.endPoints[this.indexOfEndPoints])
                            if(pathForEnemies.length > 0){
                                console.log("you can put this rock in matrice")
                                if(this.model.matrice[this.display.pile[1][0]][this.display.pile[1][1]].tile == 'basepath'){
                                    this.towerController.placeTowerInMatrice(enumTower[key], key);
                                    this.display.pile = -1;
                                }

                            } else {
                                console.log("what the fuck are you thinking, you can't put this rock in matrice little shit")
                                return;
                            }
                        } else {
                            this.towerController.placeTowerInMatrice(enumTower[key], key);
                            this.display.pile = -1;
                        }
                    } else{
                        console.log(this.playerController.player, 'NOT ENOUGH MONEY')
                    }
                }
            }
            buttonContainer.appendChild(button)
        }
    }
    setStartPoints(start){
        this.indexOfEntryPoints = start;
    }
    setEndPoints(end){
        this.indexOfEndPoints = end;
    }
}