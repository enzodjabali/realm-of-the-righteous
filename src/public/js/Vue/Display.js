import {Controller} from "../Controller/Controller.js";
import anime from '../../node_modules/animejs/lib/anime.es.js';

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
                    imgEnemy.width = this.tilesSize;
                    imgEnemy.height = this.tilesSize;
                    //Set an ID to the enemy. Permits to get it later
                    imgEnemy.setAttribute('id', matrice[x][y].enemies[j].getId());
                    
                    containerEnemies.style.top = 0;
                    containerEnemies.style.left = 0;
                    
                    document.getElementById('container-enemies').appendChild(imgEnemy);
                    let enemy = document.getElementById(matrice[x][y].enemies[j].getId());
                    enemy.style.position = 'absolute';
                    enemy.style.top = (matrice[x][y].enemies[j].position.x * this.tilesSize + 0.5*this.tilesSize - imgEnemy.width/2).toString()+'px';
                    enemy.style.left = (matrice[x][y].enemies[j].position.y * this.tilesSize + 0.5*this.tilesSize - imgEnemy.height/2).toString()+'px';
                    
                }   
            }
        }

    }
    nextMoveEnemy(enemy, path_enemy_step){
        let enemyId = enemy.id;
        let enemyImage = document.getElementById(enemyId)
        return new Promise((resolve) => {
            // Use the anime.js library to animate the enemyImage's top and left properties
            anime({
                targets: enemyImage,
                top: (enemy.position.x) * this.tilesSize, // Set the top property to the new position's x coordinate
                left: (enemy.position.y) * this.tilesSize, // Set the left property to the new position's y coordinate
                easing: 'linear', // Use linear easing for smooth movement
                duration: 300, // Set the duration of the animation to 300 milliseconds
                complete: function (){
                    resolve('all good'); // Resolve the promise when the animation is complete
                }
            });
        });
    }

}