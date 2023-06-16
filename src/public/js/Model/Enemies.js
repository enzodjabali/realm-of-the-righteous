/**
 * Base class for enemies
 * ! Les images doivent être en 64x64, sinon voir class display ! */
export class Enemy{
    constructor(enemyId, typeOfEnemies,path, path_img, position, curent_life, max_life, armor, speed, price, isFlying, name, trueDamage) {
        this.id = enemyId;
        this.max_life = max_life;
        this.curent_life = curent_life;
        this.armor = armor;
        this.position = position;
        this.path_img = path_img;
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

    getLife(){
        return this.life;
    }
    getPosition(){
        return this.position;
    }
    getPath(){
        return this.path;
    }
    getId(){
        return this.id;
    }
    setLife(life){
        /**
         *@param {life} x life of enemy.
         */
        this.life = life;
    }
    setPosition(position){
        /**
         *@param {position} x dictionnaire of position {x :?, y : ?}.
         */
        this.position = position;
    }
    setPath(path){
        /**
         * @param {string} path image path for the enemy */
        this.path = path;
    }

}