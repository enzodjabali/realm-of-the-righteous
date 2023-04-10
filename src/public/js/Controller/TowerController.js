import {Tower} from "../Model/Tower.js";

export class TowerController{
    constructor(model, display){
        this.model = model;
        this.display = display;
    }
    placeTowerInMatrice(){
        this.display.pile[0].classList.remove('tile-shadow'); // remove class (not selected anymore)
        if(this.model.matrice[this.display.pile[1][0]][this.display.pile[1][1]].tower == null){
            let towerId = 'tower'+this.model.towerId;
            this.model.towerId++;
            this.model.matrice[this.display.pile[1][0]][this.display.pile[1][1]].tower = new Tower(
                towerId, 1, {x: this.display.pile[1][0], y: this.display.pile[1][1]}
            )
            this.display.initializeTower(this.model.matrice[this.display.pile[1][0]][this.display.pile[1][1]].tower)

            //appel le boucle pour faire fonctionner la logique des tours.
            this.runTower(this.model.matrice[this.display.pile[1][0]][this.display.pile[1][1]].tower)
        } else {
            console.log('il y a déjà une tour sur cette case')
            return
        }
        console.log(this.model.matrice[this.display.pile[1][0]][this.display.pile[1][1]].tower)
        this.display.pile = -1;
    }
    async runTower(tower){
        let DIRECTIONS = [[0, -1], [1, 0], [0, 1], [-1, 0]]; // North, East, South, West
        let DIRECTIONDIAG = [[-1,-1], [-1,1], [1,-1], [1,1]];
        while(true){
            await new Promise(r => setTimeout(r, 500)); // frequence de tire
            //Checks for left, right, top, down
            for(let x = 1; x < tower.range+1; x++) {
                for (let direction of DIRECTIONS) {
                    let dx = tower.position.x + (direction[0]*x)
                    let dy = tower.position.y + (direction[1]*x)
                    if (dx >= 0 && dx < this.model.matrice.length && dy >= 0 && dy < this.model.matrice[0].length) {
                        if (this.model.matrice[dx][dy].enemies.length > 0) {
                            this.model.matrice[dx][dy].enemies[0].life = 0;
                        }
                    }
                }
                //Checks for diagonals
                if(x > 1){
                    for (let directionDiag of DIRECTIONDIAG){
                        let dxt = tower.position.x + (directionDiag[0]*(x-1))
                        let dyt = tower.position.y + (directionDiag[1]*(x-1))
                        if (dxt >= 0 && dxt < this.model.matrice.length && dyt >= 0 && dyt < this.model.matrice[0].length) {
                            if (this.model.matrice[dxt][dyt].enemies.length > 0) {
                                this.model.matrice[dxt][dyt].enemies[0].life = 0;
                            }
                        }
                    }
                }
            }
        }
    }
}



