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
            let mobDict = Enemy.mobDict;
            for(let [mobKey, mobValues] of Object.entries(mobDict)){
                    if(typeOfEnemies == mobKey){
                        let enemy = new Enemy(id, mobKey,path, mobValues.pathAlive, position, mobValues.life, mobValues.armor);
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