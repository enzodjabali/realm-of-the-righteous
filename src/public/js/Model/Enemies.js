export class Enemy{

    /**
     Create a new Enemy.
    * @param {number} enemyId - The ID of the enemy.
    * @param {string} typeOfEnemies - The type of enemy.
    * @param {string} path - The path of the enemy.
    * @param {string} pathAlive - The path when the enemy is alive.
    * @param {string} pathDead - The path when the enemy is dead.
    * @param {object} position - The position of the enemy.
    * @param {number} current_life - The current life points of the enemy.
    * @param {number} max_life - The maximum life points of the enemy.
    * @param {number} armor - The armor value of the enemy.
    * @param {number} speed - The speed of the enemy.
    * @param {number} price - The price of the enemy.
    * @param {boolean} isFlying - Indicates if the enemy is flying or not.
    * @param {string} name - The name of the enemy.
    * @param {number} trueDamage - The true damage value of the enemy.
    */
    constructor(enemyId, typeOfEnemies, path, pathAlive, pathDead, position, curent_life, max_life, armor, speed, price, isFlying, name, trueDamage) {
        this.id = enemyId;
        this.max_life = max_life;
        this.curent_life = curent_life;
        this.armor = armor;
        this.position = position;
        this.pathAlive = pathAlive;
        this.pathDead = pathDead;
        this.path = path;
        this.typeOfEnemies = typeOfEnemies;
        this.step = 0;
        this.speed = speed;
        this.price = price;
        this.isFlying = isFlying;
        this.memorySpeed = speed;
        this.name = name;
        this.trueDamage = trueDamage;
    }


    /**
     * Get the current life points of an object.
     * @returns {number} The current life points of the object.
     */
    getLife(){
        return this.life;
    }

    /**
     * Get the position of an object.
     * @returns {object} The position of the object.
     */
    getPosition(){
        return this.position;
    }

    /**
     * Get the path of an object.
     * @returns {string} The path of the object.
     */
    getPath(){
        return this.path;
    }

    /**
     * Get the ID of an object.
     * @returns {number} The ID of the object.
     */
    getId(){
        return this.id;
    }

    /**
     * Set the life points of an object.
     * @param {number} life - The new life points to set.
     */
    setLife(life){
        this.life = life;
    }

    /**
     * Set the position of an object.
     * @param {object} position - The new position to set.
     */
    setPosition(position){
        this.position = position;
    }

    /**
     * Set the position of an object.
     * @param {object} position - The new position to set.
     */
    setPath(path){
        /**
         * @param {string} path image path for the enemy */
        this.path = path;
    }
}