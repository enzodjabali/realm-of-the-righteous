import {Enemy} from "../Model/Enemies.js";

export class EnemiesController {
    constructor(model) {
        this.model = model;
        this.enemies = []
    }
    createEnemiesIntoToPlaceList(id, typeOfEnemies){
        // Create enmies for a wave. Call it once. If not, last instance will be the one the one with the id
        if (this.model.entryPoints) {
            console.log('je passe entrypoints')
            let xCord = this.model.entryPoints[0]
            let yCord = this.model.entryPoints[1]
            let position = {x: xCord,  y: yCord};
            let enemy = new Enemy(id, typeOfEnemies, position);
            this.enemies.push(enemy);
            this.model.addEnemy(enemy);
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
        //console.log(this.model.matrice[x][y])
        //console.log(enemyObject)
        this.model.matrice[x][y].enemies.push(enemyObject);
    }
}