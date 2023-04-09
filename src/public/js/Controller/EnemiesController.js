import {Enemy} from "../Model/Enemies.js";

export class EnemiesController {
    constructor(model) {
        this.model = model;
        this.enemies = []
    }

    createEnnemyObject(id ,path ,entry, typeOfEnemies){
        // Create enmies for a wave. Call it once. If not, last instance will be the one the one with the id
        if (this.model.entryPoints) {
            let xCord = entry[0]
            let yCord = entry[1]
            let position = {x: xCord,  y: yCord};
            let enemy = new Enemy(id, typeOfEnemies, position);
            this.enemies.push(enemy);
            this.model.addEnemy(enemy);
            return enemy
        }
    }

    /*placeEnemiesInMatrice(){
        for (let j = 0; j < this.model.enemiesToPlace.length ; j++){
            let x = this.model.enemiesToPlace[j].position.x
            let y = this.model.enemiesToPlace[j].position.y
            this.modifyMatrice(x, y, this.model.enemiesToPlace[j]);
        }
        //Empty this.model.enemiesToPlace
        this.model.enemiesToPlace.length = 0;
    }*/

    modifyMatrice(x, y, enemyObject){
        /**
         * @param {number} x x position of matrice.
         * @param {number} y y position of matrice.
         * @param {Enemy} enemyObject Enemy object.
         */
        this.model.matrice[x][y].enemies.push(enemyObject);
    }
}