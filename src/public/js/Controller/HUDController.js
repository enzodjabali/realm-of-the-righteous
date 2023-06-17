import {enumTower} from '../Model/enumTower.js';
import {Tower} from "../Model/Tower.js";
export class HUDController {
    constructor(model, display, towerController, playerController) {
        this.model = model;
        this.display = display;
        this.towerController = towerController;
        this.playerController = playerController
        this.goldPerMinute = {"gold": 0, "date": Date.now(), "average": [], "playerGold": this.playerController.player.money};
        this.waveState = true;

        //Set up the inital tower of the player
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
                        if(this.model.matrice[this.display.pile[1][0]][this.display.pile[1][1]].tile != 'basegrass' && key != "rock"){
                            this.playerController.postLogs("You can't put a tower", 3)
                            this.playerController.player.money += Math.round(enumTower[key].price[0]);
                            this.display.updatePlayerData(this.playerController.player.money, this.playerController.player.life, this.playerController.player.killedEnemies);
                            return
                        } else if (key == "rock") {
                            if(this.waveState) {
                                let tempMatrice = JSON.parse(JSON.stringify(this.model.matrice));
                                tempMatrice[this.display.pile[1][0]][this.display.pile[1][1]].tower = new Tower(
                                    null,
                                    null,
                                    null,
                                    {x: null, y: null},
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
                                let counter = 0;
                                for (let x = 0; x < this.model.entryPoints.length; x++) {
                                    console.log('hey')
                                    let pathForEnemies = this.model.findPathForWaves(tempMatrice, this.model.entryPoints[x], this.model.endPoints)
                                    if (pathForEnemies.length > 0) {
                                        if (this.model.matrice[this.display.pile[1][0]][this.display.pile[1][1]].tile != 'basegrass') {
                                            counter++
                                        }
                                    }
                                }
                                if (counter == this.model.entryPoints.length) {
                                    this.towerController.placeTowerInMatrice(enumTower[key], key);
                                    this.playerController.postLogs("Bought " + key + " for " + enumTower[key].price[0] + " coins", 1)
                                    this.display.pile = -1;
                                    return;
                                }
                                this.playerController.postLogs("You can't put rock here", 3)
                                this.playerController.player.money += Math.round(enumTower[key].price[0]);
                                this.display.updatePlayerData(this.playerController.player.money, this.playerController.player.life, this.playerController.player.killedEnemies);
                            } else {
                                this.playerController.postLogs("Wait for the wave to end", 3)
                            }
                        } else {
                            this.playerController.postLogs("Bought "+key+" tower for "+enumTower[key].price[0]+" coins", 1)
                            this.display.playTowerSong("putTower")
                            this.towerController.placeTowerInMatrice(enumTower[key], key);
                            this.display.pile = -1;
                        }
                    } else{
                        this.playerController.postLogs("You have not enought money", 1)
                    }
                }
            }
            buttonContainer.appendChild(button)
        }

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
    boostTowers(){
        let boostPriceDamage = Math.round(400 + this.model.currentWave * ((400/100)*8))
        let boostPriceRange = Math.round(300 + this.model.currentWave * ((300/100)*8))
        let boostPriceShotRate = Math.round(400 + this.model.currentWave * ((400/100)*8))
        let boostDamage = document.getElementById("boost-tower-damage")
        boostDamage.innerText = "Boost damage 🏹 "+boostPriceDamage+" 🪙";
        let boostRange = document.getElementById("boost-tower-range")
        boostRange.innerText = "Boost Tower Range 🔍 "+boostPriceRange+" 🪙"
        let boostShotRate = document.getElementById("boost-tower-shotRate")
        boostShotRate.innerText = "Boost Tower Speed ⚡ "+boostPriceShotRate+" 🪙"

        boostDamage.onclick = () => {
            if (this.playerController.buyTower(boostPriceDamage)) {
                if(!this.waveState) {
                    this.display.playBoostTowerSong("boostTower")
                    this.display.updatePlayerData(this.playerController.player.money, this.playerController.player.life, this.playerController.player.killedEnemies);
                    for (const [key, tower] of Object.entries(this.model.inGameTowers)) {
                        tower.damage += Math.ceil(enumTower[tower.type].damage[tower.level] * 0.2);
                        setTimeout(() => {
                            tower.damage = enumTower[tower.type].damage[tower.level];
                        }, 15000)

                    }
                    this.playerController.postLogs("Damage boost on", 1)
                } else {
                    this.playerController.postLogs("Wait for the wave to end", 3)
                }
            } else {
                this.playerController.postLogs("Damage boost costs too much", 3)
            }
        }
        boostRange.onclick = () => {
            if (this.playerController.buyTower(boostPriceRange)) {
                if(!this.waveState) {
                    this.display.playBoostTowerSong("boostTower")
                    this.display.updatePlayerData(this.playerController.player.money, this.playerController.player.life, this.playerController.player.killedEnemies);
                    for (const [key, tower] of Object.entries(this.model.inGameTowers)) {
                        tower.range += Math.ceil(enumTower[tower.type].range[tower.level] * 0.2);
                        setTimeout(() => {
                            tower.range = enumTower[tower.type].range[tower.level];
                        }, 15000);
                    }
                    this.playerController.postLogs("Range boost on", 1)
                } else {
                    this.playerController.postLogs("Wait for the wave to end", 3)
                }
            } else {
                this.playerController.postLogs("Range boost costs too much", 3)
            }
        }
        boostShotRate.onclick = () => {
            if (this.playerController.buyTower(boostPriceShotRate)) {
                if(!this.waveState) {
                    this.display.playBoostTowerSong("boostTower")
                    this.display.updatePlayerData(this.playerController.player.money, this.playerController.player.life, this.playerController.player.killedEnemies);
                    for (const [key, tower] of Object.entries(this.model.inGameTowers)) {
                        tower.shotRate += Math.ceil(enumTower[tower.type].shotRate[tower.level] * 0.2);
                        setTimeout(() => {
                            tower.shotRate = enumTower[tower.type].shotRate[tower.level];
                        }, 15000);
                    }
                    this.playerController.postLogs("Speed boost on", 1)
                } else {
                    this.playerController.postLogs("Wait for the wave to end", 3)
                }
            } else {
                this.playerController.postLogs("Speed boost costs too much", 3)
            }
        }
    }
}