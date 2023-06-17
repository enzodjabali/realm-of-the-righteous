import anime from '../../node_modules/animejs/lib/anime.es.js';
import { enumSongs } from '../Model/enumSongs.js';
export class Display {
    constructor() {
        this.enemiesIds = [];
        this.tilesSize = 0;
        this.pile = -1;
        this.offsetsTop = 0;
        this.offsetsLeft = 0;
        this.snd1;
        this.snd2;

        // Hard-coded values for display settings and animations
        // imgAmmoRationSize: The ratio used to determine the height of the ammo image
        // imgAmmoRationSizeAlt: An alternate ratio used for specific cases of the ammo image height
        // healthBarColor: The color of the health bar displayed for enemies
        // frameDurationTower: The duration (in milliseconds) between frames of tower animation
        // frameDurationAmmo: The duration (in milliseconds) between frames of ammo animation
        // frameDurationImpact: The duration (in milliseconds) between frames of impact animation

        this.imgAmmoRationSize = 8;
        this.imgAmmoRationSizeAlt = 3;
        this.healthBarColor = 'green';
        this.frameDurationTower = 500;
        this.frameDurationAmmo = 250;
        this.frameDurationImpact = 500;
    }

    initializeBoard(matrice) {
        const imgDict = {
            basegrass: "../../assets/images/tiles/grasses.png",
            eastwest: "../../assets/images/tiles/eastwest.png",
            forkeast: "../../assets/images/tiles/forkeast.png",
            forknorth: "../../assets/images/tiles/forknorth.png",
            forksouth: "../../assets/images/tiles/forksouth.png",
            forwest: "../../assets/images/tiles/forkwest.png",
            ne: "../../assets/images/tiles/ne.png",
            northsouth: "../../assets/images/tiles/northsouth.png",
            nw: "../../assets/images/tiles/nw.png",
            rock: "../../assets/images/tiles/rock.png",
            se: "../../assets/images/tiles/se.png",
            sw: "../../assets/images/tiles/sw.png",
        };

        const container = document.getElementById("board-container");
        const container_offsets = container.getBoundingClientRect();
        this.offsetsTop = container_offsets.top;
        this.offsetsLeft = container_offsets.left;

        const containerElements = [
            "container-enemies",
            "container-towers",
            "container-Ammo",
        ];

        containerElements.forEach((element) => {
            const containerElement = document.getElementById(element);
            containerElement.style.top = "0";
            containerElement.style.left = "0";
        });

        const xRatio = (0.95 * window.innerWidth) / matrice[0].length;
        const yRatio = (0.95 * window.innerHeight) / matrice.length;
        this.tilesSize = Math.floor(Math.min(xRatio, yRatio));

        const columns = `${this.tilesSize - 1}px `.repeat(matrice[0].length);
        container.style.gridTemplateColumns = columns;

        matrice.forEach((row, x) => {
            row.forEach((cell, y) => {
                Object.entries(imgDict).forEach(([img_tile, path]) => {
                    if (cell.tile === img_tile) {
                        const img = document.createElement("img");
                        img.src = path;
                        img.width = this.tilesSize;
                        img.height = this.tilesSize;
                        container.appendChild(img);
                        if (img_tile === "basegrass") {
                            img.onclick = () => {
                                if (this.pile === -1) {
                                    this.pile = [img, [x, y]];
                                } else {
                                    this.pile[0].classList.remove("tile-shadow");
                                    this.pile = [img, [x, y]];
                                }
                                this.pile[0].setAttribute("class", "tile-shadow");
                            };
                        }
                    }
                });
            });
        });
    }



    initializeEnemy(enemy) {
        /**
         * @param {Enemy} enemy instance of enemy.
         * Permit to initialize the enemy
         */
        const enemyDiv = this.createElement('div', {
            id: `enemy_${enemy.getId()}`,
            className: 'enemy',
            style: {
                position: 'absolute',
                top: `${enemy.position.x * this.tilesSize + this.offsetsTop}px`,
                left: `${enemy.position.y * this.tilesSize + this.offsetsLeft - enemy.position.y}px`
            }
        });
        document.getElementById('container-enemies').appendChild(enemyDiv);
        const enemyImg = this.createImage({
            src: enemy.pathAlive,
            height: this.tilesSize,
            width: this.tilesSize,
            id: `enemyImg_${enemy.getId()}`
        });
        enemyDiv.appendChild(enemyImg);
        const healthBar = this.createElement('div', {
            id: `health_enemy_${enemy.getId()}`,
            className: 'health-bar',
            style: {
                backgroundColor: this.healthBarColor,
                height: `${this.tilesSize / 8}px`,
                width: `${(enemy.max_life / enemy.curent_life) * 100}%`
            }
        });
        enemyDiv.appendChild(healthBar);
    }

