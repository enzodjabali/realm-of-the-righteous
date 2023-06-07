import {Tower} from "../Model/Tower.js";
import {HUDController} from "./HUDController.js";

export class TowerController {
    constructor(model, display, player) {
        this.model = model;
        this.display = display;
        this.playerController = player;
        this.DIRECTIONS = [[0, -1], [1, 0], [0, 1], [-1, 0]]; // North, East, South, West
        this.DIRECTIONDIAG = [[-1, -1], [-1, 1], [1, -1], [1, 1]];
        this.slowedEnemies = {};
    }

    placeTowerInMatrice(towerData=null, type=null, fetchedTower=null) {
        /**
            * @param {number} towerData dictionnary of data about tower.
            * Permit to place tower in the matrice
        */
        let tower;
        if (fetchedTower) {
            tower = new Tower(fetchedTower)
            tower = fetchedTower; 
            this.model.matrice[tower.position.x][tower.position.y].tower = tower;
            this.towerLogics(tower);
            return;
        }
        const row = this.display.pile[1][0];
        const col = this.display.pile[1][1];
        if (this.model.matrice[row][col].tower === null && !tower) {
            this.display.pile[0].classList.remove('tile-shadow'); // remove class (not selected anymore)
            const towerId = 'tower_' + this.model.towerId;
            const towerWeaponId = 'towerWeapon_' + this.model.towerWeaponId;
            this.model.towerId++;
            this.model.towerWeaponId++;
            switch (type){
            case "OT":
                tower = new Tower(
                    towerId, towerData.damage[0], towerData.shotRate[0], { x: row, y: col }, 0, towerData.path[0],
                    towerData.pathWeapon[0], towerWeaponId, towerData.price, type, towerData.isAttackingAir, towerData.totalFrames[0],
                    towerData.rebound[0], towerData.pathAmmo[0], towerData.pathImpact[0]
                    );
                break;
            case "T":
                tower = new Tower(
                    towerId, towerData.damage[0], towerData.shotRate[0], { x: row, y: col }, 0, towerData.path[0],
                    towerData.pathWeapon[0], towerWeaponId, towerData.price, type, towerData.isAttackingAir, towerData.totalFrames[0],
                    null, towerData.slowness[0], towerData.pathAmmo[0], towerData.pathImpact[0]
                    );
                break;
            default:
                tower = new Tower(
                    towerId, towerData.damage[0], towerData.shotRate[0], { x: row, y: col }, 0, towerData.path[0],
                    towerData.pathWeapon[0], towerWeaponId, towerData.price, type, towerData.isAttackingAir, towerData.totalFrames[0],
                    towerData.pathAmmo[0], towerData.pathImpact[0]
                    );
            }
            this.model.matrice[row][col].tower = tower;
            this.towerLogics(tower, row, col);
            
        } else {
            console.log('Il y a déjà une tour sur cette case.');
            return;
        }
        this.display.pile = -1;
    }

    towerLogics(tower) {
        
        let towerHolder = this.display.initializeTower(tower);

        towerHolder.onclick = () => {
            //Implémenter le menu pour améliorer les tours
            //Sell, upgrade, shoot priority

            this.sellTower(tower)
            // this.upgradeTower(tower)
        }

        // appel le boucle pour faire fonctionner la logique des tours.
        this.runTower(tower);
    }


    

    findNeighbour(x, y, range) {
        let enemies = [];
        let directions = this.DIRECTIONS
        for (let i = 1; i <= range; i++) {
            if (i == 2) {
                if (directions.length == 4) {
                    directions = directions.concat(this.DIRECTIONDIAG);
                    i = 1;
                }
            }
            for (let direction of directions) {
                const dx = i * direction[0];
                const dy = i * direction[1];
                const nx = x + dx;
                const ny = y + dy;

                if (nx >= 0 && nx < this.model.matrice.length && ny >= 0 && ny < this.model.matrice[0].length) {

                    const cell = this.model.matrice[nx][ny];
                    if (cell.enemies.length > 0) {
                        enemies.push([nx, ny])
                    }
                }
            }
        }
        //Avoid duplicates in list
        enemies = enemies.map(JSON.stringify).filter((e, i, a) => i === a.indexOf(e)).map(JSON.parse)
        return enemies;
    }

    async runTower(tower)
    {
        /**
            * @param {Tower} tower instance of Tower.
            * Permit to make the logic of the tower works
            */

        while (true) {
            if (tower.remove) {
                break;
            }
            this.slowedEnemy()
            await new Promise(r => setTimeout(r, tower.shotRate)); // frequency of fire
            let {range, damage} = tower;
            const {x, y} = tower.position;
            let neighbour = this.findNeighbour(x, y, range)            
            if (neighbour[0]) {
                if (tower.isAttackingAir && this.model.matrice[neighbour[0][0]][neighbour[0][1]].enemies[0].isFlying || !tower.isAttackingAir && !this.model.matrice[neighbour[0][0]][neighbour[0][1]].enemies[0].isFlying) {
                    this.provideDamage(this.model.matrice[neighbour[0][0]][neighbour[0][1]].enemies[0], damage)                    
                    this.display.playSprite(tower, this.model.matrice[neighbour[0][0]][neighbour[0][1]].enemies[0]);

                    switch (tower.type) {
                    case "BT":
                            //Splash Tower
                        if (neighbour.length > 1) {
                            neighbour = neighbour.slice(1, neighbour.length)
                            let counter = 0;
                            for (let enemy of neighbour) {
                                counter++
                                if (counter % 2 == 0) {
                                    damage = damage * 0.5
                                }
                                this.provideDamage(this.model.matrice[enemy[0]][enemy[1]].enemies[0], damage)

                            }
                        }
                        break;
                    case "OT":
                            // Rebound Tower
                        if (neighbour.length > 1) {
                            for (let i = 0; i < tower.rebound; i++) {
                                neighbour = this.findNeighbour(neighbour[0][0], neighbour[0][1], 3);
                                if (neighbour.length > 0) {
                                    if (!this.model.matrice[neighbour[0][0]][neighbour[0][1]].enemies[0].isFlying) {
                                        this.provideDamage(this.model.matrice[neighbour[0][0]][neighbour[0][1]].enemies[0], (damage / i))

                                    }

                                }
                            }
                        }
                        break;
                    case "T":
                        if (neighbour.length > 0) {
                            let enemy = this.model.matrice[neighbour[0][0]][neighbour[0][1]].enemies[0]
                            this.slowedEnemies[enemy.id] = [(Date.now()/1000)+3, enemy]
                                //Permits to round up speed
                            enemy.speed = (enemy.speed / tower.slowness).toFixed(1);
                        }
                        break;
                    }
                }
            }
        }
    }

    upgradeTower(tower)
    {
            //Permit to upgrade a tower
    }
    sellTower(tower)
    {
            //Permit to sell a tower

            //Add money to player
        this.playerController.player.money += (0.75 * tower.price[tower.level])
        this.display.updatePlayerData(this.playerController.player.money, this.playerController.player.life)
            //Remove tower from de board
            this.display.removeTower(tower);
            //break the while loop
            tower.remove = true;
            //Remove tower from the logical board
        this.model.matrice[tower.position.x][tower.position.y].tower = null;


    }
    provideDamage(enemyLife, damage)
    {
        enemyLife.curent_life -= damage;
    }
    async slowedEnemy()
    {
            //Checks for enemy slowness
        for (const [key, value] of Object.entries(this.slowedEnemies)) {
            if(value[0] < Date.now()/1000){
                value[1].speed = value[1].memorySpeed ;
            }
        }
    }
}




