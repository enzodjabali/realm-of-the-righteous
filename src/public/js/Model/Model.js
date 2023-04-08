//Permit to store data of the game (Matrice, Enemies, Towers, Money, Life)
export class Model {
    constructor() {
        this.matrice =
            [[{tile: 1, enemies: []},{tile: 1, enemies: []},{tile: 2, enemies: []},{tile: 0, enemies: []},{tile: 0, enemies: []},{tile: 0, enemies: []},{tile: 0, enemies: []},{tile: 0, enemies: []},{tile: 0, enemies: []},{tile: 0, enemies: []}],
                [{tile: 2, enemies: []},{tile: 1, enemies: []},{tile: 2, enemies: []},{tile: 0, enemies: []},{tile: 0, enemies: []},{tile: 0, enemies: []},{tile: 0, enemies: []},{tile: 0, enemies: []},{tile: 0, enemies: []},{tile: 0, enemies: []}],
                [{tile: 2, enemies: []},{tile: 1, enemies: []},{tile: 2, enemies: []},{tile: 0, enemies: []},{tile: 0, enemies: []},{tile: 0, enemies: []},{tile: 0, enemies: []},{tile: 0, enemies: []},{tile: 0, enemies: []},{tile: 0, enemies: []}],
                [{tile: 2, enemies: []},{tile: 1, enemies: []},{tile: 2, enemies: []},{tile: 2, enemies: []},{tile: 2, enemies: []},{tile: 2, enemies: []},{tile: 2, enemies: []},{tile: 2, enemies: []},{tile: 2, enemies: []},{tile: 2, enemies: []}],
                [{tile: 2, enemies: []},{tile: 1, enemies: []},{tile: 1, enemies: []},{tile: 1, enemies: []},{tile: 1, enemies: []},{tile: 1, enemies: []},{tile: 0, enemies: []},{tile: 1, enemies: []},{tile: 2, enemies: []},{tile: 2, enemies: []}],
            ]
        // [wave 0 --> [[quantity], [type]]]
        this.waves = [[[1,100],[0,110]]];
        this.enemiesToPlace = []; //List where enemy are waiting to be put in the matrice
        this.entryPoints = [[0,0]];
        this.endPoints = [];

    }
    getMatrice(){
        return this.matrice;
    }
    
    updateMatrice(newMatrice){
        this.matrice = newMatrice;
    }

    addEnemy(enemy){
        this.enemiesToPlace.push(enemy);
    }
    getWaves(){
        return this.waves;
    }

}