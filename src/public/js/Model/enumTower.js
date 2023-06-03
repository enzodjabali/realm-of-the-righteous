/**Enum object that defines tower configurations.
 * @typedef {Object} enumTower
 * @property {Object} Configuration for tower type.
 * @property {string[]} path Array of image paths for tower at different upgrade levels.
 * @property {number[]} damage - Array of damage values for tower at different upgrade levels.
 * @property {number[]} shotRate - Array of shot rate values for tower at different upgrade levels (in milliseconds).
 */

export const enumTower = {
    'BT':{
        path : ['../../assets/images/towers/BT1.png', 
                '../../assets/images/towers/BT2.png', 
                '../../assets/images/towers/BT3.png'],
        
        pathWeapon : ['../../assets/images/towers/weapons/weapons/BT1weapon.png',
                    '../../assets/images/towers/weapons/weapons/BT2weapon.png',
                    '../../assets/images/towers/weapons/weapons/BT3weapon.png'],
        
        totalFrames : [17,17,17],
        damage : [3,6,10],
        shotRate: [500, 400, 300],//in ms
        price: [100,200,300],
        isAttackingAir: false,
    },
    'OT':{
        path : ['../../assets/images/towers/OT1.png', 
                '../../assets/images/towers/OT2.png', 
                '../../assets/images/towers/OT3.png'],
        
        pathWeapon : ['../../assets/images/towers/weapons/weapons/2OT1weapon.png',
                    '../../assets/images/towers/weapons/weapons/OT2weapon.png',
                    '../../assets/images/towers/weapons/weapons/OT3weapon.png'],
        
        totalFrames : [8,8,8],
        damage : [1,2,3],
        shotRate: [200,150,100],//in ms
        price: [10,20,30],
        rebound: [3,6,9],
        isAttackingAir: true,
    },
    'T':{
        path : ['../../assets/images/towers/T1.png', 
                '../../assets/images/towers/T2.png', 
                '../../assets/images/towers/T3.png'],
        
        pathWeapon : ['../../assets/images/towers/weapons/weapons/T1weapon.png',
                    '../../assets/images/towers/weapons/weapons/T2weapon.png',
                    '../../assets/images/towers/weapons/weapons/T3weapon.png'],
        
        totalFrames : [6,6,6],
        shotRate: [300,4000,3000],//in ms
        damage: [1,40,60],
        price: [100,200,300],
        isAttackingAir: false,
        slowness: [1.3, 1.5, 1.8]
    },
    'WT':{
        path : ['../../assets/images/towers/WT1.png', 
                '../../assets/images/towers/WT2.png', 
                '../../assets/images/towers/WT3.png'],
        
        pathWeapon : ['../../assets/images/towers/weapons/weapons/WT1weapon.png',
                    '../../assets/images/towers/weapons/weapons/WT2weapon.png',
                    '../../assets/images/towers/weapons/weapons/WT3weapon.png'],
        
        totalFrames : [6,6,6],
        damage : [3,6,10],
        shotRate: [500,400,300],//in ms
        price: [1,2,3],
        isAttackingAir: false,
    },
}