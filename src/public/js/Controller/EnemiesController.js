import {Enemy} from "../Model/Enemies.js";

export class EnemiesController {
    constructor(model) {
        /**
         * @param {Model} model instance of model created in Controller.
         */
        this.model = model;
        this.enemies = []
    }
    createEnnemyObject(id, mobDict, path, entry, typeOfEnemies){
        /**
         * @param {integer} id id of the enemy.
         * @param {dict} mobDict Dictionnary of all the mobs.
         * @param {Enemy} path pathfinding list of cords.
         * @param {array} entry couple of x y for the spawn zombie.
         * @param {string} typeOfEnemies type of mob.
         * Permit to create an enemy object
         */
        if (this.model.entryPoints) {
            let xCord = entry[0];
            let yCord = entry[1];
            let position = {x: xCord,  y: yCord};
            for(let [mobKey, mobValues] of Object.entries(mobDict)){
                    if(typeOfEnemies == mobKey){
                        let enemy = new Enemy(id, mobKey,path, mobValues.pathAlive, position, mobValues.life,
                            mobValues.life, mobValues.armor, mobValues.speed, mobValues.price, mobValues.isFlying);
                        this.enemies.push(enemy);
                        this.model.addEnemy(enemy);
                        return enemy
                    }
            }
        }
    }   

    modifyMatrice(x, y, enemyObject){
        /**
         * @param {number} x x position of matrice.
         * @param {number} y y position of matrice.
         * @param {Enemy} enemyObject Enemy object.
         */
        this.model.matrice[x][y].enemies.push(enemyObject);
    }
}