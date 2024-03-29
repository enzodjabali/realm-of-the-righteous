import {Tower} from "../Model/Tower.js";
import {enumTower} from '../Model/enumTower.js';


export class TowerController {

    /**
     * Creates a new TowerController.
     * @param {object} model - The game model.
     * @param {object} display - The game display.
     * @param {object} player - The player controller.
     */
    constructor(model, display, player) {
        this.model = model;
        this.display = display;
        this.playerController = player;
        this.DIRECTIONS = [[0, -1], [1, 0], [0, 1], [-1, 0]]; // North, East, South, West
        this.DIRECTIONDIAG = [[-1, -1], [-1, 1], [1, -1], [1, 1]];
        this.slowedEnemies = {};
    }

    /**
     * Place a tower in the matrix.
     * @param {object} towerData - Dictionary of data about the tower.
     * @param {string} type - Tower type.
     * @param {object} fetchedTower - Fetched tower object.
     * @param {number} towerLevel - Tower level.
     * @param {object} towerPosition - Tower position object.
     */
    placeTowerInMatrice(towerData=null, type=null, fetchedTower=null, towerLevel = 0, towerPosition = null) {
        let tower;
        if (fetchedTower) {
            tower = new Tower(fetchedTower)
            tower = fetchedTower;
            this.model.matrice[tower.position.x][tower.position.y].tower = tower;

            // Reset values if tower was in boost state
            tower.damage = enumTower[tower.type].damage[tower.level];
            tower.range = enumTower[tower.type].range[tower.level];
            tower.shotRate = enumTower[tower.type].shotRate[tower.level];

            this.model.inGameTowers[tower.id] = tower;
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
            let pathImpact = null;
            let totalImpactFrames = null;
            let range = towerData.range[towerLevel];
            let armorDamage = towerData.armorDamage[towerLevel];
            switch (type) {
                case "OT":
                    rebound = towerData.rebound[towerLevel];
                    pathImpact = towerData.pathImpact[towerLevel];
                    totalImpactFrames = towerData.totalImpactFrames[towerLevel];
                    break;
                case "T":
                    slowness = towerData.slowness[towerLevel];
                    pathImpact = towerData.pathImpact[0];
                    totalImpactFrames = towerData.totalImpactFrames[0];
                    break;
                case "BT":
                    splashRange = towerData.splashRange[towerLevel];
                    pathImpact = towerData.pathImpact[towerLevel];
                    totalImpactFrames = towerData.totalImpactFrames[towerLevel];
                    break;
                case "WT":
                    buffTower = towerData.buffTower[towerLevel];
                    pathImpact = towerData.pathImpact[0];
                    totalImpactFrames = towerData.totalImpactFrames[0];
                    break;
                case "AT":
                    pathImpact = towerData.pathImpact[towerLevel];
                    totalImpactFrames = towerData.totalImpactFrames[towerLevel];
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
                totalImpactFrames,
                towerData.pathAmmo[towerLevel],
                pathImpact,
            );

            //Since constructor doesn't accept more parameters, create setter
            tower.setSlowness(slowness);
            tower.setRebound(rebound);
            tower.setSplashRange(splashRange)
            tower.setBuffTower(buffTower);
            tower.setArmorDamage(armorDamage);
            tower.setRange(range);

            this.model.matrice[row][col].tower = tower;
            this.towerLogics(tower, row, col);
            this.model.inGameTowers[towerId] = tower;

        } else {
            this.playerController.postLogs("There is already a tower on this tile", 2)
            return;
        }
        this.display.pile = -1;
    }

    /**
     * Perform tower logic.
     * @param {object} tower - Tower object.
     */
    towerLogics(tower) {
        let towerHolderId = this.display.initializeTower(tower);
        let towerHolder = document.getElementById(towerHolderId);
        towerHolder.tower = tower;
        towerHolder.this = this;
        towerHolder.addEventListener("click", this.towerOnclick)
        this.runTower(tower);
    }

    /**
     * Find neighbors within a specified radius around a center position.
     * @param {number} centerX - X coordinate of the center position.
     * @param {number} centerY - Y coordinate of the center position.
     * @param {number} radius - Radius to search for neighbors.
     * @param {string} searchType - Type of search: "enemy", "tower", "splash", or "rebound".
     * @param {array} listEnemyToAvoid - List of enemy IDs to avoid (only used for "rebound" search).
     * @returns {array|object|boolean} - List of towers (for "tower" search), enemy (for "enemy" or "rebound" search), splash (for "splash" search), or false if not found.
     */
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

