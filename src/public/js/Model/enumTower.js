/**Enum object that defines tower configurations.
 * @typedef {Object} enumTower
 * @property {Object} Configuration for tower type.
 * @property {string[]} path Array of image paths for tower at different upgrade levels.
 * @property {number[]} damage - Array of damage values for tower at different upgrade levels.
 * @property {number[]} shotRate - Array of shot rate values for tower at different upgrade levels (in milliseconds).
 */

export const enumTower = {
    'BT':{
        path: ['../../assets/images/towers/BT1.png', '../../assets/images/towers/BT2.png', '../../assets/images/towers/BT3.png'],
        pathWeapon :"../../assets/images/towers/weapons/crossbow.gif",
        damage: [3,6,10],
        shotRate: [500,400,300],//in ms
        price: [100,200,300]
    },
    'OT':{
        path: ['../../assets/images/towers/OT1.png', '../../assets/images/towers/OT2.png', '../../assets/images/towers/OT3.png'],
        pathWeapon :"../../assets/images/towers/weapons/crossbow.gif",
        damage: [1,2,3],
        shotRate: [200,150,100],//in ms
        price: [100,200,300]
    },
    'T':{
        path: ['../../assets/images/towers/T1.png', '../../assets/images/towers/T2.png', '../../assets/images/towers/T3.png'],
        pathWeapon :"../../assets/images/towers/weapons/crossbow.gif",
        damage: [10,20,30],
        shotRate: [5000,4000,3000],//in ms
        price: [100,200,300]
    },
    'WT':{
        path: ['../../assets/images/towers/WT1.png', '../../assets/images/towers/WT2.png', '../../assets/images/towers/WT3.png'],
        pathWeapon :"../../assets/images/towers/weapons/crossbow.gif",
        damage: [3,6,10],
        shotRate: [500,400,300],//in ms
        price: [100,200,300]
    },
}