import {Tower} from "../Model/Tower.js";
import {HUDController} from "./HUDController.js";

export class TowerController {
    constructor(model, display, player) {
        this.model = model;
        this.display = display;
        this.playerController = player;
        this.DIRECTIONS = [[0, -1], [1, 0], [0, 1], [-1, 0]]; // North, East, South, West
        this.DIRECTIONDIAG = [[-1, -1], [-1, 1], [1, -1], [1, 1]];
    }

    placeTowerInMatrice(towerData, type) {
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
                towerData.pathWeapon, towerWeaponId, towerData.price, type
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

    findNeighbour(x, y, range) {
        let enemies = [];
        let directions = this.DIRECTIONS
        for (let i = 1; i <= range; i++) {
            if (i == 2) {
                if(directions.length == 4){
                    console.log("extending list")
                    directions = directions.concat(this.DIRECTIONDIAG);
                    i = 1;
                }
            }
            for (let direction of directions) {
                const dx = i * direction[0];
                const dy = i * direction[1];
                const nx = x + dx;
                const ny = y + dy;
                console.log("--------------")
                console.log("Add to", dx, dy)
                console.log("Actual target", x, y)
                console.log("Next target position", nx, ny)

                if (nx >= 0 && nx < this.model.matrice.length && ny >= 0 && ny < this.model.matrice[0].length) {

                    const cell = this.model.matrice[nx][ny];
                    if (cell.enemies.length > 0) {
                        enemies.push([nx, ny])
                    }
                }
            }
        }
        //Avoid duplicates in list
        enemies = enemies.map(JSON.stringify).filter((e,i,a) => i === a.indexOf(e)).map(JSON.parse)
        return enemies;
    }

    async runTower(tower) {
        /**
         * @param {Tower} tower instance of Tower.
         * Permit to make the logic of the tower works
        */
    
        while (true) {
            await new Promise(r => setTimeout(r, tower.shotRate)); // frequency of fire
            let { range, damage } = tower;
            const { x, y } = tower.position;
            let neighbour = this.findNeighbour(x, y, range)
            if (neighbour[0]) {
                this.model.matrice[neighbour[0][0]][neighbour[0][1]].enemies[0].curent_life -= damage
                this.display.rotateWeapon(tower, [neighbour.nx, neighbour.ny]);
                switch (tower.type){
                    case "BT":
                        //Splash Tower
                        if(neighbour.length > 1){
                            neighbour = neighbour.slice(1, neighbour.length)
                            let counter = 0;
                            for(let enemy of neighbour){
                                counter++
                                if(counter%2 == 0){
                                    damage = damage*0.5
                                }
                                this.model.matrice[enemy[0]][enemy[1]].enemies[0].curent_life -= damage
                            }
                        }
                    case "OT":
                        // Rebound Tower
                        // Comment animer les tirs ? prendre les coordonnees de chaque ennemies
                        // et passer les tirs d'ennemi en ennemi
                        let rebound = this.findNeighbour(neighbour[0][0], neighbour[0][1], 3);
                        console.log(rebound, "rebound")
                        let minimiseDamage = 1;
                        for(let enemy of rebound){
                            minimiseDamage -= 0.2;
                            this.model.matrice[enemy[0]][enemy[1]].enemies[0].curent_life -= damage*minimiseDamage;
                            console.log("Damage given ", damage*minimiseDamage);
                        }
                }
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



