import anime from '../../node_modules/animejs/lib/anime.es.js';
import {enumSongs} from '../Model/enumSongs.js';
export class Display{
    constructor() {
        this.enemiesIds = [];
        this.tilesSize = 0;
        this.pile = -1;
        this.offsetsTop = 0;
        this.offsetsLeft = 0;
        this.snd1;
        this.snd2;
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
            this.tilesSize = Math.floor(this.tilesSize)
        } else {
            this.tilesSize = xRatio
            this.tilesSize = Math.floor(this.tilesSize)
        }
        for (let a = 0 ; a < matrice[0].length ; a++){
            columns += `${this.tilesSize-1}px `

        }
        let container = document.getElementById('board-container');

        var container_offsets = document.getElementById('board-container').getBoundingClientRect();
        this.offsetsTop = container_offsets.top;
        this.offsetsLeft  = container_offsets.left;

        
        let containerEnemies = document.getElementById('container-enemies');
        containerEnemies.style.top = 0;
        containerEnemies.style.left = 0;

        let containerTowers = document.getElementById('container-towers');
        containerTowers.style.top = 0;
        containerTowers.style.left = 0;

        container.style.gridTemplateColumns = columns;

        let imgDict = {
            'basegrass': "../../assets/images/tiles/grasses.png",
            'eastwest': "../../assets/images/tiles/eastwest.png",
            'forkeast': "../../assets/images/tiles/forkeast.png",
            'forknorth': "../../assets/images/tiles/forknorth.png",
            'forksouth': "../../assets/images/tiles/forksouth.png",
            'forwest': "../../assets/images/tiles/forkwest.png",
            'ne': "../../assets/images/tiles/ne.png",
            'northsouth': "../../assets/images/tiles/northsouth.png",
            'nw': "../../assets/images/tiles/nw.png",
            'rock': "../../assets/images/tiles/rock.png",
            'se': "../../assets/images/tiles/se.png",
            'sw': "../../assets/images/tiles/sw.png",
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
        console.log(enemy)
        let enemyDiv = document.createElement('div');
        let enemyId = enemy.getId();
        enemyDiv.id = `enemy_${enemyId}`;
        enemyDiv.className = 'enemy';
        enemyDiv.style.position = 'absolute';
        enemyDiv.style.top = (enemy.position.x * this.tilesSize) + this.offsetsTop.toString() + 'px';
        enemyDiv.style.left = (enemy.position.y * this.tilesSize) + this.offsetsLeft - enemy.position.y.toString() + 'px';
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
        let towerContainer = document.createElement(`div_${tower.id}`);
        towerContainer.id = `div_${tower.id}`;
        towerContainer.style.position = 'absolute';
        towerContainer.style.height = this.tilesSize + 'px';
        towerContainer.style.width = this.tilesSize + 'px';
        towerContainer.style.top = ((tower.position.x * this.tilesSize) + this.offsetsTop ).toString() + 'px';
        towerContainer.style.left = ((tower.position.y * this.tilesSize) + this.offsetsLeft - tower.position.y).toString() + 'px';
        document.getElementById('container-towers').appendChild(towerContainer);

        let imgTower = new Image();
        imgTower.id = `Img_${tower.id}`;
        imgTower.src = tower.path;
        imgTower.style.height = this.tilesSize+ 'px';
        imgTower.style.width = this.tilesSize + 'px';
        imgTower.style.position = 'absolute';
        imgTower.style.top = 0 + 'px';;
        imgTower.style.left = '0';
        towerContainer.appendChild(imgTower);

        let weaponDiv = document.createElement('div');
        weaponDiv.id = `weaponDiv_${tower.id}`;
        weaponDiv.style.position = 'absolute';
        weaponDiv.style.height = this.tilesSize + 'px';
        weaponDiv.style.width = this.tilesSize + 'px';
        weaponDiv.style.top = -this.tilesSize*0.2 + 'px';;
        weaponDiv.style.left = '0';
        weaponDiv.style.overflow = 'hidden';
        towerContainer.appendChild(weaponDiv);

        let imgTowerWeapon = new Image();
        imgTowerWeapon.src = tower.pathWeapon;
        imgTowerWeapon.id = `weaponImg_${tower.id}`;
        imgTowerWeapon.height = this.tilesSize;
        imgTowerWeapon.width = (this.tilesSize * tower.totalTowerFrames);
        imgTowerWeapon.style.position = 'absolute';
        imgTowerWeapon.style.top = '0';
        imgTowerWeapon.style.left = '0';
        weaponDiv.appendChild(imgTowerWeapon);

        document.getElementById('container-towers').appendChild(towerContainer);
        return `div_${tower.id}`;
    }

