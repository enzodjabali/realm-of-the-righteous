import anime from '../../node_modules/animejs/lib/anime.es.js';

export class Display{
    constructor() {
        this.enemiesIds = [];
        this.tilesSize = 0;
        this.pile = -1;
    }
    initializeBoard(matrice){
        /**
         * @param {Dict} matrice dictionnary of all the data about the game.
         * Permit to initialize board
        */
        let columns = '';
        // HELP ME
        let xRatio;
        let yRatio;
        xRatio = (0.95*window.innerWidth) / (matrice[0].length);
        yRatio = (0.95*window.innerHeight) / (matrice.length);

        if (xRatio >= yRatio){
            this.tilesSize = yRatio
        } else {
            this.tilesSize = xRatio
        }
        for (let a = 0 ; a < matrice[0].length ; a++){
            columns += `${this.tilesSize-1}px `

        }
        let container = document.getElementById('board-container');

        let containerEnemies = document.getElementById('container-enemies');
        containerEnemies.style.top = 0;
        containerEnemies.style.left = 0;

        let containerTowers = document.getElementById('container-towers');
        containerTowers.style.top = 0;
        containerTowers.style.left = 0;

        container.style.gridTemplateColumns = columns;

        let imgDict = {
            'basegrass': "../../assets/images/tiles/basegrass.png",
            'basepath':"../../assets/images/tiles/basepath.png",
            'basepathrockhorizontal': "../../assets/images/tiles/basepathrockhorizontal.png",
            'basepathrockvertical': "../../assets/images/tiles/basepathrockvertical.png",
            'bordereast': "../../assets/images/tiles/bordereast.png",
            'bordernorth': "../../assets/images/tiles/bordernorth.png",
            'bordersouth': "../../assets/images/tiles/bordersouth.png",
            'borderwest': "../../assets/images/tiles/borderwest.png",
            'towereast': "../../assets/images/tiles/towereast.png",
            'towernorth': "../../assets/images/tiles/towernorth.png",
            'towersouth': "../../assets/images/tiles/towersouth.png",
            'towerwest': "../../assets/images/tiles/towerwest.png",
            'northwest': "../../assets/images/tiles/northwest.png",
            'southwest': "../../assets/images/tiles/southwest.png",
            'northeast': "../../assets/images/tiles/northeast.png",
            'southeast': "../../assets/images/tiles/southeast.png",
            'northwestcorner': "../../assets/images/tiles/northwestcorner.png",
            'southwestcorner': "../../assets/images/tiles/southwestcorner.png",
            'northeastcorner': "../../assets/images/tiles/northeastcorner.png",
            'southeastcorner': "../../assets/images/tiles/southeastcorner.png",
        }

        for (let x = 0 ; x < matrice.length ; x++){
            for (let y = 0 ; y < matrice[x].length ; y++){
                for(let [img_tile, path] of Object.entries(imgDict)){
                    if(matrice[x][y].tile == img_tile){
                        let img = document.createElement("img");
                        img.src = path;
                        img.width = this.tilesSize;
                        img.height = this.tilesSize;
                        document.getElementById('board-container').appendChild(img);
                        if(img_tile = 'basegrass'){
                            img.onclick = () => {
                                if(this.pile == -1){
                                    this.pile = [img, [x,y]];
                                } else {
                                    this.pile[0].classList.remove('tile-shadow'); // remove class (not selected anymore)
                                    this.pile = [img, [x,y]]
                                }
                                this.pile[0].setAttribute('class', 'tile-shadow');
                            }
                        }
                    }
                }
            }
        }
    }

    initializeEnemy(enemy){
        /**
         * @param {Enemy} enemy instance of enemy.
         * Permit to initialize the enemy
         */
        let enemyDiv = document.createElement('div');
        let enemyId = enemy.getId();
        enemyDiv.id = `enemy_${enemyId}`;
        enemyDiv.className = 'enemy';
        enemyDiv.style.position = 'absolute';
        enemyDiv.style.top = (enemy.position.x * this.tilesSize).toString() + 'px';
        enemyDiv.style.left = (enemy.position.y * this.tilesSize).toString() + 'px';
        document.getElementById('container-enemies').appendChild(enemyDiv);

        let enemyImg = new Image();
        enemyImg.src = enemy.path_img;
        enemyImg.height = this.tilesSize;
        enemyImg.width = this.tilesSize;
        enemyImg.id = `enemyImg_${enemyId}`;
        enemyDiv.appendChild(enemyImg);

        let healthBar = document.createElement('div');
        let healthBarId = `health_enemy_${enemyId}`;
        healthBar.id = healthBarId;
        healthBar.className = 'health-bar';
        healthBar.style.backgroundColor = 'green';
        healthBar.style.height = this.tilesSize/8+'px'; // Set initial health to 100%
        healthBar.style.width = (enemy.max_life/enemy.curent_life)*100 +'%'; // Set initial health to 100%
        enemyDiv.appendChild(healthBar);
    }

