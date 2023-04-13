/**
 * Enum of enemy types with their properties.
 * @typedef {Object} EnemyType
 * @property {string} pathAlive - The path to the image for the enemy when alive.
 * @property {string} pathDead - The path to the image for the enemy when dead.
 * @property {number} life - The initial life or health of the enemy.
 * @property {number} armor - The initial armor of the enemy.
 * @property {number} speed - The initial speed of the enemy.
 */
export const enumEnemies = {
    'bat':{
        pathAlive: '../../assets/images/mobs/batvol.gif',
        pathDead: '../../assets/images/mobs/batdeath.gif', 
        life: 10,  
        armor: 0,
        speed: 20,
    },
    'golem':{
        pathAlive: '../../assets/images/mobs/golemwalk.gif',
        pathDead: '../../assets/images/mobs/golemdeath.gif', 
        life: 10, 
        armor: 0,
        speed: 10,
    },
    'knight':{
        pathAlive: '../../assets/images/mobs/knightrun.gif', 
        pathDead: '../../assets/images/mobs/knightdeath.gif', 
        life: 10, 
        armor: 0,
        speed: 15,
    },
    'witch':{
        pathAlive: '../../assets/images/mobs/witchwalk.gif', 
        pathDead: '../../assets/images/mobs/witchdeath.gif', 
        life: 10, 
        armor: 0,
        speed: 12,
    },
    'wolf':{
        pathAlive: '../../assets/images/mobs/wolfrun.gif', 
        pathDead: '../../assets/images/mobs/wolfdeath.gif', 
        life: 10, 
        armor: 0,
        speed: 25,
        },
    }