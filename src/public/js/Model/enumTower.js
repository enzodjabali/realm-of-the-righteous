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
        
        pathAmmo : ['../../assets/images/towers/weapons/flying/BT1flying.png',
                    '../../assets/images/towers/weapons/flying/BT2flying.png',
                    '../../assets/images/towers/weapons/flying/BT3flying.png'],

        pathImpact : ['../../assets/images/towers/weapons/impact/BT1impact.png',
                      '../../assets/images/towers/weapons/impact/BT2impact.png',
                      '../../assets/images/towers/weapons/impact/BT3impact.png'],

        totalTowerFrames : [17,17,17],
        totalAmmoFrames : [6,6,8],
        totalImpactFrames : [9,9,9],
        damage : [5,9,15],
        armorDamage: [5,10,15],
        shotRate: [1500, 1250, 1000],//in ms
        price: [200,350,500],
        isAttackingAir: false,
        splashRange: [2,4,6],
        range: [4,5,6],
        fullName: "Thunderous Tower",
    },
    'OT':{
        path : ['../../assets/images/towers/OT1.png',
                '../../assets/images/towers/OT2.png',
                '../../assets/images/towers/OT3.png'],

        pathWeapon : ['../../assets/images/towers/weapons/weapons/OT1weapon.png',
                    '../../assets/images/towers/weapons/weapons/OT2weapon.png',
                    '../../assets/images/towers/weapons/weapons/OT3weapon.png'],
        
        pathAmmo : ['../../assets/images/towers/weapons/flying/OT1flying.png',
                    '../../assets/images/towers/weapons/flying/OT2flying.png',
                    '../../assets/images/towers/weapons/flying/OT3flying.png'],

        pathImpact : ['../../assets/images/towers/weapons/impact/OT1impact.png',
                      '../../assets/images/towers/weapons/impact/OT2impact.png',
                      '../../assets/images/towers/weapons/impact/OT3impact.png'],

        totalTowerFrames : [8,8,8],
        totalAmmoFrames : [6,6,6],
        totalImpactFrames : [6,6,6],
        damage : [4,8,15],
        armorDamage: [5,10,20],
        shotRate: [1500,1000,750],//in ms
        price: [200,350,500],
        rebound: [3,6,9],
        isAttackingAir: true,
        range: [4,5,6],
        fullName: "Ricochet Sentinel",
    },
    'T':{
        path : ['../../assets/images/towers/T1.png', 
                '../../assets/images/towers/T2.png', 
                '../../assets/images/towers/T3.png'],
        
        pathWeapon : ['../../assets/images/towers/weapons/weapons/T1weapon.png',
                    '../../assets/images/towers/weapons/weapons/T2weapon.png',
                    '../../assets/images/towers/weapons/weapons/T3weapon.png'],
        
        pathAmmo : ['../../assets/images/towers/weapons/flying/T1flying.png',
                    '../../assets/images/towers/weapons/flying/T2flying.png',
                    '../../assets/images/towers/weapons/flying/T3flying.png'],

        pathImpact : ['../../assets/images/towers/weapons/impact/Timpact.png'],

        totalTowerFrames : [6,6,6],
        totalAmmoFrames : [3,4,4],
        totalImpactFrames : [6],
        shotRate: [1500,1250,1000],//in ms
        damage: [8,14,20],
        armorDamage: [7,14,25],
        price: [150,300,450],
        isAttackingAir: false,
        slowness: [1.1, 1.3, 1.5],
        range: [4,5,6],
        fullName: "Slumberfall Tower",
    },
    'WT':{
        path : ['../../assets/images/towers/WT1.png', 
                '../../assets/images/towers/WT2.png', 
                '../../assets/images/towers/WT3.png'],
        
        pathWeapon : ['../../assets/images/towers/weapons/weapons/WT1weapon.png',
                    '../../assets/images/towers/weapons/weapons/WT2weapon.png',
                    '../../assets/images/towers/weapons/weapons/WT3weapon.png'],
        
        pathAmmo : ['../../assets/images/towers/weapons/flying/WT1flying.png',
                    '../../assets/images/towers/weapons/flying/WT2flying.png',
                    '../../assets/images/towers/weapons/flying/WT3flying.png'],

        pathImpact: ['../../assets/images/towers/weapons/impact/WTimpact.png'],

        totalTowerFrames : [6,6,6],
        totalAmmoFrames : [3,6,9],
        totalImpactFrames : [6],
        damage : [3,5,10],
        armorDamage: [4,6,9],
        shotRate: [2000,1000,500],//in ms
        price: [250,450,850],
        isAttackingAir: false,
        buffTower: [1.2, 1.4, 1.6],
        range: [4,5,6],
        fullName: "Guardian's Beacon",
    },
    'NT':{
        path : ['../../assets/images/towers/OT1.png',
            '../../assets/images/towers/OT2.png',
            '../../assets/images/towers/OT3.png'],

        pathWeapon : ['../../assets/images/towers/weapons/weapons/T1weapon.png',
            '../../assets/images/towers/weapons/weapons/T2weapon.png',
            '../../assets/images/towers/weapons/weapons/T3weapon.png'],

        pathAmmo : ['../../assets/images/towers/weapons/flying/T1flying.png',
            '../../assets/images/towers/weapons/flying/T2flying.png',
            '../../assets/images/towers/weapons/flying/T3flying.png'],

        pathImpact : ['../../assets/images/towers/weapons/impact/Timpact.png'],

        totalTowerFrames : [6,6,6],
        totalAmmoFrames : [3,4,4],
        totalImpactFrames : [6],
        damage : [5,7,13],
        armorDamage: [8,14,20],
        shotRate: [1500, 1250, 1000],//in ms
        price: [100,250,400],
        isAttackingAir: false,
        range: [4,5,6],
        fullName: "Bastion of Honor",
    },
    'AR':{
        path : ['../../assets/images/towers/BT1.png',
            '../../assets/images/towers/BT2.png',
            '../../assets/images/towers/BT3.png'],

        pathWeapon : ['../../assets/images/towers/weapons/weapons/OT1weapon.png',
            '../../assets/images/towers/weapons/weapons/OT2weapon.png',
            '../../assets/images/towers/weapons/weapons/OT3weapon.png'],

        pathAmmo : ['../../assets/images/towers/weapons/flying/OT1flying.png',
            '../../assets/images/towers/weapons/flying/OT2flying.png',
            '../../assets/images/towers/weapons/flying/OT3flying.png'],

        pathImpact : ['../../assets/images/towers/weapons/impact/OT1impact.png',
            '../../assets/images/towers/weapons/impact/OT2impact.png',
            '../../assets/images/towers/weapons/impact/OT3impact.png'],

        totalTowerFrames : [8,8,8],
        totalAmmoFrames : [6,6,6],
        totalImpactFrames : [6,6,6],
        damage : [4,8,16],
        armorDamage: [2,4,6],
        shotRate: [1000, 750, 500],//in ms
        price: [175,250,350],
        isAttackingAir: true,
        range: [4,5,6],
        fullName: "Aero Bolt Tower",
    },
    "rock":{
        path : ['../../assets/images/tiles/rock.png'],

        pathWeapon : ['../../assets/images/towers/weapons/weapons/WT1weapon.png'],

        pathAmmo : ['../../assets/images/towers/weapons/flying/WT1flying.png'],

        pathImpact: ['../../assets/images/towers/weapons/impact/WTimpact.png'],

        totalTowerFrames : [0],
        totalAmmoFrames : [0],
        totalImpactFrames : [6],
        damage: [0],
        armorDamage: [0],
        shotRate: [0],//in ms
        price: [500],
        isAttackingAir: false,
        buffTower: [0],
        range: [0],
        fullName: "Rock",
    },
}