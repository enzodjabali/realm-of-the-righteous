import {enumTower} from '../Model/enumTower.js';
import {Tower} from "../Model/Tower.js";
export class HUDController {
    constructor(model, display, towerController, playerController) {
        this.model = model;
        this.display = display;
        this.towerController = towerController;
        this.playerController = playerController
        this.goldPerMinute = {"gold": 0, "date": Date.now(), "average": [], "playerGold": this.playerController.player.money};

        //Set up the inital value of the player
        document.getElementById('money').innerText = "🪙 "+this.playerController.player.money+"";
        document.getElementById('life').innerText = "Current life : "+this.playerController.player.life+" ❤️";
        document.getElementById('killedEnemies').innerText = "💀 "+ this.playerController.player.killedEnemies;
    }

    createTower() {
        /**
         * Permit to create tower on click
         */
        let buttonContainer = document.getElementById('button-buy-tower-container')

        for(const key in enumTower){
            let button = document.createElement('div');
            button.setAttribute("id", "tower_"+key)
            button.setAttribute("class", "p-2 flex-fill hud-button")
            button.style.width = "150px"
            button.innerHTML = '<p>Buy '+key+' tower <img height="50px" src="'+enumTower[key].path[0]+'"><br><br> '+enumTower[key].price[0]+' 🪙</p>';
            button.onclick = () => {
                if(this.display.pile == -1){
                } else {
                    if(this.playerController.buyTower(enumTower[key].price[0])){
                        this.display.updatePlayerData(this.playerController.player.money, this.playerController.player.life, this.playerController.player.killedEnemies);
                        if (key != "rock"){
                            this.playerController.postLogs("Bought "+key+" tower for "+enumTower[key].price[0]+" coins", 1)
                        }
                        if(this.model.matrice[this.display.pile[1][0]][this.display.pile[1][1]].tile != 'basegrass' && key != "rock"){
                            console.log("vous ne pouvez pas place de tours ici")
                            this.playerController.player.money += enumTower[key].price[0];
                            this.display.updatePlayerData(this.playerController.player.money, this.playerController.player.life, this.playerController.player.killedEnemies);
                            return
                        } else if (key == "rock") {
                            let tempMatrice = JSON.parse(JSON.stringify(this.model.matrice));
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
                            if(this.model.entryPoints[this.indexOfEntryPoints] && this.model.endPoints[this.indexOfEndPoints]) {
                                let pathForEnemies = this.model.findPathForWaves(tempMatrice, this.model.entryPoints[this.indexOfEntryPoints], this.model.endPoints[this.indexOfEndPoints])
                                if (pathForEnemies.length > 0) {
                                    console.log("you can put this rock in matrice")
                                    if (this.model.matrice[this.display.pile[1][0]][this.display.pile[1][1]].tile != 'basegrass') {
                                        this.towerController.placeTowerInMatrice(enumTower[key], key);
                                        this.playerController.postLogs("Bought "+key+" tower for "+enumTower[key].price[0]+" coins", 1)
                                        this.display.pile = -1;
                                    }
                                } else {
                                    this.playerController.postLogs("You can't put rock here", 2)
                                    console.log("what the fuck are you thinking, you can't put this rock in matrice little shit")
                                    return;
                                }
                            } else {
                                this.playerController.postLogs("Not allowed (round 0)", 3)
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
    calculateGoldPerMinute(){
        if(this.goldPerMinute.date+10000 <= Date.now()) {
            this.goldPerMinute.gold = ((this.playerController.player.money - this.goldPerMinute.playerGold) / 10) * 60
            if(this.goldPerMinute.gold < 0){
                this.goldPerMinute.gold = 0;
            }
            document.getElementById('gold-per-minute').innerText = "⏱️ "+this.goldPerMinute.gold.toFixed(0)+" g/min"

            this.goldPerMinute.gold = 0;
            this.goldPerMinute.playerGold = this.playerController.player.money;
            this.goldPerMinute.date = Date.now();
        }
    }

}