    initializeTower(tower) {
        const towerContainer = this.createElement('div', {
            id: `div_${tower.id}`,
            style: {
                position: 'absolute',
                height: `${this.tilesSize}px`,
                width: `${this.tilesSize}px`,
                top: `${tower.position.x * this.tilesSize + this.offsetsTop}px`,
                left: `${tower.position.y * this.tilesSize + this.offsetsLeft - tower.position.y}px`
            }
        });
        document.getElementById('container-towers').appendChild(towerContainer);
        const imgTower = this.createImage({
            id: `Img_${tower.id}`,
            src: tower.path,
            height: this.tilesSize,
            width: this.tilesSize,
            style: {
                position: 'absolute',
                top: '0',
                left: '0'
            }
        });
        towerContainer.appendChild(imgTower);
        const weaponDiv = this.createElement('div', {
            id: `weaponDiv_${tower.id}`,
            style: {
                position: 'absolute',
                height: `${this.tilesSize}px`,
                width: `${this.tilesSize}px`,
                top: `${-this.tilesSize * 0.2}px`,
                left: '0',
                overflow: 'hidden'
            }
        });
        towerContainer.appendChild(weaponDiv);
        const imgTowerWeapon = this.createImage({
            src: tower.pathWeapon,
            id: `weaponImg_${tower.id}`,
            height: this.tilesSize,
            width: this.tilesSize * tower.totalTowerFrames,
            style: {
                position: 'absolute',
                top: '0',
                left: '0'
            }
        });
        weaponDiv.appendChild(imgTowerWeapon);
        document.getElementById('container-towers').appendChild(towerContainer);
        return `div_${tower.id}`;
    }

    ShootEnemy(tower, enemy) {
        this.playTowerSprite(tower, enemy);
        const ammoDiv = this.initializeAmmo(tower);
        this.playAmmoSprite(tower);
        if (tower.type == 'T' || tower.type == 'WT') {
            this.rotateAmmoSprite(tower, enemy);
        }
        this.moveAmmoSprite(tower, enemy).then(() => {
            ammoDiv.remove();
            const impactDiv = this.initializeImpact(tower, enemy);
            this.playImpactSprite(tower).then(() => {
                impactDiv.remove();
                tower.towerAmmoId++;
            });
        });
    }

    initializeAmmo(tower) {
        let imgAmmoRationSize = this.imgAmmoRationSize;
        if (tower.type == 'T' || tower.type == 'WT') {
            imgAmmoRationSize = this.imgAmmoRationSizeAlt;
        }
        const ammoDiv = this.createElement('div', {
            id: `AmmoDiv_${tower.towerAmmoId}`,
            style: {
                position: 'absolute',
                height: `${Math.floor(this.tilesSize / imgAmmoRationSize)}px`,
                width: `${Math.floor(this.tilesSize / 8)}px`,
                top: `${tower.position.x * this.tilesSize + this.offsetsTop + this.tilesSize / 2 - this.tilesSize * 0.2}px`,
                left: `${tower.position.y * this.tilesSize + this.offsetsLeft - tower.position.y + this.tilesSize / 2}px`,
                overflow: 'hidden'
            }
        });
        const imgAmmo = this.createImage({
            src: tower.pathAmmo,
            id: `ammoImg_${tower.towerAmmoId}`,
            height: Math.floor(this.tilesSize / imgAmmoRationSize),
            width: Math.floor((this.tilesSize / 8) * tower.totalAmmoFrames),
            style: {
                position: 'absolute',
                top: '0',
                left: '0'
            }
        });
        ammoDiv.appendChild(imgAmmo);
        const containerAmmo = document.getElementById('container-Ammo');
        containerAmmo.appendChild(ammoDiv);
        return ammoDiv;
    }

