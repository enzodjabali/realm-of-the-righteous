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
        this.imgAmmoRationSize = 8;     // imgAmmoRationSize: The ratio used to determine the height of the ammo image
        this.imgAmmoRationSizeAlt = 3;  // imgAmmoRationSizeAlt: An alternate ratio used for specific cases of the ammo image height
        this.healthBarColor = 'green';  // healthBarColor: The color of the health bar displayed for enemies
        this.frameDurationTower = 500;  // frameDurationTower: The duration (in milliseconds) between frames of tower animation
        this.frameDurationAmmo = 250;   // frameDurationAmmo: The duration (in milliseconds) between frames of ammo animation
        this.frameDurationImpact = 500;  // frameDurationImpact: The duration (in milliseconds) between frames of impact animation
    }


    /**
 * Initializes the game board based on the provided matrix.
 * 
 * @param {Dict} matrice - Dictionary of all the data about the game.
 *                     It permits the initialization of the board.
 */
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

        const xRatio = (window.innerWidth) / matrice[0].length;
        const yRatio = (window.innerHeight) / matrice.length;
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


    /**
     * Initializes an enemy on the game board.
     * 
     * @param {Enemy} enemy - Instance of the enemy.
     *                        It permits the initialization of the enemy.
     */
    initializeEnemy(enemy) {
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

    /**
     * Initializes a tower on the game board.
     * 
     * @param {Tower} tower - Instance of the tower.
     *                        It permits the initialization of the tower.
     * @returns {string} - ID of the tower container element.
     */
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

    /**
     * Shoots an enemy with a tower.
     * 
     * @param {Tower} tower - Instance of the tower.
     *                        It represents the tower shooting the enemy.
     * @param {Enemy} enemy - Instance of the enemy.
     *                        It represents the enemy being shot by the tower.
     */
    ShootEnemy(tower, enemy) {
        this.playTowerSprite(tower, enemy);
        const ammoDiv = this.initializeAmmo(tower);
        this.playAmmoSprite(tower);
        if (tower.type == 'T' || tower.type == 'WT' || tower.type == 'NT') {
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

    /**
     * Initializes the ammunition for a tower.
     * 
     * @param {Tower} tower - Instance of the tower.
     *                        It represents the tower for which ammunition is being initialized.
     * @returns {HTMLElement} - The created ammunition div element.
     */
    initializeAmmo(tower) {
        let imgAmmoRationSize = this.imgAmmoRationSize;
        if (tower.type == 'T' || tower.type == 'WT' || tower.type == 'NT') {
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

    /**
     * Initializes the impact of a tower's ammunition on an enemy.
     * 
     * @param {Tower} tower - Instance of the tower.
     *                        It represents the tower that fired the ammunition.
     * @param {Enemy} enemy - Instance of the enemy.
     *                        It represents the enemy on which the ammunition impact is being initialized.
     * @returns {HTMLElement} - The created impact div element.
     */
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

    /**
     * Creates a new HTML element with the specified tag and options.
     * 
     * @param {string} tag - The HTML tag of the element to create.
     * @param {Object} options - The options for configuring the element.
     * @param {string} [options.id] - The ID attribute of the element.
     * @param {string} [options.className] - The class attribute of the element.
     * @param {Object} [options.style] - The CSS styles to apply to the element.
     * @returns {HTMLElement} - The created HTML element.
     */
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
    
    /**
     * Creates a new HTML image element with the specified options.
     * 
     * @param {Object} options - The options for configuring the image element.
     * @param {string} [options.src] - The source URL of the image.
     * @param {number} [options.height] - The height of the image in pixels.
     * @param {number} [options.width] - The width of the image in pixels.
     * @param {string} [options.id] - The ID attribute of the image element.
     * @param {Object} [options.style] - The CSS styles to apply to the image element.
     * @returns {HTMLImageElement} - The created image element.
     */
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

    /**
     * Plays the tower sprite animation by rotating the weapon towards the enemy.
     * 
     * @param {Tower} tower - The tower instance.
     * @param {Enemy} enemy - The enemy instance.
     */
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


    /**
     * Plays the ammo sprite animation for the given tower.
     * 
     * @param {Tower} tower - The tower instance.
     */
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

    /**
     * Rotates the ammo sprite for the given tower based on the position of the enemy.
     * 
     * @param {Tower} tower - The tower instance.
     * @param {Enemy} enemy - The enemy instance.
     */
    rotateAmmoSprite(tower, enemy) {
        let imgAmmoRationSize = 8;
        if (tower.type == 'T' || tower.type == 'WT' || tower.type == 'NT') {
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

    /**
     * Moves the ammo sprite of the given tower towards the position of the enemy.
     * 
     * @param {Tower} tower - The tower instance.
     * @param {Enemy} enemy - The enemy instance.
     * @returns {Promise<boolean>} - A promise that resolves when the movement is complete.
     */
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

    /**
     * Plays the impact sprite animation for the given tower.
     * 
     * @param {Tower} tower - The tower instance.
     * @returns {Promise<boolean>} - A promise that resolves when the impact sprite animation is complete, or rejects if the impact element is not found.
     */
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

    /**
     * Animates the sprite frames for the given tower using the specified image key, frame key, total frames key, frame duration, interval key, and optional resolve callback.
     * 
     * @param {Tower} tower - The tower instance.
     * @param {string} imgKey - The key for accessing the image element.
     * @param {string} frameKey - The key for accessing the current frame index.
     * @param {string} totalFramesKey - The key for accessing the total number of frames.
     * @param {number} frameDuration - The duration of each frame in milliseconds.
     * @param {string} intervalKey - The key for accessing the interval ID.
     * @param {Function} [resolve] - Optional resolve callback to be called when the animation is complete.
     */
    animateSprite(tower, imgKey, frameKey, totalFramesKey, frameDuration, intervalKey, resolve) {
        if (tower[frameKey] >= tower[totalFramesKey]) {
            clearInterval(tower[intervalKey]);
            if (resolve) {
                resolve(true);
            }
            return;
        }
        let img;
        let framePositionX;
        switch (imgKey) {
            case 'weaponImg':
                img = this.getElement(`weaponImg_${tower.id}`);
                framePositionX = -tower[frameKey] * this.tilesSize; // Move weapon image based on current frame
                break;
            case 'ammoImg':
                img = this.getElement(`ammoImg_${tower.towerAmmoId}`);
                framePositionX = -tower[frameKey] * this.tilesSize / 8; // Move ammo image based on current frame
                break;
            case 'impactImg':
                img = this.getElement(`impactImg_${tower.towerAmmoId}`);
                framePositionX = -tower[frameKey] * this.tilesSize / 2; // Move impact image based on current frame
                break;
            default:
                console.log('animateSprite: invalid imgKey');
                return;
        }
        if (!img) {
            return;
        }
        img.style.left = `${framePositionX}px`;
        tower[frameKey]++;
    }

    /**
     * Clears the interval associated with the specified interval key and resets the frame value to zero for the given tower.
     * 
     * @param {Tower} tower - The tower instance.
     * @param {string} intervalKey - The key for accessing the interval ID.
     * @param {string} frameKey - The key for accessing the frame value.
     */
    clearIntervalAndResetFrame(tower, intervalKey, frameKey) {
        clearInterval(tower[intervalKey]);
        tower[frameKey] = 0;
    }

    /**
     * Retrieves the DOM element with the specified ID.
     * 
     * @param {string} id - The ID of the element to retrieve.
     * @returns {HTMLElement|null} The DOM element with the given ID, or null if it is not found.
     */
    getElement(id) {
        return document.getElementById(id);
    }
    
    /**
     * Retrieves the origin coordinates for rotating the weapon of a tower.
     * 
     * @param {Tower} tower - The tower instance.
     * @returns {Object} An object containing the origin coordinates {originX, originY}.
     */
    getOriginWeapon(tower) {
        const progress = tower.currentTowerFrame / tower.totalTowerFrames;
        const originX = this.tilesSize / 2 + this.tilesSize * progress;
        const originY = this.tilesSize / 2;
        return { originX, originY };
    }

    /**
     * Calculates the rotation angle between a tower and a cell.
     * 
     * @param {Tower} tower - The tower instance.
     * @param {Cell} cell - The cell instance representing the target position.
     * @returns {number} The rotation angle in degrees.
     */
    getRotateAngle(tower, cell) {
        const deltaX = cell.position.x - tower.position.x;
        const deltaY = cell.position.y - tower.position.y;
        let angle = Math.atan2(deltaX, deltaY) * (180 / Math.PI);
        angle = angle + 90;
        return angle;
    }

    /**
     * Moves the enemy to its next position on the game board using animation.
     * 
     * @param {Enemy} enemy - The enemy instance.
     * @returns {Promise} A promise that resolves when the animation is complete.
     */
    nextMoveEnemy(enemy) {
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

    /**
     * Removes the enemy from the game board after it has been killed.
     *
     * @param {Enemy} enemy - The enemy instance to be removed.
     * @returns {Promise} A promise that resolves after a delay of 2000 milliseconds.
     */
    async killEnemy(enemy) {
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

    /**
     * Removes a tower from the game board.
     *
     * @param {Tower} tower - The tower instance to be removed.
     */
    removeTower(tower) {
        let towerContainer = document.getElementById(`div_${tower.id}`);
        const parentElement = towerContainer.parentNode; // Get the parent element of the div
        parentElement.removeChild(towerContainer); // Remove the div element from its parent
    }

    /**
     * Removes the ammo from the game board.
     */
    clearAmmoContainer() {
        const containerImpact = document.getElementById(`container-Ammo`);
        console.log(containerImpact);
        containerImpact.innerHTML = "";
    }

    /**
     * Flips the enemy image horizontally to the left.
     *
     * @param {Enemy} enemy - The enemy instance to flip.
     */
    flipItLeft(enemy) {
        let enemyId = enemy.id;
        let enemyImage = document.getElementById(`enemy_${enemyId}`)
        enemyImage.style.transform = 'scaleX(-1)';
    }

    /**
     * Flips the enemy image horizontally to the right.
     *
     * @param {Enemy} enemy - The enemy instance to flip.
     */
    flipItLeftRight(enemy) {
        let enemyId = enemy.id;
        let enemyImage = document.getElementById(`enemy_${enemyId}`)
        enemyImage.style.transform = 'scaleX(1)';
    }

    /**
     * Updates the health bar of an enemy based on its current life.
     *
     * @param {Enemy} enemy - The enemy instance whose health bar needs to be updated.
     */
    updateEnemyHealthBar(enemy) {
        const enemyId = `enemy_${enemy.id}`;
        const enemyDiv = document.getElementById(enemyId);
        let healthBar = enemyDiv.querySelector(`#health_${enemyId}`);
        healthBar.style.width = (enemy.curent_life / enemy.max_life) * 100 + '%';
    }

    /**
     * Updates the player's data on the game interface.
     *
     * @param {number} money - The amount of money the player has.
     * @param {number} life - The player's current life.
     * @param {number} killedEnemies - The number of enemies killed by the player.
     * @param {number|null} currentWave - The current wave of enemies (optional).
     */
    updatePlayerData(money, life, killedEnemies, currentWave=null) {
        document.getElementById('money').innerText = "🪙 " + money + "";
        document.getElementById('life').innerText = "Current life : " + life + " ❤️";
        document.getElementById('killedEnemies').innerText = "💀 " + killedEnemies
        if(currentWave != null){
            document.getElementById('wave-counter').innerText = "🧟 " + this.romanizeNumber(currentWave);
        }
    }

    /**
     * Displays the range of a tower on the game interface.
     *
     * @param {Object} towerPosition - The position of the tower.
     * @param {number} range - The range of the tower.
     */
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

    /**
     * Hides the range circles of towers from the game interface.
     */
    hideTowerRange() {
        const elements = document.getElementsByClassName('rangeCircle');
        while (elements.length > 0) {
            elements[0].parentNode.removeChild(elements[0]);
        }
    }

    /**
     * Converts a number to its Roman numeral representation.
     * @param {number} num - The number to be converted.
     * @returns {string} The Roman numeral representation of the input number.
     */
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

    /**
     * Plays the background song with the specified name.
     * @param {string} songName - The name of the background song to be played.
     */
    playBackgroundSong(songName) {
        let backgroundAudio = document.getElementById("background-audio");
        backgroundAudio.type = "audio/mpeg";
        backgroundAudio.src = enumSongs[songName];
        backgroundAudio.volume = 0.30;
        backgroundAudio.play();
    }

    /**
     * Plays the tower-specific song with the specified name.
     * @param {string} songName - The name of the tower song to be played.
     */
    playTowerSong(songName){
        let audio = document.getElementById("tower-audio");
        audio.type = "audio/mpeg";
        audio.src = enumSongs[songName];
        audio.play();
    }

    /**
     * Plays the bonus song with the specified name.
     * @param {string} songName - The name of the bonus song to be played.
     */
    playBonusSong(songName){
        let bonusSong = document.getElementById("bonus-audio");
        bonusSong.type = "audio/mpeg";
        bonusSong.src = enumSongs[songName];
        bonusSong.play();
    }

    /**
     * Plays the end game song with the specified name.
     * @param {string} songName - The name of the end game song to be played.
     */
    playEndGameSong(songName){
        let finalSong = document.getElementById("endgame-audio");
        finalSong.type = "audio/mpeg";
        finalSong.src = enumSongs[songName];
        finalSong.play();
    }

    /**
     * Plays the boost tower song with the specified name.
     * @param {string} songName - The name of the boost tower song to be played.
     */
    playBoostTowerSong(songName){
        let boostTowerSong = document.getElementById("boost-tower-audio");
        boostTowerSong.type = "audio/mpeg";
        boostTowerSong.src = enumSongs[songName];
        boostTowerSong.play();
    }

    /**
     * Stops the currently playing song.
     * It sets the current time of the song to the beginning and mutes the volume.
     */
    stopSong() {
        let backgroundAudio = document.getElementById("background-audio");
        backgroundAudio.currentTime = 0;
        backgroundAudio.volume = 0;
    }
}