import {Tower} from "../Model/Tower.js";

export class TowerController{
    constructor(model, display){
        this.model = model;
        this.display = display;
    }
    placeTowerInMatrice(towerData) {
        /**
         * @param {number} towerData dictionnary of data about tower.
         * Permit to place tower in the matrice
         */
        this.display.pile[0].classList.remove('tile-shadow'); // remove class (not selected anymore)

        const row = this.display.pile[1][0];
        const col = this.display.pile[1][1];

        if (this.model.matrice[row][col].tower === null) {
            const towerId = 'tower_' + this.model.towerId;
            const towerWeaponId = 'towerWeapon_' + this.model.towerWeaponId;

            this.model.towerId++;
            this.model.towerWeaponId++;

            console.log(towerData,'towerData')

            const tower = new Tower(
                towerId, towerData.damage[0], towerData.shotRate[0], {x: row, y: col}, 0, towerData.path[0],
                towerData.pathWeapon, towerWeaponId
            );

            this.model.matrice[row][col].tower = tower;
            this.display.initializeTower(tower);
            this.display.initializeWeapon(tower);

            // appel le boucle pour faire fonctionner la logique des tours.
            this.runTower(tower);

        } else {
            console.log('Il y a déjà une tour sur cette case.');
            return;
        }

        this.display.pile = -1;
    }

async runTower(tower) {
    /**
     * @param {Tower} tower instance of Tower.
     * Permit to make the logic of the tower works
     */
    const DIRECTIONS = [[0, -1], [1, 0], [0, 1], [-1, 0]]; // North, East, South, West
    const DIRECTIONDIAG = [[-1, -1], [-1, 1], [1, -1], [1, 1]];
    while (true) {
        //console.log(tower.id ,tower.shotRate, 'setTimeout');
        await new Promise(r => setTimeout(r, tower.shotRate)); // frequency of fire
        const { x, y } = tower.position;
        const { range, damage } = tower;
        for (let i = 1; i <= range; i++) {
            for (let direction of DIRECTIONS) {
                const dx = x * direction[0];
                const dy = x * direction[1];
                const nx = x + dx;
                const ny = y + dy;
                if (nx >= 0 && nx < this.model.matrice.length && ny >= 0 && ny < this.model.matrice[0].length) {
                    const cell = this.model.matrice[nx][ny];
                    if (cell.enemies.length > 0) {
                        cell.enemies[0].curent_life -= damage;
                        console.log('tower',tower.id, 'shooting',cell.enemies[0].typeOfEnemies, cell.enemies[0].id)
                        this.display.rotateWeapon(tower [nx,ny]);
                    }
                }
            }
            if (i > 1) {
                for (let directionDiag of DIRECTIONDIAG) {
                    const dxt = i * directionDiag[0];
                    const dyt = i * directionDiag[1];
                    const ndxt = x + dxt;
                    const ndyt = y + dyt;
                    if (ndxt >= 0 && ndxt < this.model.matrice.length && ndyt >= 0 && ndyt < this.model.matrice[0].length) {
                        const cell = this.model.matrice[ndxt][ndyt];
                        if (cell.enemies.length > 0) {
                            cell.enemies[0].curent_life -= damage;

                            console.log('tower',tower.id, 'shooting',cell.enemies[0].typeOfEnemies, cell.enemies[0].id)
                            this.display.rotateWeapon(tower, [ndxt, ndyt]);
                        }
                    }
                }
            } else {
                console.log(tower.id, "towerIdle")
                this.display.towerIdle(tower);
            }
        }
    }
}

}