    initializeTower(tower) {
        /**
         * @param {Tower} tower instance of tower.
         * Permit to initialize the tower
        */

        let towerDiv = document.createElement(`tower_div_${tower.id}`);
            towerDiv.id = `tower_div_${tower.id}`;
            towerDiv.style.position = 'absolute';
            towerDiv.style.height = this.tilesSize + 'px';
            towerDiv.style.width = this.tilesSize + 'px';
            towerDiv.style.top = (tower.position.x * this.tilesSize - tower.position.x + 10).toString() + 'px'; /*10 = margin css*/
            towerDiv.style.left = (tower.position.y * this.tilesSize - tower.position.y + 10).toString() + 'px'; /*10 = margin css*/
            towerDiv.style.overflow = 'hidden';
            document.getElementById('container-towers').appendChild(towerDiv);

        let imgTower = new Image();
            imgTower.id = `towerImg_${tower.id}`
            imgTower.src = tower.path;
            imgTower.style.height = this.tilesSize + 'px';
            imgTower.style.width = this.tilesSize + 'px';
            imgTower.style.center = 'center';
            imgTower.style.position = 'absolute';
            towerDiv.appendChild(imgTower);

        let imgTowerWeapon = new Image
            imgTowerWeapon.src = tower.pathWeapon;
            imgTowerWeapon.id = `weaponImg_${tower.id}`;
            imgTowerWeapon.height = this.tilesSize;
            imgTowerWeapon.width = (this.tilesSize * tower.totalFrames);
            imgTowerWeapon.style.position = 'absolute';
            towerDiv.appendChild(imgTowerWeapon);

        return towerDiv;
    }

    playSprite(animationInterval, frameDuration, tower, spriteImage) {
        clearInterval(animationInterval);
        console.log(tower, '<<<<<<<< tower from initializeWeapon ')
        tower.currentFrame = 0;
        spriteImage.style.left = '0px';
        animationInterval = setInterval(this.animateSprite(tower), frameDuration);
    }

    nextMoveEnemy(enemy){
        /**
         * @param {enemy} enemy instance of enemy.
         * Permit to make move the enemy by its coordinates in matrice
         */
        let enemyId = enemy.id;
        let enemyDiv = document.getElementById(`enemy_${enemyId}`);
        return new Promise((resolve) => {
            // Use the anime.js library to animate the enemyImage's top and left properties
            anime({
                targets: enemyDiv,
                top: (enemy.position.x) * this.tilesSize, // Set the top property to the new position's x coordinate
                left: (enemy.position.y) * this.tilesSize, // Set the left property to the new position's y coordinate
                easing: 'linear', // Use linear easing for smooth movement
                duration: 10000/enemy.speed, // Set the duration of the animation to 300 milliseconds
                complete: function (){
                    resolve('all good'); // Resolve the promise when the animation is complete
                }
            });
        });
    }
    removeEnemy(enemy){
        /**
         * @param {enemy} enemy instance of enemy.
         * Permit to remove the enemy from matrice
         */
        let enemyDiv = document.getElementById(`enemy_${enemy.id}`);
        const parentElement = enemyDiv.parentNode; // Get the parent element of the div
        parentElement.removeChild(enemyDiv); // Remove the div element from its parent
    }
    removeTower(tower){
        /**
         * @param {tower} tower instance of tower.
         * Permit to remove the tower from matrice
         */
        let towerDiv = document.getElementById(`tower_div_${tower.id}`);        
        const parentElement = towerDiv.parentNode; // Get the parent element of the div
        parentElement.removeChild(towerDiv); // Remove the div element from its parent
    }
    flipItLeft(enemy){
        /**
         * @param {enemy} enemy instance of enemy.
         * Permit to flip left enemy
         */
        let enemyId = enemy.id;
        let enemyImage = document.getElementById(`enemy_${enemyId}`)
        enemyImage.style.transform = 'scaleX(-1)';
    }
    flipItLeftRight(enemy){
        /**
         * @param {enemy} enemy instance of enemy.
         * Permit to flip left to right enemy
         */
        let enemyId = enemy.id;
        let enemyImage = document.getElementById(`enemy_${enemyId}`)
        enemyImage.style.transform = 'scaleX(1)';
    }
    updateEnemyHealthBar(enemy){
        const enemyId = `enemy_${enemy.id}`;
        const enemyDiv = document.getElementById(enemyId);
        let healthBar = enemyDiv.querySelector(`#health_${enemyId}`);
        healthBar.style.width = (enemy.curent_life/enemy.max_life)*100 +'%';        
    }
    updatePlayerData(money, life){
        let playerMoney = document.getElementById('money');
        let playerLife = document.getElementById('life');
        playerMoney.innerText = money
        playerLife.innerText = life
    }
}