import {Tower} from "../Model/Tower.js";
import {HUDController} from "./HUDController.js";

export class TowerController {
    constructor(model, display, player) {
        this.model = model;
        this.display = display;
        this.playerController = player;
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

            console.log(towerData, 'towerData')

            const tower = new Tower(
                towerId, towerData.damage[0], towerData.shotRate[0], { x: row, y: col }, 0, towerData.path[0],
                towerData.pathWeapon, towerWeaponId, towerData.price
            );
            this.model.matrice[row][col].tower = tower;
            let towerHolder = this.display.initializeTower(tower);
            towerHolder.onclick = () => {
                //Implémenter le menu pour améliorer les tours
                //Sell, upgrade, shoot priority
                this.sellTower(tower, row, col)
                // this.upgradeTower(tower)

            }
            this.display.initializeWeapon(tower);

            // appel le boucle pour faire fonctionner la logique des tours.
            this.runTower(tower);
        } else {
            console.log('Il y a déjà une tour sur cette case.');
            return;
        }

        this.display.pile = -1;
    }

    findNeighbour(x,y, range, dir, dirg) {
        for (let i = 1; i <= range; i++) {
            if (i == 2) {
                dir = dir.concat(dirg);
            }
            for (let direction of dir) {
                const dx = i * direction[0];
                const dy = i * direction[1];
                const nx = x + dx;
                const ny = y + dy;
                if (nx >= 0 && nx < this.model.matrice.length && ny >= 0 && ny < this.model.matrice[0].length) {
                    const cell = this.model.matrice[nx][ny];
                    if (cell.enemies.length > 0) {
                        return { cell, nx, ny };
                    } 

                }
            }
        } 
        return false;
    } 

    async runTower(tower) {
        /**
         * @param {Tower} tower instance of Tower.
         * Permit to make the logic of the tower works
        */
        let DIRECTIONS = [[0, -1], [1, 0], [0, 1], [-1, 0]]; // North, East, South, West
        const DIRECTIONDIAG = [[-1, -1], [-1, 1], [1, -1], [1, 1]];

        while (true) {
            DIRECTIONS = [[0, -1], [1, 0], [0, 1], [-1, 0]]
            //console.log(tower.id ,tower.shotRate, 'setTimeout');
            await new Promise(r => setTimeout(r, tower.shotRate)); // frequency of fire
            const { range, damage } = tower;
            const { x, y } = tower.position;
            if (this.findNeighbour(x, y, range, DIRECTIONS, DIRECTIONDIAG)) {
                let { cell, nx, ny } = this.findNeighbour(x, y, range, DIRECTIONS, DIRECTIONDIAG)
                cell.enemies[0].curent_life -= damage;
                console.log('tower', tower.id, 'shooting', cell.enemies[0].typeOfEnemies, cell.enemies[0].id)
                this.display.rotateWeapon(tower, [nx, ny]);
            }
                    
        }

    }

    upgradeTower(tower){
        //Permit to upgrade a tower
    }
    sellTower(tower, row, col){
        //Permit to sell a tower

        //Add money to player
        this.playerController.player.money += (0.75*tower.price[tower.level])
        this.display.updatePlayerData(this.playerController.player.money, this.playerController.player.life)
        //Remove tower from de board
        this.display.removeTower(tower);
        //Remove tower from the logical board
        this.model.matrice[row][col].tower = null;


    }

}