    initializeImpact(tower, enemy) {
        const impactDiv = this.createElement('div', {
            id: `ImpactDiv_${tower.towerAmmoId}`,
            style: {
                position: 'absolute',
                height: `${Math.floor(this.tilesSize / 2)}px`,
                width: `${Math.floor(this.tilesSize / 2)}px`,
                top: `${enemy.position.x * this.tilesSize + this.offsetsTop + this.tilesSize / 2 - this.tilesSize * 0.2}px`,
                left: `${enemy.position.y * this.tilesSize + this.offsetsLeft - tower.position.y + this.tilesSize / 2}px`,
                overflow: 'hidden'
            }
        });
        const imgImpact = this.createImage({
            src: tower.pathImpact,
            id: `impactImg_${tower.towerAmmoId}`,
            height: Math.floor(this.tilesSize / 2),
            width: Math.floor((this.tilesSize / 2) * tower.totalImpactFrames),
            style: {
                position: 'absolute',
                top: '0',
                left: '0'
            }
        });
        impactDiv.appendChild(imgImpact);
        const containerImpact = document.getElementById('container-Ammo');
        containerImpact.appendChild(impactDiv);
        return impactDiv;
    }
    // Helper function to create elements with attributes and styles
    createElement(tag, options) {
        const element = document.createElement(tag);
        if (options.id) {
            element.id = options.id;
        }
        if (options.className) {
            element.className = options.className;
        }
        if (options.style) {
            Object.assign(element.style, options.style);
        }
        return element;
    }
    // Helper function to create image elements with attributes and styles
    createImage(options) {
        const img = new Image();
        if (options.src) {
            img.src = options.src;
        }
        if (options.height) {
            img.height = options.height;
        }
        if (options.width) {
            img.width = options.width;
        }
        if (options.id) {
            img.id = options.id;
        }
        if (options.style) {
            Object.assign(img.style, options.style);
        }
        return img;
    }

    playTowerSprite(tower, enemy) {
        this.clearIntervalAndResetFrame(tower, 'animationTowerInterval', 'currentTowerFrame');
        const { originX, originY } = this.getOriginWeapon(tower);
        const angle = this.getRotateAngle(tower, enemy);
        const weaponDiv = this.getElement(`weaponDiv_${tower.id}`);
        if (!weaponDiv) {
            return;
        }
        weaponDiv.style.transformOrigin = `${originX}px ${originY}px`;
        weaponDiv.style.transform = `rotate(${angle}deg)`;
        const imgTowerWeapon = this.getElement(`weaponImg_${tower.id}`);
        imgTowerWeapon.style.left = '0px';
        const frameDuration = Math.floor(this.frameDurationTower / tower.totalTowerFrames);
        tower.animationTowerInterval = setInterval(() => {
            this.animateSprite(tower, 'weaponImg', 'currentTowerFrame', 'totalTowerFrames', frameDuration, 'animationTowerInterval');
        }, frameDuration);
    }

    playAmmoSprite(tower) {
        this.clearIntervalAndResetFrame(tower, 'animationAmmoInterval', 'currentAmmoFrame');
        const imgAmmo = this.getElement(`ammoImg_${tower.towerAmmoId}`);
        if (!imgAmmo) {
            return;
        }
        imgAmmo.style.left = '0px';
        const frameDuration = Math.floor(this.frameDurationAmmo / tower.totalAmmoFrames);
        tower.animationAmmoInterval = setInterval(() => {
            this.animateSprite(tower, 'ammoImg', 'currentAmmoFrame', 'totalAmmoFrames', frameDuration, 'animationAmmoInterval');
        }, frameDuration);
    }

    moveAmmoSprite(tower, enemy) {
        const ammoDiv = this.getElement(`AmmoDiv_${tower.towerAmmoId}`);
        return new Promise((resolve) => {
            anime({
                targets: ammoDiv,
                top: `${enemy.position.x * this.tilesSize + this.offsetsTop}px`,
                left: `${enemy.position.y * this.tilesSize + this.offsetsLeft - enemy.position.y}px`,
                easing: 'linear',
                duration: 250,
                complete: function () {
                    resolve(true);
                }
            });
        });
    }

