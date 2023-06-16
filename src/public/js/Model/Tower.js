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
        this.level = towerLevel;
        this.position = position
        this.pathWeapon = pathWeapon;
        this.price = price;
        this.type = type;
        this.isAttackingAir = isAttackingAir;
        
        this.totalTowerFrames = totalTowerFrames;
        this.totalAmmoFrames = totalAmmoFrames;
        this.totalImpactFrames = totalImpactFrames;
        
        this.currentTowerFrame = 0;
        this.currentAmmoFrame = 0;
        this.currentImpactFrame = 0;
        
        this.animateTowerSprite;
        this.animateAmmoSprite;
        this.animateImpactSprite;
        
        this.animationTowerInterval;
        this.animationAmmoInterval;
        this.animationImpactInterval;
        
        this.remove = false;
        this.path = path;
        this.pathAmmo = pathAmmo;
        this.pathImpact = pathImpact;
        this.towerAmmoId = 0;

        this.splashRange;
        this.slowness;
        this.rebound;
        this.buffTower
        this.buffedTower = [];
        this.armorDamage;
        this.range;
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
    setArmorDamage(armorDamage){
        this.armorDamage = armorDamage;
    }
    setRange(range){
        this.range = range;
    }
}
