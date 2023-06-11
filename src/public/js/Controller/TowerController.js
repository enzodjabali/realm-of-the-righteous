import {Tower} from "../Model/Tower.js";
import {enumTower} from '../Model/enumTower.js';
const gameId = new URLSearchParams(window.location.search).get('game_id');

export class TowerController {
    constructor(model, display, player) {
        this.model = model;
        this.display = display;
        this.playerController = player;
        this.DIRECTIONS = [[0, -1], [1, 0], [0, 1], [-1, 0]]; // North, East, South, West
        this.DIRECTIONDIAG = [[-1, -1], [-1, 1], [1, -1], [1, 1]];
        this.slowedEnemies = {};
    }

    placeTowerInMatrice(towerData=null, type=null, fetchedTower=null, towerLevel = 0, towerPosition = null) {
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
        let row, col;
        if (towerLevel == 0){
            row = this.display.pile[1][0];
            col = this.display.pile[1][1];
        } else if (towerLevel > 0 && towerPosition) {
            row = towerPosition.x;
            col = towerPosition.y;
        }


        if (this.model.matrice[row][col].tower === null && !tower) {
            if(towerLevel == 0){
                this.display.pile[0].classList.remove('tile-shadow'); // remove class (not selected anymore)
            }

            const towerId = 'tower_' + this.model.towerId;
            const towerWeaponId = 'towerWeapon_' + this.model.towerWeaponId;
            this.model.towerId++;
            this.model.towerWeaponId++;

            let rebound = null;
            let slowness = null;
            let splashRange = null;
            let buffTower = null;
            switch (type) {
                case "OT":
                    rebound = towerData.rebound[towerLevel];
                    break;
                case "T":
                    slowness = towerData.slowness[towerLevel];
                    break;
                case "BT":
                    splashRange = towerData.splashRange[towerLevel];
                    break;
                case "WT":
                    buffTower = towerData.buffTower[towerLevel]
                    break;
            }
            const tower = new Tower(
                towerId,
                towerData.damage[towerLevel],
                towerData.shotRate[towerLevel],
                { x: row, y: col },
                towerLevel,
                towerData.path[towerLevel],
                towerData.pathWeapon[towerLevel],
                towerWeaponId,
                towerData.price,
                type,
                towerData.isAttackingAir,
                towerData.totalTowerFrames[towerLevel],
                towerData.totalAmmoFrames[towerLevel],
                towerData.totalImpactFrames[towerLevel],
                towerData.pathAmmo[towerLevel],
                towerData.pathImpact[towerLevel],
            );

            //Since constructor does't accept more parameters, create setter
            tower.setSlowness(slowness);
            tower.setRebound(rebound);
            tower.setSplashRange(splashRange)
            tower.setBuffTower(buffTower);

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
            console.log(gameId, 'JE SUIS LID DU JEU')
            this.playerController.postLogs("texte", 1)
            console.log("send")
            this.display.showTowerRange(tower.position, tower.range*2)
            displayTabHUD('hud-tab-tower-actions')
            this.playerController.player.tab = Date.now()/1000;
            let sellContainer = document.getElementById('sell-tower')
            let upgradeContainer = document.getElementById('upgrade-tower')

            //Permit to empty the tab
            sellContainer.innerHTML = ''
            upgradeContainer.innerHTML = ''

            let sellButton = document.createElement('p')
            let upgradeButton = document.createElement('p')
            upgradeButton.innerText = "Upgrade "+tower.type+" ⚒️ ("+tower.price[tower.level]+" 🪙)"
            sellButton.innerText = "Sell "+tower.type+" ❌ ("+tower.price[tower.level]*0.75+" 🪙) ";

            sellButton.onclick = () => {
                this.sellTower(tower);
                displayTabHUD('hud-tab-general')
            }
            upgradeButton.onclick = () => {
                this.upgradeTower(tower)
                displayTabHUD('hud-tab-general')
            }
            document.getElementById('attack-value').innerText = tower.damage;
            document.getElementById('attack-speed-value').innerText = tower.shotRate;
            document.getElementById('range-value').innerText = tower.range;
            document.getElementById('level-value').innerText = tower.level+1;
            document.getElementById('current-damage-boost-value').innerText = tower.damage - tower.memoryDamage;
            document.getElementById('tower-src-value').src = tower.path;
            document.getElementById('tower-type-value').innerText = "Tower "+tower.type




            sellContainer.appendChild(sellButton);
            upgradeContainer.appendChild(upgradeButton);
        }
        // appel le boucle pour faire fonctionner la logique des tours.

        if(tower.type == "rock"){
            console.log("je bloque le passage")
        } else {
            this.runTower(tower);
        }

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
                    if (searchType === "tower" && cell.tower && (x !== centerX || y !== centerY)) {
                        tower.push(cell.tower);
                    }
                    if (searchType === "splash" && (dx !== centerX || dy !== centerY)) {
                        for (let enemy of cell.enemies) {
                            if (enemy.curent_life > 0) {
                                splash.push(enemy);
                            }
                        }

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
            if (tower.remove) {
                break;
            }
            this.checkPlayerTab()
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
                            let closeEnemies = this.findNeighbour(enemy.position.x, enemy.position.y, tower.splashRange,"splash")
                            if(closeEnemies){
                                for (enemy of closeEnemies){
                                    console.log("provide damage to an enemy")
                                    this.provideDamage(enemy, tower.damage*0.5)
                                    //REVOIR POUR GAME DESIGN   -----THOMAS----
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
                let towersNearby = this.findNeighbour(tower.position.x, tower.position.y, range, "tower")
                for (let closeTower of towersNearby){
                    if(closeTower.damage == closeTower.memoryDamage){
                        closeTower.damage = (closeTower.damage *= tower.buffTower).toFixed(1);
                    }
                }
            }
        }
    }

    upgradeTower(tower)
    {
        //Permit to upgrade a tower
        if(tower.level == enumTower[tower.type].damage.length-1){
            //Mximum tower level already reached
            return
        } else {
            tower.level++
        }
        this.sellTower(tower, false)
        this.placeTowerInMatrice(enumTower[tower.type],tower.type,null, tower.level, tower.position)

    }
    sellTower(tower, getMoneyFromTower = true)
    {
        //Permit to sell a tower
        //Add money to player
        if(getMoneyFromTower){
            this.playerController.player.money += (0.75 * tower.price[tower.level])
        }
        this.display.updatePlayerData(this.playerController.player.money, this.playerController.player.life, this.playerController.player.killedEnemies)
        //Remove tower from de board
        this.display.removeTower(tower);
        //break the while loop
        tower.remove = true;
        //Remove tower from the logical board
        this.checkPlayerTab(true)
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
    checkPlayerTab(sell = false){
        if (this.playerController.player.tab+3 < Date.now()/1000 || sell == true){
            this.display.hideTowerRange();
        }
    }
}
