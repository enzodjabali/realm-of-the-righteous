/**
 * Base class for enemies
 * ! Les images doivent être en 64x64, sinon voir class display ! */
export class Enemy{
    constructor(enemyId, typeOfEnemies,path, path_img, position, life, armor) {
        this.id = enemyId;
        this.life = life;
        this.armor = armor;
        this.position = position;  
        this.path_img = path_img;
        this.path = path;
        this.typeOfEnemies = typeOfEnemies;
        this.step = 0;
    }

    static mobDict = {
        'bat':{
            pathAlive: '../../assets/images/mobs/batvol.gif',
            pathDead: '../../assets/images/mobs/batdeath.gif', 
            life: 10,  
            armor: 0,
        },
        'golem':{
            pathAlive: '../../assets/images/mobs/golemwalk.gif',
            pathDead: '../../assets/images/mobs/golemdeath.gif', 
            life: 10, 
            armor: 0,
        },
        'knight':{
            pathAlive: '../../assets/images/mobs/knightrun.gif', 
            pathDead: '../../assets/images/mobs/knightdeath.gif', 
            life: 10, 
            armor: 0,
        },
        'witch':{
            pathAlive: '../../assets/images/mobs/witchwalk.gif', 
            pathDead: '../../assets/images/mobs/witchdeath.gif', 
            life: 10, 
            armor: 0,
        },
        'wolf':{
            pathAlive: '../../assets/images/mobs/wolfrun.gif', 
            pathDead: '../../assets/images/mobs/wolfdeath.gif', 
            life: 10, 
            armor: 0,
        },
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