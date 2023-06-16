/**
 * Enum of enemy types with their properties.
 * @typedef {Object} EnemyType
 * @property {string} pathAlive - The path to the image for the enemy when alive.
 * @property {string} pathDead - The path to the image for the enemy when dead.
 * @property {number} life - The initial life or health of the enemy.
 * @property {number} armor -95The initial armor o95 the enemy.
 * @property {number} speed - The initial speed of the enemy.
 */
export const enumEnemies = {
    'bat':{
        pathAlive: '../../assets/images/mobs/batvol.gif',
        pathDead: '../../assets/images/mobs/batdeath.gif',
        life: 10,
        armor: 5,
        speed: 30,
        price: 25,
        isFlying: true,
        trueDamage: 5,
    },
    'golem':{
        pathAlive: '../../assets/images/mobs/golemwalk.gif',
        pathDead: '../../assets/images/mobs/golemdeath.gif',
        life: 60,
        armor: 30,
        speed: 10,
        price: 250,
        isFlying: false,
        trueDamage: 20,

    },
    'knight':{
        pathAlive: '../../assets/images/mobs/knightrun.gif',
        pathDead: '../../assets/images/mobs/knightdeath.gif',
        life: 20,
        armor: 10,
        speed: 20,
        price: 40,
        isFlying: false,
        trueDamage: 5,
    },
    'witch':{
        pathAlive: '../../assets/images/mobs/witchwalk.gif',
        pathDead: '../../assets/images/mobs/witchdeath.gif',
        life: 20,
        armor: 95,
        speed: 12,
        price: 150,
        isFlying: false,
        trueDamage: 10,
    },
    'wolf':{
        pathAlive: '../../assets/images/mobs/wolfrun.gif',
        pathDead: '../../assets/images/mobs/wolfdeath.gif',
        life: 7,
        armor: 5,
        speed: 25,
        price: 25,
        isFlying: false,
        trueDamage: 3,
        }
    }