    /**
     * Run the logic of the tower.
     * @param {Tower} tower - Instance of the Tower class.
     */
    async runTower(tower) {

        if (tower.type != "rock") {
            while (true) {
                if (tower.remove) {
                    break;
                }
                this.checkPlayerTab()
                this.slowedEnemy()
                await new Promise(r => setTimeout(r, tower.shotRate)); // frequency of fire
                let {range, damage} = tower;
                const {x, y} = tower.position;
                let enemy = this.findNeighbour(x, y, range, "enemy");
                if (enemy) {
                    if (tower.isAttackingAir && enemy.isFlying || !tower.isAttackingAir && !enemy.isFlying) {
                        this.provideDamage(enemy, damage, tower.armorDamage);

                        this.display.ShootEnemy(tower, enemy);

                        switch (tower.type) {
                            case "BT":
                                //Splash Tower
                                let closeEnemies = this.findNeighbour(enemy.position.x, enemy.position.y, tower.splashRange, "splash")
                                if (closeEnemies) {
                                    for (enemy of closeEnemies) {
                                        this.provideDamage(enemy, tower.damage * 0.5, tower.armorDamage)
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
                                            this.provideDamage(enemy, (tower.damage / 2), tower.armorDamage);
                                        }
                                    }
                                }
                                break;
                            case "T":
                                if (enemy) {
                                    this.slowedEnemies[enemy.id] = [(Date.now() / 1000) + 3, enemy]
                                    //Permits to round up speed
                                    enemy.speed = (enemy.speed / tower.slowness).toFixed(1);
                                }
                                break;
                        }
                    }
                }
                if (tower.type == "WT") {
                    let towersNearby = this.findNeighbour(tower.position.x, tower.position.y, range, "tower")
                    for (let closeTower of towersNearby) {
                        if (closeTower.damage == enumTower[closeTower.type].damage[closeTower.level]) {
                            closeTower.damage = (closeTower.damage *= tower.buffTower).toFixed(1);
                            closeTower.armorDamage = (closeTower.armorDamage *= tower.buffTower).toFixed(1);
                            try {
                                tower.buffedTower.push(this.model.matrice[closeTower.position.x][closeTower.position.y].tower)
                            } catch (error) {
                                console.log(error)
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Upgrades the tower to the next level.
     * @param {Tower} tower - Instance of the Tower class.
     */
    upgradeTower(tower) {
        if (this.playerController.buyTower(enumTower[tower.type].price[tower.level+1])){
            if(tower.level == enumTower[tower.type].damage.length-1){
                //Maximum tower level already reached
                return
            } else {
                tower.level++
                this.display.playTowerSong("upgradeTower")
            }
            this.sellTower(tower, false)
            this.playerController.postLogs("Upgraded "+enumTower[tower.type].fullName+" for "+enumTower[tower.type].price[tower.level]+" golds", 1)
            this.placeTowerInMatrice(enumTower[tower.type],tower.type,null, tower.level, tower.position)
        } else {
            this.playerController.postLogs("You can't afford it, sorry", 1)
        }
    }

    /**
     * Sells the tower and performs necessary cleanup.
     * @param {Tower} tower - Instance of the Tower class.
     * @param {boolean} getMoneyFromTower - Flag indicating whether to get money from selling the tower.
     */
    async sellTower(tower, getMoneyFromTower = true) {
        if(getMoneyFromTower){
            this.playerController.player.money += Math.round(0.75 * tower.price[tower.level])
            this.model.defaultMoneyPlayer[this.model.difficulty] = this.playerController.player.money
            this.playerController.postLogs("Sold "+enumTower[tower.type].fullName+" tower for "+Math.round(tower.price[tower.level]*0.75)+" coins", 1)
            this.display.playTowerSong('sellTower')
        }
        this.display.updatePlayerData(this.playerController.player.money, this.playerController.player.life, this.playerController.player.killedEnemies)
        //Remove tower from de board
        this.display.removeTower(tower);
        //break the while loop
        tower.remove = true;
        //Remove tower from the logical board
        this.checkPlayerTab(true)
        this.model.matrice[tower.position.x][tower.position.y].tower = null;

        await new Promise(r => setTimeout(r, 1000));
        if(tower.type == "WT"){
            for (const buffedTower of tower.buffedTower){
                buffedTower.damage = enumTower[buffedTower.type].damage[buffedTower.level];
                buffedTower.armorDamage = enumTower[buffedTower.type].armorDamage[buffedTower.level];
            }
        }
        //Delete tower from inGameTowers
        if (tower.id in this.model.inGameTowers){
            delete this.model.inGameTowers[tower.id];
        }
    }

    /**
     * Inflicts damage to an enemy, considering armor.
     * @param {Enemy} enemy - Instance of the Enemy class.
     * @param {number} damage - The base damage to be inflicted.
     * @param {number} armorDamage - The armor damage of the tower.
     */
    provideDamage(enemy, damage, armorDamage) {
        let armorDifference = enemy.armor - armorDamage
        if(armorDifference <= 0){
            enemy.curent_life -= damage;
        } else {
            let grossDamage = 100 - armorDifference
            enemy.curent_life -= damage * grossDamage/100;
        }
    }

    /**
     * Restores the speed of slowed enemies after a certain duration.
     */
    async slowedEnemy() {
        for (const [key, value] of Object.entries(this.slowedEnemies)) {
            if(value[0] < Date.now()/1000){
                value[1].speed = value[1].memorySpeed ;
            }
        }
    }

    /**
     * Checks the player's tab status and performs to hide the tower range.
     * @param {boolean} sell - Indicates whether the check is triggered by a tower sell action (default: false).
     */
    checkPlayerTab(sell = false){
        if (this.playerController.player.tab+3 < Date.now()/1000 || sell == true){
            this.display.hideTowerRange();
        }
    }

    /**
     * Fills the tower specifications in the Tower Actions tab.
     * @param {number} x - The x-coordinate of the tower's position.
     * @param {number} y - The y-coordinate of the tower's position.
     * @param {string} fullName - The full name of the tower.
     */
    fillTowerSpecs(x, y, fullName){
        //Fill Tower Actions tab
        document.getElementById('attack-value').innerText = this.model.matrice[x][y].tower.damage;
        document.getElementById('attack-speed-value').innerText = this.model.matrice[x][y].tower.shotRate;
        document.getElementById('armor-damage-value').innerText = this.model.matrice[x][y].tower.armorDamage;
        document.getElementById('range-value').innerText = this.model.matrice[x][y].tower.range;
        document.getElementById('level-value').innerText = this.model.matrice[x][y].tower.level+1;
        document.getElementById('current-damage-boost-value').innerText = (this.model.matrice[x][y].tower.damage - enumTower[this.model.matrice[x][y].tower.type].damage[this.model.matrice[x][y].tower.level]).toFixed(1);
        document.getElementById('tower-src-value').src = this.model.matrice[x][y].tower.path;
        document.getElementById('tower-type-value').innerText = fullName;
    }

    /**
     * Event handler for tower click.
     * @param {Event} tower - The tower object.
     */
    towerOnclick(tower){
        let towerObject = tower.currentTarget.tower
        let thisParam = tower.currentTarget.this

        //Get rid of tile selection while looking for tower
        $(".tile-shadow").removeClass("tile-shadow");

        thisParam.display.showTowerRange(towerObject.position, towerObject.range*2)
        displayTabHUD('hud-tab-tower-actions')
        thisParam.playerController.player.tab = Date.now()/1000;
        let sellContainer = document.getElementById('sell-tower')
        let upgradeContainer = document.getElementById('upgrade-tower')

        //Permit to empty the tab
        sellContainer.innerHTML = ''
        upgradeContainer.innerHTML = ''

        let sellButton = document.createElement('p')
        let upgradeButton = document.createElement('p')
        if(towerObject.price.length <= towerObject.level+1){
            upgradeButton.innerText = "Upgrade "+enumTower[towerObject.type].fullName+" ⚒️ Max level achieved";
        } else {
            upgradeButton.innerText = "Upgrade "+enumTower[towerObject.type].fullName+" ⚒️ ("+Math.round(towerObject.price[towerObject.level+1])+" 🪙)"
        }

        sellButton.innerText = "Sell "+enumTower[towerObject.type].fullName+" ❌ ("+Math.round(towerObject.price[towerObject.level]*0.75)+" 🪙) ";

        sellButton.onclick = () => {
            thisParam.sellTower(towerObject);
            displayTabHUD('hud-tab-general')
        }

        upgradeButton.onclick = () => {
            thisParam.upgradeTower(towerObject)
            displayTabHUD('hud-tab-general')
        }

        thisParam.fillTowerSpecs(towerObject.position.x, towerObject.position.y, enumTower[towerObject.type].fullName);

        sellContainer.appendChild(sellButton);
        upgradeContainer.appendChild(upgradeButton);
    }
}
