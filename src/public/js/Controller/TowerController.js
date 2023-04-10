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
        let DIRECTIONS = [[0, -1], [1, 0], [0, 1], [-1, 0], [-1,-1], [-1,1], [1,-1], [1,1]]; // North, East, South, West
        while(true){
            await new Promise(r => setTimeout(r, 200)); // frequence de tire
            // console.log(tower.position.x-1, tower.position.y-1, 'POSITION TOUR -1')
            // IMPLEMENTER LE FAIT DE REGARDER LE PERIMETRE
            for (let direction of DIRECTIONS){
                let dx = tower.position.x + direction[0]
                let dy = tower.position.y + direction[1]
                console.log(direction, '<<<<<<<<<<')
                if(dx >= 0 && dx < this.model.matrice.length && dy >= 0 && dy < this.model.matrice[0].length){
                    if(this.model.matrice[dx][dy].enemies.length > 0){
                        console.log('enemy a range de tour')
                        console.log(this.model.matrice[dx][dy], 'here')
                        this.model.matrice[dx][dy].enemies[0].life = 0;

                    }
                }
            }
            console.log('stop')
        }
    }
}