    rotateAmmoSprite(tower, enemy) {
        let imgAmmoRationSize = 8;
        if (tower.type == 'T' || tower.type == 'WT') {
            imgAmmoRationSize = 3;
        }
        const ammoDiv = this.getElement(`AmmoDiv_${tower.towerAmmoId}`);
        const progress = tower.currentAmmoFrame / tower.totalAmmoFrames;
        const originX = this.tilesSize / imgAmmoRationSize + (this.tilesSize / imgAmmoRationSize) * progress;
        const originY = this.tilesSize / imgAmmoRationSize;
        const angle = this.getRotateAngle(tower, enemy);
        ammoDiv.style.transformOrigin = `${originX}px ${originY}px`;
        ammoDiv.style.transform = `rotate(${angle}deg)`;
    }

    playImpactSprite(tower) {
        return new Promise((resolve, reject) => {
            this.clearIntervalAndResetFrame(tower, 'animationImpactInterval', 'currentImpactFrame');
            const imgImpact = this.getElement(`impactImg_${tower.towerAmmoId}`);
            if (!imgImpact) {
                reject('Impact element not found');
                return;
            }
            imgImpact.style.left = '0px';
            const frameDuration = Math.floor(this.frameDurationImpact / tower.totalImpactFrames);
            tower.animationImpactInterval = setInterval(() => {
                this.animateSprite(tower, 'impactImg', 'currentImpactFrame', 'totalImpactFrames', frameDuration, 'animationImpactInterval', resolve);
            }, frameDuration);
        });
    }

    animateSprite(tower, imgKey, frameKey, totalFramesKey, frameDuration, intervalKey, resolve) {
        if (tower[frameKey] >= tower[totalFramesKey]) {
            clearInterval(tower[intervalKey]);
            if (resolve) {
                resolve();
            }
            return;
        }
        const img = this.getElement(`${imgKey}_${tower.towerAmmoId}`);
        if (!img) {
            return;
        }
        const framePositionX = -tower[frameKey] * this.tilesSize / 8;
        img.style.left = `${framePositionX}px`;
        tower[frameKey]++;
    }

    clearIntervalAndResetFrame(tower, intervalKey, frameKey) {
        clearInterval(tower[intervalKey]);
        tower[frameKey] = 0;
    }

    getElement(id) {
        return document.getElementById(id);
    }

    getOriginWeapon(tower) {
        const progress = tower.currentTowerFrame / tower.totalTowerFrames;
        const originX = this.tilesSize / 2 + this.tilesSize * progress;
        const originY = this.tilesSize / 2;
        return { originX, originY };
    }

    getRotateAngle(tower, cell) {
        const deltaX = cell.position.x - tower.position.x;
        const deltaY = cell.position.y - tower.position.y;
        let angle = Math.atan2(deltaX, deltaY) * (180 / Math.PI);
        angle = angle + 90;
        return angle;
    }

