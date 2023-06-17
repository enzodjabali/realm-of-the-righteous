import {Enemy} from "../Model/Enemies.js";

export class EnemiesController {
    /**
     * @param {Model} model instance of model created in Controller.
     */
    constructor(model) {
        this.model = model;
    }

    /**
    * Permit to create an enemy object
    * @param {integer} id id of the enemy.
    * @param {dict} mobDict Dictionnary of all the mobs.
    * @param {Enemy} path pathfinding list of cords.
    * @param {array} entry couple of x y for the spawn zombie.
    * @param {string} typeOfEnemies type of mob.
    */
    createEnnemyObject(id, mobDict, path, entry, typeOfEnemies){
        if (this.model.entryPoints) {
            let xCord = entry[0];
            let yCord = entry[1];
            let position = {x: xCord,  y: yCord};
            for(let [mobKey, mobValues] of Object.entries(mobDict)){
                if(typeOfEnemies == mobKey){
                    let newLife = mobValues.life + mobValues.life*(0.08*this.model.currentWave)
                    let newArmor = mobValues.armor + mobValues.armor*(0.08*this.model.currentWave)
                    let newPrice = mobValues.price + mobValues.price*(0.03*this.model.currentWave)
                    let enemy = new Enemy(id, mobKey, path, mobValues.pathAlive, mobValues.pathDead, position, newLife,
                        newLife, newArmor, mobValues.speed, newPrice, mobValues.isFlying, mobKey, mobValues.trueDamage);
                    return enemy
                }
            }
        }
    }
}