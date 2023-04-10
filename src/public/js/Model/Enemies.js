/**
 * Base class for enemies
 * ! Les images doivent être en 64x64, sinon voir class display ! */
export class Enemy{
    constructor(enemyId, typeOfEnemies,path, path_img, position, life, armor, speed) {
        this.id = enemyId;
        this.life = life;
        this.armor = armor;
        this.position = position;  
        this.path_img = path_img;
        this.path = path;
        this.typeOfEnemies = typeOfEnemies;
        this.step = 0;
        this.speed = speed;
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