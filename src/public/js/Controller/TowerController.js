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

            let rebound = null;
            let slowness = null;
            let splashRange = null;
            switch (type) {
                case "OT":
                    rebound = towerData.rebound[0];
                    break;
                case "T":
                    slowness = towerData.slowness[0];
                    break;
                case "BT":
                    splashRange = towerData.splashRange[0]
            }
            const tower = new Tower(
                towerId,
                towerData.damage[0],
                towerData.shotRate[0],
                { x: row, y: col },
                0,
                towerData.path[0],
                towerData.pathWeapon[0],
                towerWeaponId,
                towerData.price,
                type,
                towerData.isAttackingAir,
                towerData.totalTowerFrames[0],
                towerData.totalAmmoFrames[0],
                towerData.totalImpactFrames[0],
                towerData.pathAmmo[0],
                towerData.pathImpact[0],
            );
            //Since constructor does't accept more parameters, create setter
            tower.setSlowness(slowness);
            tower.setRebound(rebound);
            tower.setSplashRange(splashRange)

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




    findNeighbour(centerX, centerY, radius, searchType, listEnemyToAvoid = null) {
        let tower = [];
        let splash = [];

        const height = radius * 2;
        const width = radius * 2;

        const startX = Math.max(centerX - radius, 0);
        const startY = Math.max(centerY - radius, 0);
        const endX = Math.min(centerX + radius, this.model.matrice.length - 1);
        const endY = Math.min(centerY + radius, this.model.matrice[0].length - 1);

        for (let y = startY; y <= endY; y++) {
            for (let x = startX; x <= endX; x++) {
                if (x == startX && y == startY){
                    continue;
                }
                const dx = x - centerX;
                const dy = y - centerY;

                if (dx * dx + dy * dy <= radius ** 2) {
                    const cell = this.model.matrice[x][y];

                    if (searchType === "enemy" && cell.enemies.length > 0) {
                        if (cell.enemies[0].curent_life > 0) {
                            return cell.enemies[0];
                        }
                        
                    }
                    if (searchType === "tower" && cell.tower && (dx !== centerX || dy !== centerY)) {
                        tower.push(cell.tower);
                    }
                    if (searchType === "splash" && (dx !== centerX || dy !== centerY)) {
                        splash.push(cell.enemies);
                    }
                    if (searchType === "rebound" && cell.enemies.length > 0 && (dx !== centerX && dy !== centerY)) {
                        for (let enemy of cell.enemies) {
                            if (enemy.curent_life > 0) {
                                if(listEnemyToAvoid.includes(enemy.id)){
                                    break;
                                } else{
                                    return enemy;
                                }

                            }
                        }
                    }
                }
            }
        }
        // Return the desired values (enemy and tower) as needed
        if (searchType == "tower") {
            return tower;
        }
        if (searchType == "splash"){
            return splash;
        }
        else {
            return false;
        }
    }

    async runTower(tower)
    {
        /**
         * @param {Tower} tower instance of Tower.
         * Permit to make the logic of the tower works
         */

        while (true) {
            console.log(tower.slowness, "slowness")
            if (tower.remove) {
                break;
            }
            this.slowedEnemy()
            await new Promise(r => setTimeout(r, tower.shotRate)); // frequency of fire
            let {range, damage} = tower;
            const { x, y } = tower.position;
            let enemy = this.findNeighbour(x, y, range, "enemy");
            if (enemy) {
                if (tower.isAttackingAir && enemy.isFlying || !tower.isAttackingAir && !enemy.isFlying) {
                    this.provideDamage(enemy, damage)
                    this.display.playTowerSprite(tower, enemy);
                    switch (tower.type) {
                        case "BT":
                            //Splash Tower
                            console.log(tower.splashRange, "hererer")
                            let closeEnemy = this.findNeighbour(enemy.position.x, enemy.position.y, tower.rebound,"splash")
                            console.log(closeEnemy, "liste d'ennemi a toucher")
                            if(closeEnemy){
                                for (let cell of closeEnemy) {
                                    for (let enemy of cell){
                                        this.provideDamage(enemy, tower.damage*0.3)
                                    }
                                }
                            }
                            break;
                        case "OT":
                            // Rebound Tower
                            let hitEnemies = []
                            for (let i = 0; i < tower.range; i++) {
                                if (enemy) {
                                    hitEnemies.push(enemy.id);
                                    enemy = this.findNeighbour(enemy.position.x, enemy.position.y, 1, "rebound", hitEnemies);
                                    if (enemy.curent_life > 0) {
                                        this.provideDamage(enemy, (tower.damage / 2));
                                    }
                                }
                            }
                            break;
                        case "T":
                            if (enemy) {
                                this.slowedEnemies[enemy.id] = [(Date.now()/1000)+3, enemy]
                                //Permits to round up speed
                                enemy.speed = (enemy.speed / tower.slowness).toFixed(1);
                            }
                            break;
                    }
                }
            }
            if (tower.type == "WT"){
                let towerNearby = this.findNeighbour(x, y, range, "tower")
                console.log(towerNearby, "Tower nearby")
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
    provideDamage(enemy, damage)
    {
        enemy.curent_life -= damage;
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
