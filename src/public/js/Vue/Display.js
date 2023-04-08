// Display to the users the game
export class Display{
    constructor() {
        this.enemiesIds = [];
        this.tilesSize = 0;

    }
    initializeGame(matrice){
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
        container.style.gridTemplateColumns = columns;

        let imgArray = ["../../assets/images/chemin.png", "../../assets/images/herbe.png", "../../assets/images/tour.png"];

        for (let x = 0 ; x < matrice.length ; x++){
            for (let y = 0 ; y < matrice[x].length ; y++){
                switch (matrice[x][y].tile){
                    case 0:
                        var img = document.createElement("img");
                        img.src = imgArray[0];
                        img.width = this.tilesSize;
                        img.height = this.tilesSize;
                        document.getElementById('board-container').appendChild(img);
                        break;
                    case 1:
                        var img = document.createElement("img");
                        img.src = imgArray[1];
                        img.width = this.tilesSize;
                        img.height = this.tilesSize;
                        document.getElementById('board-container').appendChild(img);

                        break;
                    case 2:
                        var img = document.createElement("img");
                        img.src = imgArray[2];
                        img.width = this.tilesSize;
                        img.height = this.tilesSize;
                        document.getElementById('board-container').appendChild(img);
                        break;
                    default:
                        break;
                }

                for (let j = 0 ; matrice[x][y].enemies.length > j ; j++){
                    var imgEnemy = new Image();
                    imgEnemy.src = matrice[x][y].enemies[j].path;

                    // Maybe put img size in Json to make it dynamic --> HELP ME
                    imgEnemy.width = 64;
                    imgEnemy.height = 64;

                    //Set an ID to the enemy. Permits to get it later
                    imgEnemy.setAttribute('id', matrice[x][y].enemies[j].getId());
                    containerEnemies.style.top = (matrice[x][y].enemies[j].position.x * this.tilesSize + 0.5*this.tilesSize - 32).toString()+'px';
                    containerEnemies.style.left = (matrice[x][y].enemies[j].position.y * this.tilesSize + 0.5*this.tilesSize - 32).toString()+'px';
                    document.getElementById('container-enemies').appendChild(imgEnemy);
                }
            }
        }

    }
    nextMoveEnemies(matrice){
        /**
         * @param {list[list]} matrice Logical board of the game.
         * Make enemies move to their n+1 positions.
         * HELP ME --> ennemies IMGs use with STATIC width and height
         */
        for (let x = 0 ; x < matrice.length ; x++){
            for (let y = 0 ; y < matrice[x].length ; y++){
                for (let j = 0 ; matrice[x][y].enemies.length > j ; j++){
                    let enemy = document.getElementById(matrice[x][y].enemies[j].getId())
                    enemy.style.position = 'absolute';
                    anime({
                        targets: enemy,
                        translateX: matrice[x][y].enemies[j].position.y * this.tilesSize,
                        translateY: matrice[x][y].enemies[j].position.x * this.tilesSize,
                        easing: 'linear',
                        duration: 1000
                    })
                }

            }

        }

    }
}
