import {enumTower} from '../Model/enumTower.js';

export class HUDController {
    constructor(model, display, towerController) {
        this.model = model;
        this.display = display;
        this.towerController = towerController;
    }

    createTower() {
        let button1 = document.getElementById('buyTower1')
        let button2 = document.getElementById('buyTower2')
        let button3 = document.getElementById('buyTower3')
        let button4 = document.getElementById('buyTower4')

        button1.onclick = () => {
            if(this.display.pile == -1){
            } else {
                this.towerController.placeTowerInMatrice(enumTower.BT);
                this.display.pile = -1;
            }
        }
        button2.onclick = () => {
            if(this.display.pile == -1){
            } else {
                this.towerController.placeTowerInMatrice(enumTower.T);
                this.display.pile = -1;
            }
        }
        button3.onclick = () => {
            if(this.display.pile == -1){
            } else {
                this.towerController.placeTowerInMatrice(enumTower.OT);
                this.display.pile = -1;
            }
        }

        button4.onclick = () => {
            if(this.display.pile == -1){
            } else {
                this.towerController.placeTowerInMatrice(enumTower.WT);
                this.display.pile = -1;
            }
        }
    }
}