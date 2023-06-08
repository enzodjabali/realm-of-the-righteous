export class Tower{
    constructor(towerId, damage, shotRate, position, towerLevel, path, pathWeapon,
        WeaponId, price, type, isAttackingAir, totalTowerFrames, totalAmmoFrames, totalImpactFrames, pathAmmo, pathImpact,
        rebound = null, slowness = null) {
        this.id = towerId;
        this.WeaponId = WeaponId;
        this.WeaponAngle = 0;
        this.damage = damage;
        this.shotRate = shotRate;
        this.towerLevel = towerLevel;
        this.level = 0;
        this.range = 10;
        this.position = position
        this.path = path;
        this.pathWeapon = pathWeapon;
        this.price = price;
        this.type = type;
        this.isAttackingAir = isAttackingAir;
        this.rebound = rebound;
        this.slowness = slowness;
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
    }
    getId(){
        return this.id;
    }
    getWeaponId(){
        return this.WeaponId;
    }
}