    initializeAmmo(tower) {
        const ammoDiv = document.createElement('div');
        ammoDiv.id = `AmmoDiv_${tower.towerAmmoId}`;
        ammoDiv.style.position = 'absolute';
        ammoDiv.style.height = this.tilesSize + 'px';
        ammoDiv.style.width = this.tilesSize + 'px';
        ammoDiv.style.top = -this.tilesSize * 0.50 + 'px';
        ammoDiv.style.left = '0';
        ammoDiv.style.overflow = 'hidden';

        const imgAmmo = new Image();
        imgAmmo.src = tower.pathAmmo;
        imgAmmo.id = `weaponImg_${tower.id}`;
        imgAmmo.height = this.tilesSize;
        imgAmmo.width = this.tilesSize * tower.totalTowerFrames;
        imgAmmo.style.position = 'absolute';
        imgAmmo.style.top = '0';
        imgAmmo.style.left = '0';
        ammoDiv.appendChild(imgAmmo);
        const weaponDiv = document.getElementById(`weaponImg_${tower.id}`);
        weaponDiv.appendChild(ammoDiv);
        tower.towerAmmoId++;
    }

    playAmmoSprite(tower) {
        const ammoDiv = document.getElementById(`AmmoDiv_${tower.towerAmmoId}`);
        const imgAmmo = document.getElementById(`weaponImg_${tower.id}`);
        let frame_2 = 0;
        let id = setInterval(frame, 1000);
        function frame() {
            if (frame === tower.totalTowerFrames) {
                clearInterval(id);
                ammoDiv.remove();
            } else {
                frame++;
                imgAmmo.style.left = -frame * this.tilesSize + 'px';
            }
        }
    }


    playTowerSprite(tower, enemy) {
        this.initializeAmmo(tower)
        clearInterval(tower.animationInterval);
        tower.currentFrame = 0;
        const { originX, originY } = this.getOriginWeapon(tower);
        let angle = this.rotateWeapon(tower, enemy)
        if(!document.getElementById(`weaponDiv_${tower.id}`)){
            return;
        }
        let weaponDiv = document.getElementById(`weaponDiv_${tower.id}`);
        weaponDiv.style.transformOrigin = `${originX}px ${originY}px`;
        weaponDiv.style.transform = `rotate(${angle}deg)`;
        let imgTowerWeapon = document.getElementById(`weaponImg_${tower.id}`);
        imgTowerWeapon.style.left = '0px';
        const frameDuration = Math.floor(tower.shotRate / tower.totalTowerFrames);
        tower.animationInterval = setInterval(() => {
            this.animateSprite(tower);
            if (tower.currentFrame >= tower.totalTowerFrames) {
                clearInterval(tower.animationInterval);
            }
        }, frameDuration);
    }
    animateSprite(tower) {
        if (tower.currentFrame >= tower.totalTowerFrames) {
            clearInterval(tower.animationInterval);
            return;
        }
        if(!document.getElementById(`weaponImg_${tower.id}`)){
            return;
        }
        let framePositionX = -tower.currentFrame * this.tilesSize;
        let imgTowerWeapon = document.getElementById(`weaponImg_${tower.id}`);
        imgTowerWeapon.style.left = `${framePositionX}px`;
        tower.currentFrame++;
    }