    nextMoveEnemy(enemy) {
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
                duration: 10000 / enemy.speed, // Set the duration of the animation to 300 milliseconds
                complete: function () {
                    resolve('all good'); // Resolve the promise when the animation is complete
                }
            });
        });
    }

    async killEnemy(enemy) {
        /**
         * @param {enemy} enemy instance of enemy.
         * Permit to remove the enemy from matrice
        */
        let enemyDiv = document.getElementById(`enemy_${enemy.id}`);
        let enemyImg = document.getElementById(`enemyImg_${enemy.id}`);
        let healthBar = document.getElementById(`health_enemy_${enemy.id}`);
        const parentElement = enemyImg.parentNode; // Get the parent element of the div
        parentElement.removeChild(enemyImg); // Remove the enemy image from the parent element
        parentElement.removeChild(healthBar); // Remove the health bar from the parent element

        enemyImg = new Image();
        enemyImg.src = enemy.pathDead;
        enemyImg.height = this.tilesSize;
        enemyImg.width = this.tilesSize;
        enemyImg.id = `enemyImg_${enemy.id}`;
        enemyDiv.appendChild(enemyImg);
        await new Promise(r => setTimeout(r, 2000));
        enemyDiv.remove();
    }

    removeTower(tower) {
        /**
         * @param {tower} tower instance of tower.
         * Permit to remove the tower from matrice
         */
        let towerContainer = document.getElementById(`div_${tower.id}`);
        const parentElement = towerContainer.parentNode; // Get the parent element of the div
        parentElement.removeChild(towerContainer); // Remove the div element from its parent
    }

    flipItLeft(enemy) {
        /**
         * @param {enemy} enemy instance of enemy.
         * Permit to flip left enemy
         */
        let enemyId = enemy.id;
        let enemyImage = document.getElementById(`enemy_${enemyId}`)
        enemyImage.style.transform = 'scaleX(-1)';
    }

    flipItLeftRight(enemy) {
        /**
         * @param {enemy} enemy instance of enemy.
         * Permit to flip left to right enemy
         */
        let enemyId = enemy.id;
        let enemyImage = document.getElementById(`enemy_${enemyId}`)
        enemyImage.style.transform = 'scaleX(1)';
    }

    updateEnemyHealthBar(enemy) {
        const enemyId = `enemy_${enemy.id}`;
        const enemyDiv = document.getElementById(enemyId);
        let healthBar = enemyDiv.querySelector(`#health_${enemyId}`);
        healthBar.style.width = (enemy.curent_life / enemy.max_life) * 100 + '%';
    }
    updatePlayerData(money, life, killedEnemies, currentWave=null) {
        document.getElementById('money').innerText = "🪙 " + money + "";
        document.getElementById('life').innerText = "Current life : " + life + " ❤️";
        document.getElementById('killedEnemies').innerText = "💀 " + killedEnemies
        if(currentWave != null){
            console.log("updating current wave")
            document.getElementById('wave-counter').innerText = "🧟 " + this.romanizeNumber(currentWave);
        }

    }
    showTowerRange(towerPosition, range) {
        this.hideTowerRange()
        let x, y;
        let width = (this.tilesSize * range).toString() + "px"
        let height = (this.tilesSize * range).toString() + "px"

        x = ((towerPosition.x * this.tilesSize) + this.offsetsTop - ((this.tilesSize / 2) * (range - 1))).toString() + 'px'; /*10 = margin css*/
        y = ((towerPosition.y * this.tilesSize) + this.offsetsLeft - towerPosition.y - (this.tilesSize / 2 * (range - 1))).toString() + 'px'; /*10 = margin css*/

        let circle = document.createElement('div')
        circle.style.position = "absolute"
        circle.style.top = x;
        circle.style.left = y;

        circle.style.width = width;
        circle.style.height = height;

        circle.setAttribute('class', 'rangeCircle')
        document.body.appendChild(circle)
    }
    hideTowerRange() {
        const elements = document.getElementsByClassName('rangeCircle');
        while (elements.length > 0) {
            elements[0].parentNode.removeChild(elements[0]);
        }
    }
    romanizeNumber(num) {
        if (isNaN(num) || num == 0)
            return "0";
        var digits = String(+num).split(""),
            key = ["", "C", "CC", "CCC", "CD", "D", "DC", "DCC", "DCCC", "CM",
                "", "X", "XX", "XXX", "XL", "L", "LX", "LXX", "LXXX", "XC",
                "", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX"],
            roman = "",
            i = 3;
        while (i--)
            roman = (key[+digits.pop() + (i * 10)] || "") + roman;
        return Array(+digits.join("") + 1).join("M") + roman;
    }

    playBackgroundSong(songName) {
        let backgroundAudio = document.getElementById("background-audio");
        backgroundAudio.type = "audio/mpeg";
        backgroundAudio.src = enumSongs[songName];
        backgroundAudio.volume = 0.30;
        backgroundAudio.play();
    }
    playTowerSong(songName){
        let audio = document.getElementById("tower-audio");
        audio.type = "audio/mpeg";
        audio.src = enumSongs[songName];
        audio.play();
    }
    playBonusSong(songName){
        let bonusSong = document.getElementById("bonus-audio");
        bonusSong.type = "audio/mpeg";
        bonusSong.src = enumSongs[songName];
        bonusSong.play();
    }
    playEndGameSong(songName){
        let finalSong = document.getElementById("endgame-audio");
        finalSong.type = "audio/mpeg";
        finalSong.src = enumSongs[songName];
        finalSong.play();
    }
    playBoostTowerSong(songName){
        let boostTowerSong = document.getElementById("boost-tower-audio");
        boostTowerSong.type = "audio/mpeg";
        boostTowerSong.src = enumSongs[songName];
        boostTowerSong.play();
    }
    stopSong() {
        let backgroundAudio = document.getElementById("background-audio");
        backgroundAudio.currentTime = 0;
        backgroundAudio.volume = 0;
    }
}