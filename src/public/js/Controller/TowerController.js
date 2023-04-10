import {Tower} from "../Model/Tower.js";

export class TowerController{
    constructor(model, display){
        this.model = model;
        this.display = display;
    }
    placeTowerInMatrice(){
        this.display.pile[0].classList.remove('tile-shadow'); // remove class (not selected anymore)
        if(this.model.matrice[this.display.pile[1][0]][this.display.pile[1][1]].tower == null){
            console.log(this.model.towerId, 'id tower ici');
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
        while(true){
            await new Promise(r => setTimeout(r, 200)); // frequence de tire
            // console.log(tower.position.x-1, tower.position.y-1, 'POSITION TOUR -1')
            // IMPLEMENTER LE FAIT DE REGARDER LE PERIMETRE
            if(this.model.matrice[tower.position.x-1][tower.position.y-1].enemies.length > 0){
                this.model.matrice[tower.position.x-1][tower.position.y-1].enemies[0].life = 0;
            }
        }
    }

}
