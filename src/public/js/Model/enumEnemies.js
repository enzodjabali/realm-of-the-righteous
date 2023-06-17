/**
 * Enum of enemy types with their properties.
 * @typedef {Object} EnemyType
 * @property {string} pathAlive - The path to the image for the enemy when alive.
 * @property {string} pathDead - The path to the image for the enemy when dead.
 * @property {number} life - The initial life or health of the enemy.
 * @property {number} armor - The initial armor of the enemy.
 * @property {number} speed - The initial speed of the enemy.
 * @property {number} price - The initial speed of the enemy.
 * @property {boolean} isFlying - The initial speed of the enemy.
 * @property {number} trueDamage - The initial speed of the enemy.
 */
export const enumEnemies = {
    'bat':{
        pathAlive: '../../assets/images/mobs/batvol.gif',
        pathDead: '../../assets/images/mobs/batdeath.gif',
        life: 10,
        armor: 0,
        speed: 15,
        price: 50,
        isFlying: true,
        trueDamage: 5,
    },
    'golem':{
        pathAlive: '../../assets/images/mobs/golemwalk.gif',
        pathDead: '../../assets/images/mobs/golemdeath.gif', 
        life: 300,
        armor: 40,
        speed: 5,
        price: 250,
        isFlying: false,
        trueDamage: 20,

    },
    'knight':{
        pathAlive: '../../assets/images/mobs/knightrun.gif',
        pathDead: '../../assets/images/mobs/knightdeath.gif',
        life: 20,
        armor: 10,
        speed: 15,
        price: 50,
        isFlying: false,
        trueDamage: 5,
    },
    'witch':{
        pathAlive: '../../assets/images/mobs/witchwalk.gif', 
        pathDead: '../../assets/images/mobs/witchdeath.gif', 
        life: 50,
        armor: 55,
        speed: 10,
        price: 150,
        isFlying: false,
        trueDamage: 10,
    },
    'wolf':{
        pathAlive: '../../assets/images/mobs/wolfrun.gif', 
        pathDead: '../../assets/images/mobs/wolfdeath.gif', 
        life: 9,
        armor: 3,
        speed: 25,
        price: 25,
        isFlying: false,
        trueDamage: 3,
        }
    }