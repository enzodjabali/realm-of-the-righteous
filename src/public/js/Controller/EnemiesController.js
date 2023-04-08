import {Enemy} from "../Model/Enemies.js";

export class EnemiesController {
    constructor(model) {
        this.model = model;
    }
    createEnemiesIntoToPlaceList(id, typeOfEnemies){
        // Create enmies for a wave. Call it once. If not, last instance will be the one the one with the id
        if (this.model.entryPoints.length > 0) {
            let path = Math.floor(Math.random() * (this.model.entryPoints.length)) //HELP ME permet de spawn les ennemies en aleatoire
            let xCord = this.model.entryPoints[path][0] //
            let yCord = this.model.entryPoints[path][1]
            let position = {x: xCord,  y: yCord};
            this.model.addEnemy(new Enemy(id, typeOfEnemies, position))
        }
    }
    placeEnemiesInMatrice(){
        /**
         * @param {Enemy} enemyObject instance of an enemy
         * */
        for (let j = 0; j < this.model.enemiesToPlace.length ; j++){
            let x = this.model.enemiesToPlace[j].position.x
            let y = this.model.enemiesToPlace[j].position.y
            this.modifyMatrice(x, y, this.model.enemiesToPlace[j]);
        }
        //Empty this.model.enemiesToPlace
        this.model.enemiesToPlace.length = 0;
    }
    modifyMatrice(x, y, enemyObject){
        /**
         * @param {number} x x position of matrice.
         * @param {number} y y position of matrice.
         * @param {Enemy} enemyObject Enemy object.
         */
        
        this.model.matrice[x][y].enemies.push(enemyObject) ;
    }
}