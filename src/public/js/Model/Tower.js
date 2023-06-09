export class Tower{
    constructor(towerId, damage, shotRate, position, towerLevel, path, pathWeapon,
                WeaponId, price, type, isAttackingAir, totalTowerFrames, totalAmmoFrames, totalImpactFrames, pathAmmo, pathImpact,
                ) {
        this.id = towerId;
        this.WeaponId = WeaponId;
        this.WeaponAngle = 0;
        this.damage = damage;
        this.shotRate = shotRate;
        this.towerLevel = towerLevel;
        this.level = 0;
        this.range = 5;
        this.position = position
        this.path = path;
        this.pathWeapon = pathWeapon;
        this.price = price;
        this.type = type;
        this.isAttackingAir = isAttackingAir;
        this.totalTowerFrames = totalTowerFrames;
        this.totalAmmoFrames = totalAmmoFrames;
        this.totalImpactFrames = totalImpactFrames;
        this.currentFrame = 0;
        this.animateSprite;
        this.animationInterval;
        this.remove = false;
        this.pathAmmo = pathAmmo;
        this.pathImpact = pathImpact;
        this.towerAmmoId = 0;
        this.memoryDamage = damage;

        this.splashRange;
        this.slowness;
        this.rebound;
        this.buffTower


    }
    getId(){
        return this.id;
    }
    getWeaponId(){
        return this.WeaponId;
    }
    setSlowness(slowness){
        this.slowness = slowness;
    }
    setRebound(rebound){
        this.rebound = rebound;
    }
    setSplashRange(splashRange){
        this.splashRange = splashRange;
    }
    setBuffTower(buffTower){
        this.buffTower = buffTower;
    }
}