    getOriginWeapon(tower) {
        const progress = tower.currentFrame / tower.totalTowerFrames;
        const originX = this.tilesSize / 2 + this.tilesSize * progress;
        const originY = this.tilesSize / 2;
        return { originX, originY };
    }

    rotateWeapon(tower, cell) {
        const deltaX = cell.position.x - tower.position.x;
        const deltaY = cell.position.y - tower.position.y;
        let angle = Math.atan2(deltaX, deltaY) * (180 / Math.PI); // Calculate angle in degrees
        angle = angle + 90; // Rotate 180 degrees
        return angle
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
                top: ((enemy.position.x * this.tilesSize) + this.offsetsTop).toString() + 'px', // Set the top property to the new position's x coordinate
                left: ((enemy.position.y * this.tilesSize) + this.offsetsLeft - enemy.position.y).toString() + 'px', // Set the left property to the new position's y coordinate
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
        let towerContainer = document.getElementById(`div_${tower.id}`);
        const parentElement = towerContainer.parentNode; // Get the parent element of the div
        parentElement.removeChild(towerContainer); // Remove the div element from its parent
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
    
    updatePlayerData(money, life, killedEnemies, currentWave){
        document.getElementById('money').innerText = "🪙 "+money+"";
        document.getElementById('life').innerText = "Current life : "+life+" ❤️";
        document.getElementById('killedEnemies').innerText = "💀 "+killedEnemies
        document.getElementById('wave-counter').innerText = "🧟 "+this.romanizeNumber(currentWave+1);
    }
    showTowerRange(towerPosition, range){
        this.hideTowerRange()
        let x, y;
        let width = (this.tilesSize * range).toString()+"px"
        let height = (this.tilesSize * range).toString()+"px"

        x = ((towerPosition.x * this.tilesSize) + this.offsetsTop - ((this.tilesSize/2)*(range-1))).toString() + 'px'; /*10 = margin css*/
        y = ((towerPosition.y * this.tilesSize) + this.offsetsLeft - towerPosition.y - (this.tilesSize/2*(range-1))).toString() + 'px'; /*10 = margin css*/

        let circle = document.createElement('div')
        circle.style.position = "absolute"
        circle.style.top = x;
        circle.style.left = y;

        circle.style.width = width;
        circle.style.height = height;

        circle.setAttribute('class', 'rangeCircle')
        document.body.appendChild(circle)
    }
    hideTowerRange(){
        const elements = document.getElementsByClassName('rangeCircle');
        while(elements.length > 0){
            elements[0].parentNode.removeChild(elements[0]);
        }
    }
    romanizeNumber (num) {
        if (isNaN(num) || num == 0)
            return "I";
        var digits = String(+num).split(""),
            key = ["","C","CC","CCC","CD","D","DC","DCC","DCCC","CM",
                "","X","XX","XXX","XL","L","LX","LXX","LXXX","XC",
                "","I","II","III","IV","V","VI","VII","VIII","IX"],
            roman = "",
            i = 3;
        while (i--)
            roman = (key[+digits.pop() + (i * 10)] || "") + roman;
        return Array(+digits.join("") + 1).join("M") + roman;
    }
    playSong(backgroundMusic, songName){
        let audio = document.getElementById("audio");
        let backgroundAudio = document.getElementById("backgroundAudio");
        if(backgroundMusic) {
            // this.snd1 = new Audio();
            // let src1 = document.createElement("source");
            console.log(songName)
            backgroundAudio.type = "audio/mpeg";
            backgroundAudio.src = enumSongs[songName];
            backgroundAudio.volume = 0.30;
            backgroundAudio.play();
        } else {
            audio.type = "audio/mpeg";
            audio.src = enumSongs[songName];
            audio.play();
        }
    }

    stopSong(){
        let backgroundAudio = document.getElementById("backgroundAudio");
        backgroundAudio.currentTime = 0;
        backgroundAudio.volume = 0;
        // this.snd1.pause();
    }
}