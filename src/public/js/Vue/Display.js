import anime from '../../node_modules/animejs/lib/anime.es.js';

export class Display{
    constructor() {
        this.enemiesIds = [];
        this.tilesSize = 0;
        this.pile = -1;
    }
    initializeBoard(matrice){
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
            'northeast':"../../assets/images/tiles/northeast.png",
            'northeastcorner':"../../assets/images/tiles/northeastcorner.png",
            'northwest':"../../assets/images/tiles/northwest.png",
            'northwestcorner':"../../assets/images/tiles/northwestcorner.png",
            'southeast':"../../assets/images/tiles/southeast.png",
            'southeastcorner':"../../assets/images/tiles/southeastcorner.png",
            'southwest':"../../assets/images/tiles/southwest.png",
            'southwestcorner':"../../assets/images/tiles/southwestcorner.png",
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
                        //HELP ME Revoir avec Baba
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
        let imgEnemy = new Image();
        imgEnemy.src = enemy.path_img;

        // Maybe put img size in Json to make it dynamic --> HELP ME
        imgEnemy.height = this.tilesSize;
        imgEnemy.width = this.tilesSize;
        //Set an ID to the enemy. Permits to get it later
        imgEnemy.setAttribute('id', enemy.getId());
      
        document.getElementById('container-enemies').appendChild(imgEnemy);
        let enemyCss = document.getElementById(enemy.getId());
        enemyCss.style.position = 'absolute';
        enemyCss.style.top = (enemy.position.x * this.tilesSize + 0.5*this.tilesSize - imgEnemy.height/2).toString()+'px';
        enemyCss.style.left = (enemy.position.y * this.tilesSize + 0.5*this.tilesSize - imgEnemy.width/2).toString()+'px';
    }

    initializeTower(tower){
        let imgTower = new Image();
        imgTower.src = tower.path;

        imgTower.height = this.tilesSize;
        imgTower.width = this.tilesSize;

        //Set an ID to the enemy. Permits to get it later
        imgTower.setAttribute('id', tower.getId());

        document.getElementById('container-towers').appendChild(imgTower);
        let towerCss = document.getElementById(tower.getId());
        towerCss.style.position = 'absolute';
        towerCss.style.top = (tower.position.x * this.tilesSize + 0.5*this.tilesSize - imgTower.height/2).toString()+'px';
        towerCss.style.left = (tower.position.y * this.tilesSize + 0.5*this.tilesSize - imgTower.width/2).toString()+'px';

    }
    nextMoveEnemy(enemy){
        console.log(enemy)
        let enemyId = enemy.id;
        let enemyImage = document.getElementById(enemyId)
        return new Promise((resolve) => {
            // Use the anime.js library to animate the enemyImage's top and left properties
            anime({
                targets: enemyImage,
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
        let enemyId = enemy.id;
        let enemyImage = document.getElementById(enemyId)
        enemyImage.parentNode.removeChild(enemyImage)
    }

    flipItLeft(enemy){
        let enemyId = enemy.id;
        let enemyImage = document.getElementById(enemyId)
        enemyImage.style.transform = 'scaleX(-1)';
    }
    flipItLeftRight(enemy){
        let enemyId = enemy.id;
        let enemyImage = document.getElementById(enemyId)
        enemyImage.style.transform = 'scaleX(1)';
    }
}